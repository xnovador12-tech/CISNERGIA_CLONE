<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class admin_CrmMantenimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mantenimiento::with(['cliente', 'tecnico']);

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', fn($q2) => 
                      $q2->where('nombre', 'like', "%{$buscar}%")
                         ->orWhere('razon_social', 'like', "%{$buscar}%")
                  );
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_programada', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_programada', '<=', $request->fecha_hasta);
        }

        $orderBy = $request->get('order_by', 'fecha_programada');
        $orderDir = $request->get('order_dir', 'asc');
        $query->orderBy($orderBy, $orderDir);

        // Usar get() para DataTables del lado del cliente
        $mantenimientos = $query->get();

        // Estadísticas
        $hoy = now();
        $stats = [
            'programados' => Mantenimiento::whereIn('estado', ['programado', 'confirmado'])->count(),
            'en_ejecucion' => Mantenimiento::where('estado', 'en_ejecucion')->count(),
            'completados_mes' => Mantenimiento::where('estado', 'completado')
                ->whereMonth('fecha_realizada', $hoy->month)
                ->whereYear('fecha_realizada', $hoy->year)->count(),
            'proximos' => Mantenimiento::whereBetween('fecha_programada', [$hoy, $hoy->copy()->addDays(7)])
                ->whereIn('estado', ['programado', 'confirmado'])->count(),
        ];

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $clientes = Cliente::orderBy('nombre')->get();

        return view('ADMINISTRADOR.CRM.mantenimientos.index', compact(
            'mantenimientos',
            'stats',
            'tecnicos',
            'clientes'
        ));
    }

    /**
     * Vista calendario de mantenimientos
     */
    public function calendario(Request $request)
    {
        $mes = $request->get('mes', now()->month);
        $ano = $request->get('ano', now()->year);
        $tecnicoId = $request->get('tecnico_id');

        $inicio = Carbon::create($ano, $mes, 1)->startOfMonth();
        $fin = Carbon::create($ano, $mes, 1)->endOfMonth();

        $query = Mantenimiento::with(['cliente', 'tecnico'])
            ->whereBetween('fecha_programada', [$inicio, $fin]);

        if ($tecnicoId) {
            $query->where('tecnico_id', $tecnicoId);
        }

        $mantenimientos = $query->orderBy('fecha_programada')
            ->orderBy('hora_programada')
            ->get()
            ->groupBy(fn($m) => $m->fecha_programada->format('Y-m-d'));

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        return view('ADMINISTRADOR.CRM.mantenimientos.calendario', compact(
            'mantenimientos',
            'mes',
            'ano',
            'tecnicos',
            'tecnicoId'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);
        $clienteId = $request->get('cliente_id');

        // Checklist por defecto según tipo
        $checklistsPorTipo = $this->getChecklistsPorTipo();

        return view('ADMINISTRADOR.CRM.mantenimientos.create', compact(
            'clientes',
            'tecnicos',
            'clienteId',
            'checklistsPorTipo'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:preventivo,correctivo,predictivo,limpieza,inspeccion',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'hora_programada' => 'nullable|date_format:H:i',
            'duracion_estimada_horas' => 'nullable|integer|min:1|max:24',
            'direccion' => 'required|string|max:255',
            'tecnico_id' => 'nullable|exists:users,id',
            'descripcion' => 'nullable|string',
            'potencia_sistema_kw' => 'nullable|numeric|min:0',
            'cantidad_paneles' => 'nullable|integer|min:1',
            'marca_inversor' => 'nullable|string|max:100',
            'modelo_inversor' => 'nullable|string|max:100',
            'es_gratuito' => 'boolean',
            'observaciones' => 'nullable|string',
            'checklist' => 'nullable|array',
        ]);

        $validated['estado'] = 'programado';

        // Generar checklist por defecto si no se envió
        if (empty($validated['checklist'])) {
            $validated['checklist'] = $this->getChecklistPorTipo($validated['tipo']);
        }

        $mantenimiento = Mantenimiento::create($validated);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento programado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mantenimiento $mantenimiento)
    {
        $mantenimiento->load(['cliente', 'tecnico']);

        // Historial de mantenimientos del cliente
        $historial = Mantenimiento::where('cliente_id', $mantenimiento->cliente_id)
            ->where('id', '!=', $mantenimiento->id)
            ->orderByDesc('fecha_programada')
            ->take(5)
            ->get();

        return view('ADMINISTRADOR.CRM.mantenimientos.show', compact('mantenimiento', 'historial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mantenimiento $mantenimiento)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);
        $checklistsPorTipo = $this->getChecklistsPorTipo();

        return view('ADMINISTRADOR.CRM.mantenimientos.edit', compact(
            'mantenimiento',
            'clientes',
            'tecnicos',
            'checklistsPorTipo'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        // Si solo se está actualizando el checklist
        if ($request->has('solo_checklist')) {
            $checklist = [];
            foreach ($request->input('checklist', []) as $item) {
                $checklist[] = [
                    'tarea' => $item['tarea'] ?? 'Tarea',
                    'completado' => isset($item['completado']),
                ];
            }
            $mantenimiento->update(['checklist' => $checklist]);
            
            return redirect()
                ->route('admin.crm.mantenimientos.show', $mantenimiento)
                ->with('success', 'Checklist actualizado exitosamente.');
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:preventivo,correctivo,predictivo,limpieza,inspeccion',
            'fecha_programada' => 'required|date',
            'hora_programada' => 'nullable|date_format:H:i',
            'duracion_estimada_horas' => 'nullable|integer|min:1|max:24',
            'direccion' => 'required|string|max:255',
            'tecnico_id' => 'nullable|exists:users,id',
            'estado' => 'required|in:programado,confirmado,en_camino,en_progreso,completado,cancelado,reprogramado',
            'descripcion' => 'nullable|string',
            'es_gratuito' => 'boolean',
            'potencia_sistema_kw' => 'nullable|numeric|min:0',
            'cantidad_paneles' => 'nullable|integer|min:1',
            'marca_inversor' => 'nullable|string|max:100',
            'modelo_inversor' => 'nullable|string|max:100',
            'costo_mano_obra' => 'nullable|numeric|min:0',
            'costo_materiales' => 'nullable|numeric|min:0',
            'costo_transporte' => 'nullable|numeric|min:0',
            'estado_pago' => 'nullable|in:pendiente,pagado,no_aplica',
        ]);

        // Manejar checkbox es_gratuito
        $validated['es_gratuito'] = $request->has('es_gratuito');
        
        // Calcular costo total
        $validated['costo_total'] = ($validated['costo_mano_obra'] ?? 0) + 
                                    ($validated['costo_materiales'] ?? 0) + 
                                    ($validated['costo_transporte'] ?? 0);

        $mantenimiento->update($validated);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mantenimiento $mantenimiento)
    {
        $mantenimiento->delete();

        return redirect()
            ->route('admin.crm.mantenimientos.index')
            ->with('success', 'Mantenimiento eliminado exitosamente.');
    }

    /**
     * Confirmar mantenimiento
     */
    public function confirmar(Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->estado !== 'programado') {
            return back()->with('error', 'Solo se pueden confirmar mantenimientos programados.');
        }

        $mantenimiento->update(['estado' => 'confirmado']);

        return back()->with('success', 'Mantenimiento confirmado.');
    }

    /**
     * Iniciar mantenimiento
     */
    public function iniciar(Mantenimiento $mantenimiento)
    {
        if (!in_array($mantenimiento->estado, ['programado', 'confirmado'])) {
            return back()->with('error', 'Este mantenimiento no puede iniciarse.');
        }

        $mantenimiento->update([
            'estado' => 'en_progreso',
            'fecha_realizada' => now(),
            'hora_inicio' => now()->format('H:i'),
        ]);

        return back()->with('success', 'Mantenimiento iniciado.');
    }

    /**
     * Completar mantenimiento
     */
    public function completar(Request $request, Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->estado !== 'en_progreso') {
            return back()->with('error', 'Solo se pueden completar mantenimientos en progreso.');
        }

        $validated = $request->validate([
            'trabajo_realizado' => 'required|string',
            'hallazgos' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'costo_mano_obra' => 'nullable|numeric|min:0',
            'costo_materiales' => 'nullable|numeric|min:0',
        ]);

        // Calcular hora fin y duración real si tiene hora inicio
        $duracionReal = null;
        $horaFin = now()->format('H:i');
        
        if ($mantenimiento->hora_inicio && $mantenimiento->fecha_realizada) {
            $horaInicio = Carbon::parse($mantenimiento->fecha_realizada->format('Y-m-d') . ' ' . $mantenimiento->hora_inicio);
            $duracionReal = round($horaInicio->diffInMinutes(now()) / 60, 2);
        }

        // Calcular costo total
        $costoTotal = ($validated['costo_mano_obra'] ?? 0) + ($validated['costo_materiales'] ?? 0);

        $mantenimiento->update([
            'estado' => 'completado',
            'fecha_realizada' => $mantenimiento->fecha_realizada ?? now(),
            'hora_fin' => $horaFin,
            'duracion_real_horas' => $duracionReal,
            'trabajo_realizado' => $validated['trabajo_realizado'],
            'hallazgos' => $validated['hallazgos'],
            'recomendaciones' => $validated['recomendaciones'],
            'observaciones' => $validated['observaciones'],
            'costo_mano_obra' => $validated['costo_mano_obra'] ?? 0,
            'costo_materiales' => $validated['costo_materiales'] ?? 0,
            'costo_total' => $costoTotal,
        ]);

        return redirect()
            ->route('admin.crm.mantenimientos.index')
            ->with('success', 'âœ… Mantenimiento completado exitosamente.');
    }

    /**
     * Cancelar mantenimiento
     */
    public function cancelar(Request $request, Mantenimiento $mantenimiento)
    {
        if (in_array($mantenimiento->estado, ['completado', 'cancelado'])) {
            return back()->with('error', 'Este mantenimiento no puede cancelarse.');
        }

        $validated = $request->validate([
            'motivo_cancelacion' => 'nullable|string|max:500',
        ]);

        $motivo = $validated['motivo_cancelacion'] ?? 'Sin motivo especificado';
        
        $mantenimiento->update([
            'estado' => 'cancelado',
            'observaciones' => ($mantenimiento->observaciones ?? '') . "\n[Cancelado " . now()->format('d/m/Y H:i') . "] " . $motivo,
        ]);

        return redirect()
            ->route('admin.crm.mantenimientos.index')
            ->with('info', 'Mantenimiento cancelado correctamente.');
    }

    /**
     * Reprogramar mantenimiento
     */
    public function reprogramar(Request $request, Mantenimiento $mantenimiento)
    {
        if (in_array($mantenimiento->estado, ['completado', 'en_progreso'])) {
            return back()->with('error', 'Este mantenimiento no puede reprogramarse.');
        }

        $validated = $request->validate([
            'fecha_programada' => 'required|date|after_or_equal:today',
            'hora_programada' => 'nullable|date_format:H:i',
            'motivo_reprogramacion' => 'required|string|max:255',
        ]);

        $mantenimiento->update([
            'fecha_programada' => $validated['fecha_programada'],
            'hora_programada' => $validated['hora_programada'],
            'estado' => 'programado',
            'notas_previas' => ($mantenimiento->notas_previas ?? '') . 
                "\n[Reprogramado " . now()->format('d/m/Y') . "] " . $validated['motivo_reprogramacion'],
        ]);

        return back()->with('success', 'Mantenimiento reprogramado.');
    }

    /**
     * Asignar técnico
     */
    public function asignarTecnico(Request $request, Mantenimiento $mantenimiento)
    {
        $validated = $request->validate([
            'tecnico_id' => 'required|exists:users,id',
        ]);

        $mantenimiento->update(['tecnico_id' => $validated['tecnico_id']]);

        $tecnico = User::find($validated['tecnico_id']);
        return back()->with('success', "Técnico {$tecnico->name} asignado.");
    }

    /**
     * Generar reporte de mantenimiento (PDF)
     */
    public function generarReporte(Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->estado !== 'completado') {
            return back()->with('error', 'Solo se pueden generar reportes de mantenimientos completados.');
        }

        $mantenimiento->load(['cliente', 'tecnico']);

        // Usar DomPDF si está disponible
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ADMINISTRADOR.CRM.mantenimientos.reporte-pdf', compact('mantenimiento'));
            return $pdf->download("mantenimiento_{$mantenimiento->codigo}.pdf");
        }

        // Fallback: vista HTML para imprimir
        return view('ADMINISTRADOR.CRM.mantenimientos.reporte-pdf', compact('mantenimiento'));
    }

    /**
     * Programar mantenimiento recurrente
     */
    public function programarRecurrente(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo' => 'required|in:preventivo,limpieza,inspeccion',
            'frecuencia_meses' => 'required|integer|in:3,6,12',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'cantidad_programaciones' => 'required|integer|min:1|max:12',
            'tecnico_id' => 'nullable|exists:users,id',
            'descripcion' => 'nullable|string',
        ]);

        $mantenimientosCreados = [];
        $fecha = Carbon::parse($validated['fecha_inicio']);

        for ($i = 0; $i < $validated['cantidad_programaciones']; $i++) {
            $mantenimiento = Mantenimiento::create([
                'cliente_id' => $validated['cliente_id'],
                'tipo' => $validated['tipo'],
                'fecha_programada' => $fecha->copy(),
                'tecnico_id' => $validated['tecnico_id'],
                'estado' => 'programado',
                'prioridad' => 'media',
                'descripcion' => $validated['descripcion'] ?? "Mantenimiento {$validated['tipo']} programado",
                'checklist' => $this->getChecklistPorTipo($validated['tipo']),
            ]);
            
            $mantenimientosCreados[] = $mantenimiento;
            $fecha->addMonths($validated['frecuencia_meses']);
        }

        return redirect()
            ->route('admin.crm.mantenimientos.index')
            ->with('success', count($mantenimientosCreados) . ' mantenimientos programados exitosamente.');
    }

    /**
     * Eventos para FullCalendar (AJAX)
     */
    public function eventosCalendario(Request $request)
    {
        $inicio = $request->get('start');
        $fin = $request->get('end');
        $tecnicoId = $request->get('tecnico_id');

        $query = Mantenimiento::with(['cliente', 'tecnico'])
            ->whereBetween('fecha_programada', [$inicio, $fin]);

        if ($tecnicoId) {
            $query->where('tecnico_id', $tecnicoId);
        }

        $mantenimientos = $query->get();

        $eventos = $mantenimientos->map(function ($m) {
            $colores = [
                'programado' => '#3B82F6',
                'confirmado' => '#8B5CF6',
                'en_progreso' => '#F59E0B',
                'completado' => '#10B981',
                'cancelado' => '#EF4444',
            ];

            $start = $m->fecha_programada->format('Y-m-d');
            if ($m->hora_programada) {
                $start .= 'T' . $m->hora_programada;
            }

            return [
                'id' => $m->id,
                'title' => $m->cliente->nombre_corto . ' - ' . ucfirst($m->tipo),
                'start' => $start,
                'color' => $colores[$m->estado] ?? '#64748B',
                'extendedProps' => [
                    'tipo' => $m->tipo,
                    'estado' => $m->estado,
                    'cliente' => $m->cliente->nombre_completo,
                    'tecnico' => $m->tecnico?->name,
                    'url' => route('ADMINISTRADOR.CRM.mantenimientos.show', $m),
                ],
            ];
        });

        return response()->json($eventos);
    }

    /**
     * Obtener checklists por tipo de mantenimiento
     */
    protected function getChecklistsPorTipo(): array
    {
        return [
            'preventivo' => $this->getChecklistPorTipo('preventivo'),
            'correctivo' => $this->getChecklistPorTipo('correctivo'),
            'limpieza' => $this->getChecklistPorTipo('limpieza'),
            'inspeccion' => $this->getChecklistPorTipo('inspeccion'),
            'predictivo' => $this->getChecklistPorTipo('predictivo'),
        ];
    }

    /**
     * Obtener checklist específico por tipo
     */
    protected function getChecklistPorTipo(string $tipo): array
    {
        $checklists = [
            'preventivo' => [
                ['tarea' => 'Inspección visual de paneles', 'completado' => false],
                ['tarea' => 'Limpieza de paneles solares', 'completado' => false],
                ['tarea' => 'Verificación de conexiones eléctricas', 'completado' => false],
                ['tarea' => 'Revisión de estructura de montaje', 'completado' => false],
                ['tarea' => 'Verificación de inversor (luces, pantalla)', 'completado' => false],
                ['tarea' => 'Lectura de producción actual', 'completado' => false],
                ['tarea' => 'Verificación de puesta a tierra', 'completado' => false],
                ['tarea' => 'Revisión de cableado y canalizaciones', 'completado' => false],
                ['tarea' => 'Verificación de protecciones eléctricas', 'completado' => false],
                ['tarea' => 'Test de funcionamiento general', 'completado' => false],
            ],
            'correctivo' => [
                ['tarea' => 'Diagnóstico del problema', 'completado' => false],
                ['tarea' => 'Identificación de componente fallado', 'completado' => false],
                ['tarea' => 'Reparación/reemplazo realizado', 'completado' => false],
                ['tarea' => 'Pruebas post-reparación', 'completado' => false],
                ['tarea' => 'Verificación de funcionamiento normal', 'completado' => false],
                ['tarea' => 'Lectura de producción post-reparación', 'completado' => false],
            ],
            'limpieza' => [
                ['tarea' => 'Limpieza de superficie de paneles', 'completado' => false],
                ['tarea' => 'Limpieza de marcos de paneles', 'completado' => false],
                ['tarea' => 'Limpieza de estructura', 'completado' => false],
                ['tarea' => 'Limpieza de área del inversor', 'completado' => false],
                ['tarea' => 'Retiro de hojas/suciedad acumulada', 'completado' => false],
                ['tarea' => 'Verificación visual post-limpieza', 'completado' => false],
            ],
            'inspeccion' => [
                ['tarea' => 'Inspección visual de paneles', 'completado' => false],
                ['tarea' => 'Inspección de estructura', 'completado' => false],
                ['tarea' => 'Inspección de cableado', 'completado' => false],
                ['tarea' => 'Inspección del inversor', 'completado' => false],
                ['tarea' => 'Verificación de medidor bidireccional', 'completado' => false],
                ['tarea' => 'Registro fotográfico', 'completado' => false],
                ['tarea' => 'Lectura de producción', 'completado' => false],
            ],
            'predictivo' => [
                ['tarea' => 'Análisis de datos de producción', 'completado' => false],
                ['tarea' => 'Termografía de paneles', 'completado' => false],
                ['tarea' => 'Medición de curvas I-V', 'completado' => false],
                ['tarea' => 'Análisis de rendimiento', 'completado' => false],
                ['tarea' => 'Evaluación de degradación', 'completado' => false],
                ['tarea' => 'Informe predictivo', 'completado' => false],
            ],
        ];

        return $checklists[$tipo] ?? [];
    }

    /**
     * Exportar mantenimientos
     */
    public function exportar(Request $request)
    {
        $query = Mantenimiento::with(['cliente', 'tecnico']);

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_programada', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_programada', '<=', $request->fecha_hasta);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $mantenimientos = $query->orderBy('fecha_programada')->get();

        $filename = 'mantenimientos_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($mantenimientos) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Código', 'Cliente', 'Tipo', 'Fecha Programada', 'Estado',
                'Técnico', 'Duración (hrs)', 'Costo Total', 'Observaciones'
            ]);

            foreach ($mantenimientos as $m) {
                fputcsv($file, [
                    $m->codigo,
                    $m->cliente?->nombre_completo,
                    $m->tipo,
                    $m->fecha_programada?->format('d/m/Y'),
                    $m->estado,
                    $m->tecnico?->name,
                    $m->duracion_real_horas ?? $m->duracion_estimada_horas,
                    $m->costo_total,
                    $m->observaciones,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

