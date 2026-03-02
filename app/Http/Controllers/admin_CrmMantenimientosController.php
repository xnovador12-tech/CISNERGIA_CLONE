<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class admin_CrmMantenimientosController extends Controller
{
    public function index(Request $request)
    {
        $query = Mantenimiento::with(['cliente', 'tecnico']);

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

        $mantenimientos = $query->get();

        $hoy = now();
        $stats = [
            'programados' => Mantenimiento::whereIn('estado', ['programado', 'confirmado'])->count(),
            'en_ejecucion' => Mantenimiento::where('estado', 'en_progreso')->count(),
            'completados_mes' => Mantenimiento::where('estado', 'completado')
                ->whereMonth('fecha_realizada', $hoy->month)
                ->whereYear('fecha_realizada', $hoy->year)->count(),
            'proximos' => Mantenimiento::whereBetween('fecha_programada', [$hoy, $hoy->copy()->addDays(7)])
                ->whereIn('estado', ['programado', 'confirmado'])->count(),
        ];

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $clientes = Cliente::orderBy('nombre')->get();

        return view('ADMINISTRADOR.CRM.mantenimientos.index', compact(
            'mantenimientos', 'stats', 'tecnicos', 'clientes'
        ));
    }

    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);
        $clienteId = $request->get('cliente_id');

        $ticket = null;
        if ($request->filled('ticket_id')) {
            $ticket = Ticket::with('cliente')->find($request->ticket_id);
            if ($ticket) {
                $clienteId = $ticket->cliente_id;
            }
        }

        $checklistsPorTipo = $this->getChecklistsPorTipo();

        return view('ADMINISTRADOR.CRM.mantenimientos.create', compact(
            'clientes', 'tecnicos', 'clienteId', 'checklistsPorTipo', 'ticket'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'ticket_id' => 'nullable|integer',
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
            'notas_internas' => 'nullable|string|max:2000',
            'checklist' => 'nullable|array',
        ]);

        $validated['estado'] = 'programado';

        if (empty($validated['checklist'])) {
            $validated['checklist'] = $this->getChecklistPorTipo($validated['tipo']);
        }

        $mantenimiento = Mantenimiento::create($validated);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento programado exitosamente.');
    }

    public function show(Mantenimiento $mantenimiento)
    {
        $mantenimiento->load(['cliente', 'tecnico', 'ticket']);

        $historial = Mantenimiento::where('cliente_id', $mantenimiento->cliente_id)
            ->where('id', '!=', $mantenimiento->id)
            ->orderByDesc('fecha_programada')
            ->take(5)
            ->get();

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        return view('ADMINISTRADOR.CRM.mantenimientos.show', compact('mantenimiento', 'historial', 'tecnicos'));
    }

    public function edit(Mantenimiento $mantenimiento)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);
        $checklistsPorTipo = $this->getChecklistsPorTipo();

        return view('ADMINISTRADOR.CRM.mantenimientos.edit', compact(
            'mantenimiento', 'clientes', 'tecnicos', 'checklistsPorTipo'
        ));
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        // Solo checklist update
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
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        $validated['es_gratuito'] = $request->has('es_gratuito');
        $validated['costo_total'] = ($validated['costo_mano_obra'] ?? 0) + 
                                    ($validated['costo_materiales'] ?? 0) + 
                                    ($validated['costo_transporte'] ?? 0);

        $mantenimiento->update($validated);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        // Si tiene evidencias, eliminar archivos
        if ($mantenimiento->evidencias) {
            foreach ($mantenimiento->evidencias as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $mantenimiento->delete();

        return redirect()
            ->route('admin.crm.mantenimientos.index')
            ->with('success', 'Mantenimiento eliminado exitosamente.');
    }

    public function confirmar(Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->estado !== 'programado') {
            return back()->with('error', 'Solo se pueden confirmar mantenimientos programados.');
        }

        $mantenimiento->update(['estado' => 'confirmado']);

        return back()->with('success', 'Mantenimiento confirmado.');
    }

    public function iniciar(Mantenimiento $mantenimiento)
    {
        if (!in_array($mantenimiento->estado, ['programado', 'confirmado'])) {
            return back()->with('error', 'Este mantenimiento no puede iniciarse.');
        }

        $mantenimiento->update([
            'estado' => 'en_progreso',
            'fecha_realizada' => now(),
        ]);

        return back()->with('success', 'Mantenimiento iniciado.');
    }

    /**
     * Completar mantenimiento + auto-resolver ticket vinculado
     */
    public function completar(Request $request, Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->estado !== 'en_progreso') {
            return back()->with('error', 'Solo se pueden completar mantenimientos en progreso.');
        }

        $validated = $request->validate([
            'hallazgos' => 'nullable|string',
            'recomendaciones' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'duracion_real_horas' => 'nullable|integer|min:1|max:24',
            'costo_mano_obra' => 'nullable|numeric|min:0',
            'costo_materiales' => 'nullable|numeric|min:0',
            'costo_transporte' => 'nullable|numeric|min:0',
            'requiere_seguimiento' => 'nullable|boolean',
            'fecha_proximo_mantenimiento' => 'nullable|date|after:today',
            'evidencias.*' => 'nullable|image|max:5120',
        ]);

        // Procesar evidencias (fotos)
        $evidencias = $mantenimiento->evidencias ?? [];
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $foto) {
                $evidencias[] = $foto->store('mantenimientos/evidencias', 'public');
            }
        }

        $costoTotal = ($validated['costo_mano_obra'] ?? 0) 
                    + ($validated['costo_materiales'] ?? 0) 
                    + ($validated['costo_transporte'] ?? 0);

        $mantenimiento->update([
            'estado' => 'completado',
            'fecha_realizada' => $mantenimiento->fecha_realizada ?? now(),
            'duracion_real_horas' => $validated['duracion_real_horas'],
            'hallazgos' => $validated['hallazgos'],
            'recomendaciones' => $validated['recomendaciones'],
            'observaciones' => $validated['observaciones'],
            'costo_mano_obra' => $validated['costo_mano_obra'] ?? 0,
            'costo_materiales' => $validated['costo_materiales'] ?? 0,
            'costo_transporte' => $validated['costo_transporte'] ?? 0,
            'costo_total' => $costoTotal,
            'requiere_seguimiento' => $request->has('requiere_seguimiento'),
            'fecha_proximo_mantenimiento' => $validated['fecha_proximo_mantenimiento'] ?? null,
            'evidencias' => $evidencias,
        ]);

        // AUTO-RESOLVER ticket vinculado
        if ($mantenimiento->ticket_id) {
            $ticket = Ticket::find($mantenimiento->ticket_id);
            if ($ticket && !in_array($ticket->estado, ['resuelto', 'cerrado'])) {
                $ticket->update([
                    'estado' => 'resuelto',
                    'fecha_resolucion' => now(),
                    'solucion' => "Mantenimiento {$mantenimiento->codigo} completado. " 
                        . ($validated['hallazgos'] ? "Hallazgos: {$validated['hallazgos']}" : ''),
                    'tipo_solucion' => 'visita_tecnica',
                    'sla_cumplido' => $ticket->sla_vencimiento ? now()->lte($ticket->sla_vencimiento) : null,
                ]);

                return redirect()
                    ->route('admin.crm.mantenimientos.show', $mantenimiento)
                    ->with('success', "Mantenimiento completado. Ticket #{$ticket->codigo} resuelto automáticamente.");
            }
        }

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento completado exitosamente.');
    }

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
            'estado' => 'reprogramado',
            'observaciones' => ($mantenimiento->observaciones ?? '') . 
                "\n[Reprogramado " . now()->format('d/m/Y') . "] " . $validated['motivo_reprogramacion'],
        ]);

        return back()->with('success', 'Mantenimiento reprogramado.');
    }

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
}
