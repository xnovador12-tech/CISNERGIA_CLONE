<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Oportunidad;
use App\Models\Prospecto;
use App\Models\User;
use App\Models\Sede;
use Illuminate\Http\Request;

class admin_CrmOportunidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Oportunidad::with(['prospecto', 'vendedor', 'cliente']);

        // Filtros
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

        // Excluir cerradas por defecto
        if (!$request->filled('incluir_cerradas')) {
            $query->activas();
        }

        $orderBy = $request->get('order_by', 'fecha_cierre_estimada');
        $orderDir = $request->get('order_dir', 'asc');
        $query->orderBy($orderBy, $orderDir);

        // Cargar todos para DataTables del lado cliente
        $oportunidades = $query->get();

        // EstadÃ­sticas del pipeline
        $pipelineStats = $this->getEstadisticasPipeline();
        
        $estadisticas = [
            'valor_pipeline' => $pipelineStats['total_ponderado'] ?? 0,
            'activas' => $pipelineStats['total_oportunidades'] ?? 0,
            'tasa_conversion' => $pipelineStats['tasa_conversion'] ?? 0,
            'ciclo_promedio' => $pipelineStats['ciclo_venta_promedio'] ?? 0,
        ];

        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.index', compact(
            'oportunidades',
            'estadisticas',
            'vendedores'
        ));
    }

    /**
     * Vista Kanban del pipeline
     */
    public function kanban(Request $request)
    {
        $etapas = array_keys(Oportunidad::ETAPAS);
        // Excluir ganada y perdida del kanban activo
        $etapasActivas = array_filter($etapas, fn($e) => !in_array($e, ['ganada', 'perdida']));
        
        $oportunidadesPorEtapa = [];
        foreach ($etapasActivas as $etapa) {
            $query = Oportunidad::with(['prospecto', 'vendedor'])
                ->where('etapa', $etapa)
                ->orderBy('fecha_cierre_estimada');
            
            if ($request->filled('vendedor_id')) {
                $query->where('user_id', $request->vendedor_id);
            }
            
            $oportunidadesPorEtapa[$etapa] = $query->get();
        }

        $estadisticas = $this->getEstadisticasPipeline();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.kanban', compact(
            'oportunidadesPorEtapa',
            'etapasActivas',
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
        
        // Pre-seleccionar prospecto si viene de ahÃ­
        $prospectoId = $request->get('prospecto_id');

        return view('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.create', compact(
            'prospectos',
            'vendedores',
            'prospectoId'
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
            'tipo_proyecto' => 'required|in:residencial,comercial,industrial,agricola,bombeo_solar',
            'monto_estimado' => 'required|numeric|min:0',
            'fecha_cierre_estimada' => 'required|date|after:today',
            'potencia_kw' => 'nullable|numeric|min:0',
            'cantidad_paneles' => 'nullable|integer|min:1',
            'tipo_panel' => 'nullable|string|max:50',
            'marca_panel' => 'nullable|string|max:50',
            'tipo_inversor' => 'nullable|string|max:50',
            'marca_inversor' => 'nullable|string|max:50',
            'incluye_baterias' => 'nullable|boolean',
            'capacidad_baterias_kwh' => 'nullable|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'observaciones' => 'nullable|string',
            'notas_tecnicas' => 'nullable|string',
        ]);

        // Asegurar que incluye_baterias sea booleano
        $validated['incluye_baterias'] = $request->boolean('incluye_baterias');
        
        $validated['etapa'] = 'calificacion';
        $validated['probabilidad'] = Oportunidad::ETAPAS['calificacion']['probabilidad'];
        $validated['fecha_creacion'] = now();
        $validated['user_id'] = $validated['user_id'] ?? auth()->id();

        $oportunidad = Oportunidad::create($validated);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.show', $oportunidad)
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
            'tecnico',
            'cotizaciones' => fn($q) => $q->latest(),
            'actividades' => fn($q) => $q->latest()->take(15),
        ]);

        // Info de etapas para la lÃ­nea de tiempo
        $etapasInfo = Oportunidad::ETAPAS;

        return view('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.show', compact('oportunidad', 'etapasInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oportunidad $oportunidad)
    {
        $prospectos = Prospecto::orderBy('nombre')->get();
        $vendedores = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $clientes = \App\Models\Cliente::orderBy('nombre')->get();
        $sedes = Sede::orderBy('name')->get();

        return view('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.edit', compact(
            'oportunidad',
            'prospectos',
            'vendedores',
            'tecnicos',
            'clientes',
            'sedes'
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
            'tipo_proyecto' => 'required|in:residencial,comercial,industrial,agricola,bombeo_solar',
            'etapa' => 'required|in:calificacion,analisis_sitio,propuesta_tecnica,negociacion,contrato,ganada,perdida',
            'monto_estimado' => 'required|numeric|min:0',
            'monto_final' => 'nullable|numeric|min:0',
            'probabilidad' => 'nullable|integer|min:0|max:100',
            'fecha_cierre_estimada' => 'nullable|date',
            'fecha_cierre_real' => 'nullable|date',
            'fecha_instalacion_estimada' => 'nullable|date',
            'potencia_kw' => 'nullable|numeric|min:0',
            'cantidad_paneles' => 'nullable|integer|min:0',
            'tipo_panel' => 'nullable|string|max:50',
            'marca_panel' => 'nullable|string|max:50',
            'tipo_inversor' => 'nullable|string|max:50',
            'marca_inversor' => 'nullable|string|max:50',
            'incluye_baterias' => 'nullable|boolean',
            'capacidad_baterias_kwh' => 'nullable|numeric|min:0',
            'produccion_mensual_kwh' => 'nullable|numeric|min:0',
            'produccion_anual_kwh' => 'nullable|numeric|min:0',
            'ahorro_mensual_soles' => 'nullable|numeric|min:0',
            'ahorro_anual_soles' => 'nullable|numeric|min:0',
            'retorno_inversion_anos' => 'nullable|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
            'tecnico_id' => 'nullable|exists:users,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'observaciones' => 'nullable|string',
            'notas_tecnicas' => 'nullable|string',
            'motivo_perdida' => 'nullable|string|max:100',
            'detalle_perdida' => 'nullable|string',
            'competidor_ganador' => 'nullable|string|max:100',
        ]);

        // Asegurar que incluye_baterias sea booleano
        $validated['incluye_baterias'] = $request->boolean('incluye_baterias');

        $oportunidad->update($validated);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.show', $oportunidad)
            ->with('success', 'Oportunidad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Oportunidad $oportunidad)
    {
        $oportunidad->delete();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.index')
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

        return back()->with('error', 'No se puede avanzar mÃ¡s esta oportunidad.');
    }

    /**
     * Cambiar etapa especÃ­fica (para Kanban drag & drop)
     */
    public function cambiarEtapa(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'etapa' => 'required|in:' . implode(',', array_keys(Oportunidad::ETAPAS)),
        ]);

        $oportunidad->etapa = $validated['etapa'];
        $oportunidad->probabilidad = Oportunidad::ETAPAS[$validated['etapa']]['probabilidad'];
        $oportunidad->save();

        return response()->json([
            'success' => true,
            'message' => 'Etapa actualizada',
            'oportunidad' => $oportunidad->fresh(['prospecto']),
        ]);
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
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.show', $oportunidad)
            ->with('success', 'ðŸŽ‰ Â¡Oportunidad ganada! El prospecto ha sido convertido a cliente.');
    }

    /**
     * Marcar oportunidad como perdida
     */
    public function marcarPerdida(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'motivo_perdida' => 'required|in:precio,competencia,presupuesto,tiempo,no_interesado,otro',
            'detalle_perdida' => 'nullable|string|max:500',
            'competidor_ganador' => 'nullable|string|max:100',
        ]);

        $oportunidad->marcarPerdida(
            $validated['motivo_perdida'],
            $validated['detalle_perdida'],
            $validated['competidor_ganador']
        );

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.index')
            ->with('info', 'Oportunidad marcada como perdida.');
    }

    /**
     * Crear cotizaciÃ³n desde oportunidad
     */
    public function crearCotizacion(Request $request, Oportunidad $oportunidad)
    {
        $validated = $request->validate([
            'precio_equipos' => 'required|numeric|min:0',
            'precio_instalacion' => 'required|numeric|min:0',
            'precio_tramites' => 'nullable|numeric|min:0',
            'precio_estructura' => 'nullable|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',
            'tiempo_instalacion_dias' => 'nullable|integer|min:1',
            'condiciones_comerciales' => 'nullable|string',
        ]);

        $cotizacion = $oportunidad->crearCotizacion($validated);
        $cotizacion->calcularTotales();
        $cotizacion->calcularProduccion();
        $cotizacion->calcularAhorro();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.show', $cotizacion)
            ->with('success', 'CotizaciÃ³n creada exitosamente.');
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
            'hora_inicio' => 'nullable|date_format:H:i',
            'duracion_minutos' => 'nullable|integer|min:5',
            'prioridad' => 'nullable|in:alta,media,baja',
        ]);

        $validated['estado'] = 'programada';
        $validated['user_id'] = auth()->id();

        $oportunidad->actividades()->create($validated);

        return back()->with('success', 'Actividad registrada exitosamente.');
    }

    /**
     * Obtener estadÃ­sticas del pipeline
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
            'ciclo_venta_promedio' => $this->calcularCicloVentaPromedio(),
        ];
    }

    /**
     * Calcular tasa de conversiÃ³n
     */
    protected function calcularTasaConversion(): float
    {
        $cerradas = Oportunidad::whereIn('etapa', ['ganada', 'perdida'])->count();
        $ganadas = Oportunidad::where('etapa', 'ganada')->count();
        
        return $cerradas > 0 ? round(($ganadas / $cerradas) * 100, 1) : 0;
    }

    /**
     * Calcular ciclo de venta promedio en dÃ­as
     */
    protected function calcularCicloVentaPromedio(): int
    {
        $oportunidades = Oportunidad::where('etapa', 'ganada')
            ->whereNotNull('fecha_cierre_real')
            ->get();

        if ($oportunidades->isEmpty()) {
            return 0;
        }

        $totalDias = $oportunidades->sum(fn($o) => $o->fecha_creacion->diffInDays($o->fecha_cierre_real));
        
        return (int) round($totalDias / $oportunidades->count());
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
                'CÃ³digo', 'Nombre', 'Cliente/Prospecto', 'Etapa', 'Tipo Proyecto',
                'Potencia kW', 'Monto Estimado', 'Valor Ponderado', 'Probabilidad',
                'Fecha Cierre Est.', 'Vendedor', 'DÃ­as en Pipeline'
            ]);

            foreach ($oportunidades as $o) {
                fputcsv($file, [
                    $o->codigo,
                    $o->nombre,
                    $o->prospecto?->nombre_completo ?? $o->cliente?->nombre_completo,
                    $o->nombre_etapa,
                    $o->tipo_proyecto,
                    $o->potencia_kw,
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
        // Verificar que la oportunidad estÃ© ganada
        if ($oportunidad->etapa !== 'ganada') {
            return back()->with('error', 'Solo se pueden convertir prospectos de oportunidades ganadas.');
        }

        // Verificar que tenga un prospecto asociado
        if (!$oportunidad->prospecto) {
            return back()->with('error', 'Esta oportunidad no tiene un prospecto asociado.');
        }

        // Verificar que no se haya convertido ya
        if ($oportunidad->cliente_id) {
            return back()->with('info', 'Este prospecto ya fue convertido a cliente.');
        }

        // Convertir prospecto a cliente
        $cliente = $oportunidad->prospecto->convertirACliente();
        
        // Actualizar oportunidad con el cliente
        $oportunidad->cliente_id = $cliente->id;
        $oportunidad->save();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.oportunidades.show', $oportunidad)
            ->with('success', 'ðŸŽ‰ Â¡Prospecto convertido a cliente exitosamente! CÃ³digo: ' . $cliente->codigo);
    }
}

