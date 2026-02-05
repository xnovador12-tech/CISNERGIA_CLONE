<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActividadCrm;
use App\Models\Prospecto;
use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class admin_CrmActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActividadCrm::with(['usuario.persona', 'actividadable', 'asignadoA.persona']);

        // Filtros
        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', "%{$request->buscar}%");
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('usuario_id')) {
            $query->where('user_id', $request->usuario_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_programada', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_programada', '<=', $request->fecha_hasta);
        }

        // Filtro por entidad relacionada
        if ($request->filled('entidad_tipo') && $request->filled('entidad_id')) {
            $query->where('actividadable_type', $request->entidad_tipo)
                  ->where('actividadable_id', $request->entidad_id);
        }

        $orderBy = $request->get('order_by', 'fecha_programada');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $actividades = $query->get();

        // EstadÃ­sticas
        $stats = [
            'hoy' => ActividadCrm::programadasHoy()->count(),
            'llamadas' => ActividadCrm::where('tipo', 'llamada')->pendientes()->count(),
            'reuniones' => ActividadCrm::where('tipo', 'reunion')->pendientes()->count(),
            'visitas' => ActividadCrm::where('tipo', 'visita_tecnica')->pendientes()->count(),
        ];

        $usuarios = User::all();

        return view('ADMINISTRADOR.PRINCIPAL.crm.actividades.index', compact(
            'actividades',
            'stats',
            'usuarios'
        ));
    }

    /**
     * Vista de calendario
     */
    public function calendario(Request $request)
    {
        $mes = $request->get('mes', now()->month);
        $ano = $request->get('ano', now()->year);
        $usuarioId = $request->get('usuario_id');

        $inicio = Carbon::create($ano, $mes, 1)->startOfMonth();
        $fin = Carbon::create($ano, $mes, 1)->endOfMonth();

        $query = ActividadCrm::with(['usuario', 'activable'])
            ->whereBetween('fecha_programada', [$inicio, $fin]);

        if ($usuarioId) {
            $query->where('user_id', $usuarioId);
        }

        $actividades = $query->orderBy('fecha_programada')
            ->orderBy('hora_inicio')
            ->get()
            ->groupBy(fn($a) => $a->fecha_programada->format('Y-m-d'));

        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        return view('ADMINISTRADOR.PRINCIPAL.crm.actividades.calendario', compact(
            'actividades',
            'mes',
            'ano',
            'usuarios',
            'usuarioId'
        ));
    }

    /**
     * Vista de agenda del dÃ­a
     */
    public function agenda(Request $request)
    {
        $fecha = $request->get('fecha', now()->toDateString());
        $usuarioId = $request->get('usuario_id', auth()->id());

        $actividades = ActividadCrm::with(['activable'])
            ->whereDate('fecha_programada', $fecha)
            ->where('user_id', $usuarioId)
            ->orderBy('hora_inicio')
            ->get();

        // Actividades vencidas sin completar
        $vencidas = ActividadCrm::vencidas()
            ->where('user_id', $usuarioId)
            ->orderBy('fecha_programada')
            ->take(10)
            ->get();

        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->nombre);

        return view('ADMINISTRADOR.PRINCIPAL.crm.actividades.agenda', compact(
            'actividades',
            'vencidas',
            'fecha',
            'usuarios',
            'usuarioId'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $prospectos = Prospecto::activos()->orderBy('nombre')->get();
        $oportunidades = Oportunidad::activas()->with('prospecto')->orderByDesc('created_at')->get();
        $usuarios = User::with('persona')->get();

        // Pre-seleccionar entidad
        $entidadTipo = $request->get('entidad_tipo');
        $entidadId = $request->get('entidad_id');

        return view('ADMINISTRADOR.PRINCIPAL.crm.actividades.create', compact(
            'prospectos',
            'oportunidades',
            'usuarios',
            'entidadTipo',
            'entidadId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DEBUG: Ver quÃ© llega del formulario ANTES de validar
        \Log::info('REQUEST COMPLETO', [
            'all' => $request->all(),
            'user_id_from_request' => $request->input('user_id'),
            'has_user_id' => $request->has('user_id'),
            'filled_user_id' => $request->filled('user_id'),
        ]);

        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,videollamada,whatsapp,tarea,nota',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'duracion_minutos' => 'nullable|integer|min:0|max:480',
            'prioridad' => 'nullable|in:alta,media,baja',
            'ubicacion' => 'nullable|string|max:255',
            'recordatorio_minutos' => 'nullable|integer|min:5',
            'estado' => 'nullable|in:programada,en_progreso,completada,cancelada,reprogramada,no_realizada',
            'user_id' => 'required|exists:users,id',
            'activable_type' => 'nullable|string',
            'activable_id' => 'nullable|integer',
        ]);

        // Mapear recordatorio_minutos a recordatorio_minutos_antes
        if (isset($validated['recordatorio_minutos'])) {
            $validated['recordatorio_minutos_antes'] = $validated['recordatorio_minutos'];
            $validated['recordatorio_activo'] = true;
            unset($validated['recordatorio_minutos']);
        }

        // Mapear activable a actividadable
        if (isset($validated['activable_type'])) {
            $validated['actividadable_type'] = $validated['activable_type'];
            unset($validated['activable_type']);
        }
        if (isset($validated['activable_id'])) {
            $validated['actividadable_id'] = $validated['activable_id'];
            unset($validated['activable_id']);
        }

        // Valores por defecto
        $validated['estado'] = $validated['estado'] ?? 'programada';
        $validated['prioridad'] = $validated['prioridad'] ?? 'media';
        
        // SIEMPRE asignar created_by con el usuario actual
        $validated['created_by'] = auth()->id();

        // DEBUG: Ver quÃ© valores se estÃ¡n pasando
        \Log::info('Creando actividad', [
            'user_id' => $validated['user_id'],
            'created_by' => $validated['created_by'],
            'auth_id' => auth()->id(),
        ]);

        $actividad = ActividadCrm::create($validated);

        // DEBUG: Ver quÃ© se guardÃ³ realmente
        \Log::info('Actividad creada', [
            'id' => $actividad->id,
            'user_id' => $actividad->user_id,
            'created_by' => $actividad->created_by
        ]);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.actividades.show', $actividad)
            ->with('success', 'Actividad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActividadCrm $actividade)
    {
        $actividade->load([
            'usuario.persona', 
            'activable', 
            'asignadoA.persona', 
            'creadoPor.persona', 
            'actividadable'
        ]);

        return view('ADMINISTRADOR.PRINCIPAL.crm.actividades.show', compact('actividade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActividadCrm $actividade)
    {
        $prospectos = Prospecto::orderBy('nombre')->get();
        $oportunidades = Oportunidad::with('prospecto')->orderByDesc('created_at')->get();
        $usuarios = User::with('persona')->get();

        return view('ADMINISTRADOR.PRINCIPAL.crm.actividades.edit', compact(
            'actividade',
            'prospectos',
            'oportunidades',
            'usuarios'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActividadCrm $actividade)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,videollamada,whatsapp,tarea,nota',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'duracion_minutos' => 'nullable|integer|min:0|max:480',
            'prioridad' => 'nullable|in:alta,media,baja',
            'estado' => 'nullable|in:programada,en_progreso,completada,cancelada,reprogramada,no_realizada',
            'ubicacion' => 'nullable|string|max:255',
            'recordatorio_minutos' => 'nullable|integer|min:5',
            'user_id' => 'required|exists:users,id',
            'activable_type' => 'nullable|string',
            'activable_id' => 'nullable|integer',
        ]);

        // Mapear recordatorio_minutos a recordatorio_minutos_antes
        if (isset($validated['recordatorio_minutos'])) {
            $validated['recordatorio_minutos_antes'] = $validated['recordatorio_minutos'];
            $validated['recordatorio_activo'] = true;
            unset($validated['recordatorio_minutos']);
        }

        // Mapear activable a actividadable
        if (isset($validated['activable_type'])) {
            $validated['actividadable_type'] = $validated['activable_type'];
            unset($validated['activable_type']);
        }
        if (isset($validated['activable_id'])) {
            $validated['actividadable_id'] = $validated['activable_id'];
            unset($validated['activable_id']);
        }

        $actividade->update($validated);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.actividades.show', $actividade)
            ->with('success', 'Actividad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActividadCrm $actividade)
    {
        $actividade->delete();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.actividades.index')
            ->with('success', 'Actividad eliminada exitosamente.');
    }

    /**
     * Marcar actividad como completada
     */
    public function completar(Request $request, ActividadCrm $actividade)
    {
        $validated = $request->validate([
            'resultado' => 'nullable|string',
        ]);

        $actividade->update([
            'estado' => 'completada',
            'fecha_realizada' => now(),
            'resultado' => $validated['resultado'] ?? 'Actividad completada',
        ]);

        return back()->with('success', 'âœ… Actividad completada exitosamente.');
    }

    /**
     * Marcar actividad como cancelada
     */
    public function cancelar(Request $request, ActividadCrm $actividade)
    {
        $validated = $request->validate([
            'motivo_cancelacion' => 'nullable|string|max:255',
        ]);

        $actividade->update([
            'estado' => 'cancelada',
            'motivo_cancelacion' => $validated['motivo_cancelacion'] ?? 'Sin motivo especificado',
        ]);

        return back()->with('info', 'âŒ Actividad cancelada.');
    }

    /**
     * Reprogramar actividad
     */
    public function reprogramar(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'fecha_programada' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'nullable|date_format:H:i',
            'motivo_reprogramacion' => 'nullable|string|max:255',
        ]);

        $descripcionAnterior = $actividad->descripcion ?? '';
        $nuevaDescripcion = $descripcionAnterior . "\n\n[Reprogramada el " . now()->format('d/m/Y H:i') . "]";
        if ($validated['motivo_reprogramacion']) {
            $nuevaDescripcion .= "\nMotivo: " . $validated['motivo_reprogramacion'];
        }

        $actividad->update([
            'fecha_programada' => $validated['fecha_programada'],
            'hora_inicio' => $validated['hora_inicio'],
            'estado' => 'programada',
            'descripcion' => $nuevaDescripcion,
        ]);

        return back()->with('success', 'Actividad reprogramada exitosamente.');
    }

    /**
     * Crear seguimiento desde actividad
     */
    public function crearSeguimiento(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,videollamada,whatsapp,tarea,nota',
            'titulo' => 'required|string|max:200',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'nullable|date_format:H:i',
            'descripcion' => 'nullable|string',
        ]);

        $seguimiento = ActividadCrm::create([
            'activable_type' => $actividad->activable_type,
            'activable_id' => $actividad->activable_id,
            'tipo' => $validated['tipo'],
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? "Seguimiento de: {$actividad->titulo}",
            'fecha_programada' => $validated['fecha_programada'],
            'hora_inicio' => $validated['hora_inicio'],
            'estado' => 'programada',
            'prioridad' => $actividad->prioridad,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.actividades.show', $seguimiento)
            ->with('success', 'Actividad de seguimiento creada.');
    }

    /**
     * Obtener actividades para FullCalendar (AJAX)
     */
    public function eventosCalendario(Request $request)
    {
        $inicio = $request->get('start');
        $fin = $request->get('end');
        $usuarioId = $request->get('usuario_id');

        $query = ActividadCrm::with(['activable'])
            ->whereBetween('fecha_programada', [$inicio, $fin]);

        if ($usuarioId) {
            $query->where('user_id', $usuarioId);
        }

        $actividades = $query->get();

        $eventos = $actividades->map(function ($actividad) {
            $colores = [
                'llamada' => '#3B82F6',
                'email' => '#8B5CF6',
                'reunion' => '#10B981',
                'visita_tecnica' => '#F59E0B',
                'videollamada' => '#6366F1',
                'whatsapp' => '#22C55E',
                'tarea' => '#64748B',
                'nota' => '#94A3B8',
            ];

            $start = $actividad->fecha_programada->format('Y-m-d');
            if ($actividad->hora_inicio) {
                $start .= 'T' . $actividad->hora_inicio;
            }

            return [
                'id' => $actividad->id,
                'title' => $actividad->titulo,
                'start' => $start,
                'end' => $actividad->hora_fin 
                    ? $actividad->fecha_programada->format('Y-m-d') . 'T' . $actividad->hora_fin
                    : null,
                'color' => $colores[$actividad->tipo] ?? '#64748B',
                'textColor' => '#FFFFFF',
                'extendedProps' => [
                    'tipo' => $actividad->tipo,
                    'estado' => $actividad->estado,
                    'prioridad' => $actividad->prioridad,
                    'entidad' => $actividad->activable?->nombre_completo ?? $actividad->activable?->nombre,
                    'url' => route('ADMINISTRADOR.PRINCIPAL.crm.actividades.show', $actividad),
                ],
            ];
        });

        return response()->json($eventos);
    }

    /**
     * Actualizar actividad via drag & drop (AJAX)
     */
    public function actualizarFecha(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'fecha_programada' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
        ]);

        $actividad->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fecha actualizada',
        ]);
    }

    /**
     * Mis actividades pendientes (widget dashboard)
     */
    public function misPendientes()
    {
        $actividades = ActividadCrm::with(['activable'])
            ->where('user_id', auth()->id())
            ->pendientes()
            ->orderBy('fecha_programada')
            ->orderBy('prioridad')
            ->take(10)
            ->get();

        return response()->json($actividades);
    }

    /**
     * Recordatorios prÃ³ximos (para notificaciones)
     */
    public function recordatoriosProximos()
    {
        $ahora = now();
        
        $actividades = ActividadCrm::with(['activable', 'usuario'])
            ->where('recordatorio_activo', true)
            ->where('estado', 'programada')
            ->whereRaw('DATE_SUB(CONCAT(fecha_programada, " ", COALESCE(hora_inicio, "09:00")), INTERVAL recordatorio_minutos_antes MINUTE) <= ?', [$ahora])
            ->whereRaw('CONCAT(fecha_programada, " ", COALESCE(hora_inicio, "09:00")) > ?', [$ahora])
            ->get();

        return response()->json($actividades);
    }
}

