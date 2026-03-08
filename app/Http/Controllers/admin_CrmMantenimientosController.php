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
                  ->orWhere('titulo', 'like', "%{$buscar}%")
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

        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $mantenimientos = $query->get();

        $hoy = now();
        $stats = [
            'programados'     => Mantenimiento::whereIn('estado', ['programado', 'confirmado'])->count(),
            'en_ejecucion'    => Mantenimiento::where('estado', 'en_progreso')->count(),
            'completados_mes' => Mantenimiento::where('estado', 'completado')
                ->where(function ($q) use ($hoy) {
                    $q->where(function ($q2) use ($hoy) {
                        $q2->whereNotNull('fecha_realizada')
                           ->whereMonth('fecha_realizada', $hoy->month)
                           ->whereYear('fecha_realizada', $hoy->year);
                    })->orWhere(function ($q2) use ($hoy) {
                        $q2->whereNull('fecha_realizada')
                           ->whereMonth('updated_at', $hoy->month)
                           ->whereYear('updated_at', $hoy->year);
                    });
                })->count(),
            'proximos'        => Mantenimiento::whereBetween('fecha_programada', [$hoy, $hoy->copy()->addDays(7)])
                ->whereIn('estado', ['programado', 'confirmado'])->count(),
            'sin_tecnico'     => Mantenimiento::whereNull('tecnico_id')
                ->whereNotIn('estado', ['completado', 'cancelado'])->count(),
        ];

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $clientes = Cliente::orderBy('nombre')->get();

        return view('ADMINISTRADOR.CRM.mantenimientos.index', compact(
            'mantenimientos', 'stats', 'tecnicos', 'clientes'
        ));
    }

    public function show(Mantenimiento $mantenimiento)
    {
        $mantenimiento->load(['cliente', 'tecnico', 'ticket']);

        $historial = Mantenimiento::where('cliente_id', $mantenimiento->cliente_id)
            ->where('id', '!=', $mantenimiento->id)
            ->orderByDesc('fecha_programada')
            ->take(5)
            ->get();

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        $rolesAdmin = ['cuantica', 'administrador'];
        $userSlug   = strtolower(auth()->user()->role->slug ?? '');
        $esAdmin    = in_array($userSlug, $rolesAdmin);
        $esTecnico  = $userSlug === 'tecnico';

        return view('ADMINISTRADOR.CRM.mantenimientos.show', compact(
            'mantenimiento', 'historial', 'tecnicos', 'esAdmin', 'esTecnico'
        ));
    }

    public function edit(Mantenimiento $mantenimiento)
    {
        if (in_array($mantenimiento->estado, ['completado', 'cancelado'])) {
            return redirect()
                ->route('admin.crm.mantenimientos.show', $mantenimiento)
                ->with('info', 'Los mantenimientos completados o cancelados no pueden editarse.');
        }

        $tecnicos = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.mantenimientos.edit', compact('mantenimiento', 'tecnicos'));
    }

    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        // Actualización de checklist desde el show (técnico marcando tareas)
        if ($request->has('solo_checklist')) {
            $checklist = [];
            foreach ($request->input('checklist', []) as $item) {
                $checklist[] = [
                    'tarea'      => $item['tarea'],
                    'completado' => isset($item['completado']),
                ];
            }
            $mantenimiento->update(['checklist' => $checklist]);

            return redirect()
                ->route('admin.crm.mantenimientos.show', $mantenimiento)
                ->with('success', 'Checklist actualizado exitosamente.');
        }

        // Actualización de datos logísticos (fecha, hora, técnico, dirección)
        $validated = $request->validate([
            'fecha_programada' => 'required|date',
            'hora_programada'  => 'nullable|date_format:H:i',
            'tecnico_id'       => 'nullable|exists:users,id',
            'direccion'        => 'required|string|max:255',
            'notas_internas'   => 'nullable|string|max:2000',
        ]);

        $mantenimiento->update($validated);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    public function destroy(Mantenimiento $mantenimiento)
    {
        if ($mantenimiento->estado === 'completado') {
            return redirect()
                ->route('admin.crm.mantenimientos.show', $mantenimiento)
                ->with('error', 'No se puede eliminar un mantenimiento completado. Forma parte del historial del cliente.');
        }

        // Eliminar evidencias del storage
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
        if ($mantenimiento->estado !== 'confirmado') {
            return back()->with('error', 'Solo se pueden iniciar mantenimientos confirmados.');
        }

        $mantenimiento->update([
            'estado'          => 'en_progreso',
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

        // Determinar si el ticket origen es de garantía (para contexto visual, los costos igual se registran)
        $esGarantia = $mantenimiento->ticket && $mantenimiento->ticket->categoria === 'garantia';

        $validated = $request->validate([
            'hallazgos'                   => 'nullable|string',
            'recomendaciones'             => 'nullable|string',
            'observaciones'               => 'nullable|string',
            'duracion_real_horas'         => 'nullable|integer|min:1|max:24',
            'costo_mano_obra'             => 'nullable|numeric|min:0',
            'costo_materiales'            => 'nullable|numeric|min:0',
            'costo_transporte'            => 'nullable|numeric|min:0',
            'requiere_seguimiento'        => 'nullable|boolean',
            'fecha_proximo_mantenimiento' => 'nullable|date|after:today',
            'evidencias.*'                => 'nullable|image|max:5120',
        ]);

        // Procesar evidencias (fotos)
        $evidencias = $mantenimiento->evidencias ?? [];
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $foto) {
                $evidencias[] = $foto->store('mantenimientos/evidencias', 'public');
            }
        }

        $updateData = [
            'estado'                      => 'completado',
            'fecha_realizada'             => $mantenimiento->fecha_realizada ?? now(),
            'duracion_real_horas'         => $validated['duracion_real_horas'] ?? null,
            'hallazgos'                   => $validated['hallazgos'] ?? null,
            'recomendaciones'             => $validated['recomendaciones'] ?? null,
            'observaciones'               => $validated['observaciones'] ?? null,
            'costo_mano_obra'             => $validated['costo_mano_obra'] ?? 0,
            'costo_materiales'            => $validated['costo_materiales'] ?? 0,
            'costo_transporte'            => $validated['costo_transporte'] ?? 0,
            'costo_total'                 => ($validated['costo_mano_obra'] ?? 0)
                                          + ($validated['costo_materiales'] ?? 0)
                                          + ($validated['costo_transporte'] ?? 0),
            'requiere_seguimiento'        => $request->has('requiere_seguimiento'),
            'fecha_proximo_mantenimiento' => $validated['fecha_proximo_mantenimiento'] ?? null,
            'evidencias'                  => $evidencias,
        ];

        $mantenimiento->update($updateData);

        // AUTO-RESOLVER ticket vinculado
        if ($mantenimiento->ticket_id) {
            $ticket = Ticket::find($mantenimiento->ticket_id);
            if ($ticket && !in_array($ticket->estado, ['resuelto'])) {
                $ticket->update([
                    'estado'           => 'resuelto',
                    'fecha_resolucion' => now(),
                    'fecha_cierre'     => now(),
                    'solucion'         => "Mantenimiento {$mantenimiento->codigo} completado. "
                        . ($validated['hallazgos'] ? "Hallazgos: {$validated['hallazgos']}" : ''),
                    'tipo_solucion'    => 'visita_tecnica',
                    'sla_cumplido'     => $ticket->sla_vencimiento ? now()->lte($ticket->sla_vencimiento) : null,
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
            'estado'        => 'cancelado',
            'observaciones' => ($mantenimiento->observaciones ? $mantenimiento->observaciones . "\n" : '')
                . '[Cancelado ' . now()->format('d/m/Y H:i') . '] ' . $motivo,
        ]);

        // Si hay ticket vinculado, reabrirlo para que el agente retome la atención
        if ($mantenimiento->ticket_id) {
            $ticket = Ticket::find($mantenimiento->ticket_id);
            if ($ticket && !in_array($ticket->estado, ['resuelto'])) {
                $ticket->update([
                    'estado'          => 'reabierto',
                    'notas_internas'  => ($ticket->notas_internas ? $ticket->notas_internas . "\n" : '')
                        . '[' . now()->format('d/m/Y H:i') . '] Mantenimiento ' . $mantenimiento->codigo
                        . ' cancelado. Motivo: ' . $motivo . '. Requiere nueva gestión.',
                ]);

                return redirect()
                    ->route('admin.crm.mantenimientos.index')
                    ->with('warning', "Mantenimiento cancelado. El ticket #{$ticket->codigo} fue reabierto para su seguimiento.");
            }
        }

        return redirect()
            ->route('admin.crm.mantenimientos.index')
            ->with('info', 'Mantenimiento cancelado correctamente.');
    }

    public function reprogramar(Request $request, Mantenimiento $mantenimiento)
    {
        if (in_array($mantenimiento->estado, ['completado', 'en_progreso', 'cancelado'])) {
            return back()->with('error', 'Este mantenimiento no puede reprogramarse.');
        }

        $validated = $request->validate([
            'fecha_programada'      => 'required|date|after_or_equal:today',
            'hora_programada'       => 'nullable|date_format:H:i',
            'motivo_reprogramacion' => 'required|string|max:500',
        ]);

        $nota = '[Reprogramado ' . now()->format('d/m/Y H:i') . '] '
              . 'De ' . $mantenimiento->fecha_programada->format('d/m/Y')
              . ' a ' . \Carbon\Carbon::parse($validated['fecha_programada'])->format('d/m/Y')
              . '. Motivo: ' . $validated['motivo_reprogramacion'];

        $mantenimiento->update([
            'fecha_programada' => $validated['fecha_programada'],
            'hora_programada'  => $validated['hora_programada'] ?? $mantenimiento->hora_programada,
            'observaciones'    => ($mantenimiento->observaciones ? $mantenimiento->observaciones . "\n" : '') . $nota,
        ]);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento reprogramado para el ' . \Carbon\Carbon::parse($validated['fecha_programada'])->format('d/m/Y') . '.');
    }

    protected function getChecklistPorTipo(string $tipo): array
    {
        $checklists = [
            'preventivo' => [
                ['tarea' => 'Inspección visual de paneles y estructura', 'completado' => false],
                ['tarea' => 'Limpieza general de paneles', 'completado' => false],
                ['tarea' => 'Revisión de conexiones y cableado', 'completado' => false],
                ['tarea' => 'Revisión del inversor', 'completado' => false],
                ['tarea' => 'Revisión de protecciones eléctricas', 'completado' => false],
                ['tarea' => 'Verificación de funcionamiento general', 'completado' => false],
                ['tarea' => 'Registro fotográfico', 'completado' => false],
            ],
            'correctivo' => [
                ['tarea' => 'Diagnóstico del problema', 'completado' => false],
                ['tarea' => 'Identificación del componente fallado', 'completado' => false],
                ['tarea' => 'Reparación o reemplazo realizado', 'completado' => false],
                ['tarea' => 'Pruebas posteriores a la reparación', 'completado' => false],
                ['tarea' => 'Verificación de funcionamiento normal', 'completado' => false],
                ['tarea' => 'Registro fotográfico', 'completado' => false],
            ],
            'limpieza' => [
                ['tarea' => 'Limpieza de superficie de paneles', 'completado' => false],
                ['tarea' => 'Limpieza de marcos y estructura', 'completado' => false],
                ['tarea' => 'Limpieza de área del inversor', 'completado' => false],
                ['tarea' => 'Retiro de residuos acumulados', 'completado' => false],
                ['tarea' => 'Verificación visual post-limpieza', 'completado' => false],
                ['tarea' => 'Registro fotográfico', 'completado' => false],
            ],
            'inspeccion' => [
                ['tarea' => 'Inspección visual de paneles', 'completado' => false],
                ['tarea' => 'Inspección de estructura y anclajes', 'completado' => false],
                ['tarea' => 'Inspección de cableado y conexiones', 'completado' => false],
                ['tarea' => 'Inspección del inversor', 'completado' => false],
                ['tarea' => 'Verificación de funcionamiento del sistema', 'completado' => false],
                ['tarea' => 'Registro fotográfico', 'completado' => false],
            ],
            'predictivo' => [
                ['tarea' => 'Revisión del historial de producción', 'completado' => false],
                ['tarea' => 'Identificación de caídas o anomalías en rendimiento', 'completado' => false],
                ['tarea' => 'Inspección visual de componentes con desgaste', 'completado' => false],
                ['tarea' => 'Revisión de conexiones y puntos de calor visibles', 'completado' => false],
                ['tarea' => 'Evaluación general del estado del sistema', 'completado' => false],
                ['tarea' => 'Registro fotográfico', 'completado' => false],
            ],
        ];

        return $checklists[$tipo] ?? [];
    }
}
