<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Tipo;
use App\Models\User;
use App\Http\Requests\StoreActividadOportunidadRequest;
use App\Http\Requests\StoreOportunidadRequest;
use App\Http\Requests\UpdateOportunidadRequest;
use Illuminate\Http\Request;

class admin_CrmOportunidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $rolesAdmin = ['cuantica', 'administrador'];
        $esAdmin = in_array(strtolower($user->role->slug ?? ''), $rolesAdmin);

        $query = Oportunidad::with(['prospecto', 'vendedor', 'cliente']);

        // Filtro por rol: no admins solo ven sus oportunidades
        if (!$esAdmin) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%")
                  ->orWhereHas('prospecto', fn($q2) => 
                      $q2->where('nombre', 'like', "%{$buscar}%")
                         ->orWhere('razon_social', 'like', "%{$buscar}%")
                  );
            });
        }

        if ($request->filled('etapa')) {
            $query->where('etapa', $request->etapa);
        }

        if ($request->filled('tipo_proyecto')) {
            $query->where('tipo_proyecto', $request->tipo_proyecto);
        }

        if ($request->filled('vendedor_id')) {
            $query->where('user_id', $request->vendedor_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_creacion', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_creacion', '<=', $request->fecha_hasta);
        }

        // Todas las oportunidades se envían a la vista
        // El filtro "Incluir Ganadas/Perdidas" se maneja en el frontend con DataTables

        $orderBy = $request->get('order_by', 'fecha_cierre_estimada');
        $orderDir = $request->get('order_dir', 'asc');
        $query->orderBy($orderBy, $orderDir);

        $oportunidades = $query->get();

        // Estadísticas del pipeline
        $pipelineStats = $this->getEstadisticasPipeline();
        
        $estadisticas = [
            'valor_pipeline' => $pipelineStats['total_ponderado'] ?? 0,
            'activas' => $pipelineStats['total_oportunidades'] ?? 0,
            'tasa_conversion' => $pipelineStats['tasa_conversion'] ?? 0,
            'valor_ganado_mes' => $pipelineStats['valor_ganado_mes'] ?? 0,
        ];

        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.oportunidades.index', compact(
            'oportunidades',
            'estadisticas',
            'vendedores',
            'esAdmin'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Incluir prospectos convertidos: un cliente puede tener nuevas oportunidades
        // (ampliación, mantenimiento, segundo proyecto, etc.)
        // Solo se excluyen los descartados
        $prospectos = Prospecto::where('estado', '!=', 'descartado')
            ->orderBy('nombre')
            ->get();
        
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        // Tipos con categorías (cascada) — mismo patrón que cotizaciones
        $tipos = Tipo::with(['categories' => function ($q) {
            $q->where('estado', 'Activo')->orderBy('name');
        }])->where('estado', 'Activo')->orderBy('name')->get();

        // Productos activos con relaciones
        $productos = Producto::where('estado', 'Activo')
            ->with(['marca', 'categorie', 'tipo'])
            ->orderBy('name')
            ->get();

        // Servicios activos del catálogo (lista plana)
        $servicios = Servicio::where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        $prospectoId = $request->get('prospecto_id');
        $montoEstimado = $request->get('monto_estimado');

        return view('ADMINISTRADOR.CRM.oportunidades.create', compact(
            'prospectos',
            'vendedores',
            'tipos',
            'productos',
            'servicios',
            'prospectoId',
            'montoEstimado'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOportunidadRequest $request)
    {
        $validated = $request->validated();

        $validated['etapa'] = 'calificacion';
        $validated['probabilidad'] = Oportunidad::ETAPAS['calificacion']['probabilidad'];
        $validated['fecha_creacion'] = now();
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();
        $validated['requiere_visita_tecnica'] = $request->has('requiere_visita_tecnica');

        $oportunidad = Oportunidad::create($validated);

        // Guardar productos de interés
        if ($request->has('items')) {
            $syncData = [];
            foreach ($request->items as $item) {
                if (!empty($item['producto_id'])) {
                    $syncData[$item['producto_id']] = [
                        'cantidad' => $item['cantidad'] ?? 1,
                        'notas' => $item['notas'] ?? null,
                    ];
                }
            }
            $oportunidad->productosInteres()->sync($syncData);
        }

        // Auto-crear actividad de visita técnica si aplica
        if ($oportunidad->requiere_visita_tecnica && $oportunidad->fecha_visita_programada) {
            \App\Models\ActividadCrm::create([
                'tipo'              => 'visita_tecnica',
                'actividadable_type'=> Oportunidad::class,
                'actividadable_id'  => $oportunidad->id,
                'titulo'            => 'Visita Técnica — ' . $oportunidad->nombre,
                'descripcion'       => $oportunidad->descripcion_servicio
                                        ? 'Evaluación técnica para: ' . $oportunidad->descripcion_servicio
                                        : 'Evaluación técnica de la oportunidad ' . $oportunidad->codigo,
                'ubicacion'         => $oportunidad->ubicacion_visita,
                'fecha_programada'  => $oportunidad->fecha_visita_programada,
                'estado'            => 'programada',
                'prioridad'         => 'alta',
                'user_id'           => $oportunidad->tecnico_visita_id ?? auth()->id(),
                'created_by'        => auth()->id(),
                'recordatorio_activo'          => true,
                'recordatorio_minutos_antes'   => 60,
            ]);
        }

        return redirect()
            ->route('admin.crm.oportunidades.show', $oportunidad)
            ->with('success', 'Oportunidad creada exitosamente.' .
                ($oportunidad->requiere_visita_tecnica && $oportunidad->fecha_visita_programada
                    ? ' Se creó la actividad de visita técnica automáticamente.'
                    : ''));
    }

    /**
     * Display the specified resource.
     */
    public function show(Oportunidad $oportunidad)
    {
        $oportunidad->load([
            'prospecto',
            'cliente',
            'vendedor',
            'tecnicoVisita',
            'servicio',
            'cotizaciones' => fn($q) => $q->latest(),
            'actividades' => fn($q) => $q->latest()->take(15),
            'productosInteres.marca',
            'productosInteres.categorie',
            'productosInteres.tipo',
        ]);

        $etapasInfo = Oportunidad::ETAPAS;
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.oportunidades.show', compact('oportunidad', 'etapasInfo', 'vendedores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oportunidad $oportunidad)
    {
        $oportunidad->load('productosInteres.marca');
        $prospectos = Prospecto::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $clientes = \App\Models\Cliente::orderBy('nombre')->get();

        // Tipos con categorías (cascada)
        $tipos = Tipo::with(['categories' => function ($q) {
            $q->where('estado', 'Activo')->orderBy('name');
        }])->where('estado', 'Activo')->orderBy('name')->get();

        // Productos activos con relaciones
        $productos = Producto::where('estado', 'Activo')
            ->with(['marca', 'categorie', 'tipo'])
            ->orderBy('name')
            ->get();

        // Servicios activos del catálogo (lista plana)
        $servicios = Servicio::where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        $productosExistentesJson = $oportunidad->productosInteres->map(function($p) {
            return [
                'producto_id' => $p->id,
                'cantidad' => $p->pivot->cantidad,
                'notas' => $p->pivot->notas ?? '',
                'precio' => $p->precio,
                'tipo_id' => $p->tipo_id,
                'categorie_id' => $p->categorie_id,
            ];
        })->values();

        return view('ADMINISTRADOR.CRM.oportunidades.edit', compact(
            'oportunidad',
            'prospectos',
            'vendedores',
            'clientes',
            'tipos',
            'productos',
            'servicios',
            'productosExistentesJson'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOportunidadRequest $request, Oportunidad $oportunidad)
    {
        $validated = $request->validated();

        $validated['requiere_visita_tecnica'] = $request->has('requiere_visita_tecnica');

        // Limpiar campos de servicio si el tipo cambia a 'producto'
        if (($validated['tipo_oportunidad'] ?? null) === 'producto') {
            $validated['servicio_id']         = null;
            $validated['descripcion_servicio'] = null;
            $validated['requiere_visita_tecnica'] = false;
            $validated['fecha_visita_programada'] = null;
            $validated['ubicacion_visita']    = null;
            $validated['tecnico_visita_id']   = null;
        }

        // Guardar estado anterior de visita para comparar
        $visitaAntes = [
            'activa'   => $oportunidad->requiere_visita_tecnica,
            'fecha'    => $oportunidad->fecha_visita_programada?->toDateTimeString(),
            'tecnico'  => $oportunidad->tecnico_visita_id,
            'ubicacion'=> $oportunidad->ubicacion_visita,
        ];

        $oportunidad->update($validated);

        // ── Sincronizar actividad de visita técnica ──────────────────────────
        $visitaDespues = $validated['requiere_visita_tecnica'] ?? false;

        if ($visitaDespues && $oportunidad->fecha_visita_programada) {
            // Buscar actividad de visita existente (programada o en_evaluacion)
            $actividadVisita = \App\Models\ActividadCrm::where('actividadable_type', Oportunidad::class)
                ->where('actividadable_id', $oportunidad->id)
                ->where('tipo', 'visita_tecnica')
                ->whereIn('estado', ['programada', 'en_evaluacion'])
                ->latest()
                ->first();

            $cambioFecha   = $visitaAntes['fecha']    !== $oportunidad->fecha_visita_programada?->toDateTimeString();
            $cambioTecnico = $visitaAntes['tecnico']  !== $oportunidad->tecnico_visita_id;
            $cambioUbic    = $visitaAntes['ubicacion'] !== $oportunidad->ubicacion_visita;

            if ($actividadVisita) {
                // Actualizar la actividad existente si cambiaron datos relevantes
                if ($cambioFecha || $cambioTecnico || $cambioUbic) {
                    $actividadVisita->update([
                        'fecha_programada' => $oportunidad->fecha_visita_programada,
                        'user_id'          => $oportunidad->tecnico_visita_id ?? $actividadVisita->user_id,
                        'ubicacion'        => $oportunidad->ubicacion_visita,
                    ]);
                }
            } elseif (!$visitaAntes['activa']) {
                // Se activó requiere_visita_tecnica en este update → crear actividad nueva
                \App\Models\ActividadCrm::create([
                    'tipo'               => 'visita_tecnica',
                    'actividadable_type' => Oportunidad::class,
                    'actividadable_id'   => $oportunidad->id,
                    'titulo'             => 'Visita Técnica — ' . $oportunidad->nombre,
                    'descripcion'        => $oportunidad->descripcion_servicio
                                            ? 'Evaluación técnica para: ' . $oportunidad->descripcion_servicio
                                            : 'Evaluación técnica de la oportunidad ' . $oportunidad->codigo,
                    'ubicacion'          => $oportunidad->ubicacion_visita,
                    'fecha_programada'   => $oportunidad->fecha_visita_programada,
                    'estado'             => 'programada',
                    'prioridad'          => 'alta',
                    'user_id'            => $oportunidad->tecnico_visita_id ?? auth()->id(),
                    'created_by'         => auth()->id(),
                    'recordatorio_activo'         => true,
                    'recordatorio_minutos_antes'  => 60,
                ]);
            }
        }

        // Sincronizar productos de interés
        $syncData = [];
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['producto_id'])) {
                    $syncData[$item['producto_id']] = [
                        'cantidad' => $item['cantidad'] ?? 1,
                        'notas'    => $item['notas'] ?? null,
                    ];
                }
            }
        }
        $oportunidad->productosInteres()->sync($syncData);

        $redirectTo = $request->get('redirect_to');
        $route = $redirectTo === 'show'
            ? route('admin.crm.oportunidades.show', $oportunidad)
            : route('admin.crm.oportunidades.index');

        return redirect($route)->with('success', 'Oportunidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Oportunidad $oportunidad)
    {
        if ($oportunidad->etapa === 'ganada') {
            return redirect()
                ->route('admin.crm.oportunidades.show', $oportunidad)
                ->with('error', 'No se puede eliminar una oportunidad ganada. Tiene un pedido asociado.');
        }

        if ($oportunidad->cotizaciones()->exists()) {
            return redirect()
                ->route('admin.crm.oportunidades.show', $oportunidad)
                ->with('error', 'No se puede eliminar una oportunidad con cotizaciones asociadas. Elimina primero las cotizaciones.');
        }

        $oportunidad->delete();

        return redirect()
            ->route('admin.crm.oportunidades.index')
            ->with('success', 'Oportunidad eliminada exitosamente.');
    }

    /**
     * Avanzar oportunidad a siguiente etapa
     */
    public function avanzarEtapa(Oportunidad $oportunidad)
    {
        if ($oportunidad->avanzarEtapa()) {
            return back()->with('success', "Oportunidad avanzada a: {$oportunidad->nombre_etapa}");
        }

        return back()->with('error', 'No se puede avanzar más esta oportunidad.');
    }

    /**
     * Avanza la oportunidad a cotizacion y redirige a crear cotización.
     * Si ya está en cotizacion o más adelante, solo redirige.
     */
    public function crearCotizacion(Oportunidad $oportunidad)
    {
        $etapas = array_keys(Oportunidad::ETAPAS);
        $indiceActual = array_search($oportunidad->etapa, $etapas);
        $indicePropuesta = array_search('cotizacion', $etapas);

        // Avanzar solo si aún está antes de cotizacion
        if ($indiceActual !== false && $indiceActual < $indicePropuesta) {
            $oportunidad->etapa = 'cotizacion';
            $oportunidad->probabilidad = Oportunidad::ETAPAS['cotizacion']['probabilidad'];
            $oportunidad->save();
        }

        return redirect()
            ->route('admin.crm.cotizaciones.create', ['oportunidad_id' => $oportunidad->id])
            ->with('success', 'Oportunidad avanzada a Cotización. Completa la cotización.');
    }
    public function marcarPerdida(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'motivo_perdida' => 'required|string|max:500',
            'detalle_perdida' => 'nullable|string|max:500',
            'competidor_ganador' => 'nullable|string|max:100',
        ]);

        $oportunidad->marcarPerdida(
            $validated['motivo_perdida'],
            $validated['detalle_perdida'],
            $validated['competidor_ganador']
        );

        return redirect()
            ->route('admin.crm.oportunidades.index')
            ->with('info', 'Oportunidad marcada como perdida.');
    }

    /**
     * Registrar actividad
     */
    public function registrarActividad(StoreActividadOportunidadRequest $request, Oportunidad $oportunidad)
    {
        $validated = $request->validated();

        $validated['estado'] = 'programada';
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();
        $validated['created_by'] = auth()->id();

        $oportunidad->actividades()->create($validated);

        return back()->with('success', 'Actividad registrada exitosamente.');
    }

    /**
     * Obtener estadísticas del pipeline
     */
    protected function getEstadisticasPipeline(): array
    {
        $pipeline = Oportunidad::getValorPipeline();
        
        $totalValor = 0;
        $totalPonderado = 0;
        $totalOportunidades = 0;
        
        foreach ($pipeline as $etapa => $datos) {
            $totalValor += $datos['valor'];
            $totalPonderado += $datos['valor_ponderado'];
            $totalOportunidades += $datos['cantidad'];
        }

        return [
            'pipeline' => $pipeline,
            'total_valor' => $totalValor,
            'total_ponderado' => $totalPonderado,
            'total_oportunidades' => $totalOportunidades,
            'ganadas_mes' => Oportunidad::ganadas()->cerradasEnMes()->count(),
            'valor_ganado_mes' => Oportunidad::ganadas()->cerradasEnMes()->sum('monto_final'),
            'perdidas_mes' => Oportunidad::perdidas()->cerradasEnMes()->count(),
            'tasa_conversion' => $this->calcularTasaConversion(),
            'ticket_promedio' => Oportunidad::ganadas()->avg('monto_final') ?? 0,
        ];
    }

    protected function calcularTasaConversion(): float
    {
        $cerradas = Oportunidad::whereIn('etapa', ['ganada', 'perdida'])->count();
        $ganadas = Oportunidad::where('etapa', 'ganada')->count();
        
        return $cerradas > 0 ? round(($ganadas / $cerradas) * 100, 1) : 0;
    }

    /**
     * AJAX: Obtener wishlist de un prospecto
     */
    public function getWishlist(Prospecto $prospecto)
    {
        $wishlistItems = collect();

        if ($prospecto->registered_user_id) {
            $wishlistItems = \DB::table('wish_lists')
                ->join('productos', 'wish_lists.producto_id', '=', 'productos.id')
                ->leftJoin('marcas', 'productos.marca_id', '=', 'marcas.id')
                ->where('wish_lists.user_id', $prospecto->registered_user_id)
                ->where('wish_lists.deseo', true)
                ->select('productos.id', 'productos.name', 'productos.codigo', 'productos.precio', 'marcas.name as marca_nombre')
                ->get();
        }

        return response()->json([
            'wishlist' => $wishlistItems,
            'count' => $wishlistItems->count(),
        ]);
    }
}
