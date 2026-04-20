<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CotizacionCrm;
use App\Models\DetalleCotizacionCrm;
use App\Models\Oportunidad;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Tipo;
use App\Models\Category;
use App\Models\User;
use App\Services\CotizacionApprovalService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class admin_CrmCotizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user       = auth()->user();
        $esAdmin    = $user->hasAnyRole(['Gerencia', 'Administrador']);

        $query = CotizacionCrm::with(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario']);

        // Rol: no admins solo ven sus propias cotizaciones
        if (!$esAdmin) {
            $query->where('user_id', $user->id);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhereHas('oportunidad', fn($q2) =>
                      $q2->where('nombre', 'like', "%{$buscar}%")
                  )
                  ->orWhereHas('oportunidad.prospecto', fn($q2) =>
                      $q2->where('nombre', 'like', "%{$buscar}%")
                         ->orWhere('razon_social', 'like', "%{$buscar}%")
                  );
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $query->orderByDesc('created_at');
        $cotizaciones = $query->get();

        $stats = [
            'total_mes'   => CotizacionCrm::whereMonth('created_at', now()->month)->count(),
            'valor_total' => CotizacionCrm::whereMonth('created_at', now()->month)->sum('total'),
            'aprobadas'   => CotizacionCrm::where('estado', 'aceptada')->whereMonth('created_at', now()->month)->count(),
            'pendientes'  => CotizacionCrm::whereIn('estado', ['borrador', 'enviada'])->count(),
        ];

        $usuarios = $this->vendedoresDisponibles();

        return view('ADMINISTRADOR.CRM.cotizaciones.index', compact('cotizaciones', 'stats', 'usuarios', 'esAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $esAdmin = $user->hasAnyRole(['Gerencia', 'Administrador']);

        // OPORTUNIDADES: solo las que el usuario puede cotizar.
        //   - Admin: todas las activas.
        //   - No-admin: solo las asignadas a él (consistente con el index de oportunidades).
        // Evita que un vendedor cotice oportunidades que son de otro vendedor.
        $queryOportunidades = Oportunidad::with(['prospecto', 'servicio'])->activas();
        if (!$esAdmin) {
            $queryOportunidades->where('user_id', $user->id);
        }
        $oportunidades = $queryOportunidades->orderByDesc('created_at')->get();

        $oportunidadId = $request->get('oportunidad_id');

        // Tipos con sus categorías (para selects en cascada)
        $tipos = Tipo::with(['categories' => function ($q) {
            $q->where('estado', 'Activo')->orderBy('name');
        }])->where('estado', 'Activo')->orderBy('name')->get();

        // Productos activos con relaciones
        $productos = Producto::where('estado', 'Activo')
            ->with(['marca', 'medida', 'categorie', 'tipo'])
            ->orderBy('name')
            ->get();

        // Servicios activos del catálogo agrupados por tipo
        $servicios = Servicio::where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        return view('ADMINISTRADOR.CRM.cotizaciones.create', compact('oportunidades', 'oportunidadId', 'tipos', 'productos', 'servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'oportunidad_id'   => 'required|exists:oportunidades,id',
            'nombre_proyecto'  => 'required|string|max:200',
            'vigencia_dias'    => 'required|integer|min:1|max:90',
            'incluye_igv'      => 'nullable|boolean',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',

            // Ítems
            'items'                          => 'required|array|min:1',
            'items.*.categoria'              => 'required|in:producto,servicio,otro',
            'items.*.descripcion'            => 'required|string|max:255',
            'items.*.especificaciones'       => 'nullable|string',
            'items.*.cantidad'               => 'required|numeric|min:0.01',
            'items.*.unidad'                 => 'required|string|max:20',
            'items.*.precio_unitario'        => 'required|numeric|min:0',
            'items.*.descuento_porcentaje'   => 'nullable|numeric|min:0|max:100',
            'items.*.producto_id'            => 'nullable|exists:productos,id',
            'items.*.servicio_id'            => 'nullable|exists:servicios,id',
            'items.*.tiempo_ejecucion_dias'  => 'nullable|integer|min:1',

            // Plazos
            'garantia_servicio'     => 'nullable|string|max:200',

            // Notas
            'condiciones_comerciales' => 'nullable|string',
            'notas_internas'          => 'nullable|string',
            'observaciones'           => 'nullable|string',
        ]);

        $oportunidad = Oportunidad::findOrFail($validated['oportunidad_id']);

        // Generar código y slug explícitamente
        $codigo = CotizacionCrm::generarCodigo();
        $slug = CotizacionCrm::generarSlug($codigo);

        $cotizacion = CotizacionCrm::create([
            'codigo' => $codigo,
            'slug' => $slug,
            'oportunidad_id' => $oportunidad->id,
            'prospecto_id' => $oportunidad->prospecto_id,
            'cliente_id' => $oportunidad->cliente_id,
            'nombre_proyecto' => $validated['nombre_proyecto'],
            'version' => 1,
            'estado' => 'borrador',
            'fecha_emision' => now(),
            'fecha_vigencia' => now()->addDays((int) $validated['vigencia_dias']),
            'user_id' => auth()->id(),
            'incluye_igv' => $request->boolean('incluye_igv', true),
            'descuento_porcentaje' => $validated['descuento_porcentaje'] ?? 0,
            'tiempo_ejecucion_dias' => 0, // recalculado desde ítems de servicio
            'garantia_servicio' => $validated['garantia_servicio'] ?? null,
            'condiciones_comerciales' => $validated['condiciones_comerciales'] ?? null,
            'notas_internas' => $validated['notas_internas'] ?? null,
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        // Crear los ítems de detalle
        $this->guardarItemsDeCotizacion($cotizacion, $validated['items']);

        $cotizacion->calcularTotales();

        return redirect()
            ->route('admin.crm.cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CotizacionCrm $cotizacion)
    {
        $cotizacion->load([
            'oportunidad.prospecto',
            'oportunidad.cliente',
            'usuario',
            'detalles.producto',
            'detalles.servicio',
        ]);

        $detallesPorCategoria = $cotizacion->detalles->groupBy('categoria');

        // Buscar pedido vinculado por cotizacion_id (FK directa)
        $pedidoGenerado = null;
        if ($cotizacion->estado === 'aceptada') {
            $pedidoGenerado = Pedido::where('cotizacion_id', $cotizacion->id)->first();

            // Fallback por observaciones para pedidos antiguos sin cotizacion_id
            if (!$pedidoGenerado) {
                $pedidoGenerado = Pedido::where('observaciones', 'LIKE', "%{$cotizacion->codigo}%")->first();
            }
        }

        return view('ADMINISTRADOR.CRM.cotizaciones.show', compact('cotizacion', 'detallesPorCategoria', 'pedidoGenerado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionCrm $cotizacion)
    {
        // No permitir editar cotizaciones cerradas
        if (in_array($cotizacion->estado, ['aceptada', 'rechazada'])) {
            return redirect()
                ->route('admin.crm.cotizaciones.show', $cotizacion)
                ->with('error', 'No se puede editar una cotización ' . $cotizacion->estado . '.');
        }

        $cotizacion->load(['detalles.producto', 'detalles.servicio', 'oportunidad.prospecto', 'oportunidad.servicio']);

        // OPORTUNIDADES: mismo filtro que create, pero SIEMPRE incluir la
        // oportunidad de la cotización actual aunque no pertenezca al usuario
        // (evita que el edit rompa si la cotización fue reasignada por un admin).
        $user = auth()->user();
        $esAdmin = $user->hasAnyRole(['Gerencia', 'Administrador']);

        $oportunidades = Oportunidad::with(['prospecto', 'servicio'])
            ->where(function ($q) use ($cotizacion, $esAdmin, $user) {
                // Condición 1: oportunidades activas (filtradas por user si no es admin)
                $q->where(function ($q2) use ($esAdmin, $user) {
                    $q2->activas();
                    if (!$esAdmin) {
                        $q2->where('user_id', $user->id);
                    }
                });
                // Condición 2: O la oportunidad de la cotización actual (siempre presente)
                $q->orWhere('id', $cotizacion->oportunidad_id);
            })
            ->orderByDesc('created_at')
            ->get();

        // Tipos con sus categorías (para selects en cascada)
        $tipos = Tipo::with(['categories' => function ($q) {
            $q->where('estado', 'Activo')->orderBy('name');
        }])->where('estado', 'Activo')->orderBy('name')->get();

        $productos = Producto::where('estado', 'Activo')
            ->with(['marca', 'medida', 'categorie', 'tipo'])
            ->orderBy('name')
            ->get();

        // Servicios activos del catálogo
        $servicios = Servicio::where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        $categorias = DetalleCotizacionCrm::CATEGORIAS;
        $unidades = DetalleCotizacionCrm::UNIDADES;

        // Preparar ítems existentes para JavaScript (evita closure en @json de Blade)
        $itemsParaEditar = $cotizacion->detalles->map(fn($d) => [
            'categoria'              => $d->categoria,
            'descripcion'            => $d->descripcion,
            'especificaciones'       => $d->especificaciones,
            'cantidad'               => $d->cantidad,
            'unidad'                 => $d->unidad,
            'precio_unitario'        => $d->precio_unitario,
            'descuento_porcentaje'   => $d->descuento_porcentaje,
            'producto_id'            => $d->producto_id,
            'servicio_id'            => $d->servicio_id,
            'tiempo_ejecucion_dias'  => $d->tiempo_ejecucion_dias,
            'producto_tipo_id'       => $d->producto?->tipo_id,
            'producto_categorie_id'  => $d->producto?->categorie_id,
        ])->values();

        return view('ADMINISTRADOR.CRM.cotizaciones.edit', compact(
            'cotizacion', 'oportunidades', 'tipos', 'productos', 'servicios', 'categorias', 'unidades', 'itemsParaEditar'
        ));
    }

    /**
     * Update the specified resource in storage.
     * Ahora recibe y procesa el array de ítems completo (igual que store).
     */
    public function update(Request $request, CotizacionCrm $cotizacion)
    {
        // No permitir actualizar cotizaciones cerradas
        if (in_array($cotizacion->estado, ['aceptada', 'rechazada'])) {
            return redirect()
                ->route('admin.crm.cotizaciones.show', $cotizacion)
                ->with('error', 'No se puede modificar una cotización ' . $cotizacion->estado . '.');
        }

        $validated = $request->validate([
            'oportunidad_id' => 'required|exists:oportunidades,id',
            'nombre_proyecto' => 'required|string|max:200',
            'fecha_vigencia' => 'required|date',
            'incluye_igv' => 'nullable|boolean',

            // Ítems (obligatorios, mismo formato que store)
            'items' => 'required|array|min:1',
            'items.*.categoria' => 'required|in:producto,servicio,otro',
            'items.*.descripcion' => 'required|string|max:255',
            'items.*.especificaciones' => 'nullable|string',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.unidad' => 'required|string|max:20',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'items.*.producto_id' => 'nullable|exists:productos,id',
            'items.*.servicio_id' => 'nullable|exists:servicios,id',
            'items.*.tiempo_ejecucion_dias' => 'nullable|integer|min:1',

            // Totales
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',

            // Plazos
            'garantia_servicio' => 'nullable|string|max:200',

            // Notas
            'condiciones_comerciales' => 'nullable|string',
            'notas_internas' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $oportunidad = Oportunidad::findOrFail($validated['oportunidad_id']);

        // Actualizar datos generales de la cotización
        $cotizacion->update([
            'oportunidad_id' => $oportunidad->id,
            'prospecto_id' => $oportunidad->prospecto_id,
            'cliente_id' => $oportunidad->cliente_id,
            'nombre_proyecto' => $validated['nombre_proyecto'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'incluye_igv' => $request->boolean('incluye_igv', true),
            'descuento_porcentaje' => $validated['descuento_porcentaje'] ?? 0,
            'tiempo_ejecucion_dias' => 0, // recalculado desde ítems de servicio
            'garantia_servicio' => $validated['garantia_servicio'] ?? null,
            'condiciones_comerciales' => $validated['condiciones_comerciales'] ?? null,
            'notas_internas' => $validated['notas_internas'] ?? null,
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        // Eliminar ítems anteriores y recrear desde el formulario
        $cotizacion->detalles()->delete();
        $this->guardarItemsDeCotizacion($cotizacion, $validated['items']);

        // Recalcular totales desde los nuevos ítems
        $cotizacion->calcularTotales();

        return redirect()
            ->route('admin.crm.cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionCrm $cotizacion)
    {
        if (in_array($cotizacion->estado, ['aceptada'])) {
            return back()->with('error', 'No se puede eliminar una cotización aceptada.');
        }

        $cotizacion->delete();

        return redirect()
            ->route('admin.crm.cotizaciones.index')
            ->with('success', 'Cotización eliminada correctamente.');
    }

    /**
     * Enviar cotización
     */
    public function enviar(CotizacionCrm $cotizacion)
    {
        if ($cotizacion->estado !== 'borrador') {
            return back()->with('error', 'Solo se pueden enviar cotizaciones en estado borrador.');
        }

        $cotizacion->marcarEnviada();

        return back()->with('success', 'Cotización enviada exitosamente.');
    }

    /**
     * Aprobar cotización → Flujo completo:
     * Cotización aceptada → Prospecto convertido → Cliente creado → Oportunidad ganada → Pedido generado
     */
    public function aprobar(CotizacionCrm $cotizacion)
    {
        $service = new CotizacionApprovalService();
        $resultado = $service->aprobar($cotizacion);

        if ($resultado['success']) {
            return back()->with('success', $resultado['message']);
        }

        return back()->with('error', $resultado['message']);
    }

    /**
     * Rechazar cotización
     */
    public function rechazar(Request $request, CotizacionCrm $cotizacion)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        $service = new CotizacionApprovalService();
        $resultado = $service->rechazar($cotizacion, $request->motivo_rechazo);

        return back()->with('success', $resultado['message']);
    }

    /**
     * Duplicar cotización
     */
    public function duplicar(CotizacionCrm $cotizacion)
    {
        $nueva = $cotizacion->crearNuevaVersion();

        return redirect()
            ->route('admin.crm.cotizaciones.edit', $nueva)
            ->with('success', 'Cotización duplicada. Puedes editarla antes de enviar.');
    }

    /**
     * Generar PDF profesional
     */
    public function generarPdf(CotizacionCrm $cotizacion)
    {
        $cotizacion->load(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario', 'detalles.producto']);

        $detallesPorCategoria = $cotizacion->detalles->groupBy('categoria');

        $pdf = Pdf::loadView('ADMINISTRADOR.CRM.cotizaciones.pdf', compact('cotizacion', 'detallesPorCategoria'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("cotizacion_{$cotizacion->codigo}.pdf");
    }

    /**
     * Vista previa del PDF
     */
    public function previsualizarPdf(CotizacionCrm $cotizacion)
    {
        $cotizacion->load(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario', 'detalles.producto']);

        $detallesPorCategoria = $cotizacion->detalles->groupBy('categoria');

        $pdf = Pdf::loadView('ADMINISTRADOR.CRM.cotizaciones.pdf', compact('cotizacion', 'detallesPorCategoria'));

        return $pdf->stream("cotizacion_{$cotizacion->codigo}.pdf");
    }

    /**
     * Recalcular valores
     */
    public function recalcular(CotizacionCrm $cotizacion)
    {
        $cotizacion->calcularTotales();

        return back()->with('success', 'Valores recalculados exitosamente.');
    }

    /**
     * Guardar múltiples ítems (AJAX)
     */
    public function guardarItems(Request $request, CotizacionCrm $cotizacion)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.categoria' => 'required|in:producto,servicio,otro',
            'items.*.descripcion' => 'required|string|max:255',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.unidad' => 'required|string|max:20',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $cotizacion->detalles()->delete();
        $this->guardarItemsDeCotizacion($cotizacion, $request->items);
        $cotizacion->calcularTotales();

        return response()->json([
            'success' => true,
            'message' => 'Ítems guardados correctamente.',
            'totales' => [
                'subtotal' => $cotizacion->subtotal,
                'descuento' => $cotizacion->descuento_monto,
                'igv' => $cotizacion->igv,
                'total' => $cotizacion->total,
            ]
        ]);
    }


    // ================================================================
    // MÉTODOS PRIVADOS
    // ================================================================

    /**
     * Guardar array de ítems en la cotización.
     * Reutilizado por store(), update() y guardarItems().
     */
    private function guardarItemsDeCotizacion(CotizacionCrm $cotizacion, array $items): void
    {
        $orden = 1;
        $tiempoTotal = 0;

        // Pre-cargar códigos de productos y servicios en lote para evitar N+1.
        // Estos códigos se "congelan" en codigo_item al momento de cotizar.
        $productoIds = collect($items)->pluck('producto_id')->filter()->unique()->values();
        $servicioIds = collect($items)->pluck('servicio_id')->filter()->unique()->values();

        $codigosProductos = $productoIds->isNotEmpty()
            ? Producto::whereIn('id', $productoIds)->pluck('codigo', 'id')
            : collect();

        $codigosServicios = $servicioIds->isNotEmpty()
            ? Servicio::whereIn('id', $servicioIds)->pluck('codigo', 'id')
            : collect();

        foreach ($items as $itemData) {
            $esServicio = ($itemData['categoria'] ?? '') === 'servicio';
            $tiempoItem = $esServicio ? (int)($itemData['tiempo_ejecucion_dias'] ?? 0) : null;
            if ($tiempoItem) $tiempoTotal += $tiempoItem;

            $productoId = !empty($itemData['producto_id']) ? $itemData['producto_id'] : null;
            $servicioId = !empty($itemData['servicio_id']) ? $itemData['servicio_id'] : null;

            // Snapshot del SKU/código al momento de cotizar.
            // Si el producto/servicio cambia su código a futuro, la cotización mantiene el original.
            $codigoSnapshot = null;
            if ($productoId) {
                $codigoSnapshot = $codigosProductos[$productoId] ?? null;
            } elseif ($servicioId) {
                $codigoSnapshot = $codigosServicios[$servicioId] ?? null;
            }

            DetalleCotizacionCrm::create([
                'cotizacion_id'          => $cotizacion->id,
                'categoria'              => $itemData['categoria'],
                'codigo_item'            => $codigoSnapshot,
                'descripcion'            => $itemData['descripcion'],
                'especificaciones'       => $itemData['especificaciones'] ?? null,
                'cantidad'               => $itemData['cantidad'],
                'unidad'                 => $itemData['unidad'],
                'precio_unitario'        => $itemData['precio_unitario'],
                'descuento_porcentaje'   => $itemData['descuento_porcentaje'] ?? 0,
                'producto_id'            => $productoId,
                'servicio_id'            => $servicioId,
                'tiempo_ejecucion_dias'  => $tiempoItem,
                'orden'                  => $orden++,
            ]);
        }

        // Actualizar tiempo total (reset a 0 si no hay servicios, suma si los hay)
        $cotizacion->update(['tiempo_ejecucion_dias' => $tiempoTotal]);
    }

    /**
     * Retorna la lista de usuarios que pueden aparecer en el filtro de
     * vendedor del listado de cotizaciones.
     *
     * CRITERIO (basado en permisos, NO en roles hardcoded):
     *   - Solo usuarios con el permiso 'crm.cotizaciones.edit'. Quien pueda
     *     editar cotizaciones es quien puede haberlas creado.
     *   - Solo usuarios con estado 'Activo'.
     */
    private function vendedoresDisponibles()
    {
        return User::permission('crm.cotizaciones.edit')
            ->where('estado', 'Activo')
            ->with('persona')
            ->get()
            ->sortBy(fn($u) => $u->persona?->name);
    }
}
