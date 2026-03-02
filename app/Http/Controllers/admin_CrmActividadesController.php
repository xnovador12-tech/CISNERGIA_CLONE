<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActividadCrm;
use App\Models\NotificacionCrmLeida;
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

        // Estadísticas
        $completadasMes = ActividadCrm::completadas()->whereMonth('fecha_realizada', now()->month)->whereYear('fecha_realizada', now()->year)->count();
        $cerradasMes = ActividadCrm::whereIn('estado', ['completada', 'cancelada', 'no_realizada'])
            ->whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->count();

        $stats = [
            'pendientes' => ActividadCrm::where('estado', 'programada')->count(),
            'completadas_mes' => $completadasMes,
            'vencidas' => ActividadCrm::vencidas()->count(),
            'tasa_cumplimiento' => $cerradasMes > 0
                ? round(($completadasMes / $cerradasMes) * 100, 1)
                : 0,
        ];

        $usuarios = User::all();

        return view('ADMINISTRADOR.CRM.actividades.index', compact(
            'actividades',
            'stats',
            'usuarios'
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

        return view('ADMINISTRADOR.CRM.actividades.create', compact(
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
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,whatsapp',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'prioridad' => 'nullable|in:alta,media,baja',
            'ubicacion' => 'nullable|string|max:255',
            'recordatorio_minutos' => 'nullable|integer|min:5',
            'estado' => 'nullable|in:programada,completada,cancelada,reprogramada,no_realizada',
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

        $actividad = ActividadCrm::create($validated);

        return redirect()
            ->route('admin.crm.actividades.show', $actividad)
            ->with('success', 'Actividad creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ActividadCrm $actividad)
    {
        $actividad->load([
            'usuario.persona', 
            'actividadable', 
            'asignadoA.persona', 
            'creadoPor.persona',
        ]);

        return view('ADMINISTRADOR.CRM.actividades.show', compact('actividad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActividadCrm $actividad)
    {
        $prospectos = Prospecto::orderBy('nombre')->get();
        $oportunidades = Oportunidad::with('prospecto')->orderByDesc('created_at')->get();
        $usuarios = User::with('persona')->get();

        return view('ADMINISTRADOR.CRM.actividades.edit', compact(
            'actividad',
            'prospectos',
            'oportunidades',
            'usuarios'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,whatsapp',
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_programada' => 'required|date',
            'prioridad' => 'nullable|in:alta,media,baja',
            'estado' => 'nullable|in:programada,completada,cancelada,reprogramada,no_realizada',
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

        $actividad->update($validated);

        return redirect()
            ->route('admin.crm.actividades.show', $actividad)
            ->with('success', 'Actividad actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActividadCrm $actividad)
    {
        $actividad->delete();

        return redirect()
            ->route('admin.crm.actividades.index')
            ->with('success', 'Actividad eliminada exitosamente.');
    }

    /**
     * Marcar actividad como completada
     */
    public function completar(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'resultado' => 'nullable|string',
        ]);

        $actividad->completar($validated['resultado'] ?? 'Actividad completada');

        return back()->with('success', 'Actividad completada exitosamente.');
    }

    /**
     * Marcar actividad como cancelada
     */
    public function cancelar(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'motivo_cancelacion' => 'nullable|string|max:255',
        ]);

        $actividad->cancelar($validated['motivo_cancelacion'] ?? 'Sin motivo especificado');

        return back()->with('info', 'Actividad cancelada.');
    }

    /**
     * Reprogramar actividad
     */
    public function reprogramar(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'fecha_programada' => 'required|date|after_or_equal:today',
            'motivo_reprogramacion' => 'nullable|string|max:255',
        ]);

        $actividad->reprogramar(
            new \DateTime($validated['fecha_programada']),
            $validated['motivo_reprogramacion'] ?? null
        );

        return back()->with('success', 'Actividad reprogramada exitosamente.');
    }

    /**
     * Crear seguimiento desde actividad
     */
    public function crearSeguimiento(Request $request, ActividadCrm $actividad)
    {
        $validated = $request->validate([
            'tipo' => 'required|in:llamada,email,reunion,visita_tecnica,whatsapp',
            'titulo' => 'required|string|max:200',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'descripcion' => 'nullable|string',
        ]);

        $seguimiento = ActividadCrm::create([
            'actividadable_type' => $actividad->actividadable_type,
            'actividadable_id' => $actividad->actividadable_id,
            'tipo' => $validated['tipo'],
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? "Seguimiento de: {$actividad->titulo}",
            'fecha_programada' => $validated['fecha_programada'],
            'estado' => 'programada',
            'prioridad' => $actividad->prioridad,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.crm.actividades.show', $seguimiento)
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
                'whatsapp' => '#22C55E',
            ];

            $start = $actividad->fecha_programada->toIso8601String();

            return [
                'id' => $actividad->id,
                'title' => $actividad->titulo,
                'start' => $start,
                'end' => null,
                'color' => $colores[$actividad->tipo] ?? '#64748B',
                'textColor' => '#FFFFFF',
                'extendedProps' => [
                    'tipo' => $actividad->tipo,
                    'estado' => $actividad->estado,
                    'prioridad' => $actividad->prioridad,
                    'entidad' => $actividad->activable?->nombre_completo ?? $actividad->activable?->nombre,
                    'url' => route('ADMINISTRADOR.CRM.actividades.show', $actividad),
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
     * Notificaciones para campana del navbar (polling AJAX)
     * 3 categorías:
     *   - Recordatorio: se dispara según recordatorio_minutos_antes (descartable)
     *   - Próxima a iniciar: se dispara 5 min antes siempre (descartable)
     *   - Vencida: persiste hasta que se atienda la actividad (NO descartable)
     *
     * Roles admin (Cuantica/Administrador): ven TODAS
     * Otros roles: solo las asignadas al usuario logueado
     */
    public function notificacionesCampana()
    {
        $user = auth()->user();
        $ahora = now();
        $rolesAdmin = ['cuantica', 'administrador'];
        $esAdmin = in_array(strtolower($user->role->slug ?? ''), $rolesAdmin);

        // IDs de notificaciones ya descartadas por este usuario
        $descartadas = NotificacionCrmLeida::where('user_id', $user->id)
            ->get()
            ->groupBy('tipo')
            ->mapWithKeys(fn($items, $tipo) => [$tipo => $items->pluck('actividad_crm_id')->toArray()]);

        $descartadasRecordatorio = $descartadas->get('recordatorio', []);
        $descartadasProxima = $descartadas->get('proxima', []);

        $notificaciones = collect();

        // ============================================================
        // 1. RECORDATORIO: según recordatorio_minutos_antes del usuario
        //    Solo si recordatorio_activo = true
        // ============================================================
        $queryRecordatorio = ActividadCrm::with(['actividadable', 'responsable.persona'])
            ->where('estado', 'programada')
            ->where('recordatorio_activo', true)
            ->whereRaw('DATE_SUB(fecha_programada, INTERVAL recordatorio_minutos_antes MINUTE) <= ?', [$ahora])
            ->where('fecha_programada', '>', $ahora);

        if (!$esAdmin) {
            $queryRecordatorio->where('user_id', $user->id);
        }
        if (!empty($descartadasRecordatorio)) {
            $queryRecordatorio->whereNotIn('id', $descartadasRecordatorio);
        }

        foreach ($queryRecordatorio->orderBy('fecha_programada')->take(10)->get() as $act) {
            $notificaciones->push($this->formatearNotificacion($act, 'info', 'Recordatorio', 'recordatorio'));
        }

        // ============================================================
        // 2. PRÓXIMA A INICIAR: 5 minutos antes, siempre (sistema)
        // ============================================================
        $queryProxima = ActividadCrm::with(['actividadable', 'responsable.persona'])
            ->where('estado', 'programada')
            ->where('fecha_programada', '<=', $ahora->copy()->addMinutes(5))
            ->where('fecha_programada', '>', $ahora);

        if (!$esAdmin) {
            $queryProxima->where('user_id', $user->id);
        }
        if (!empty($descartadasProxima)) {
            $queryProxima->whereNotIn('id', $descartadasProxima);
        }

        foreach ($queryProxima->orderBy('fecha_programada')->take(10)->get() as $act) {
            // Evitar duplicar si ya aparece como recordatorio
            if ($notificaciones->where('id', $act->id)->isEmpty()) {
                $notificaciones->push($this->formatearNotificacion($act, 'warning', 'Por iniciar', 'proxima'));
            }
        }

        // ============================================================
        // 3. VENCIDAS: programadas con fecha pasada (NO descartables)
        // ============================================================
        $queryVencidas = ActividadCrm::with(['actividadable', 'responsable.persona'])
            ->where('estado', 'programada')
            ->where('fecha_programada', '<', $ahora);

        if (!$esAdmin) {
            $queryVencidas->where('user_id', $user->id);
        }

        foreach ($queryVencidas->orderByDesc('fecha_programada')->take(10)->get() as $act) {
            $notificaciones->push($this->formatearNotificacion($act, 'danger', 'Vencida', 'vencida'));
        }

        // Contadores por categoría
        $conteo = $notificaciones->countBy('categoria');

        return response()->json([
            'total' => $notificaciones->count(),
            'recordatorios' => $conteo->get('recordatorio', 0),
            'proximas' => $conteo->get('proxima', 0),
            'vencidas' => $conteo->get('vencida', 0),
            'items' => $notificaciones->take(20)->values(),
            'es_admin' => $esAdmin,
        ]);
    }

    /**
     * Formatear una actividad como notificación
     */
    private function formatearNotificacion(ActividadCrm $act, string $color, string $etiqueta, string $categoria): array
    {
        $relacionado = null;
        if ($act->actividadable) {
            $relacionado = [
                'tipo' => class_basename($act->actividadable_type),
                'nombre' => $act->actividadable->nombre_completo ?? $act->actividadable->nombre ?? 'N/A',
            ];
        }

        return [
            'id' => $act->id,
            'slug' => $act->slug,
            'titulo' => $act->titulo,
            'tipo_actividad' => $act->tipo_info['nombre'],
            'icono' => $act->tipo_info['icono'],
            'color' => $color,
            'etiqueta' => $etiqueta,
            'categoria' => $categoria,
            'descartable' => $categoria !== 'vencida',
            'fecha' => $act->fecha_programada->format('d/m/Y H:i'),
            'tiempo' => $act->fecha_programada->diffForHumans(),
            'prioridad' => ucfirst($act->prioridad),
            'responsable' => $act->responsable?->persona?->name ?? $act->responsable?->email ?? '',
            'relacionado' => $relacionado,
            'url' => route('admin.crm.actividades.show', $act->slug),
        ];
    }

    /**
     * Descartar una notificación (AJAX)
     * Solo para recordatorio y proxima, NO para vencidas
     */
    public function descartarNotificacion(Request $request)
    {
        $validated = $request->validate([
            'actividad_id' => 'required|exists:actividades_crm,id',
            'categoria' => 'required|in:recordatorio,proxima',
        ]);

        NotificacionCrmLeida::firstOrCreate([
            'user_id' => auth()->id(),
            'actividad_crm_id' => $validated['actividad_id'],
            'tipo' => $validated['categoria'],
        ]);

        return response()->json(['success' => true]);
    }
}

