<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prospecto;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\User;
use App\Http\Requests\StoreActividadProspectoRequest;
use App\Http\Requests\StoreProspectoRequest;
use App\Http\Requests\UpdateProspectoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_CrmProspectosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $rolesAdmin = ['cuantica', 'administrador'];
        $esAdmin = in_array(strtolower($user->role->slug ?? ''), $rolesAdmin);

        $query = Prospecto::with(['vendedor', 'distrito', 'cliente'])
            ->addSelect(['wishlist_count' => \DB::table('wish_lists')
                ->selectRaw('COUNT(*)')
                ->whereColumn('wish_lists.user_id', 'prospectos.registered_user_id')
                ->where('wish_lists.deseo', true)
            ]);

        // Solo admins ven todos; otros solo los asignados a ellos
        if (!$esAdmin) {
            $query->where('user_id', $user->id);
        }

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

        // Estadísticas — una sola query agrupada por estado
        $conteoEstados = Prospecto::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $totalGeneral = $conteoEstados->sum();
        $convertidos  = $conteoEstados->get('convertido', 0);

        $estadisticas = [
            'total'           => $totalGeneral,
            'nuevos_mes'      => Prospecto::nuevosEsteMes()->count(),
            'calificados'     => $conteoEstados->get('calificado', 0),
            'tasa_conversion' => $totalGeneral > 0
                ? round(($convertidos / $totalGeneral) * 100, 1)
                : 0,
        ];

        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.prospectos.index', compact(
            'prospectos',
            'estadisticas',
            'vendedores'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.prospectos.create', compact('departamentos', 'vendedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProspectoRequest $request)
    {
        $validated = $request->validated();

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
            'cliente',
            'oportunidades' => fn($q) => $q->latest()->take(5),
            'actividades' => fn($q) => $q->latest()->take(10),
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
        $departamentos = Departamento::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        // Cargar relaciones del distrito actual para pre-seleccionar los cascading selects
        $prospecto->load('distrito.provincia.departamento');

        return view('ADMINISTRADOR.CRM.prospectos.edit', compact('prospecto', 'departamentos', 'vendedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProspectoRequest $request, Prospecto $prospecto)
    {
        $validated = $request->validated();

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
        if ($prospecto->estado === 'convertido') {
            return redirect()
                ->route('admin.crm.prospectos.show', $prospecto)
                ->with('error', 'No se puede eliminar un prospecto convertido a cliente.');
        }

        if ($prospecto->oportunidades()->exists()) {
            return redirect()
                ->route('admin.crm.prospectos.show', $prospecto)
                ->with('error', 'No se puede eliminar un prospecto con oportunidades asociadas.');
        }

        $prospecto->delete();

        return redirect()
            ->route('admin.crm.prospectos.index')
            ->with('success', 'Prospecto eliminado exitosamente.');
    }

    /**
     * Registrar actividad para prospecto
     */
    public function registrarActividad(StoreActividadProspectoRequest $request, Prospecto $prospecto)
    {
        $validated = $request->validated();

        $validated['estado'] = $validated['estado'] ?? 'programada';
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();
        $validated['created_by'] = auth()->id();

        $prospecto->actividades()->create($validated);

        // Actualizar fecha de último contacto del prospecto
        $prospecto->update(['fecha_ultimo_contacto' => now()]);

        return back()->with('success', 'Actividad registrada exitosamente.');
    }

    /**
     * Vista Kanban por estado
     */
    /**
     * Actualizar estado (AJAX o formulario)
     */
    public function actualizarEstado(Request $request, Prospecto $prospecto)
    {
        $validated = $request->validate([
            'estado' => 'required|in:nuevo,contactado,calificado,descartado', // convertido se asigna automáticamente al aprobar una cotización
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

}

