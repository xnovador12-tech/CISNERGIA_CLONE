<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMensaje;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class admin_CrmTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['cliente', 'asignado', 'creador']);

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
            'tipo' => 'required|in:consulta,reclamo,garantia,soporte_tecnico,mantenimiento,facturacion,otro',
            'categoria' => 'nullable|in:paneles,inversor,baterias,estructura,cableado,monitoreo,produccion,instalacion,documentacion,otro',
            'prioridad' => 'required|in:baja,media,alta,critica',
            'canal' => 'required|in:web,email,telefono,whatsapp,presencial',
            'user_id' => 'nullable|exists:users,id',
            'instalacion_id' => 'nullable|integer',
            'adjuntos' => 'nullable|array',
            'adjuntos.*' => 'file|max:10240', // 10MB máx
        ]);

        $validated['user_id'] = auth()->id();
        $validated['estado'] = 'abierto';
        
        // Calcular SLA según prioridad
        $horasSla = match($validated['prioridad']) {
            'critica' => 4,
            'alta' => 8,
            'media' => 24,
            'baja' => 48,
        };
        $validated['sla_vencimiento'] = now()->addHours($horasSla);

        // Procesar adjuntos
        $adjuntos = [];
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $archivo) {
                $path = $archivo->store('tickets/adjuntos', 'public');
                $adjuntos[] = [
                    'nombre' => $archivo->getClientOriginalName(),
                    'path' => $path,
                    'tipo' => $archivo->getMimeType(),
                    'tamano' => $archivo->getSize(),
                ];
            }
        }
        $validated['adjuntos'] = $adjuntos;

        $ticket = Ticket::create($validated);

        // Registrar primera respuesta automática si hay asignado
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
            'mensajes' => fn($q) => $q->with('usuario')->orderBy('created_at'),
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
            'tipo' => 'required|in:consulta,reclamo,garantia,soporte_tecnico,mantenimiento,facturacion,otro',
            'categoria' => 'nullable|in:paneles,inversor,baterias,estructura,cableado,monitoreo,produccion,instalacion,documentacion,otro',
            'prioridad' => 'required|in:baja,media,alta,critica',
            'user_id' => 'nullable|exists:users,id',
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
        // Eliminar adjuntos
        if ($ticket->adjuntos) {
            foreach ($ticket->adjuntos as $adjunto) {
                Storage::disk('public')->delete($adjunto['path']);
            }
        }

        $ticket->delete();

        return redirect()
            ->route('admin.crm.tickets.index')
            ->with('success', 'Ticket eliminado exitosamente.');
    }

    /**
     * Agregar mensaje/respuesta al ticket
     */
    public function agregarMensaje(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'mensaje' => 'required|string',
            'es_interno' => 'boolean',
            'adjuntos' => 'nullable|array',
            'adjuntos.*' => 'file|max:10240',
        ]);

        // Procesar adjuntos
        $adjuntos = [];
        if ($request->hasFile('adjuntos')) {
            foreach ($request->file('adjuntos') as $archivo) {
                $path = $archivo->store('tickets/mensajes', 'public');
                $adjuntos[] = [
                    'nombre' => $archivo->getClientOriginalName(),
                    'path' => $path,
                    'tipo' => $archivo->getMimeType(),
                ];
            }
        }

        $mensaje = $ticket->mensajes()->create([
            'user_id' => auth()->id(),
            'mensaje' => $validated['mensaje'],
            'es_interno' => $validated['es_interno'] ?? false,
            'adjuntos' => $adjuntos,
        ]);

        // Actualizar primera respuesta si es la primera
        if (!$ticket->fecha_primera_respuesta && !$mensaje->es_interno) {
            $ticket->update(['fecha_primera_respuesta' => now()]);
        }

        // Cambiar estado a en_progreso si estaba abierto
        if ($ticket->estado === 'abierto') {
            $ticket->update(['estado' => 'en_progreso']);
        }

        return back()->with('success', 'Respuesta agregada exitosamente.');
    }

    /**
     * Cambiar estado del ticket
     */
    public function cambiarEstado(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'estado' => 'required|in:abierto,en_progreso,pendiente,resuelto,cerrado',
            'comentario' => 'nullable|string|max:500',
        ]);

        $estadoAnterior = $ticket->estado;
        $ticket->estado = $validated['estado'];

        // Si se resuelve, registrar fecha
        if ($validated['estado'] === 'resuelto' && $estadoAnterior !== 'resuelto') {
            $ticket->fecha_resolucion = now();
        }

        // Si se cierra, registrar fecha
        if ($validated['estado'] === 'cerrado' && $estadoAnterior !== 'cerrado') {
            $ticket->fecha_cierre = now();
        }

        $ticket->save();

        // Registrar comentario como nota interna
        if (isset($validated['comentario']) && !empty($validated['comentario'])) {
            $ticket->mensajes()->create([
                'user_id' => auth()->id(),
                'mensaje' => "Estado cambiado a {$validated['estado']}: {$validated['comentario']}",
                'es_interno' => true,
            ]);
        }

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

        // Registrar asignación
        $usuario = User::find($validated['user_id']);
        $ticket->mensajes()->create([
            'user_id' => auth()->id(),
            'mensaje' => "Ticket asignado a: {$usuario->name}",
            'es_interno' => true,
        ]);

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

        // Registrar escalamiento
        $motivo = isset($validated['motivo_escalamiento']) && $validated['motivo_escalamiento'] 
            ? $validated['motivo_escalamiento'] 
            : 'Escalado sin motivo especificado';
        
        $ticket->mensajes()->create([
            'user_id' => auth()->id(),
            'mensaje' => "âš ï¸ TICKET ESCALADO\nMotivo: {$motivo}\nNueva prioridad: {$ticket->prioridad}",
            'es_interno' => true,
        ]);

        return back()->with('warning', 'Ticket escalado exitosamente. Nueva prioridad: ' . ucfirst($ticket->prioridad));
    }

    /**
     * Registrar calificación del cliente
     */
    public function calificar(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'calificacion_cliente' => 'required|integer|min:1|max:5',
            'comentario_cliente' => 'nullable|string|max:500',
        ]);

        $ticket->update([
            'calificacion_cliente' => $validated['calificacion_cliente'],
            'comentario_cliente' => $validated['comentario_cliente'],
        ]);

        return back()->with('success', 'Gracias por tu calificación.');
    }

    /**
     * Dashboard de métricas de soporte
     */
    public function metricas(Request $request)
    {
        $periodo = $request->get('periodo', 'mes');
        
        $fechaInicio = match($periodo) {
            'semana' => now()->startOfWeek(),
            'mes' => now()->startOfMonth(),
            'trimestre' => now()->startOfQuarter(),
            'ano' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };

        // Métricas generales
        $metricas = [
            'total_tickets' => Ticket::where('created_at', '>=', $fechaInicio)->count(),
            'resueltos' => Ticket::where('estado', 'resuelto')
                ->where('fecha_resolucion', '>=', $fechaInicio)->count(),
            'tiempo_respuesta_promedio' => $this->calcularTiempoRespuestaPromedio($fechaInicio),
            'tiempo_resolucion_promedio' => $this->calcularTiempoResolucionPromedio($fechaInicio),
            'satisfaccion_promedio' => Ticket::whereNotNull('calificacion_cliente')
                ->where('created_at', '>=', $fechaInicio)
                ->avg('calificacion_cliente'),
            'tasa_resolucion_primer_contacto' => $this->calcularTasaFCR($fechaInicio),
            'cumplimiento_sla' => $this->calcularCumplimientoSla($fechaInicio),
        ];

        // Por categoría
        $porCategoria = Ticket::selectRaw('categoria, COUNT(*) as total')
            ->where('created_at', '>=', $fechaInicio)
            ->groupBy('categoria')
            ->get();

        // Por agente
        $porAgente = Ticket::selectRaw('user_id, COUNT(*) as total, AVG(calificacion) as satisfaccion')
            ->with('asignado')
            ->where('created_at', '>=', $fechaInicio)
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->get();

        // Tendencia diaria
        $tendencia = Ticket::selectRaw('DATE(created_at) as fecha, COUNT(*) as creados')
            ->where('created_at', '>=', $fechaInicio)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return view('ADMINISTRADOR.CRM.tickets.metricas', compact(
            'metricas',
            'porCategoria',
            'porAgente',
            'tendencia',
            'periodo'
        ));
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

    /**
     * Calcular tiempo de resolución promedio en horas
     */
    protected function calcularTiempoResolucionPromedio($desde = null): float
    {
        $query = Ticket::whereNotNull('fecha_resolucion');
        
        if ($desde) {
            $query->where('created_at', '>=', $desde);
        }

        $tickets = $query->get();

        if ($tickets->isEmpty()) {
            return 0;
        }

        $totalHoras = $tickets->sum(function ($ticket) {
            return $ticket->created_at->diffInMinutes($ticket->fecha_resolucion) / 60;
        });

        return round($totalHoras / $tickets->count(), 1);
    }

    /**
     * Calcular tasa de resolución en primer contacto
     */
    protected function calcularTasaFCR($desde = null): float
    {
        $queryTotal = Ticket::whereIn('estado', ['resuelto', 'cerrado']);
        $queryFCR = Ticket::whereIn('estado', ['resuelto', 'cerrado'])
            ->whereRaw('(SELECT COUNT(*) FROM ticket_mensajes WHERE ticket_id = tickets.id AND es_interno = 0) <= 2');

        if ($desde) {
            $queryTotal->where('created_at', '>=', $desde);
            $queryFCR->where('created_at', '>=', $desde);
        }

        $total = $queryTotal->count();
        $fcr = $queryFCR->count();

        return $total > 0 ? round(($fcr / $total) * 100, 1) : 0;
    }

    /**
     * Calcular cumplimiento de SLA
     */
    protected function calcularCumplimientoSla($desde = null): float
    {
        $queryTotal = Ticket::whereNotNull('sla_vencimiento')
            ->whereIn('estado', ['resuelto', 'cerrado']);
        
        $queryCumplido = Ticket::whereNotNull('sla_vencimiento')
            ->whereIn('estado', ['resuelto', 'cerrado'])
            ->whereColumn('fecha_resolucion', '<=', 'sla_vencimiento');

        if ($desde) {
            $queryTotal->where('created_at', '>=', $desde);
            $queryCumplido->where('created_at', '>=', $desde);
        }

        $total = $queryTotal->count();
        $cumplido = $queryCumplido->count();

        return $total > 0 ? round(($cumplido / $total) * 100, 1) : 100;
    }
}

