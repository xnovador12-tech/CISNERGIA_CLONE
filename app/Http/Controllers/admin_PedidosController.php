<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Almacen;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Tipo;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\ComprobanteEmail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class admin_PedidosController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'usuario', 'distrito', 'venta']);

        // Filtro por Fecha
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        // Filtro por Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por Cliente
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        $pedidos = $query->orderBy('created_at', 'desc')->get();

        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::with(['vendedor.persona', 'distrito'])->orderBy('nombre')->get();
        $tipos    = Tipo::with('categories.subcategories')->get();
        $subcategorias = Subcategory::all();
        $productos = Producto::with('marca')->get();
        $servicios = Servicio::all();
        $almacenes = Almacen::all();
        $distritos = Distrito::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();

        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.create', compact('clientes', 'tipos', 'subcategorias', 'productos', 'servicios', 'almacenes', 'distritos', 'departamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_entrega_estimada' => 'nullable|date',
            'direccion_instalacion' => 'nullable|string',
            'distrito_id' => 'nullable|exists:distritos,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
            'condicion_pago' => 'nullable|in:Contado,Crédito',
            'cuotas' => 'nullable|array',
            'cuotas.*.importe' => 'required_with:cuotas|numeric|min:0.01',
            'cuotas.*.fecha_vencimiento' => 'required_with:cuotas|date'
        ]);

        // Generar código único
        $ultimoPedido = Pedido::latest('id')->first();
        $numero = $ultimoPedido ? $ultimoPedido->id + 1 : 1;
        $codigo = 'PED-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        $pedido = new Pedido();
        $pedido->codigo = $codigo;
        $pedido->slug = Str::slug($codigo);
        $pedido->cliente_id = $request->cliente_id;
        $pedido->user_id = auth()->id();
        $pedido->subtotal = $request->subtotal ?? 0;
        $pedido->descuento_porcentaje = $request->descuento_porcentaje ?? 0;
        $pedido->descuento_monto = $request->descuento_monto ?? 0;
        $pedido->incluye_igv = $request->boolean('incluye_igv');
        $pedido->igv = $request->igv ?? 0;
        $pedido->total = $request->total ?? 0;
        $pedido->estado = 'pendiente';
        $pedido->aprobacion_finanzas = false;  // Nuevo pedido = No aprobado
        $pedido->aprobacion_stock = false;     // Nuevo pedido = Sin reserva
        $pedido->direccion_instalacion = $request->direccion_instalacion;
        $pedido->distrito_id = $request->distrito_id;
        $pedido->fecha_entrega_estimada = $request->fecha_entrega_estimada;
        $pedido->almacen_id = $request->almacen_id;
        $pedido->condicion_pago = $request->condicion_pago;
        $pedido->observaciones = $request->observaciones;
        $pedido->origen = 'directo';
        $pedido->save();

        // Guardar cuotas si es crédito
        if ($pedido->condicion_pago === 'Crédito' && $request->has('cuotas')) {
            foreach ($request->cuotas as $index => $cuotaData) {
                \App\Models\PedidoCuota::create([
                    'pedido_id' => $pedido->id,
                    'numero_cuota' => $index + 1,
                    'importe' => $cuotaData['importe'],
                    'fecha_vencimiento' => $cuotaData['fecha_vencimiento'],
                ]);
            }
        }

        // Guardar detalles del pedido y Reservar Stock Automáticamente
        if ($request->has('detalles')) {
            $stockReservadoTotalmente = true;

            foreach ($request->detalles as $detalleData) {
                $detalle = DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $detalleData['producto_id'] ?? null,
                    'servicio_id' => $detalleData['servicio_id'] ?? null,
                    'subcategory_id' => $detalleData['subcategory_id'] ?? null,
                    'tipo' => $detalleData['tipo'] ?? 'producto',
                    'descripcion' => $detalleData['descripcion'],
                    'cantidad' => $detalleData['cantidad'],
                    'unidad' => $detalleData['unidad'] ?? 'und',
                    'precio_unitario' => $detalleData['precio_unitario'],
                    'descuento_porcentaje' => $detalleData['descuento_porcentaje'] ?? 0,
                    'descuento_monto' => $detalleData['descuento_monto'] ?? 0,
                    'subtotal' => $detalleData['subtotal'],
                ]);

                // LOGICA DE RESERVA INTERNA AUTOMÁTICA USANDO StockService
                if ($detalle->producto_id) {
                    $stockService = new \App\Services\StockService();
                    if ($stockService->hasStock([$detalle], $pedido->almacen_id)) {
                        $stockService->deductStock([$detalle], $pedido->almacen_id);
                    } else {
                        $stockReservadoTotalmente = false;
                    }
                }
            }

            // Si se pudo reservar todo el stock de los productos
            if ($stockReservadoTotalmente) {
                $pedido->aprobacion_stock = true;
                $pedido->save();
            }
        }

        return redirect()->route('admin-pedidos.show', $pedido)->with('success', '✅ Pedido creado' . ($pedido->aprobacion_stock ? ' y stock reservado automáticamente.' : '. ⚠️ Atención: No hay stock suficiente para reserva automática.'));
    }

    public function show(Pedido $admin_pedido)
    {
        $pedido = $admin_pedido->load(['cliente', 'usuario', 'distrito.provincia', 'almacen', 'detalles.producto', 'detalles.servicio', 'detalles.subcategoria', 'cuotas', 'cotizacionCrm']);
        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $admin_pedido)
    {
        // VALIDACIÓN: No permitir editar pedidos que ya tienen venta generada
        if ($admin_pedido->venta) {
            return redirect()->route('admin-pedidos.show', $admin_pedido)
                ->with('error', '❌ No se puede editar un pedido que ya tiene un comprobante generado: ' . $admin_pedido->venta->codigo . '. Debe anular primero la venta si necesita hacer cambios.');
        }

        $pedido = $admin_pedido->load('detalles', 'cuotas');
        $clientes = Cliente::with('distrito')->orderBy('nombre')->get();
        $tipos    = Tipo::with('categories.subcategories')->get();
        $subcategorias = Subcategory::all();
        $productos = Producto::with('marca')->get();
        $servicios = Servicio::all();
        $almacenes = Almacen::all();
        $distritos = Distrito::orderBy('nombre')->get();
        $departamentos = Departamento::orderBy('nombre')->get();

        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.create', compact('pedido', 'clientes', 'tipos', 'subcategorias', 'productos', 'servicios', 'almacenes', 'distritos', 'departamentos'));
    }

    public function update(Request $request, Pedido $admin_pedido)
    {
        // VALIDACIÓN: No permitir actualizar pedidos que ya tienen venta generada
        if ($admin_pedido->venta) {
            return redirect()->route('admin-pedidos.show', $admin_pedido)
                ->with('error', '❌ No se puede modificar un pedido que ya tiene un comprobante generado: ' . $admin_pedido->venta->codigo . '. Debe anular primero la venta.');
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|in:pendiente,proceso,confirmado,cancelado',
            'fecha_entrega_estimada' => 'nullable|date',
            'direccion_instalacion' => 'nullable|string',
            'distrito_id' => 'nullable|exists:distritos,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
            'subtotal' => 'nullable|numeric',
            'descuento_porcentaje' => 'nullable|numeric',
            'descuento_monto' => 'nullable|numeric',
            'igv' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'condicion_pago' => 'nullable|in:Contado,Crédito',
            'cuotas' => 'nullable|array',
            'cuotas.*.importe' => 'required_with:cuotas|numeric|min:0.01',
            'cuotas.*.fecha_vencimiento' => 'required_with:cuotas|date'
        ]);

        // If 'Contado' is sent as an empty string or null from the frontend (if applicable)
        // ensure it's saved as null if it's not actually specified.
        if (empty($validated['condicion_pago'])) {
            $validated['condicion_pago'] = null;
        }

        // 1. Devolver Stock actual antes de los cambios (si estaba reservado)
        if ($admin_pedido->aprobacion_stock) {
            $stockService = new \App\Services\StockService();
            $stockService->restoreStock($admin_pedido->detalles, $admin_pedido->almacen_id);
            $admin_pedido->aprobacion_stock = false;
        }

        // 2. Actualizar datos principales
        $admin_pedido->update($validated);

        // Actualizar cuotas si es crédito
        $admin_pedido->cuotas()->delete();
        if (isset($validated['condicion_pago']) && $validated['condicion_pago'] === 'Crédito' && !empty($validated['cuotas'])) {
            foreach ($validated['cuotas'] as $index => $cuotaData) {
                \App\Models\PedidoCuota::create([
                    'pedido_id' => $admin_pedido->id,
                    'numero_cuota' => $index + 1,
                    'importe' => $cuotaData['importe'],
                    'fecha_vencimiento' => $cuotaData['fecha_vencimiento'],
                ]);
            }
        }

        // 3. Actualizar Detalles (Borrar y crear nuevos)
        if ($request->has('detalles')) {
            $admin_pedido->detalles()->delete();
            $stockReservadoTotalmente = true;

            foreach ($request->detalles as $detalleData) {
                $detalle = DetallePedido::create([
                    'pedido_id' => $admin_pedido->id,
                    'producto_id' => $detalleData['producto_id'] ?? null,
                    'servicio_id' => $detalleData['servicio_id'] ?? null,
                    'subcategory_id' => $detalleData['subcategory_id'] ?? null,
                    'tipo' => $detalleData['tipo'] ?? 'producto',
                    'descripcion' => $detalleData['descripcion'],
                    'cantidad' => $detalleData['cantidad'],
                    'unidad' => $detalleData['unidad'] ?? 'und',
                    'precio_unitario' => $detalleData['precio_unitario'],
                    'descuento_porcentaje' => $detalleData['descuento_porcentaje'] ?? 0,
                    'descuento_monto' => $detalleData['descuento_monto'] ?? 0,
                    'subtotal' => $detalleData['subtotal'],
                ]);

                // 4. Intentar re-reservar stock si es manual y era pendiente/proceso
                if ($detalle->producto_id && in_array($admin_pedido->estado, ['pendiente', 'proceso'])) {
                    $stockService = new \App\Services\StockService();
                    if ($stockService->deductStock([$detalle], $admin_pedido->almacen_id)) {
                        // Stock reservado unitariamente
                    } else {
                        $stockReservadoTotalmente = false;
                    }
                }
            }

            if ($stockReservadoTotalmente && in_array($admin_pedido->estado, ['pendiente', 'proceso'])) {
                $admin_pedido->aprobacion_stock = true;
                $admin_pedido->save();
            }
        }

        return redirect()->route('admin-pedidos.show', $admin_pedido)->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Pedido $admin_pedido)
    {
        // VALIDACIÓN: No permitir eliminar pedidos que ya tienen venta generada
        if ($admin_pedido->venta) {
            return back()->with('error', '❌ No se puede eliminar un pedido que tiene un comprobante generado: ' . $admin_pedido->venta->codigo . '. Debe anular primero la venta desde el módulo de Ventas.');
        }

        // Devolver stock si estaba aprobado
        if ($admin_pedido->aprobacion_stock) {
            $stockService = new \App\Services\StockService();
            $stockService->restoreStock($admin_pedido->detalles, $admin_pedido->almacen_id);
        }

        $admin_pedido->delete();
        return redirect()->route('admin-pedidos.index')->with('success', '✅ Pedido eliminado correctamente. Stock restaurado al inventario.');
    }

    /**
     * Cambiar estado del pedido con lógica de cancelación correcta
     * 
     * ESCENARIOS MANEJADOS:
     * 1. Cancelación sin venta: Restaura stock + revoca aprobaciones
     * 2. Cancelación con venta (e-commerce): Bloquea y redirige a Nota de Crédito
     * 3. Otros cambios de estado: Solo cambian estado
     */
    public function estado(Request $request, Pedido $admin_pedido)
    {
        $nuevoEstado = $request->estado;
        
        // ================================================================
        // VALIDACIÓN 1: Si es CANCELACIÓN, revisar si tiene venta asociada
        // ================================================================
        if ($nuevoEstado === 'cancelado') {
            // Si tiene venta generada, necesita Nota de Crédito
            if ($admin_pedido->venta) {
                return back()->with('error', 
                    '❌ No se puede cancelar directamente. Este pedido tiene comprobante emitido: ' . 
                    $admin_pedido->venta->codigo . 
                    '. Debe generar una NOTA DE CRÉDITO en el módulo de Ventas para reversar esta operación.'
                );
            }
        }

        // ================================================================
        // LÓGICA DE CANCELACIÓN: Restaurar stock y revertir aprobaciones
        // ================================================================
        if ($nuevoEstado === 'cancelado') {
            return DB::transaction(function () use ($admin_pedido, $nuevoEstado) {
                $stockRestorado = false;
                
                // PASO 1: Restaurar stock si estaba aprobado
                if ($admin_pedido->aprobacion_stock) {
                    try {
                        $stockService = new \App\Services\StockService();
                        $stockService->restoreStock($admin_pedido->detalles, $admin_pedido->almacen_id);
                        $stockRestorado = true;
                    } catch (\Exception $e) {
                        return back()->with('error', '❌ Error al restaurar stock: ' . $e->getMessage());
                    }
                }

                // PASO 2: Revertir aprobaciones al cancelar
                $admin_pedido->aprobacion_stock = false;
                $admin_pedido->aprobacion_finanzas = false;

                // PASO 3: Cambiar estado a cancelado
                $admin_pedido->estado = 'cancelado';
                $admin_pedido->updated_by = auth()->id();
                $admin_pedido->save();

                // PASO 4: Registrar la cancelación en observaciones para auditoría
                $motivoCancelacion = $request->motivo ?? 'No especificado';
                $observacionesAdicionales = $request->observaciones_cancelacion ?? '';
                $observacionesActuales = $admin_pedido->observaciones ?? '';
                
                // Construir registro de auditoría completo
                $registroCancelacion = "[CANCELACIÓN - " . now()->format('Y-m-d H:i:s') . "] " .
                    "Usuario: " . auth()->user()->name . " | " .
                    "Motivo: " . $motivoCancelacion;
                
                if (!empty($observacionesAdicionales)) {
                    $registroCancelacion .= " | Notas: " . $observacionesAdicionales;
                }
                
                $registroCancelacion .= ($stockRestorado ? " | Stock restaurado: SÍ" : " | Stock: No tenía reservado");
                
                $admin_pedido->observaciones = $observacionesActuales . "\n\n" . $registroCancelacion;
                $admin_pedido->save();

                // PASO 5: Mensaje de éxito personalizando por origen
                $msg = match($admin_pedido->origen) {
                    'ecommerce' => '✅ Pedido e-commerce cancelado. Stock de ' . $admin_pedido->detalles->count() . 
                                   ' línea(s) restaurado. Notificar al cliente.',
                    'cotizacion' => '✅ Pedido desde cotización cancelado. Stock restaurado. Actualizar prospecto.',
                    default => '✅ Pedido cancelado correctamente.' . ($stockRestorado ? ' Stock restaurado.' : '')
                };

                return back()->with('success', $msg);
            });
        }
        
        // ================================================================
        // OTROS CAMBIOS DE ESTADO (confirmado → proceso, etc)
        // ================================================================
        $admin_pedido->estado = $nuevoEstado;
        $admin_pedido->updated_by = auth()->id();
        $admin_pedido->save();

        $msg = match($nuevoEstado) {
            'confirmado' => '✅ Pedido confirmado.',
            'proceso' => '✅ Pedido en proceso.',
            'entregado' => '✅ Pedido entregado.',
            default => '✅ Estado actualizado.'
        };

        return back()->with('success', $msg);
    }

    /**
     * Toggle aprobación de Finanzas con Registro de Pago
     */
    public function aprobarFinanzas(Request $request, Pedido $admin_pedido)
    {
        if (!$admin_pedido->aprobacion_finanzas) {
            // Flujo simplificado solicitado: confirmar pago sin modal ni captura duplicada
            $admin_pedido->aprobacion_finanzas = true;
        } else {
            // Se va a Revocar
            $admin_pedido->aprobacion_finanzas = false;
        }

        // Auto-avanzar a 'proceso' si ambas aprobaciones están listas
        if ($admin_pedido->aprobacion_finanzas && $admin_pedido->aprobacion_stock) {
            $admin_pedido->estado = 'proceso';
        } 
        // Si se revoca y no estaba ya terminado, vuelve a pendiente
        elseif (!$admin_pedido->aprobacion_finanzas && $admin_pedido->estado === 'proceso') {
            $admin_pedido->estado = 'pendiente';
        }

        $admin_pedido->save();
        return back()->with('success', $admin_pedido->aprobacion_finanzas 
            ? '✅ Pago validado. Ya puede generar el comprobante desde Facturación Directa.'
            : '⚠️ Aprobación revocada. Pedido regresó a PENDIENTE.');
    }

    /**
     * Toggle aprobación de Stock
     */
    public function aprobarStock(Pedido $admin_pedido)
    {
        // Lógica de movimiento de Stock
        if (!$admin_pedido->aprobacion_stock) {
            // Se va a activar: DESCONTAR STOCK
            try {
                $stockService = new \App\Services\StockService();
                $stockService->deductStock($admin_pedido->detalles, $admin_pedido->almacen_id);
            } catch (\Exception $e) {
                return back()->with('error', '❌ Error al reservar stock: ' . $e->getMessage());
            }
            $admin_pedido->aprobacion_stock = true;
            $msg = '✅ Stock reservado correctamente. El inventario ha sido descontado.';
        } else {
            // Se va a desactivar: DEVOLVER STOCK
            $stockService = new \App\Services\StockService();
            $stockService->restoreStock($admin_pedido->detalles, $admin_pedido->almacen_id);

            $admin_pedido->aprobacion_stock = false;
            // Si estaba en proceso y se libera stock, vuelve a pendiente
            if ($admin_pedido->estado === 'proceso') {
                $admin_pedido->estado = 'pendiente';
                $msg = '⚠️ Aprobación de stock revocada. El pedido regresó a PENDIENTE.';
            } else {
                $msg = '⚠️ Aprobación de stock revocada. El inventario ha sido restaurado.';
            }
        }

        // Auto-avanzar a 'proceso' si al reservar stock, finanzas ya estaba aprobada
        if ($admin_pedido->aprobacion_stock && $admin_pedido->aprobacion_finanzas) {
            $admin_pedido->estado = 'proceso';
            $msg = '✅ Stock reservado. El pedido ahora está EN PROCESO.';
        }

        $admin_pedido->save();
        return back()->with('success', $msg);
    }

    /**
     * Generar Comprobante (Venta) desde Pedido Entregado
     */
    public function generarComprobante(Request $request, Pedido $admin_pedido)
    {
        // VALIDACIÓN 1: El pedido debe tener aprobación de Finanzas
        if (!$admin_pedido->aprobacion_finanzas) {
            return back()->with('error', 'Solo se pueden facturar pedidos con pago verificado (Finanzas Aprobado).');
        }

        // VALIDACIÓN 2: El pedido no debe tener venta asociada
        if ($admin_pedido->venta) {
            return redirect()->route('admin-ventas.show', $admin_pedido->venta)
                ->with('error', 'Este pedido ya tiene un comprobante generado: ' . $admin_pedido->venta->codigo);
        }

        // VALIDACIÓN 3: Debe tener aprobaciones (solo validamos Finanzas estrictamente para facturar)
        // El Stock es logístico, a veces se factura antes de tener stock físico (Venta Futura)
        if ($admin_pedido->origen !== 'ecommerce') {
            if (!$admin_pedido->aprobacion_finanzas) {
                return back()->with('error', 'El pedido debe tener aprobación de Finanzas antes de facturar.');
            }
        }

        // Validar datos del formulario
        $validated = $request->validate([
            'tiposcomprobante_id' => 'required|exists:tiposcomprobantes,id',
            'condicion_pago' => 'required|in:Contado,Crédito',
            'mediopago_id' => 'required|exists:mediopagos,id',
            'cuotas' => 'nullable|array',
            'cuotas.*.importe' => 'required_with:cuotas|numeric|min:0.01',
            'cuotas.*.fecha_vencimiento' => 'required_with:cuotas|date'
        ]);

        // Generar número de comprobante usando SerieComprobante
        $serieComprobante = \App\Models\SerieComprobante::where('tiposcomprobante_id', $validated['tiposcomprobante_id'])
            ->where('activo', true)
            ->first();

        if (!$serieComprobante) {
            return back()->with('error', 'No hay una serie activa para este tipo de comprobante.');
        }

        $numeroComprobante = $serieComprobante->generarNumero();

        // Extraer serie y correlativo por separado
        $serieStr = $serieComprobante->serie;
        $correlativoNum = $serieComprobante->correlativo->numero;

        // Fecha de emisión y hora actuales
        $fechaEmision = now()->format('Y-m-d');
        $hora = now()->format('H:i:s');

        // Generar código único para la venta
        $ultimaVenta = \App\Models\Sale::latest('id')->first();
        $numero = $ultimaVenta ? $ultimaVenta->id + 1 : 1;
        $codigoVenta = 'VTA-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        // Crear la Venta copiando datos del Pedido
        $venta = \App\Models\Sale::create([
            'codigo' => $codigoVenta,
            'slug' => Str::slug($codigoVenta),
            'pedido_id' => $admin_pedido->id,
            'cliente_id' => $admin_pedido->cliente_id,
            'tiposcomprobante_id' => $validated['tiposcomprobante_id'],
            'numero_comprobante' => $numeroComprobante,
            'fecha_emision' => $fechaEmision,
            'hora' => $hora,
            'serie_id' => $serieComprobante->id,
            'serie' => $serieStr,
            'correlativo' => $correlativoNum,
            'subtotal' => $admin_pedido->subtotal,
            'descuento' => $admin_pedido->descuento_monto,
            'igv' => $admin_pedido->igv,
            'total' => $admin_pedido->total,
            'mediopago_id' => $validated['mediopago_id'],
            'condicion_pago' => $validated['condicion_pago'],
            'estado' => 'completada',
            'user_id' => auth()->id(),
            'sede_id' => auth()->user()->persona->sede_id ?? null,
            'tipo_venta' => 'pedido',
            'observaciones' => 'Generado automáticamente desde Pedido ' . $admin_pedido->codigo,
        ]);

        // Copiar detalles del Pedido a la Venta
        foreach ($admin_pedido->detalles as $detalle) {
            \App\Models\Detailsale::create([
                'sale_id' => $venta->id,
                'producto_id' => $detalle->producto_id,
                'servicio_id' => $detalle->servicio_id,
                'tipo' => $detalle->tipo ?? 'producto',
                'descripcion' => $detalle->descripcion,
                'cantidad' => $detalle->cantidad,
                'precio_unitario' => $detalle->precio_unitario,
                'descuento_porcentaje' => $detalle->descuento_porcentaje ?? 0,
                'descuento_monto' => $detalle->descuento_monto ?? 0,
                'subtotal' => $detalle->subtotal,
            ]);
        }

        // Si es a crédito y trae cuotas, lo guardamos
        if ($validated['condicion_pago'] === 'Crédito' && !empty($validated['cuotas'])) {
            foreach ($validated['cuotas'] as $index => $cuotaData) {
                \App\Models\SaleCuota::create([
                    'sale_id' => $venta->id,
                    'numero_cuota' => $index + 1,
                    'importe' => $cuotaData['importe'],
                    'fecha_vencimiento' => $cuotaData['fecha_vencimiento'],
                ]);
            }
            // Crédito: fecha_vencimiento = fecha de la primera cuota
            $venta->fecha_vencimiento = $validated['cuotas'][0]['fecha_vencimiento'];
        } else {
            // Contado: fecha_vencimiento = fecha de emisión
            $venta->fecha_vencimiento = $fechaEmision;
        }
        $venta->save();

        // =====================================================
        // AUTOMATIZACIÓN: Enviar a Operaciones (Logística)
        // =====================================================
        $admin_pedido->estado_operativo = 'sin_asignar';
        $admin_pedido->area_actual = 'logistica';
        $admin_pedido->estado = 'proceso';
        $admin_pedido->save();

        return redirect()->route('admin-ventas.show', $venta)
            ->with('success', 'Comprobante generado exitosamente. El pedido ha sido enviado a Operaciones (Logística).')
            ->with('auto_descargar_comprobante', true);
    }

    /**
     * Ver/Descargar Voucher de Pago (Voucher Manual)
     */
    public function voucher(Pedido $pedido)
    {
        // Cargar relaciones necesarias
        $pedido->load([
            'cliente',
            'detalles',
            'usuario',
            'cuotas',
            'venta.tipocomprobante',
            'venta.mediopago',
        ]);

        $pdf = Pdf::loadView('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.voucher_pdf', compact('pedido'));
        return $pdf->download('Comprobante-' . $pedido->codigo . '.pdf');
    }

}
