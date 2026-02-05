<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CotizacionCrm;
use App\Models\Oportunidad;
use App\Models\Prospecto;
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

        // Filtros
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

        if ($request->filled('fecha_desde')) {
            $query->where('fecha_emision', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->where('fecha_emision', '<=', $request->fecha_hasta);
        }

        if ($request->filled('usuario_id')) {
            $query->where('user_id', $request->usuario_id);
        }

        $orderBy = $request->get('order_by', 'created_at');
        $orderDir = $request->get('order_dir', 'desc');
        $query->orderBy($orderBy, $orderDir);

        $cotizaciones = $query->get();

        // EstadÃ­sticas
        $stats = [
            'total_mes' => CotizacionCrm::whereMonth('created_at', now()->month)->count(),
            'valor_total' => CotizacionCrm::whereMonth('created_at', now()->month)->sum('total'),
            'aprobadas' => CotizacionCrm::where('estado', 'aceptada')->whereMonth('created_at', now()->month)->count(),
            'pendientes' => CotizacionCrm::whereIn('estado', ['borrador', 'enviada'])->count(),
        ];

        $usuarios = User::with('persona')->get()->sortBy(fn($u) => $u->persona?->name);

        return view('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.index', compact(
            'cotizaciones',
            'stats',
            'usuarios'
        ));
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

        return view('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.create', compact('oportunidades', 'oportunidadId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'oportunidad_id' => 'required|exists:oportunidades,id',
            'vigencia_dias' => 'required|integer|min:1|max:90',
            
            // Especificaciones tÃ©cnicas
            'potencia_kw' => 'required|numeric|min:0.5',
            'cantidad_paneles' => 'required|integer|min:1',
            'marca_panel' => 'required|string|max:50',
            'modelo_panel' => 'nullable|string|max:100',
            'potencia_panel_w' => 'required|numeric|min:100',
            
            'marca_inversor' => 'required|string|max:50',
            'modelo_inversor' => 'nullable|string|max:100',
            'potencia_inversor_kw' => 'required|numeric|min:0.5',
            
            'incluye_baterias' => 'boolean',
            'marca_bateria' => 'nullable|string|max:50',
            'modelo_bateria' => 'nullable|string|max:100',
            'capacidad_baterias_kwh' => 'nullable|numeric|min:0',
            
            // Precios
            'precio_equipos' => 'required|numeric|min:0',
            'precio_instalacion' => 'required|numeric|min:0',
            'precio_estructura' => 'nullable|numeric|min:0',
            'precio_tramites' => 'nullable|numeric|min:0',
            'precio_otros' => 'nullable|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',
            
            // Tiempos y garantÃ­as
            'tiempo_instalacion_dias' => 'nullable|integer|min:1',
            'garantia_paneles_anos' => 'nullable|integer|min:1|max:30',
            'garantia_inversor_anos' => 'nullable|integer|min:1|max:15',
            'garantia_instalacion_anos' => 'nullable|integer|min:1|max:10',
            
            // Datos de producciÃ³n
            'horas_sol_pico' => 'nullable|numeric|min:1|max:10',
            'tarifa_electrica_kwh' => 'nullable|numeric|min:0',
            
            // Otros
            'condiciones_comerciales' => 'nullable|string',
            'notas_internas' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $validated['estado'] = 'borrador';
        $validated['version'] = 1;
        $validated['fecha_emision'] = now();
        $validated['fecha_vigencia'] = now()->addDays((int) $validated['vigencia_dias']);
        $validated['user_id'] = auth()->id();

        // Obtener datos de la oportunidad para nombre_proyecto y prospecto_id
        $oportunidad = Oportunidad::find($validated['oportunidad_id']);
        $validated['nombre_proyecto'] = $oportunidad->nombre;
        $validated['prospecto_id'] = $oportunidad->prospecto_id;
        $validated['cliente_id'] = $oportunidad->cliente_id;

        // Valores por defecto
        $validated['horas_sol_pico'] = $validated['horas_sol_pico'] ?? 5.0;
        $validated['tarifa_electrica_kwh'] = $validated['tarifa_electrica_kwh'] ?? 0.65;
        $validated['garantia_paneles_anos'] = $validated['garantia_paneles_anos'] ?? 25;
        $validated['garantia_inversor_anos'] = $validated['garantia_inversor_anos'] ?? 10;
        $validated['garantia_instalacion_anos'] = $validated['garantia_instalacion_anos'] ?? 2;

        // Eliminar campo auxiliar
        unset($validated['vigencia_dias']);

        $cotizacion = CotizacionCrm::create($validated);
        
        // Calcular valores derivados
        $cotizacion->calcularTotales();
        $cotizacion->calcularProduccion();
        $cotizacion->calcularAhorro();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.show', $cotizacion)
            ->with('success', 'CotizaciÃ³n creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CotizacionCrm $cotizacione)
    {
        $cotizacione->load(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario', 'detalles']);

        // Agrupar detalles por categorÃ­a
        $detallesPorCategoria = $cotizacione->detalles->groupBy('categoria');

        // Datos para grÃ¡fico de ahorro proyectado
        $proyeccionAhorro = $this->calcularProyeccionAhorro($cotizacione);

        return view('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.show', compact('cotizacione', 'proyeccionAhorro', 'detallesPorCategoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionCrm $cotizacione)
    {
        if ($cotizacione->estado === 'aceptada') {
            return back()->with('error', 'No se puede editar una cotizaciÃ³n aceptada.');
        }

        $cotizacione->load('detalles');

        $oportunidades = Oportunidad::with('prospecto')
            ->orderByDesc('created_at')
            ->get();

        $productos = \App\Models\Producto::where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        $categorias = \App\Models\DetalleCotizacionCrm::CATEGORIAS;
        $unidades = \App\Models\DetalleCotizacionCrm::UNIDADES;

        return view('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.edit', compact('cotizacione', 'oportunidades', 'productos', 'categorias', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionCrm $cotizacione)
    {
        if ($cotizacione->estado === 'aceptada') {
            return back()->with('error', 'No se puede editar una cotizaciÃ³n aceptada.');
        }

        $validated = $request->validate([
            'oportunidad_id' => 'required|exists:oportunidades,id',
            'fecha_vigencia' => 'required|date|after:today',
            
            // Especificaciones tÃ©cnicas
            'potencia_kw' => 'required|numeric|min:0.5',
            'cantidad_paneles' => 'required|integer|min:1',
            'marca_panel' => 'required|string|max:50',
            'modelo_panel' => 'nullable|string|max:100',
            'potencia_panel_w' => 'required|numeric|min:100',
            
            'marca_inversor' => 'required|string|max:50',
            'modelo_inversor' => 'nullable|string|max:100',
            'potencia_inversor_kw' => 'required|numeric|min:0.5',
            
            'incluye_baterias' => 'boolean',
            'marca_bateria' => 'nullable|string|max:50',
            'modelo_bateria' => 'nullable|string|max:100',
            'capacidad_baterias_kwh' => 'nullable|numeric|min:0',
            
            // Precios
            'precio_equipos' => 'required|numeric|min:0',
            'precio_instalacion' => 'required|numeric|min:0',
            'precio_estructura' => 'nullable|numeric|min:0',
            'precio_tramites' => 'nullable|numeric|min:0',
            'precio_otros' => 'nullable|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:50',
            
            // Tiempos y garantÃ­as
            'tiempo_instalacion_dias' => 'nullable|integer|min:1',
            'garantia_paneles_anos' => 'nullable|integer|min:1|max:30',
            'garantia_inversor_anos' => 'nullable|integer|min:1|max:15',
            'garantia_instalacion_anos' => 'nullable|integer|min:1|max:10',
            
            // Otros
            'condiciones_comerciales' => 'nullable|string',
            'notas_internas' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        // Incrementar versiÃ³n si ya fue enviada
        if ($cotizacion->estado === 'enviada') {
            $validated['version'] = $cotizacion->version + 1;
            $validated['estado'] = 'borrador';
        }

        // Si no hay baterÃ­as, limpiar campos relacionados
        if (!($validated['incluye_baterias'] ?? false)) {
            $validated['incluye_baterias'] = false;
            $validated['marca_bateria'] = null;
            $validated['modelo_bateria'] = null;
            $validated['capacidad_baterias_kwh'] = null;
        }

        $cotizacione->update($validated);
        
        // Recalcular valores
        $cotizacione->calcularTotales();
        $cotizacione->calcularProduccion();
        $cotizacione->calcularAhorro();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.show', $cotizacione)
            ->with('success', 'CotizaciÃ³n actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionCrm $cotizacione)
    {
        if ($cotizacione->estado === 'aceptada') {
            return back()->with('error', 'No se puede eliminar una cotizaciÃ³n aceptada.');
        }

        $cotizacione->delete();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.index')
            ->with('success', 'CotizaciÃ³n eliminada exitosamente.');
    }

    /**
     * Enviar cotizaciÃ³n al cliente
     */
    public function enviar(Request $request, CotizacionCrm $cotizacione)
    {
        if ($cotizacione->estado !== 'borrador') {
            return back()->with('error', 'Solo se pueden enviar cotizaciones en borrador.');
        }

        // Validar que tenga email
        $prospecto = $cotizacione->oportunidad->prospecto;
        if (!$prospecto?->email) {
            return back()->with('error', 'El prospecto no tiene email registrado.');
        }

        $cotizacione->update([
            'estado' => 'enviada',
            'fecha_envio' => now(),
        ]);

        // TODO: Enviar email con PDF adjunto
        // Mail::to($prospecto->email)->send(new CotizacionMail($cotizacione));

        return back()->with('success', 'CotizaciÃ³n enviada exitosamente.');
    }

    /**
     * Marcar cotizaciÃ³n como aceptada
     */
    public function aprobar(Request $request, CotizacionCrm $cotizacione)
    {
        if (!in_array($cotizacione->estado, ['borrador', 'enviada'])) {
            return back()->with('error', 'Esta cotizaciÃ³n no puede ser aceptada.');
        }

        $cotizacione->update([
            'estado' => 'aceptada',
            'fecha_aprobacion' => now(),
        ]);

        // Actualizar oportunidad
        $oportunidad = $cotizacione->oportunidad;
        if ($oportunidad && $oportunidad->etapa !== 'ganada') {
            $oportunidad->update([
                'etapa' => 'negociacion',
                'probabilidad' => 70,
                'monto_final' => $cotizacione->total,
            ]);
        }

        return back()->with('success', 'âœ… CotizaciÃ³n aceptada. La oportunidad ha sido actualizada.');
    }

    /**
     * Marcar cotizaciÃ³n como rechazada
     */
    public function rechazar(Request $request, CotizacionCrm $cotizacione)
    {
        $validated = $request->validate([
            'motivo_rechazo' => 'required|string|max:500',
        ]);

        $cotizacione->update([
            'estado' => 'rechazada',
            'motivo_rechazo' => $validated['motivo_rechazo'],
        ]);

        return back()->with('info', 'CotizaciÃ³n marcada como rechazada.');
    }

    /**
     * Duplicar cotizaciÃ³n
     */
    public function duplicar(CotizacionCrm $cotizacione)
    {
        $nueva = $cotizacione->replicate([
            'codigo', 'estado', 'fecha_emision', 'fecha_envio', 
            'fecha_aprobacion', 'motivo_rechazo', 'version'
        ]);

        $nueva->estado = 'borrador';
        $nueva->version = 1;
        $nueva->fecha_emision = now();
        $nueva->fecha_vigencia = now()->addDays(30);
        $nueva->user_id = auth()->id();
        $nueva->save();

        return redirect()
            ->route('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.edit', $nueva)
            ->with('success', 'CotizaciÃ³n duplicada. Puedes editarla antes de enviar.');
    }

    /**
     * Generar PDF de la cotizaciÃ³n
     */
    public function generarPdf(CotizacionCrm $cotizacione)
    {
        $cotizacione->load(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario']);
        
        $proyeccionAhorro = $this->calcularProyeccionAhorro($cotizacione);

        $pdf = Pdf::loadView('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.pdf', compact('cotizacione', 'proyeccionAhorro'));
        
        $pdf->setPaper('A4', 'portrait');

        $filename = "cotizacion_{$cotizacione->codigo}.pdf";

        return $pdf->download($filename);
    }

    /**
     * Vista previa del PDF
     */
    public function previsualizarPdf(CotizacionCrm $cotizacione)
    {
        $cotizacione->load(['oportunidad.prospecto', 'oportunidad.cliente', 'usuario']);
        
        $proyeccionAhorro = $this->calcularProyeccionAhorro($cotizacione);

        $pdf = Pdf::loadView('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.pdf', compact('cotizacione', 'proyeccionAhorro'));
        
        return $pdf->stream("cotizacion_{$cotizacione->codigo}.pdf");
    }

    /**
     * Recalcular valores de la cotizaciÃ³n
     */
    public function recalcular(CotizacionCrm $cotizacione)
    {
        $cotizacione->calcularTotales();
        $cotizacione->calcularProduccion();
        $cotizacione->calcularAhorro();

        return back()->with('success', 'Valores recalculados exitosamente.');
    }

    /**
     * Calcular proyecciÃ³n de ahorro a 25 aÃ±os
     */
    protected function calcularProyeccionAhorro(CotizacionCrm $cotizacion): array
    {
        $proyeccion = [];
        $ahorroAnual = ($cotizacion->ahorro_mensual_soles ?? 0) * 12;
        $tarifaIncremento = ($cotizacion->incremento_tarifa_anual ?? 4) / 100;
        $degradacionPanel = 0.005; // 0.5% anual
        $ahorroAcumulado = 0;
        $inversion = $cotizacion->total ?? 0;

        for ($ano = 1; $ano <= 25; $ano++) {
            // Ajustar por incremento de tarifa y degradaciÃ³n del panel
            $factorTarifa = pow(1 + $tarifaIncremento, $ano - 1);
            $factorDegradacion = pow(1 - $degradacionPanel, $ano - 1);
            
            $ahorroAnoActual = $ahorroAnual * $factorTarifa * $factorDegradacion;
            $ahorroAcumulado += $ahorroAnoActual;
            
            $proyeccion[] = [
                'ano' => $ano,
                'ahorro_anual' => round($ahorroAnoActual, 2),
                'ahorro_acumulado' => round($ahorroAcumulado, 2),
                'roi' => $inversion > 0 ? round((($ahorroAcumulado - $inversion) / $inversion) * 100, 1) : 0,
                'recuperado' => $ahorroAcumulado >= $inversion,
            ];
        }

        return $proyeccion;
    }

    /**
     * Comparar cotizaciones
     */
    public function comparar(Request $request)
    {
        $ids = $request->get('ids', []);
        
        if (count($ids) < 2 || count($ids) > 4) {
            return back()->with('error', 'Selecciona entre 2 y 4 cotizaciones para comparar.');
        }

        $cotizaciones = CotizacionCrm::with(['oportunidad.prospecto'])
            ->whereIn('id', $ids)
            ->get();

        return view('ADMINISTRADOR.PRINCIPAL.crm.cotizaciones.comparar', compact('cotizaciones'));
    }

    /**
     * Agregar Ã­tem a cotizaciÃ³n
     */
    public function agregarItem(Request $request, CotizacionCrm $cotizacione)
    {
        $validated = $request->validate([
            'categoria' => 'required|in:equipo,mano_obra,servicio,material,tramite,otro',
            'descripcion' => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad' => 'required|string|max:20',
            'precio_unitario' => 'required|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
            'producto_id' => 'nullable|exists:productos,id',
        ]);

        $validated['cotizacion_id'] = $cotizacione->id;
        $validated['orden'] = $cotizacione->detalles()->max('orden') + 1;

        \App\Models\DetalleCotizacionCrm::create($validated);

        // Recalcular totales
        $cotizacione->calcularTotales();

        return back()->with('success', 'Ãtem agregado correctamente.');
    }

    /**
     * Actualizar Ã­tem de cotizaciÃ³n
     */
    public function actualizarItem(Request $request, CotizacionCrm $cotizacione, $itemId)
    {
        $validated = $request->validate([
            'categoria' => 'required|in:equipo,mano_obra,servicio,material,tramite,otro',
            'descripcion' => 'required|string|max:255',
            'especificaciones' => 'nullable|string',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad' => 'required|string|max:20',
            'precio_unitario' => 'required|numeric|min:0',
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
        ]);

        $item = $cotizacione->detalles()->findOrFail($itemId);
        $item->update($validated);

        // Recalcular totales
        $cotizacione->calcularTotales();

        return back()->with('success', 'Ãtem actualizado correctamente.');
    }

    /**
     * Eliminar Ã­tem de cotizaciÃ³n
     */
    public function eliminarItem(CotizacionCrm $cotizacione, $itemId)
    {
        $item = $cotizacione->detalles()->findOrFail($itemId);
        $item->delete();

        // Recalcular totales
        $cotizacione->calcularTotales();

        return back()->with('success', 'Ãtem eliminado correctamente.');
    }

    /**
     * Guardar mÃºltiples Ã­tems (AJAX)
     */
    public function guardarItems(Request $request, CotizacionCrm $cotizacione)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.categoria' => 'required|in:equipo,mano_obra,servicio,material,tramite,otro',
            'items.*.descripcion' => 'required|string|max:255',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.unidad' => 'required|string|max:20',
            'items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Eliminar Ã­tems anteriores y recrear
        $cotizacione->detalles()->delete();

        foreach ($request->items as $index => $itemData) {
            \App\Models\DetalleCotizacionCrm::create([
                'cotizacion_id' => $cotizacione->id,
                'categoria' => $itemData['categoria'],
                'descripcion' => $itemData['descripcion'],
                'especificaciones' => $itemData['especificaciones'] ?? null,
                'cantidad' => $itemData['cantidad'],
                'unidad' => $itemData['unidad'],
                'precio_unitario' => $itemData['precio_unitario'],
                'descuento_porcentaje' => $itemData['descuento_porcentaje'] ?? 0,
                'orden' => $index + 1,
            ]);
        }

        // Recalcular totales
        $cotizacione->calcularTotales();

        return response()->json([
            'success' => true,
            'message' => 'Ãtems guardados correctamente.',
            'totales' => [
                'subtotal' => $cotizacione->subtotal,
                'descuento' => $cotizacione->descuento_monto,
                'igv' => $cotizacione->igv,
                'total' => $cotizacione->total,
            ]
        ]);
    }
}

