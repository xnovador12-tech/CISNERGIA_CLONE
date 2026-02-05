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
        $query = Prospecto::with(['vendedor', 'distrito', 'cliente']);

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

        if ($request->filled('scoring')) {
            $query->where('scoring', $request->scoring);
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

        // EstadÃ­sticas
        $estadisticas = [
            'total' => Prospecto::count(),
            'nuevos_mes' => Prospecto::nuevosEsteMes()->count(),
            'calificados' => Prospecto::porEstado('calificado')->count(),
            'pendientes_contactar' => Prospecto::conSeguimientoPendiente()->count(),
        ];

        return view('ADMINISTRADOR.PRINCIPAL.crm.prospectos.index', compact(
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

        return view('ADMINISTRADOR.PRINCIPAL.crm.prospectos.create', compact('distritos', 'vendedores'));
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
            'origen' => 'required|in:web,facebook,instagram,google_ads,referido,llamada,visita,feria,otro',
            'origen_detalle' => 'nullable|string|max:255',
            'segmento' => 'required|in:residencial,comercial,industrial,agricola',
            'consumo_mensual_kwh' => 'nullable|numeric|min:0',
            'factura_mensual_soles' => 'nullable|numeric|min:0',
            'tipo_inmueble' => 'nullable|string|max:50',
            'area_disponible_m2' => 'nullable|numeric|min:0',
            'tiene_medidor_bidireccional' => 'boolean',
            'empresa_electrica' => 'nullable|string|max:100',
            'presupuesto_estimado' => 'nullable|numeric|min:0',
            'nivel_interes' => 'nullable|in:muy_alto,alto,medio,bajo',
            'urgencia' => 'nullable|in:inmediata,corto_plazo,mediano_plazo,largo_plazo',
            'requiere_financiamiento' => 'boolean',
            'user_id' => 'nullable|exists:users,id',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estado'] = 'nuevo';
        $validated['fecha_primer_contacto'] = now();

        $prospecto = \DB::transaction(function () use ($validated) {
            $prospecto = Prospecto::create($validated);
            $prospecto->actualizarScoring();
            return $prospecto;
        });

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.prospectos.show', $prospecto)
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

        return view('ADMINISTRADOR.PRINCIPAL.crm.prospectos.show', compact('prospecto', 'timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prospecto $prospecto)
    {
        $distritos = Distrito::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.PRINCIPAL.crm.prospectos.edit', compact('prospecto', 'distritos', 'vendedores'));
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
            'origen' => 'required|in:web,facebook,instagram,google_ads,referido,llamada,visita,feria,otro',
            'origen_detalle' => 'nullable|string|max:255',
            'segmento' => 'required|in:residencial,comercial,industrial,agricola',
            'estado' => 'required|in:nuevo,contactado,calificado,no_calificado,descartado',
            'motivo_descarte' => 'nullable|required_if:estado,descartado|string|max:255',
            'consumo_mensual_kwh' => 'nullable|numeric|min:0',
            'factura_mensual_soles' => 'nullable|numeric|min:0',
            'tipo_inmueble' => 'nullable|string|max:50',
            'area_disponible_m2' => 'nullable|numeric|min:0',
            'tiene_medidor_bidireccional' => 'boolean',
            'empresa_electrica' => 'nullable|string|max:100',
            'presupuesto_estimado' => 'nullable|numeric|min:0',
            'nivel_interes' => 'nullable|in:muy_alto,alto,medio,bajo',
            'urgencia' => 'nullable|in:inmediata,corto_plazo,mediano_plazo,largo_plazo',
            'requiere_financiamiento' => 'boolean',
            'user_id' => 'nullable|exists:users,id',
            'fecha_proximo_contacto' => 'nullable|date',
            'observaciones' => 'nullable|string',
            'scoring' => 'nullable|in:A,B,C',
            'scoring_puntos' => 'nullable|integer|min:0|max:100',
        ]);

        $prospecto->update($validated);

        // Solo recalcular scoring automÃ¡ticamente si no se proporcionÃ³ manualmente
        if (!$request->filled('scoring') && !$request->filled('scoring_puntos')) {
            $prospecto->actualizarScoring();
        }

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.prospectos.show', $prospecto)
            ->with('success', 'Prospecto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prospecto $prospecto)
    {
        $prospecto->delete();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.prospectos.index')
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
                ->route('ADMINISTRADOR.PRINCIPAL.crm.prospectos.index')
                ->with('success', "Prospecto '{$prospecto->nombre_completo}' convertido a cliente exitosamente. CÃ³digo: {$cliente->codigo}");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al convertir: ' . $e->getMessage());
        }
    }

    /**
     * Crear oportunidad desde prospecto
     */
    public function crearOportunidad(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'tipo_proyecto' => 'required|in:on_grid,off_grid,hibrido,bombeo_solar',
            'monto_estimado' => 'required|numeric|min:0',
            'fecha_cierre_estimada' => 'required|date|after:today',
        ]);

        $oportunidad = $prospecto->oportunidades()->create([
            'nombre' => $validated['nombre'],
            'tipo_proyecto' => $validated['tipo_proyecto'],
            'monto_estimado' => $validated['monto_estimado'],
            'fecha_cierre_estimada' => $validated['fecha_cierre_estimada'],
            'etapa' => 'calificacion',
            'probabilidad' => 10,
            'user_id' => auth()->id(),
        ]);

        // Actualizar estado del prospecto
        if ($prospecto->estado === 'nuevo') {
            $prospecto->update(['estado' => 'contactado']);
        }

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.show', $oportunidad)
            ->with('success', 'Oportunidad creada exitosamente.');
    }

    /**
     * Registrar actividad para prospecto
     */
    public function registrarActividad(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,videollamada,whatsapp,tarea,nota',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'duracion_minutos' => 'nullable|integer|min:5',
            'prioridad' => 'nullable|in:alta,media,baja',
            'recordatorio_activo' => 'boolean',
            'recordatorio_minutos_antes' => 'nullable|integer|min:5',
        ]);

        $validated['estado'] = 'programada';
        $validated['user_id'] = auth()->id();

        $prospecto->actividades()->create($validated);

        return back()->with('success', 'Actividad registrada exitosamente.');
    }

    /**
     * Vista Kanban por estado
     */
    public function kanban()
    {
        $estados = ['nuevo', 'contactado', 'calificado', 'no_calificado', 'descartado'];
        
        $prospectosPorEstado = [];
        foreach ($estados as $estado) {
            $prospectosPorEstado[$estado] = Prospecto::with('vendedor')
                ->where('estado', $estado)
                ->orderByDesc('scoring_puntos')
                ->take(20)
                ->get();
        }

        return view('ADMINISTRADOR.PRINCIPAL.crm.prospectos.kanban', compact('prospectosPorEstado', 'estados'));
    }

    /**
     * Actualizar estado (AJAX o formulario)
     */
    public function actualizarEstado(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'estado' => 'required|in:nuevo,contactado,calificado,no_calificado,descartado',
            'motivo_descarte' => 'nullable|required_if:estado,descartado|string',
        ]);

        $prospecto->update($validated);

        // Si es peticiÃ³n AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado',
                'prospecto' => $prospecto->fresh(),
            ]);
        }

        // Si es formulario normal, redirigir con mensaje
        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.prospectos.show', $prospecto)
            ->with('success', 'Estado actualizado a ' . ucfirst(str_replace('_', ' ', $validated['estado'])));
    }

    /**
     * Actualizar scoring manualmente
     */
    public function actualizarScoring(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'scoring' => 'required|in:A,B,C',
            'scoring_puntos' => 'required|integer|min:0|max:100',
        ]);

        $prospecto->update($validated);

        // Si es peticiÃ³n AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Scoring actualizado',
                'prospecto' => $prospecto->fresh(),
            ]);
        }

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.prospectos.show', $prospecto)
            ->with('success', 'Scoring actualizado correctamente');
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
                'CÃ³digo', 'Nombre', 'Email', 'TelÃ©fono', 'Segmento', 
                'Estado', 'Scoring', 'Origen', 'Consumo kWh', 'Presupuesto',
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
                    $p->scoring,
                    $p->origen,
                    $p->consumo_mensual_kwh,
                    $p->presupuesto_estimado,
                    $p->vendedor?->name,
                    $p->created_at->format('d/m/Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

