<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prospecto;
use App\Models\Distrito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_CrmProspectosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prospecto::with(['vendedor', 'distrito', 'cliente'])
            ->addSelect(['wishlist_count' => \DB::table('wish_lists')
                ->selectRaw('COUNT(*)')
                ->whereColumn('wish_lists.user_id', 'prospectos.registered_user_id')
                ->where('wish_lists.deseo', true)
            ]);

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellidos', 'like', "%{$buscar}%")
                  ->orWhere('razon_social', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('segmento')) {
            $query->where('segmento', $request->segmento);
        }

        if ($request->filled('origen')) {
            $query->where('origen', $request->origen);
        }

        if ($request->filled('vendedor_id')) {
            $query->where('user_id', $request->vendedor_id);
        }

        // Ordenamiento
        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        // Cargar todos para DataTables del lado cliente
        $prospectos = $query->get();

        // Estadísticas
        $estadisticas = [
            'total' => Prospecto::count(),
            'nuevos_mes' => Prospecto::nuevosEsteMes()->count(),
            'calificados' => Prospecto::porEstado('calificado')->count(),
            'tasa_conversion' => Prospecto::count() > 0
                ? round((Prospecto::porEstado('calificado')->count() / Prospecto::count()) * 100, 1)
                : 0,
        ];

        return view('ADMINISTRADOR.CRM.prospectos.index', compact(
            'prospectos',
            'estadisticas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $distritos = Distrito::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.prospectos.create', compact('distritos', 'vendedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'razon_social' => 'nullable|string|max:200',
            'ruc' => 'nullable|string|size:11|unique:prospectos,ruc',
            'dni' => 'nullable|string|size:8|unique:prospectos,dni',
            'email' => 'nullable|email|max:150|unique:prospectos,email',
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'distrito_id' => 'nullable|exists:distritos,id',
            'tipo_persona' => 'required|in:natural,juridica',
            'origen' => 'required|in:sitio_web,redes_sociales,llamada,referido,ecommerce,otro',
            'segmento' => 'required|in:residencial,comercial,industrial,agricola',
            'tipo_interes' => 'required|in:producto,servicio,ambos',
            'nivel_interes' => 'nullable|in:muy_alto,alto,medio,bajo',
            'urgencia' => 'nullable|in:inmediata,corto_plazo,mediano_plazo,largo_plazo',
            'user_id' => 'nullable|exists:users,id',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estado'] = 'nuevo';
        $validated['fecha_primer_contacto'] = now();

        $prospecto = \DB::transaction(function () use ($validated) {
            $prospecto = Prospecto::create($validated);
            return $prospecto;
        });

        return redirect()
            ->route('admin.crm.prospectos.show', $prospecto)
            ->with('success', 'Prospecto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prospecto $prospecto)
    {
        $prospecto->load([
            'vendedor',
            'distrito.provincia.departamento',
            'oportunidades' => fn($q) => $q->latest()->take(5),
            'actividades' => fn($q) => $q->latest()->take(10),
            'cotizaciones' => fn($q) => $q->latest()->take(5),
        ]);

        // Timeline de actividades
        $timeline = $prospecto->actividades()
            ->orderByDesc('fecha_programada')
            ->take(20)
            ->get();

        // Cargar wishlist si el prospecto tiene usuario registrado (ecommerce)
        $wishlistItems = collect();
        if ($prospecto->registered_user_id) {
            $wishlistItems = \DB::table('wish_lists')
                ->join('productos', 'wish_lists.producto_id', '=', 'productos.id')
                ->where('wish_lists.user_id', $prospecto->registered_user_id)
                ->where('wish_lists.deseo', true)
                ->select(
                    'productos.id',
                    'productos.name as nombre',
                    'productos.precio',
                    'productos.precio_descuento',
                    'productos.imagen',
                    'wish_lists.created_at'
                )
                ->orderByDesc('wish_lists.created_at')
                ->get();
        }

        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.prospectos.show', compact('prospecto', 'timeline', 'wishlistItems', 'vendedores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prospecto $prospecto)
    {
        $distritos = Distrito::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.prospectos.edit', compact('prospecto', 'distritos', 'vendedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'razon_social' => 'nullable|string|max:200',
            'ruc' => 'nullable|string|size:11|unique:prospectos,ruc,' . $prospecto->id,
            'dni' => 'nullable|string|size:8|unique:prospectos,dni,' . $prospecto->id,
            'email' => 'nullable|email|max:150|unique:prospectos,email,' . $prospecto->id,
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'distrito_id' => 'nullable|exists:distritos,id',
            'tipo_persona' => 'required|in:natural,juridica',
            'origen' => 'required|in:sitio_web,redes_sociales,llamada,referido,ecommerce,otro',
            'segmento' => 'required|in:residencial,comercial,industrial,agricola',
            'tipo_interes' => 'required|in:producto,servicio,ambos',
            'estado' => 'required|in:nuevo,contactado,calificado,descartado',
            'motivo_descarte' => 'nullable|required_if:estado,descartado|string|max:255',
            'nivel_interes' => 'nullable|in:muy_alto,alto,medio,bajo',
            'urgencia' => 'nullable|in:inmediata,corto_plazo,mediano_plazo,largo_plazo',
            'user_id' => 'nullable|exists:users,id',
            'fecha_proximo_contacto' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $prospecto->update($validated);

        return redirect()
            ->route('admin.crm.prospectos.show', $prospecto)
            ->with('success', 'Prospecto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prospecto $prospecto)
    {
        $prospecto->delete();

        return redirect()
            ->route('admin.crm.prospectos.index')
            ->with('success', 'Prospecto eliminado exitosamente.');
    }

    /**
     * Convertir prospecto a cliente
     */
    public function convertirACliente(Prospecto $prospecto)
    {
        try {
            $cliente = $prospecto->convertirACliente();
            
            return redirect()
                ->route('admin.crm.prospectos.index')
                ->with('success', "Prospecto '{$prospecto->nombre_completo}' convertido a cliente exitosamente. Código: {$cliente->codigo}");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al convertir: ' . $e->getMessage());
        }
    }

    /**
     * Crear oportunidad desde prospecto
     */
    /**
     * Registrar actividad para prospecto
     */
    public function registrarActividad(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,whatsapp',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'prioridad' => 'nullable|in:alta,media,baja',
            'estado' => 'nullable|in:programada,en_progreso,completada,cancelada,reprogramada,no_realizada',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $validated['estado'] = $validated['estado'] ?? 'programada';
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();
        $validated['created_by'] = auth()->id();

        $prospecto->actividades()->create($validated);

        return back()->with('success', 'Actividad registrada exitosamente.');
    }

    /**
     * Vista Kanban por estado
     */
    public function kanban()
    {
        $estados = ['nuevo', 'contactado', 'calificado', 'descartado'];
        
        $prospectosPorEstado = [];
        foreach ($estados as $estado) {
            $prospectosPorEstado[$estado] = Prospecto::with('vendedor')
                ->where('estado', $estado)
                ->orderByDesc('created_at')
                ->take(20)
                ->get();
        }

        return view('ADMINISTRADOR.CRM.prospectos.kanban', compact('prospectosPorEstado', 'estados'));
    }

    /**
     * Actualizar estado (AJAX o formulario)
     */
    public function actualizarEstado(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'estado' => 'required|in:nuevo,contactado,calificado,descartado',
            'motivo_descarte' => 'nullable|required_if:estado,descartado|string',
        ]);

        $prospecto->update($validated);

        // Si es petición AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado',
                'prospecto' => $prospecto->fresh(),
            ]);
        }

        // Si es formulario normal, redirigir con mensaje
        return redirect()
            ->route('admin.crm.prospectos.show', $prospecto)
            ->with('success', 'Estado actualizado a ' . ucfirst(str_replace('_', ' ', $validated['estado'])));
    }


    /**
     * Exportar prospectos a Excel/CSV
     */
    public function exportar(Request $request)
    {
        $query = Prospecto::with(['vendedor', 'distrito']);

        // Aplicar mismos filtros que index
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('segmento')) {
            $query->where('segmento', $request->segmento);
        }

        $prospectos = $query->get();

        $filename = 'prospectos_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($prospectos) {
            $file = fopen('php://output', 'w');
            
            // Encabezados
            fputcsv($file, [
                'Código', 'Nombre', 'Email', 'Teléfono', 'Segmento', 
                'Estado', 'Origen', 'Nivel Interés', 'Urgencia',
                'Vendedor', 'Fecha Registro'
            ]);

            foreach ($prospectos as $p) {
                fputcsv($file, [
                    $p->codigo,
                    $p->nombre_completo,
                    $p->email,
                    $p->celular ?? $p->telefono,
                    $p->segmento,
                    $p->estado,
                    $p->origen,
                    $p->nivel_interes,
                    $p->urgencia,
                    $p->vendedor?->persona?->name ?? '',
                    $p->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

