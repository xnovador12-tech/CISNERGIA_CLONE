<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;

class admin_CrmTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['cliente', 'asignado', 'creador', 'mantenimiento']);

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('asunto', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', fn($q2) => 
                      $q2->where('nombre', 'like', "%{$buscar}%")
                         ->orWhere('razon_social', 'like', "%{$buscar}%")
                  );
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        // Por defecto mostrar abiertos primero
        if (!$request->filled('incluir_cerrados')) {
            $query->abiertos();
        }

        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        
        // Ordenar por prioridad si se solicita
        if ($orderBy === 'prioridad') {
            $query->orderByRaw("FIELD(prioridad, 'critica', 'alta', 'media', 'baja')");
        } else {
            $query->orderBy($orderBy, $orderDir);
        }

        // Usar get() para DataTables del lado del cliente
        $tickets = $query->get();

        // Estadísticas
        $stats = [
            'abiertos' => Ticket::abiertos()->count(),
            'en_progreso' => Ticket::where('estado', 'en_progreso')->count(),
            'resueltos_hoy' => Ticket::where('estado', 'resuelto')
                ->whereDate('fecha_resolucion', today())->count(),
            'tiempo_promedio' => $this->calcularTiempoRespuestaPromedio() . 'h',
        ];

        // Por categoría
        $porCategoria = Ticket::selectRaw('categoria, COUNT(*) as total')
            ->abiertos()
            ->groupBy('categoria')
            ->pluck('total', 'categoria');

        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);
        $clientes = Cliente::orderBy('nombre')->get();

        return view('ADMINISTRADOR.CRM.tickets.index', compact(
            'tickets',
            'stats',
            'porCategoria',
            'usuarios',
            'clientes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        $clienteId = $request->get('cliente_id');

        return view('ADMINISTRADOR.CRM.tickets.create', compact('clientes', 'usuarios', 'clienteId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'asunto' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'categoria' => 'required|in:soporte_paneles,soporte_inversores,soporte_baterias,soporte_monitoreo,soporte_estructura,mantenimiento,instalacion,garantia,facturacion,consulta,reclamo,otro',
            'prioridad' => 'required|in:baja,media,alta,critica',
            'canal' => 'required|in:web,email,telefono,whatsapp,presencial',
            'user_id' => 'nullable|exists:users,id',
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        $validated['estado'] = 'abierto';
        
        // Calcular SLA según prioridad
        $horasSla = match($validated['prioridad']) {
            'critica' => 4,
            'alta' => 8,
            'media' => 24,
            'baja' => 48,
        };
        $validated['sla_vencimiento'] = now()->addHours($horasSla);

        $ticket = Ticket::create($validated);

        // Si tiene agente asignado, registrar primera respuesta
        if ($ticket->user_id) {
            $ticket->update(['fecha_primera_respuesta' => now()]);
        }

        return redirect()
            ->route('admin.crm.tickets.show', $ticket)
            ->with('success', "Ticket #{$ticket->codigo} creado exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load([
            'cliente',
            'asignado',
            'creador',
            'mantenimiento',
        ]);

        // Calcular tiempo transcurrido
        $tiempoTranscurrido = $ticket->created_at->diffForHumans();
        $tiempoRestanteSla = $ticket->sla_vencimiento 
            ? ($ticket->sla_vencimiento->isPast() 
                ? 'Vencido' 
                : $ticket->sla_vencimiento->diffForHumans())
            : null;

        // Historial de estados
        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        return view('ADMINISTRADOR.CRM.tickets.show', compact(
            'ticket',
            'tiempoTranscurrido',
            'tiempoRestanteSla',
            'usuarios'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        return view('ADMINISTRADOR.CRM.tickets.edit', compact('ticket', 'clientes', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'asunto' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'categoria' => 'required|in:soporte_paneles,soporte_inversores,soporte_baterias,soporte_monitoreo,soporte_estructura,mantenimiento,instalacion,garantia,facturacion,consulta,reclamo,otro',
            'prioridad' => 'required|in:baja,media,alta,critica',
            'user_id' => 'nullable|exists:users,id',
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        // Si cambia prioridad, recalcular SLA
        if ($validated['prioridad'] !== $ticket->prioridad && $ticket->estado !== 'resuelto') {
            $horasSla = match($validated['prioridad']) {
                'critica' => 4,
                'alta' => 8,
                'media' => 24,
                'baja' => 48,
            };
            $validated['sla_vencimiento'] = now()->addHours($horasSla);
        }

        $ticket->update($validated);

        return redirect()
            ->route('admin.crm.tickets.show', $ticket)
            ->with('success', 'Ticket actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('admin.crm.tickets.index')
            ->with('success', 'Ticket eliminado exitosamente.');
    }

    /**
     * Cambiar estado del ticket
     */
    public function cambiarEstado(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'estado' => 'required|in:abierto,asignado,en_progreso,pendiente_cliente,pendiente_proveedor,resuelto,cerrado,reabierto',
            'comentario' => 'nullable|string|max:500',
            'solucion' => 'nullable|string|max:2000',
            'tipo_solucion' => 'nullable|in:resuelto_remoto,visita_tecnica,cambio_equipo,ajuste_configuracion,capacitacion,sin_solucion,otro',
            'programar_mantenimiento' => 'nullable|boolean',
        ]);

        $estadoAnterior = $ticket->estado;

        // FLUJO ESPECIAL: Programar mantenimiento (NO resuelve, pasa a en_progreso)
        if ($ticket->es_mantenimiento && !empty($validated['programar_mantenimiento'])) {
            $ticket->update(['estado' => 'en_progreso']);

            return redirect()
                ->route('admin.crm.mantenimientos.create', ['ticket_id' => $ticket->id])
                ->with('success', "Ticket #{$ticket->codigo} en progreso. Complete los datos del mantenimiento.");
        }

        // BLOQUEO: No resolver manualmente si tiene mantenimiento pendiente
        if ($validated['estado'] === 'resuelto' && $ticket->mantenimiento
            && !in_array($ticket->mantenimiento->estado, ['completado', 'cancelado'])) {
            return back()->with('error', 'Este ticket tiene un mantenimiento pendiente. Se resolverá automáticamente al completar el mantenimiento.');
        }

        // RESOLUCIÓN: Requiere solución
        if ($validated['estado'] === 'resuelto' && $estadoAnterior !== 'resuelto') {
            $ticket->fecha_resolucion = now();
            $ticket->solucion = $validated['solucion'] ?? null;
            $ticket->tipo_solucion = $validated['tipo_solucion'] ?? null;
            $ticket->sla_cumplido = $ticket->sla_vencimiento ? now()->lte($ticket->sla_vencimiento) : null;
        }

        // CIERRE
        if ($validated['estado'] === 'cerrado' && $estadoAnterior !== 'cerrado') {
            $ticket->fecha_cierre = now();
        }

        $ticket->estado = $validated['estado'];
        $ticket->save();

        return back()->with('success', "Estado actualizado a: {$validated['estado']}");
    }

    /**
     * Asignar ticket a usuario
     */
    public function asignar(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'user_id' => $validated['user_id'],
            'fecha_primera_respuesta' => $ticket->fecha_primera_respuesta ?? now(),
        ]);

        $usuario = User::find($validated['user_id']);

        return back()->with('success', "Ticket asignado a {$usuario->name}");
    }

    /**
     * Escalar ticket
     */
    public function escalar(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'motivo_escalamiento' => 'nullable|string|max:500',
            'nuevo_user_id' => 'nullable|exists:users,id',
        ]);

        // Subir prioridad si no es crítica
        if ($ticket->prioridad !== 'critica') {
            $prioridades = ['baja' => 'media', 'media' => 'alta', 'alta' => 'critica'];
            $ticket->prioridad = $prioridades[$ticket->prioridad] ?? $ticket->prioridad;
        }

        if (isset($validated['nuevo_user_id']) && $validated['nuevo_user_id']) {
            $ticket->user_id = $validated['nuevo_user_id'];
        }

        $ticket->save();

        return back()->with('warning', 'Ticket escalado exitosamente. Nueva prioridad: ' . ucfirst($ticket->prioridad));
    }

    /**
     * Calcular tiempo de respuesta promedio en horas
     */
    protected function calcularTiempoRespuestaPromedio($desde = null): float
    {
        $query = Ticket::whereNotNull('fecha_primera_respuesta');
        
        if ($desde) {
            $query->where('created_at', '>=', $desde);
        }

        $tickets = $query->get();

        if ($tickets->isEmpty()) {
            return 0;
        }

        $totalHoras = $tickets->sum(function ($ticket) {
            return $ticket->created_at->diffInMinutes($ticket->fecha_primera_respuesta) / 60;
        });

        return round($totalHoras / $tickets->count(), 1);
    }
}
