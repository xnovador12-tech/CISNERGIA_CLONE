<?php

namespace App\Http\Controllers;

use App\Models\Campania;
use App\Models\CampaniaMetrica;
use App\Models\ChecklistItem;
use App\Models\Pedido;
use App\Models\PedidoCalidad;
use App\Models\PedidoVerificacion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_OperacionesController extends Controller
{
    /**
     * =============================================
     * ASIGNACIÓN DE TAREAS
     * =============================================
     */

    private $estadosKanban = [
        'sin_asignar' => 'Sin Asignar',
        'logistica'   => 'Logística',
        'almacen'     => 'Almacén',
        'calidad'     => 'Control de Calidad',
        'despacho'    => 'Despacho',
        'completado'  => 'Completado',
    ];

    /**
     * Mostrar vista de asignaciones (Stats Cards + DataTable)
     */
    public function asignacionesIndex()
    {
        $stats = [];
        foreach ($this->estadosKanban as $key => $label) {
            $stats[$key] = Pedido::enKanban()->where('estado_operativo', $key)->count();
        }

        $tecnicos = User::whereHas('role', function ($q) {
                $q->whereIn('slug', ['administrador', 'logistica', 'almacen']);
            })
            ->where('estado', 'Activo')
            ->with('persona')
            ->get();

        return view('ADMINISTRADOR.OPERACIONES.asignaciones.index', compact('stats', 'tecnicos'));
    }

    /**
     * Datos para DataTable server-side (AJAX)
     */
    public function asignacionesData(Request $request)
    {
        $query = Pedido::enKanban()
            ->with(['cliente', 'tecnico.persona', 'calidad']);

        // Filtros
        if ($request->filled('area')) {
            $query->where('estado_operativo', $request->area);
        }
        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }
        if ($request->filled('tecnico')) {
            $query->where('tecnico_asignado_id', $request->tecnico);
        }
        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        // Búsqueda global
        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function ($q2) use ($search) {
                      $q2->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellidos', 'like', "%{$search}%")
                         ->orWhere('razon_social', 'like', "%{$search}%");
                  });
            });
        }

        $totalRecords = Pedido::enKanban()->count();
        $filteredRecords = $query->count();

        // Ordenamiento
        $orderColumnIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $columns = ['codigo', 'cliente_nombre', 'total', 'estado_operativo', 'prioridad', 'tecnico_nombre', 'fecha_entrega_estimada', 'id'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';

        if (in_array($orderColumn, ['codigo', 'total', 'estado_operativo', 'prioridad', 'fecha_entrega_estimada'])) {
            $query->orderBy($orderColumn, $orderDir);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Paginación
        $start = $request->input('start', 0);
        $length = $request->input('length', 25);
        $pedidos = $query->skip($start)->take($length)->get();

        $data = $pedidos->map(function ($p) {
            $clienteNombre = $p->cliente ? $p->cliente->nombre_completo : '';

            $tecnicoNombre = '—';
            if ($p->tecnico && $p->tecnico->persona) {
                $tecnicoNombre = trim($p->tecnico->persona->name . ' ' . ($p->tecnico->persona->surnames ?? ''));
            }

            $rechazado = $p->calidad && $p->calidad->estado_calidad === 'rechazado';

            return [
                'id' => $p->id,
                'codigo' => $p->codigo,
                'cliente_nombre' => $clienteNombre ?: 'Sin nombre',
                'total' => 'S/ ' . number_format($p->total, 2),
                'estado_operativo' => $p->estado_operativo,
                'prioridad' => $p->prioridad ?? 'media',
                'tecnico_nombre' => $tecnicoNombre,
                'fecha_entrega_estimada' => $p->fecha_entrega_estimada ? $p->fecha_entrega_estimada->format('d/m/Y') : '—',
                'rechazado' => $rechazado,
                'motivo_rechazo' => $rechazado ? $p->calidad->motivo_rechazo : null,
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    /**
     * Obtener stats actualizados (AJAX)
     */
    public function asignacionesGetStats()
    {
        $stats = [];
        foreach ($this->estadosKanban as $key => $label) {
            $stats[$key] = Pedido::enKanban()->where('estado_operativo', $key)->count();
        }
        return response()->json($stats);
    }

    /**
     * Obtener detalle de un pedido para el modal (AJAX) — incluye historial
     */
    public function asignacionesGetPedido($id)
    {
        $pedido = Pedido::with([
            'cliente',
            'tecnico.persona',
            'detalles.producto',
            'distrito',
            'calidad.verificador.persona',
        ])->findOrFail($id);

        $clienteNombre = $pedido->cliente ? $pedido->cliente->nombre_completo : '';
        $clienteCelular = $pedido->cliente->celular ?? $pedido->cliente->telefono ?? '';
        $clienteEmail = $pedido->cliente->email ?? '';

        $tecnicoNombre = '';
        if ($pedido->tecnico && $pedido->tecnico->persona) {
            $tecnicoNombre = trim($pedido->tecnico->persona->name . ' ' . ($pedido->tecnico->persona->surnames ?? ''));
        }

        $productos = $pedido->detalles->map(function ($d) {
            return [
                'descripcion'    => $d->descripcion ?? ($d->producto->name ?? 'Producto'),
                'cantidad'       => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'subtotal'       => $d->subtotal,
            ];
        });

        // Info de rechazo de calidad
        $rechazoInfo = null;
        if ($pedido->calidad && $pedido->calidad->estado_calidad === 'rechazado') {
            $verificadorNombre = '';
            if ($pedido->calidad->verificador && $pedido->calidad->verificador->persona) {
                $verificadorNombre = trim($pedido->calidad->verificador->persona->name . ' ' . ($pedido->calidad->verificador->persona->surnames ?? ''));
            }
            $labelsArea = ['logistica' => 'Logística', 'almacen' => 'Almacén'];
            $rechazoInfo = [
                'motivo' => $pedido->calidad->motivo_rechazo,
                'verificador' => $verificadorNombre,
                'fecha' => $pedido->calidad->fecha_verificacion ? $pedido->calidad->fecha_verificacion->format('d/m/Y h:i A') : null,
                'area_destino' => $pedido->calidad->area_destino,
                'area_destino_label' => $labelsArea[$pedido->calidad->area_destino] ?? $pedido->calidad->area_destino,
            ];
        }

        // Timeline (reutilizado de trazabilidad)
        $ordenEtapas = ['sin_asignar', 'logistica', 'almacen', 'calidad', 'despacho', 'completado'];
        $etapasConfig = [
            'sin_asignar' => ['label' => 'Pedido Creado', 'icono' => 'bi-cart-check', 'descripcion' => 'Pedido registrado en el sistema.'],
            'logistica'   => ['label' => 'Logística', 'icono' => 'bi-truck', 'descripcion' => 'Coordinación logística y verificación de stock.'],
            'almacen'     => ['label' => 'Almacén', 'icono' => 'bi-box-seam', 'descripcion' => 'Preparación, empaque y etiquetado de productos.'],
            'calidad'     => ['label' => 'Control de Calidad', 'icono' => 'bi-clipboard2-check', 'descripcion' => 'Verificación de calidad y documentación.'],
            'despacho'    => ['label' => 'Despacho', 'icono' => 'bi-send', 'descripcion' => 'Envío al cliente.'],
            'completado'  => ['label' => 'Completado', 'icono' => 'bi-check-circle', 'descripcion' => 'Pedido entregado al cliente.'],
        ];

        $estadoActualIdx = array_search($pedido->estado_operativo, $ordenEtapas);
        $timeline = [];
        foreach ($ordenEtapas as $idx => $etapa) {
            $config = $etapasConfig[$etapa];
            $timeline[] = [
                'etapa'       => $etapa,
                'label'       => $config['label'],
                'icono'       => $config['icono'],
                'descripcion' => $config['descripcion'],
                'estado'      => $idx < $estadoActualIdx ? 'completado' : ($idx === $estadoActualIdx ? 'activo' : 'pendiente'),
            ];
        }

        return response()->json([
            'id'                      => $pedido->id,
            'codigo'                  => $pedido->codigo,
            'cliente_nombre'          => $clienteNombre,
            'cliente_celular'         => $clienteCelular,
            'cliente_email'           => $clienteEmail,
            'fecha_pedido'            => $pedido->created_at->format('d/m/Y'),
            'prioridad'               => $pedido->prioridad,
            'estado_operativo'        => $pedido->estado_operativo,
            'estado_operativo_label'  => $this->estadosKanban[$pedido->estado_operativo] ?? $pedido->estado_operativo,
            'total'                   => number_format($pedido->total, 2),
            'subtotal'                => number_format($pedido->subtotal, 2),
            'igv'                     => number_format($pedido->igv, 2),
            'direccion'               => $pedido->direccion_instalacion ?? 'No especificada',
            'distrito'                => $pedido->distrito->nombre ?? '',
            'tecnico_id'              => $pedido->tecnico_asignado_id,
            'tecnico_nombre'          => $tecnicoNombre,
            'fecha_asignacion'        => $pedido->fecha_asignacion ? $pedido->fecha_asignacion->format('d/m/Y h:i A') : null,
            'fecha_entrega_estimada'  => $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('Y-m-d') : '',
            'observaciones_operativas' => $pedido->observaciones_operativas ?? '',
            'origen'                  => $pedido->origen,
            'pagado'                  => true,
            'productos'               => $productos,
            'timeline'                => $timeline,
            'rechazo'                 => $rechazoInfo,
            'fecha_completado'        => $pedido->estado_operativo === 'completado' ? $pedido->updated_at->format('d/m/Y h:i A') : null,
        ]);
    }

    /**
     * Asignar/mover pedido a otra columna del Kanban (AJAX)
     */
    public function asignacionesAsignar(Request $request)
    {
        $request->validate([
            'pedido_id'              => 'required|exists:pedidos,id',
            'estado_operativo'       => 'required|in:sin_asignar,logistica,almacen,calidad,despacho,completado',
            'tecnico_asignado_id'    => 'nullable|exists:users,id',
            'fecha_entrega_estimada' => 'nullable|date',
            'prioridad'              => 'nullable|in:alta,media,baja',
            'observaciones_operativas' => 'nullable|string|max:2000',
        ]);

        $pedido = Pedido::findOrFail($request->pedido_id);

        $resultado = $pedido->moverEstado($request->estado_operativo, [
            'tecnico_asignado_id'    => $request->tecnico_asignado_id,
            'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
            'prioridad'              => $request->prioridad,
            'observaciones_operativas' => $request->observaciones_operativas,
        ]);

        if (!$resultado['success']) {
            return response()->json($resultado, 422);
        }

        $pedido->load(['cliente', 'tecnico.persona', 'detalles']);

        return response()->json([
            'success' => true,
            'message' => $resultado['message'],
            'pedido'  => [
                'id'               => $pedido->id,
                'codigo'           => $pedido->codigo,
                'estado_operativo' => $pedido->estado_operativo,
                'prioridad'        => $pedido->prioridad,
            ],
        ]);
    }

    /**
     * Filtrar tarjetas del Kanban (AJAX)
     */
    public function asignacionesFiltrar(Request $request)
    {
        $query = Pedido::enKanban()
            ->with(['cliente', 'tecnico.persona', 'detalles']);

        if ($request->filled('area')) {
            $query->where('estado_operativo', $request->area);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_asignado_id', $request->tecnico_id);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        $pedidos = $query->orderBy('prioridad', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $pedidosPorEstado = [];
        $stats = [];
        foreach ($this->estadosKanban as $key => $label) {
            $grupo = $pedidos->where('estado_operativo', $key)->values();
            $pedidosPorEstado[$key] = $grupo->map(function ($p) {
                $clienteNombre = $p->cliente ? $p->cliente->nombre_completo : '';

                $tecnicoNombre = '';
                $tecnicoIniciales = '';
                if ($p->tecnico && $p->tecnico->persona) {
                    $pers = $p->tecnico->persona;
                    $tecnicoNombre = trim($pers->name . ' ' . ($pers->surnames ?? ''));
                    $inicialNombre = mb_substr($pers->name, 0, 1);
                    $inicialApellido = $pers->surnames ? mb_substr($pers->surnames, 0, 1) : '';
                    $tecnicoIniciales = mb_strtoupper($inicialNombre . $inicialApellido);
                }

                $productosTexto = $p->detalles->map(function ($d) {
                    $desc = $d->descripcion ?? 'Producto';
                    return $d->cantidad > 1 ? "{$desc} (x{$d->cantidad})" : $desc;
                })->implode(', ');

                return [
                    'id'                 => $p->id,
                    'codigo'             => $p->codigo,
                    'cliente_nombre'     => $clienteNombre,
                    'productos'          => $productosTexto,
                    'prioridad'          => $p->prioridad,
                    'fecha'              => $p->created_at->format('d M Y'),
                    'tecnico_nombre'     => $tecnicoNombre,
                    'tecnico_iniciales'  => $tecnicoIniciales,
                    'estado_operativo'   => $p->estado_operativo,
                ];
            });
            $stats[$key] = $grupo->count();
        }

        return response()->json([
            'pedidosPorEstado' => $pedidosPorEstado,
            'stats'            => $stats,
        ]);
    }

    /**
     * =============================================
     * CONTROL DE CALIDAD
     * =============================================
     */

    private $secciones = [
        'empaque' => ['label' => 'Empaque', 'icono' => 'bi-box-seam', 'color' => '#6f42c1'],
        'facturacion' => ['label' => 'Facturación', 'icono' => 'bi-receipt', 'color' => '#0d6efd'],
        'preparacion_envio' => ['label' => 'Preparación de Envío', 'icono' => 'bi-truck', 'color' => '#fd7e14'],
    ];

    /**
     * Mostrar listado de pedidos en control de calidad
     */
    public function calidadIndex()
    {
        $pedidos = Pedido::where('estado_operativo', 'calidad')
            ->with(['cliente', 'calidad.verificaciones.checklistItem'])
            ->orderBy('prioridad', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Stats
        $totalCalidad = PedidoCalidad::count();
        $pendientes = PedidoCalidad::where('estado_calidad', 'pendiente')
            ->orWhere('estado_calidad', 'en_revision')
            ->count();
        $aprobados = PedidoCalidad::where('estado_calidad', 'aprobado')->count();
        $rechazados = PedidoCalidad::where('estado_calidad', 'rechazado')->count();

        $stats = [
            'pendientes' => $pendientes,
            'aprobados' => $aprobados,
            'rechazados' => $rechazados,
            'total' => $totalCalidad,
        ];

        return view('ADMINISTRADOR.OPERACIONES.calidad.index', compact('pedidos', 'stats'));
    }

    /**
     * Obtener detalle de calidad de un pedido (AJAX)
     */
    public function calidadGetPedido($id)
    {
        $pedido = Pedido::with([
            'cliente',
            'calidad.verificaciones.checklistItem',
            'calidad.verificador.persona',
            'detalles.producto',
        ])->findOrFail($id);

        $clienteNombre = $pedido->cliente ? $pedido->cliente->nombre_completo : '';

        $calidad = $pedido->calidad;

        // Si no tiene registro de calidad, crearlo
        if (!$calidad) {
            $calidad = PedidoCalidad::create([
                'pedido_id' => $pedido->id,
                'estado_calidad' => 'pendiente',
            ]);

            $checklistItems = ChecklistItem::activo()->orderBy('seccion')->orderBy('orden')->get();
            foreach ($checklistItems as $item) {
                $calidad->verificaciones()->create([
                    'checklist_item_id' => $item->id,
                    'cumple' => false,
                ]);
            }

            $calidad->load(['verificaciones.checklistItem', 'verificador.persona']);
        }

        // Organizar verificaciones por sección
        $secciones = [];
        foreach ($this->secciones as $key => $config) {
            $verificacionesSeccion = $calidad->verificaciones
                ->filter(fn($v) => $v->checklistItem && $v->checklistItem->seccion === $key)
                ->sortBy(fn($v) => $v->checklistItem->orden)
                ->values();

            $total = $verificacionesSeccion->count();
            $cumplidos = $verificacionesSeccion->where('cumple', true)->count();

            $secciones[$key] = [
                'label' => $config['label'],
                'icono' => $config['icono'],
                'color' => $config['color'],
                'verificaciones' => $verificacionesSeccion->map(fn($v) => [
                    'id' => $v->id,
                    'checklist_item_id' => $v->checklist_item_id,
                    'descripcion' => $v->checklistItem->descripcion,
                    'cumple' => $v->cumple,
                    'observacion' => $v->observacion,
                ]),
                'total' => $total,
                'cumplidos' => $cumplidos,
                'porcentaje' => $total > 0 ? round(($cumplidos / $total) * 100) : 0,
            ];
        }

        $verificadorNombre = '';
        if ($calidad->verificador && $calidad->verificador->persona) {
            $verificadorNombre = trim($calidad->verificador->persona->name . ' ' . ($calidad->verificador->persona->surnames ?? ''));
        }

        return response()->json([
            'id' => $pedido->id,
            'codigo' => $pedido->codigo,
            'cliente_nombre' => $clienteNombre,
            'fecha_pedido' => $pedido->created_at->format('d/m/Y'),
            'prioridad' => $pedido->prioridad,
            'total' => number_format($pedido->total, 2),
            'calidad_id' => $calidad->id,
            'estado_calidad' => $calidad->estado_calidad,
            'observaciones' => $calidad->observaciones,
            'motivo_rechazo' => $calidad->motivo_rechazo,
            'verificador_nombre' => $verificadorNombre,
            'fecha_verificacion' => $calidad->fecha_verificacion ? $calidad->fecha_verificacion->format('d/m/Y h:i A') : null,
            'secciones' => $secciones,
        ]);
    }

    /**
     * Guardar check individual de verificación (AJAX)
     */
    public function calidadGuardarCheck(Request $request)
    {
        $request->validate([
            'verificacion_id' => 'required|exists:pedido_verificaciones,id',
            'cumple' => 'required|boolean',
            'observacion' => 'nullable|string|max:1000',
        ]);

        $verificacion = PedidoVerificacion::findOrFail($request->verificacion_id);
        $verificacion->update([
            'cumple' => $request->cumple,
            'observacion' => $request->observacion,
            'verificado_por' => $request->user() ? $request->user()->id : null,
            'fecha_verificacion' => now(),
        ]);

        // Actualizar estado de calidad a en_revision si estaba pendiente
        $calidad = $verificacion->pedidoCalidad;
        if ($calidad->estado_calidad === 'pendiente') {
            $calidad->update(['estado_calidad' => 'en_revision']);
        }

        // Calcular progreso de la sección
        $seccion = $verificacion->checklistItem->seccion;
        $verificacionesSeccion = PedidoVerificacion::where('pedido_calidad_id', $calidad->id)
            ->whereHas('checklistItem', fn($q) => $q->where('seccion', $seccion))
            ->get();

        $total = $verificacionesSeccion->count();
        $cumplidos = $verificacionesSeccion->where('cumple', true)->count();

        return response()->json([
            'success' => true,
            'cumplidos' => $cumplidos,
            'total' => $total,
            'porcentaje' => $total > 0 ? round(($cumplidos / $total) * 100) : 0,
            'estado_calidad' => $calidad->estado_calidad,
        ]);
    }

    /**
     * Aprobar pedido en control de calidad (AJAX)
     */
    public function calidadAprobar(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $pedido = Pedido::with('calidad.verificaciones')->findOrFail($request->pedido_id);
        $calidad = $pedido->calidad;

        if (!$calidad) {
            return response()->json(['success' => false, 'message' => 'No existe registro de calidad para este pedido.'], 422);
        }

        // Verificar que todos los checks estén marcados
        $totalVerificaciones = $calidad->verificaciones->count();
        $cumplidas = $calidad->verificaciones->where('cumple', true)->count();

        $faltantes = $totalVerificaciones - $cumplidas;
        if ($totalVerificaciones > 0 && $faltantes > 0) {
            return response()->json([
                'success' => false,
                'message' => "Faltan {$faltantes} verificaciones por completar. Debe marcar todos los items antes de aprobar.",
                'faltantes' => $faltantes,
            ], 422);
        }

        $calidad->update([
            'estado_calidad' => 'aprobado',
            'observaciones' => $request->observaciones,
            'verificado_por' => $request->user() ? $request->user()->id : null,
            'fecha_verificacion' => now(),
        ]);

        // Mover pedido a despacho en el Kanban
        $pedido->moverEstado('despacho');

        return response()->json([
            'success' => true,
            'message' => 'Pedido aprobado y movido a Despacho.',
        ]);
    }

    /**
     * Rechazar pedido en control de calidad (AJAX)
     */
    public function calidadRechazar(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'motivo_rechazo' => 'required|string|max:2000',
        ]);

        $pedido = Pedido::with('calidad.verificaciones.checklistItem')->findOrFail($request->pedido_id);
        $calidad = $pedido->calidad;

        if (!$calidad) {
            return response()->json(['success' => false, 'message' => 'No existe registro de calidad para este pedido.'], 422);
        }

        // Determinar destino según secciones que fallaron
        $seccionesQueNoConforman = $calidad->verificaciones
            ->where('cumple', false)
            ->pluck('checklistItem.seccion')
            ->unique()
            ->values()
            ->toArray();

        // Mapeo: sección → área responsable
        $seccionArea = [
            'empaque'      => 'almacen',
            'facturacion'  => 'logistica',
            'preparacion_envio' => 'logistica',
        ];

        // Orden del flujo (menor = más atrás)
        $ordenFlujo = [
            'logistica' => 1,
            'almacen'   => 2,
        ];

        // Determinar el área más atrás en el flujo
        $destino = 'almacen'; // fallback
        $menorOrden = PHP_INT_MAX;

        foreach ($seccionesQueNoConforman as $seccion) {
            $area = $seccionArea[$seccion] ?? 'almacen';
            $orden = $ordenFlujo[$area] ?? 99;
            if ($orden < $menorOrden) {
                $menorOrden = $orden;
                $destino = $area;
            }
        }

        $labelsArea = [
            'logistica' => 'Logística',
            'almacen'   => 'Almacén',
        ];

        $calidad->update([
            'estado_calidad' => 'rechazado',
            'motivo_rechazo' => $request->motivo_rechazo,
            'area_destino'   => $destino,
            'verificado_por' => $request->user() ? $request->user()->id : null,
            'fecha_verificacion' => now(),
        ]);

        $pedido->moverEstado($destino);

        return response()->json([
            'success' => true,
            'message' => 'Pedido rechazado y devuelto a ' . ($labelsArea[$destino] ?? $destino) . '.',
            'destino' => $destino,
        ]);
    }

    /**
     * =============================================
     * TRAZABILIDAD
     * =============================================
     */

    /**
     * Mostrar vista de consulta rápida de trazabilidad
     */
    public function trazabilidadIndex()
    {
        return view('ADMINISTRADOR.OPERACIONES.trazabilidad.index');
    }

    /**
     * Buscar pedidos para trazabilidad (AJAX)
     */
    public function trazabilidadBuscar(Request $request)
    {
        $search = $request->input('q', '');
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $pedidos = Pedido::with(['cliente', 'tecnico.persona'])
            ->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function ($q2) use ($search) {
                      $q2->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellidos', 'like', "%{$search}%")
                         ->orWhere('razon_social', 'like', "%{$search}%");
                  });
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                $clienteNombre = $p->cliente ? $p->cliente->nombre_completo : '';
                return [
                    'id' => $p->id,
                    'codigo' => $p->codigo,
                    'cliente_nombre' => $clienteNombre ?: 'Sin nombre',
                    'estado_operativo' => $p->estado_operativo,
                    'total' => number_format($p->total, 2),
                ];
            });

        return response()->json($pedidos);
    }

    /**
     * Obtener trazabilidad de un pedido (AJAX)
     */
    public function trazabilidadGetPedido($id)
    {
        $pedido = Pedido::with([
            'cliente',
            'tecnico.persona',
            'detalles.producto',
            'distrito',
        ])->findOrFail($id);

        $clienteNombre = $pedido->cliente ? $pedido->cliente->nombre_completo : '';
        $clienteCelular = $pedido->cliente->celular ?? $pedido->cliente->telefono ?? '';
        $clienteEmail = $pedido->cliente->email ?? '';

        $tecnicoNombre = '';
        if ($pedido->tecnico && $pedido->tecnico->persona) {
            $tecnicoNombre = trim($pedido->tecnico->persona->name . ' ' . ($pedido->tecnico->persona->surnames ?? ''));
        }

        // Construir timeline basado en el estado operativo actual
        $ordenEtapas = ['sin_asignar', 'logistica', 'almacen', 'calidad', 'despacho', 'completado'];
        $etapasConfig = [
            'sin_asignar' => ['label' => 'Pedido Creado', 'icono' => 'bi-cart-check', 'descripcion' => 'Pedido registrado en el sistema.'],
            'logistica'   => ['label' => 'Logística', 'icono' => 'bi-truck', 'descripcion' => 'Coordinación logística y verificación de stock.'],
            'almacen'     => ['label' => 'Almacén', 'icono' => 'bi-box-seam', 'descripcion' => 'Preparación, empaque y etiquetado de productos.'],
            'calidad'     => ['label' => 'Control de Calidad', 'icono' => 'bi-clipboard2-check', 'descripcion' => 'Verificación de calidad y documentación.'],
            'despacho'    => ['label' => 'Despacho', 'icono' => 'bi-send', 'descripcion' => 'Envío al cliente.'],
            'completado'  => ['label' => 'Completado', 'icono' => 'bi-check-circle', 'descripcion' => 'Pedido entregado al cliente.'],
        ];

        $estadoActualIdx = array_search($pedido->estado_operativo, $ordenEtapas);
        $timeline = [];

        // Si llegó aquí es porque tiene venta completada
        $pagado = true;

        foreach ($ordenEtapas as $idx => $etapa) {
            $config = $etapasConfig[$etapa];
            if ($idx < $estadoActualIdx) {
                $estado = 'completado';
            } elseif ($idx === $estadoActualIdx) {
                $estado = 'activo';
            } else {
                $estado = 'pendiente';
            }

            $timeline[] = [
                'etapa'       => $etapa,
                'label'       => $config['label'],
                'icono'       => $config['icono'],
                'descripcion' => $config['descripcion'],
                'estado'      => $estado,
            ];
        }

        $productos = $pedido->detalles->map(function ($d) {
            return [
                'descripcion'     => $d->descripcion ?? ($d->producto->name ?? 'Producto'),
                'cantidad'        => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'subtotal'        => $d->subtotal,
            ];
        });

        return response()->json([
            'id'                     => $pedido->id,
            'codigo'                 => $pedido->codigo,
            'cliente_nombre'         => $clienteNombre,
            'cliente_celular'        => $clienteCelular,
            'cliente_email'          => $clienteEmail,
            'fecha_pedido'           => $pedido->created_at->format('d/m/Y h:i A'),
            'prioridad'              => $pedido->prioridad,
            'estado'                 => $pedido->estado,
            'estado_operativo'       => $pedido->estado_operativo,
            'estado_operativo_label' => $this->estadosKanban[$pedido->estado_operativo] ?? $pedido->estado_operativo,
            'total'                  => number_format($pedido->total, 2),
            'subtotal'               => number_format($pedido->subtotal, 2),
            'igv'                    => number_format($pedido->igv, 2),
            'direccion'              => $pedido->direccion_instalacion ?? 'No especificada',
            'distrito'               => $pedido->distrito->nombre ?? '',
            'tecnico_nombre'         => $tecnicoNombre,
            'fecha_asignacion'       => $pedido->fecha_asignacion ? $pedido->fecha_asignacion->format('d/m/Y h:i A') : null,
            'fecha_entrega_estimada' => $pedido->fecha_entrega_estimada ? $pedido->fecha_entrega_estimada->format('d/m/Y') : null,
            'origen'                 => $pedido->origen,
            'pagado'                 => $pagado,
            'productos'              => $productos,
            'timeline'               => $timeline,
        ]);
    }

    /**
     * =============================================
     * CAMPAÑAS Y PROMOCIONES
     * =============================================
     */

    public function campaniasIndex()
    {
        $campanias = Campania::with(['creador.persona', 'productos', 'metricas'])
            ->orderByRaw("FIELD(estado, 'activa', 'borrador', 'pausada', 'finalizada')")
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'activas' => Campania::where('estado', 'activa')->count(),
            'borradores' => Campania::where('estado', 'borrador')->count(),
            'pausadas' => Campania::where('estado', 'pausada')->count(),
            'finalizadas' => Campania::where('estado', 'finalizada')->count(),
        ];

        return view('ADMINISTRADOR.OPERACIONES.campanias.index', compact('campanias', 'stats'));
    }

    public function campaniasCreate()
    {
        $productos = Producto::where('estado', 'Activo')
            ->orderBy('name')
            ->get(['id', 'name', 'codigo', 'precio']);

        return view('ADMINISTRADOR.OPERACIONES.campanias.create', compact('productos'));
    }

    public function campaniasStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150|unique:campanias,nombre',
            'tipo' => 'required|in:descuento,envio_gratis,combo,temporada,flash_sale',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'descuento_porcentaje' => 'nullable|numeric|between:0.01,99.99',
            'descuento_monto' => 'nullable|numeric|min:0.01',
            'condicion_minimo' => 'nullable|numeric|min:0',
            'aplica_todos_productos' => 'nullable|boolean',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'descuentos_especificos' => 'nullable|array',
            'estado' => 'required|in:borrador,activa',
            'imagen_banner' => 'nullable|image|max:2048',
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen_banner')) {
            $imagenPath = $request->file('imagen_banner')->store('campanias', 'public');
        }

        $userId = $request->user() ? $request->user()->id : 1;

        $campania = Campania::create([
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'descuento_porcentaje' => $request->descuento_porcentaje,
            'descuento_monto' => $request->descuento_monto,
            'condicion_minimo' => $request->condicion_minimo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado,
            'imagen_banner' => $imagenPath,
            'aplica_todos_productos' => $request->boolean('aplica_todos_productos'),
            'creado_por' => $userId,
            'activado_por' => $request->estado === 'activa' ? $userId : null,
            'activado_at' => $request->estado === 'activa' ? now() : null,
        ]);

        // Asociar productos si no aplica a todos
        if (!$request->boolean('aplica_todos_productos') && $request->filled('productos')) {
            $syncData = [];
            foreach ($request->productos as $productoId) {
                $descEsp = $request->descuentos_especificos[$productoId] ?? null;
                $syncData[$productoId] = ['descuento_especifico' => $descEsp];
            }
            $campania->productos()->sync($syncData);
        }

        return redirect()->route('admin-operaciones-campanias.index')
            ->with('success', 'Campaña creada exitosamente.');
    }

    public function campaniasShow($id)
    {
        $campania = Campania::with([
            'creador.persona',
            'activador.persona',
            'pausador.persona',
            'productos',
            'metricas' => fn($q) => $q->orderBy('fecha'),
        ])->findOrFail($id);

        return view('ADMINISTRADOR.OPERACIONES.campanias.show', compact('campania'));
    }

    public function campaniasEdit($id)
    {
        $campania = Campania::with('productos')->findOrFail($id);
        $productos = Producto::where('estado', 'Activo')
            ->orderBy('name')
            ->get(['id', 'name', 'codigo', 'precio']);

        return view('ADMINISTRADOR.OPERACIONES.campanias.edit', compact('campania', 'productos'));
    }

    public function campaniasUpdate(Request $request, $id)
    {
        $campania = Campania::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:150|unique:campanias,nombre,' . $id,
            'tipo' => 'required|in:descuento,envio_gratis,combo,temporada,flash_sale',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'descuento_porcentaje' => 'nullable|numeric|between:0.01,99.99',
            'descuento_monto' => 'nullable|numeric|min:0.01',
            'condicion_minimo' => 'nullable|numeric|min:0',
            'aplica_todos_productos' => 'nullable|boolean',
            'productos' => 'nullable|array',
            'productos.*' => 'exists:productos,id',
            'descuentos_especificos' => 'nullable|array',
            'imagen_banner' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'slug' => Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'descuento_porcentaje' => $request->descuento_porcentaje,
            'descuento_monto' => $request->descuento_monto,
            'condicion_minimo' => $request->condicion_minimo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'aplica_todos_productos' => $request->boolean('aplica_todos_productos'),
        ];

        if ($request->hasFile('imagen_banner')) {
            $data['imagen_banner'] = $request->file('imagen_banner')->store('campanias', 'public');
        }

        $campania->update($data);

        if (!$request->boolean('aplica_todos_productos') && $request->filled('productos')) {
            $syncData = [];
            foreach ($request->productos as $productoId) {
                $descEsp = $request->descuentos_especificos[$productoId] ?? null;
                $syncData[$productoId] = ['descuento_especifico' => $descEsp];
            }
            $campania->productos()->sync($syncData);
        } elseif ($request->boolean('aplica_todos_productos')) {
            $campania->productos()->detach();
        }

        return redirect()->route('admin-operaciones-campanias.index')
            ->with('success', 'Campaña actualizada exitosamente.');
    }

    public function campaniasDestroy($id)
    {
        $campania = Campania::findOrFail($id);
        $campania->delete();

        return response()->json(['success' => true, 'message' => 'Campaña eliminada.']);
    }

    public function campaniasActivar($id)
    {
        $campania = Campania::with('productos')->findOrFail($id);

        if (!$campania->aplica_todos_productos && $campania->productos->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'La campaña debe tener productos asociados o aplicar a todos.'], 422);
        }

        $userId = request()->user() ? request()->user()->id : null;
        $campania->activar($userId);

        return response()->json(['success' => true, 'message' => 'Campaña activada exitosamente.']);
    }

    public function campaniasPausar(Request $request, $id)
    {
        $request->validate(['motivo' => 'required|string|max:255']);

        $campania = Campania::findOrFail($id);
        $userId = $request->user() ? $request->user()->id : null;
        $campania->pausar($request->motivo, $userId);

        return response()->json(['success' => true, 'message' => 'Campaña pausada.']);
    }

    public function campaniasReanudar($id)
    {
        $campania = Campania::findOrFail($id);

        if ($campania->fecha_fin->isPast()) {
            return response()->json(['success' => false, 'message' => 'No se puede reanudar, la campaña ya venció.'], 422);
        }

        $userId = request()->user() ? request()->user()->id : null;
        $campania->reanudar($userId);

        return response()->json(['success' => true, 'message' => 'Campaña reanudada.']);
    }

    public function campaniasFinalizar($id)
    {
        $campania = Campania::findOrFail($id);
        $campania->finalizar();

        return response()->json(['success' => true, 'message' => 'Campaña finalizada.']);
    }

    public function campaniasDuplicar($id)
    {
        $original = Campania::with('productos')->findOrFail($id);
        $userId = request()->user() ? request()->user()->id : 1;

        $nueva = $original->replicate(['activado_por', 'activado_at', 'pausado_por', 'pausado_at', 'motivo_pausa']);
        $nueva->nombre = $original->nombre . ' (Copia)';
        $nueva->slug = Str::slug($nueva->nombre) . '-' . time();
        $nueva->estado = 'borrador';
        $nueva->creado_por = $userId;
        $nueva->save();

        // Copiar productos asociados
        foreach ($original->productos as $producto) {
            $nueva->productos()->attach($producto->id, [
                'descuento_especifico' => $producto->pivot->descuento_especifico,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Campaña duplicada como borrador.',
            'redirect' => route('admin-operaciones-campanias.edit', $nueva->id),
        ]);
    }

    public function campaniasGetProductos(Request $request)
    {
        $query = Producto::where('estado', 'Activo');

        if ($request->filled('q')) {
            $busqueda = $request->q;
            $query->where(function ($q) use ($busqueda) {
                $q->where('name', 'like', "%{$busqueda}%")
                    ->orWhere('codigo', 'like', "%{$busqueda}%");
            });
        }

        $productos = $query->orderBy('name')->limit(50)->get(['id', 'name', 'codigo', 'precio']);

        return response()->json($productos);
    }

    public function campaniasGetMetricas($id)
    {
        $campania = Campania::findOrFail($id);
        $metricas = $campania->metricas()->orderBy('fecha')->get();

        return response()->json([
            'labels' => $metricas->pluck('fecha')->map(fn($f) => $f->format('d/m')),
            'pedidos' => $metricas->pluck('pedidos_generados'),
            'ventas' => $metricas->pluck('monto_total'),
            'visitas' => $metricas->pluck('visitas'),
        ]);
    }
}
