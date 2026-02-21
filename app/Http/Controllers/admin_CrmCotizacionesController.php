<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CotizacionCrm;
use App\Models\DetalleCotizacionCrm;
use App\Models\Oportunidad;
use App\Models\Producto;
use App\Models\Tipo;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class admin_CrmCotizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CotizacionCrm::with(['oportunidad.prospecto', 'usuario']);

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
            'total_mes' => CotizacionCrm::whereMonth('created_at', now()->month)->count(),
            'valor_total' => CotizacionCrm::whereMonth('created_at', now()->month)->sum('total'),
            'aprobadas' => CotizacionCrm::where('estado', 'aceptada')->whereMonth('created_at', now()->month)->count(),
            'pendientes' => CotizacionCrm::whereIn('estado', ['borrador', 'enviada'])->count(),
        ];

        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.CRM.cotizaciones.index', compact('cotizaciones', 'stats', 'usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $oportunidades = Oportunidad::with('prospecto')
            ->activas()
            ->orderByDesc('created_at')
            ->get();

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

        return view('ADMINISTRADOR.CRM.cotizaciones.create', compact('oportunidades', 'oportunidadId', 'tipos', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'oportunidad_id' => 'required|exists:oportunidades,id',
            'nombre_proyecto' => 'required|string|max:200',
            'vigencia_dias' => 'required|integer|min:1|max:90',
            'incluye_igv' => 'nullable|boolean',
            
            // Ítems
            'items' => 'required|array|min:1',
            'items.*.categoria' => 'required|in:producto,servicio,otro',
            'items.*.descripcion' => 'required|string|max:255',
            'items.*.especificaciones' => 'nullable|string',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.unidad' => 'required|string|max:20',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'items.*.producto_id' => 'nullable|exists:productos,id',
            
            // Totales
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',
            
            // Plazos
            'tiempo_ejecucion_dias' => 'nullable|integer|min:1',
            'garantia_servicio' => 'nullable|string|max:200',
            
            // Notas
            'condiciones_comerciales' => 'nullable|string',
            'notas_internas' => 'nullable|string',
            'observaciones' => 'nullable|string',
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
            'tiempo_ejecucion_dias' => $validated['tiempo_ejecucion_dias'] ?? 5,
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
        $cotizacion->load(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario', 'detalles.producto']);

        $detallesPorCategoria = $cotizacion->detalles->groupBy('categoria');

        return view('ADMINISTRADOR.CRM.cotizaciones.show', compact('cotizacion', 'detallesPorCategoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionCrm $cotizacion)
    {
        $cotizacion->load(['detalles.producto', 'oportunidad.prospecto']);

        $oportunidades = Oportunidad::with('prospecto')
            ->where(function ($q) use ($cotizacion) {
                $q->activas()->orWhere('id', $cotizacion->oportunidad_id);
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

        $categorias = DetalleCotizacionCrm::CATEGORIAS;
        $unidades = DetalleCotizacionCrm::UNIDADES;

        // Preparar ítems existentes para JavaScript (evita closure en @json de Blade)
        $itemsParaEditar = $cotizacion->detalles->map(fn($d) => [
            'categoria' => $d->categoria,
            'descripcion' => $d->descripcion,
            'especificaciones' => $d->especificaciones,
            'cantidad' => $d->cantidad,
            'unidad' => $d->unidad,
            'precio_unitario' => $d->precio_unitario,
            'descuento_porcentaje' => $d->descuento_porcentaje,
            'producto_id' => $d->producto_id,
            'producto_tipo_id' => $d->producto?->tipo_id,
            'producto_categorie_id' => $d->producto?->categorie_id,
        ])->values();

        return view('ADMINISTRADOR.CRM.cotizaciones.edit', compact(
            'cotizacion', 'oportunidades', 'tipos', 'productos', 'categorias', 'unidades', 'itemsParaEditar'
        ));
    }

    /**
     * Update the specified resource in storage.
     * Ahora recibe y procesa el array de ítems completo (igual que store).
     */
    public function update(Request $request, CotizacionCrm $cotizacion)
    {
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

            // Totales
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',

            // Plazos
            'tiempo_ejecucion_dias' => 'nullable|integer|min:1',
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
            'tiempo_ejecucion_dias' => $validated['tiempo_ejecucion_dias'] ?? 5,
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
     * Aprobar cotización
     */
    public function aprobar(CotizacionCrm $cotizacion)
    {
        $cotizacion->aceptar();

        return back()->with('success', 'Cotización aprobada exitosamente.');
    }

    /**
     * Rechazar cotización
     */
    public function rechazar(Request $request, CotizacionCrm $cotizacion)
    {
        $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        $cotizacion->rechazar($request->motivo_rechazo);

        return back()->with('success', 'Cotización rechazada.');
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
     * Agregar ítem (desde edit modal legacy — se mantiene por compatibilidad)
     */
    public function agregarItem(Request $request, CotizacionCrm $cotizacion)
    {
        $validated = $request->validate([
            'categoria' => 'required|in:producto,servicio,otro',
            'descripcion' => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad' => 'required|string|max:20',
            'precio_unitario' => 'required|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'producto_id' => 'nullable|exists:productos,id',
        ]);

        $validated['cotizacion_id'] = $cotizacion->id;
        $validated['orden'] = $cotizacion->detalles()->max('orden') + 1;

        DetalleCotizacionCrm::create($validated);
        $cotizacion->calcularTotales();

        return back()->with('success', 'Ítem agregado correctamente.');
    }

    /**
     * Actualizar ítem
     */
    public function actualizarItem(Request $request, CotizacionCrm $cotizacion, $itemId)
    {
        $validated = $request->validate([
            'categoria' => 'required|in:producto,servicio,otro',
            'descripcion' => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad' => 'required|string|max:20',
            'precio_unitario' => 'required|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
        ]);

        $item = $cotizacion->detalles()->findOrFail($itemId);
        $item->update($validated);
        $cotizacion->calcularTotales();

        return back()->with('success', 'Ítem actualizado correctamente.');
    }

    /**
     * Eliminar ítem
     */
    public function eliminarItem(CotizacionCrm $cotizacion, $itemId)
    {
        $item = $cotizacion->detalles()->findOrFail($itemId);
        $item->delete();
        $cotizacion->calcularTotales();

        return back()->with('success', 'Ítem eliminado correctamente.');
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
        foreach ($items as $itemData) {
            DetalleCotizacionCrm::create([
                'cotizacion_id' => $cotizacion->id,
                'categoria' => $itemData['categoria'],
                'descripcion' => $itemData['descripcion'],
                'especificaciones' => $itemData['especificaciones'] ?? null,
                'cantidad' => $itemData['cantidad'],
                'unidad' => $itemData['unidad'],
                'precio_unitario' => $itemData['precio_unitario'],
                'descuento_porcentaje' => $itemData['descuento_porcentaje'] ?? 0,
                'producto_id' => !empty($itemData['producto_id']) ? $itemData['producto_id'] : null,
                'orden' => $orden++,
            ]);
        }
    }
}
