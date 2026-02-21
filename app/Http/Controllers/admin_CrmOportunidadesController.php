<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use App\Models\Producto;
use App\Models\Tipo;
use App\Models\User;
use Illuminate\Http\Request;

class admin_CrmOportunidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Oportunidad::with(['prospecto', 'vendedor', 'cliente']);

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
            'vendedores'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $prospectos = Prospecto::activos()
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

        $prospectoId = $request->get('prospecto_id');
        $montoEstimado = $request->get('monto_estimado');

        return view('ADMINISTRADOR.CRM.oportunidades.create', compact(
            'prospectos',
            'vendedores',
            'tipos',
            'productos',
            'prospectoId',
            'montoEstimado'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'prospecto_id' => 'required|exists:prospectos,id',
            'tipo_proyecto' => 'required|in:residencial,comercial,industrial,agricola',
            'tipo_oportunidad' => 'required|in:producto,servicio,mixto',
            'monto_estimado' => 'required|numeric|min:0',
            'fecha_cierre_estimada' => 'required|date|after:today',
            // Servicio
            'tipo_servicio' => 'nullable|in:instalacion,mantenimiento_preventivo,mantenimiento_correctivo,ampliacion,otro',
            'descripcion_servicio' => 'nullable|string',
            // Visita técnica
            'requiere_visita_tecnica' => 'nullable|boolean',
            'fecha_visita_programada' => 'nullable|date',
            // Descripción y notas
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            // Productos de interés
            'items' => 'nullable|array',
            'items.*.producto_id' => 'required_with:items|exists:productos,id',
            'items.*.cantidad' => 'required_with:items|numeric|min:0.01',
            'items.*.notas' => 'nullable|string|max:500',
        ]);

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

        return redirect()
            ->route('admin.crm.oportunidades.show', $oportunidad)
            ->with('success', 'Oportunidad creada exitosamente.');
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
            'productosExistentesJson'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:200',
            'prospecto_id' => 'nullable|exists:prospectos,id',
            'cliente_id' => 'nullable|exists:clientes,id',
            'tipo_proyecto' => 'required|in:residencial,comercial,industrial,agricola',
            'tipo_oportunidad' => 'required|in:producto,servicio,mixto',
            'etapa' => 'required|in:calificacion,evaluacion,propuesta_tecnica,negociacion,ganada,perdida',
            'monto_estimado' => 'required|numeric|min:0',
            'monto_final' => 'nullable|numeric|min:0',
            'probabilidad' => 'nullable|integer|min:0|max:100',
            // Servicio
            'tipo_servicio' => 'nullable|in:instalacion,mantenimiento_preventivo,mantenimiento_correctivo,ampliacion,otro',
            'descripcion_servicio' => 'nullable|string',
            // Visita técnica
            'requiere_visita_tecnica' => 'nullable|boolean',
            'fecha_visita_programada' => 'nullable|date',
            'resultado_visita' => 'nullable|string',
            // Fechas y notas
            'fecha_cierre_estimada' => 'nullable|date',
            'fecha_cierre_real' => 'nullable|date',
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'motivo_perdida' => 'nullable|string|max:100',
            'detalle_perdida' => 'nullable|string',
            'competidor_ganador' => 'nullable|string|max:100',
            // Productos de interés
            'items' => 'nullable|array',
            'items.*.producto_id' => 'required_with:items|exists:productos,id',
            'items.*.cantidad' => 'required_with:items|numeric|min:0.01',
            'items.*.notas' => 'nullable|string|max:500',
        ]);

        $validated['requiere_visita_tecnica'] = $request->has('requiere_visita_tecnica');

        $oportunidad->update($validated);

        // Sincronizar productos de interés
        $syncData = [];
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['producto_id'])) {
                    $syncData[$item['producto_id']] = [
                        'cantidad' => $item['cantidad'] ?? 1,
                        'notas' => $item['notas'] ?? null,
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
     * Marcar oportunidad como ganada
     */
    public function marcarGanada(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'monto_final' => 'nullable|numeric|min:0',
        ]);

        $oportunidad->marcarGanada($validated['monto_final'] ?? null);

        return redirect()
            ->route('admin.crm.oportunidades.show', $oportunidad)
            ->with('success', '🎉 ¡Oportunidad ganada! El prospecto ha sido convertido a cliente.');
    }

    /**
     * Marcar oportunidad como perdida
     */
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
     * Crear cotización desde oportunidad
     */
    public function crearCotizacion(Request $request, Oportunidad $oportunidad)
    {
        $cotizacion = $oportunidad->crearCotizacion();

        return redirect()
            ->route('admin.crm.cotizaciones.edit', $cotizacion)
            ->with('success', 'Cotización creada. Agregue los ítems del catálogo.');
    }

    /**
     * Registrar actividad
     */
    public function registrarActividad(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,videollamada,whatsapp,tarea,nota',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'prioridad' => 'nullable|in:alta,media,baja,urgente',
            'user_id' => 'nullable|exists:users,id',
        ]);

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
            'ganadas_mes' => Oportunidad::ganadas()->delMes()->count(),
            'valor_ganado_mes' => Oportunidad::ganadas()->delMes()->sum('monto_final'),
            'perdidas_mes' => Oportunidad::perdidas()->delMes()->count(),
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
     * Exportar oportunidades
     */
    public function exportar(Request $request)
    {
        $query = Oportunidad::with(['prospecto', 'vendedor']);

        if ($request->filled('etapa')) {
            $query->where('etapa', $request->etapa);
        }

        if (!$request->filled('incluir_cerradas')) {
            $query->activas();
        }

        $oportunidades = $query->get();

        $filename = 'oportunidades_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($oportunidades) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Código', 'Nombre', 'Cliente/Prospecto', 'Etapa', 'Tipo Proyecto',
                'Tipo Oportunidad', 'Monto Estimado', 'Valor Ponderado',
                'Probabilidad', 'Fecha Cierre Est.', 'Vendedor', 'Días en Pipeline'
            ]);

            foreach ($oportunidades as $o) {
                fputcsv($file, [
                    $o->codigo,
                    $o->nombre,
                    $o->prospecto?->nombre_completo ?? $o->cliente?->nombre_completo,
                    $o->nombre_etapa,
                    $o->tipo_proyecto,
                    $o->tipo_oportunidad,
                    $o->monto_estimado,
                    $o->valor_ponderado,
                    $o->probabilidad . '%',
                    $o->fecha_cierre_estimada?->format('d/m/Y'),
                    $o->vendedor?->name,
                    $o->dias_en_pipeline,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Convertir el prospecto de una oportunidad ganada a cliente
     */
    public function convertirACliente(Oportunidad $oportunidad)
    {
        if ($oportunidad->etapa !== 'ganada') {
            return back()->with('error', 'Solo se pueden convertir prospectos de oportunidades ganadas.');
        }

        if (!$oportunidad->prospecto) {
            return back()->with('error', 'Esta oportunidad no tiene un prospecto asociado.');
        }

        if ($oportunidad->cliente_id) {
            return back()->with('info', 'Este prospecto ya fue convertido a cliente.');
        }

        $cliente = $oportunidad->prospecto->convertirACliente();
        
        $oportunidad->cliente_id = $cliente->id;
        $oportunidad->save();

        return redirect()
            ->route('admin.crm.oportunidades.show', $oportunidad)
            ->with('success', '🎉 ¡Prospecto convertido a cliente exitosamente! Código: ' . $cliente->codigo);
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
