<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Sale;
use App\Models\User;
use App\Models\Mantenimiento;
use App\Models\ActividadCrm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class admin_CrmTicketsController extends Controller
{
    // AJAX ----------------------------------------------------------------

    public function pedidosPorCliente(int $clienteId)
    {
        $pedidos = Pedido::where('cliente_id', $clienteId)
            ->whereIn('estado', ['pendiente', 'proceso', 'entregado'])
            ->orderByDesc('created_at')
            ->get(['id', 'codigo', 'estado', 'total', 'direccion_instalacion'])
            ->map(fn($p) => [
                'id'        => $p->id,
                'codigo'    => $p->codigo,
                'estado'    => ucfirst($p->estado),
                'total'     => number_format($p->total, 2),
                'direccion' => $p->direccion_instalacion,
            ]);
        return response()->json($pedidos);
    }

    public function ventasPorCliente(int $clienteId)
    {
        $ventas = Sale::where('cliente_id', $clienteId)
            ->whereIn('estado', ['completada', 'parcial'])
            ->orderByDesc('created_at')
            ->get(['id', 'codigo', 'numero_comprobante', 'total', 'estado'])
            ->map(fn($v) => [
                'id'          => $v->id,
                'codigo'      => $v->codigo,
                'comprobante' => $v->numero_comprobante ?? 'Sin comprobante',
                'total'       => number_format($v->total, 2),
                'estado'      => ucfirst($v->estado),
            ]);
        return response()->json($ventas);
    }

    // INDEX ---------------------------------------------------------------

    public function index(Request $request)
    {
        $query = Ticket::with(['cliente', 'asignado', 'creador', 'mantenimiento', 'pedido']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('asunto', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', fn($q2) =>
                      $q2->where('nombre', 'like', "%{$buscar}%")
                         ->orWhere('razon_social', 'like', "%{$buscar}%")
                  );
            });
        }

        if ($request->filled('estado'))     $query->where('estado', $request->estado);
        if ($request->filled('prioridad'))  $query->where('prioridad', $request->prioridad);
        if ($request->filled('categoria'))  $query->where('categoria', $request->categoria);
        if ($request->filled('user_id'))    $query->where('user_id', $request->user_id);
        if ($request->filled('cliente_id')) $query->where('cliente_id', $request->cliente_id);

        if ($request->filled('incluir_resueltos')) {
            $query->where('estado', 'resuelto');
        } else {
            $query->abiertos();
        }

        $orderBy  = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');

        if ($orderBy === 'prioridad') {
            $query->orderByRaw("FIELD(prioridad, 'critica', 'alta', 'media', 'baja')");
        } else {
            $query->orderBy($orderBy, $orderDir);
        }

        $tickets = $query->get();

        $stats = [
            'abiertos'        => Ticket::abiertos()->count(),
            'en_progreso'     => Ticket::where('estado', 'en_progreso')->count(),
            'resueltos_hoy'   => Ticket::where('estado', 'resuelto')->whereDate('fecha_resolucion', today())->count(),
            'tiempo_promedio' => $this->calcularTiempoRespuestaPromedio() . 'h',
        ];

        $porCategoria = Ticket::selectRaw('categoria, COUNT(*) as total')
            ->abiertos()->groupBy('categoria')->pluck('total', 'categoria');

        return view('ADMINISTRADOR.CRM.tickets.index', compact('tickets', 'stats', 'porCategoria'));
    }

    // CREATE --------------------------------------------------------------

    public function create(Request $request)
    {
        $clientes  = Cliente::orderBy('nombre')->get();
        $usuarios  = User::with('persona')
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Tecnico', 'Operaciones']))
            ->get()->sortBy(fn($u) => $u->persona?->name);
        $clienteId = $request->get('cliente_id');

        $pedidos = $clienteId
            ? Pedido::where('cliente_id', $clienteId)
                ->whereIn('estado', ['pendiente', 'proceso', 'entregado'])
                ->orderByDesc('created_at')->get()
            : collect();

        return view('ADMINISTRADOR.CRM.tickets.create', compact('clientes', 'usuarios', 'clienteId', 'pedidos'));
    }

    // STORE ---------------------------------------------------------------

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'          => 'required|exists:clientes,id',
            'asunto'              => 'required|string|max:200',
            'descripcion'         => 'required|string',
            'categoria'           => 'required|in:mantenimiento,soporte_tecnico,garantia,facturacion,consulta_reclamo',
            'componente_afectado' => 'nullable|string|max:150',
            'tipo_mantenimiento'  => 'nullable|in:preventivo,correctivo,limpieza,inspeccion,predictivo',
            'fecha_mantenimiento' => 'nullable|date|after_or_equal:today',
            'hora_mantenimiento'  => 'nullable|date_format:H:i',
            'prioridad'           => 'required|in:baja,media,alta,critica',
            'canal'               => 'required|in:web,email,telefono,whatsapp,presencial',
            'user_id'             => 'nullable|exists:users,id',
            'pedido_id'           => 'nullable|exists:pedidos,id',
            'venta_id'            => 'nullable|exists:sales,id',
            'direccion_sistema'   => 'nullable|string|max:255',
            'notas_internas'      => 'nullable|string|max:2000',
            'adjuntos.*'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Validación extra: mantenimiento requiere tipo y fecha
        if ($validated['categoria'] === 'mantenimiento') {
            $request->validate([
                'tipo_mantenimiento'  => 'required|in:preventivo,correctivo,limpieza,inspeccion,predictivo',
                'fecha_mantenimiento' => 'required|date|after_or_equal:today',
            ]);
        }

        // Heredar dirección del pedido si no se ingresó
        if (empty($validated['direccion_sistema']) && !empty($validated['pedido_id'])) {
            $pedido = Pedido::find($validated['pedido_id']);
            $validated['direccion_sistema'] = $pedido?->direccion_instalacion;
        }

        // Limpiar referencias que no aplican a la categoría
        if (!in_array($validated['categoria'], Ticket::CATEGORIAS_CON_PEDIDO)) {
            $validated['pedido_id']           = null;
            $validated['direccion_sistema']    = null;
            $validated['componente_afectado']  = null;
        }
        if (!in_array($validated['categoria'], Ticket::CATEGORIAS_CON_VENTA)) {
            $validated['venta_id'] = null;
        }
        if ($validated['categoria'] !== 'mantenimiento') {
            $validated['tipo_mantenimiento']  = null;
            $validated['fecha_mantenimiento'] = null;
            $validated['hora_mantenimiento']  = null;
        }

        // Procesar adjuntos
        $adjuntos = [];
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $archivo) {
                $adjuntos[] = $archivo->store('tickets/adjuntos', 'public');
            }
        }
        $validated['adjuntos'] = !empty($adjuntos) ? $adjuntos : null;
        $validated['estado']   = 'abierto';

        $ticket = Ticket::create($validated);

        if ($ticket->user_id) {
            $ticket->update(['fecha_primera_respuesta' => now()]);
        }

        // ── AUTO-CREAR MANTENIMIENTO ─────────────────────────────────────────
        if ($ticket->categoria === 'mantenimiento') {
            $tipoMant = $validated['tipo_mantenimiento'] ?? 'preventivo';

            $mantenimiento = Mantenimiento::create([
                'cliente_id'       => $ticket->cliente_id,
                'ticket_id'        => $ticket->id,
                'titulo'           => $ticket->asunto,
                'tipo'             => $tipoMant,
                'descripcion'      => $ticket->descripcion,
                'fecha_programada' => $validated['fecha_mantenimiento'],
                'hora_programada'  => $validated['hora_mantenimiento'] ?? null,
                'direccion'        => $ticket->direccion_sistema ?? '',
                'tecnico_id'       => $ticket->user_id,
                'estado'           => 'programado',
                'checklist'        => $this->checklistPorTipo($tipoMant),
                'notas_internas'   => $ticket->notas_internas,
            ]);

            // Ticket pasa a en_progreso automáticamente
            $ticket->update(['estado' => 'en_progreso']);

            return redirect()
                ->route('admin.crm.mantenimientos.show', $mantenimiento)
                ->with('success', "Ticket #{$ticket->codigo} creado → Mantenimiento {$mantenimiento->codigo} programado automáticamente.");
        }

        return redirect()
            ->route('admin.crm.tickets.show', $ticket)
            ->with('success', "Ticket #{$ticket->codigo} creado exitosamente.");
    }

    // SHOW ----------------------------------------------------------------

    public function show(Ticket $ticket)
    {
        $ticket->load(['cliente', 'pedido', 'venta', 'asignado', 'creador', 'mantenimiento']);

        $tiempoTranscurrido = $ticket->created_at->diffForHumans();
        $tiempoRestanteSla  = $ticket->sla_vencimiento
            ? ($ticket->sla_vencimiento->isPast() ? 'Vencido' : $ticket->sla_vencimiento->diffForHumans())
            : null;

        $usuarios = User::with('persona')
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Tecnico', 'Operaciones']))
            ->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.tickets.show', compact(
            'ticket', 'tiempoTranscurrido', 'tiempoRestanteSla', 'usuarios'
        ));
    }

    // EDIT ----------------------------------------------------------------

    public function edit(Ticket $ticket)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $usuarios = User::with('persona')
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['Tecnico', 'Operaciones']))
            ->get()->sortBy(fn($u) => $u->persona?->name);

        $pedidos = Pedido::where('cliente_id', $ticket->cliente_id)
            ->whereIn('estado', ['pendiente', 'proceso', 'entregado'])
            ->orderByDesc('created_at')->get();

        $ventas = Sale::where('cliente_id', $ticket->cliente_id)
            ->whereIn('estado', ['completada', 'parcial'])
            ->orderByDesc('created_at')->get();

        return view('ADMINISTRADOR.CRM.tickets.edit', compact('ticket', 'clientes', 'usuarios', 'pedidos', 'ventas'));
    }

    // UPDATE --------------------------------------------------------------

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'asunto'              => 'required|string|max:200',
            'descripcion'         => 'required|string',
            'categoria'           => 'required|in:mantenimiento,soporte_tecnico,garantia,facturacion,consulta_reclamo',
            'componente_afectado' => 'nullable|string|max:150',
            'tipo_mantenimiento'  => 'nullable|in:preventivo,correctivo,limpieza,inspeccion,predictivo',
            'fecha_mantenimiento' => 'nullable|date',
            'hora_mantenimiento'  => 'nullable|date_format:H:i',
            'prioridad'           => 'required|in:baja,media,alta,critica',
            'canal'               => 'required|in:web,email,telefono,whatsapp,presencial',
            'pedido_id'           => 'nullable|exists:pedidos,id',
            'venta_id'            => 'nullable|exists:sales,id',
            'direccion_sistema'   => 'nullable|string|max:255',
            'user_id'             => 'nullable|exists:users,id',
            'notas_internas'      => 'nullable|string|max:2000',
            'adjuntos.*'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if (!in_array($validated['categoria'], Ticket::CATEGORIAS_CON_PEDIDO)) {
            $validated['pedido_id']           = null;
            $validated['direccion_sistema']    = null;
            $validated['componente_afectado']  = null;
        }
        if (!in_array($validated['categoria'], Ticket::CATEGORIAS_CON_VENTA)) {
            $validated['venta_id'] = null;
        }
        if ($validated['categoria'] !== 'mantenimiento') {
            $validated['tipo_mantenimiento']  = null;
            $validated['fecha_mantenimiento'] = null;
            $validated['hora_mantenimiento']  = null;
        }

        if ($request->hasFile('adjuntos')) {
            $existentes = $ticket->adjuntos ?? [];
            foreach ($request->file('adjuntos') as $archivo) {
                $existentes[] = $archivo->store('tickets/adjuntos', 'public');
            }
            $validated['adjuntos'] = $existentes;
        }

        if ($validated['prioridad'] !== $ticket->prioridad && $ticket->estado !== 'resuelto') {
            $horas = Ticket::SLA_POR_PRIORIDAD[$validated['prioridad']] ?? 48;
            $validated['sla_vencimiento'] = now()->addHours($horas);
        }

        $ticket->update($validated);

        return redirect()
            ->route('admin.crm.tickets.show', $ticket)
            ->with('success', 'Ticket actualizado exitosamente.');
    }

    // DESTROY -------------------------------------------------------------

    public function destroy(Ticket $ticket)
    {
        if ($ticket->estado === 'resuelto') {
            return redirect()
                ->route('admin.crm.tickets.show', $ticket)
                ->with('error', 'No se puede eliminar un ticket resuelto. Forma parte del historial.');
        }

        $ticket->delete();

        return redirect()
            ->route('admin.crm.tickets.index')
            ->with('success', 'Ticket eliminado exitosamente.');
    }

    // CAMBIAR ESTADO ------------------------------------------------------

    public function cambiarEstado(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'estado'               => 'required|in:abierto,asignado,en_progreso,pendiente_cliente,pendiente_proveedor,resuelto,reabierto',
            'comentario'           => 'nullable|string|max:500',
            'solucion'             => 'nullable|string|max:2000',
            'tipo_solucion'        => 'nullable|in:resuelto_remoto,visita_tecnica,cambio_equipo,ajuste_configuracion,garantia_aplicada,derivado_proveedor,otro',
            'requiere_seguimiento' => 'nullable|boolean',
            'dias_seguimiento'     => 'nullable|integer|min:1|max:90',
        ]);

        $estadoAnterior = $ticket->estado;

        // Bloqueo: no resolver si tiene mantenimiento activo vinculado
        if ($validated['estado'] === 'resuelto' && $ticket->mantenimiento
            && !in_array($ticket->mantenimiento->estado, ['completado', 'cancelado'])) {
            return back()->with('error', 'Este ticket tiene un mantenimiento pendiente. Se resolverá automáticamente al completarlo.');
        }

        if ($validated['estado'] === 'resuelto' && $estadoAnterior !== 'resuelto') {
            $ticket->fecha_resolucion = now();
            $ticket->solucion         = $validated['solucion'] ?? null;
            $ticket->tipo_solucion    = $validated['tipo_solucion'] ?? null;
            $ticket->sla_cumplido     = $ticket->sla_vencimiento ? now()->lte($ticket->sla_vencimiento) : null;
            $ticket->fecha_cierre     = now();
        }

        $ticket->estado = $validated['estado'];
        $ticket->save();

        // ── AUTO-CREAR ACTIVIDAD DE SEGUIMIENTO ──────────────────────────────
        if ($validated['estado'] === 'resuelto' && !empty($validated['requiere_seguimiento'])) {
            $dias        = (int) ($validated['dias_seguimiento'] ?? 7);
            $fechaSeguim = now()->addDays($dias)->setTime(9, 0);
            $responsable = $ticket->user_id ?? auth()->id();

            ActividadCrm::create([
                'tipo'                       => 'seguimiento',
                'actividadable_id'           => $ticket->id,
                'actividadable_type'         => Ticket::class,
                'titulo'                     => "Seguimiento: {$ticket->asunto}",
                'descripcion'                => "Verificar que el ticket {$ticket->codigo} sigue resuelto. Solución aplicada: " . ($validated['solucion'] ?? 'Sin descripción'),
                'fecha_programada'           => $fechaSeguim,
                'estado'                     => 'programada',
                'prioridad'                  => 'media',
                'user_id'                    => $responsable,
                'recordatorio_activo'        => true,
                'recordatorio_minutos_antes' => 60,
            ]);

            return back()->with('success', "Ticket resuelto. Actividad de seguimiento programada para {$fechaSeguim->format('d/m/Y')}.");
        }

        return back()->with('success', "Estado actualizado a: {$validated['estado']}");
    }

    // ASIGNAR -------------------------------------------------------------

    public function asignar(Request $request, Ticket $ticket)
    {
        $validated = $request->validate(['user_id' => 'required|exists:users,id']);

        $ticket->update([
            'user_id'                 => $validated['user_id'],
            'fecha_primera_respuesta' => $ticket->fecha_primera_respuesta ?? now(),
        ]);

        $usuario       = User::with('persona')->find($validated['user_id']);
        $nombreUsuario = $usuario->persona?->name ?? $usuario->name;

        return back()->with('success', "Ticket asignado a {$nombreUsuario}.");
    }

    // AGENDAR VISITA TÉCNICA (desde soporte_tecnico / garantia) ----------

    /**
     * Crea un mantenimiento correctivo desde el show de un ticket de soporte/garantia.
     * Reemplaza el flujo anterior que redirigía al create de mantenimientos.
     */
    public function agendarVisita(Request $request, Ticket $ticket)
    {
        if (!in_array($ticket->categoria, ['soporte_tecnico', 'garantia'])) {
            return back()->with('error', 'Solo tickets de Soporte Técnico o Garantía pueden agendar una visita desde aquí.');
        }

        if ($ticket->mantenimiento && !in_array($ticket->mantenimiento->estado, ['completado', 'cancelado'])) {
            return back()->with('error', 'Este ticket ya tiene un mantenimiento activo vinculado.');
        }

        $validated = $request->validate([
            'tipo_mantenimiento'  => 'required|in:preventivo,correctivo,limpieza,inspeccion,predictivo',
            'fecha_mantenimiento' => 'required|date|after_or_equal:today',
            'hora_mantenimiento'  => 'nullable|date_format:H:i',
            'tecnico_id'          => 'nullable|exists:users,id',
        ]);

        $mantenimiento = Mantenimiento::create([
            'cliente_id'       => $ticket->cliente_id,
            'ticket_id'        => $ticket->id,
            'titulo'           => $ticket->asunto,
            'tipo'             => $validated['tipo_mantenimiento'],
            'descripcion'      => $ticket->descripcion,
            'fecha_programada' => $validated['fecha_mantenimiento'],
            'hora_programada'  => $validated['hora_mantenimiento'] ?? null,
            'direccion'        => $ticket->direccion_sistema ?? '',
            'tecnico_id'       => $validated['tecnico_id'] ?? $ticket->user_id,
            'estado'           => 'programado',
            'checklist'        => $this->checklistPorTipo($validated['tipo_mantenimiento']),
            'notas_internas'   => $ticket->notas_internas,
        ]);

        $ticket->update(['estado' => 'en_progreso']);

        return redirect()
            ->route('admin.crm.mantenimientos.show', $mantenimiento)
            ->with('success', "Visita agendada. Mantenimiento {$mantenimiento->codigo} programado para el {$mantenimiento->fecha_programada->format('d/m/Y')}.");
    }

    // HELPERS -------------------------------------------------------------

    protected function calcularTiempoRespuestaPromedio($desde = null): float
    {
        $query = Ticket::whereNotNull('fecha_primera_respuesta');
        if ($desde) $query->where('created_at', '>=', $desde);

        $tickets = $query->get();
        if ($tickets->isEmpty()) return 0;

        $totalHoras = $tickets->sum(fn($t) =>
            $t->created_at->diffInMinutes($t->fecha_primera_respuesta) / 60
        );

        return round($totalHoras / $tickets->count(), 1);
    }

    /**
     * Checklist por tipo de mantenimiento.
     * Delega al model Mantenimiento para evitar duplicación de código.
     */
    protected function checklistPorTipo(string $tipo): array
    {
        return Mantenimiento::checklistPorTipo($tipo);
    }
}
