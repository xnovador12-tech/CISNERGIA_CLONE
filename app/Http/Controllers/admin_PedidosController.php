<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Almacen;
use App\Models\Distrito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_PedidosController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['cliente', 'usuario', 'distrito']);

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
        $clientes = Cliente::with('vendedor.persona')->get();
        $productos = Producto::all();
        $servicios = Servicio::all();
        $almacenes = Almacen::all();
        $distritos = Distrito::all();
        $tecnicos = User::whereHas('role', function($q) {
            $q->where('name', 'Técnico');
        })->get();
        
        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.create', compact('clientes', 'productos', 'servicios', 'almacenes', 'distritos', 'tecnicos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_entrega_estimada' => 'nullable|date',
            'direccion_instalacion' => 'nullable|string',
            'distrito_id' => 'nullable|exists:distritos,id',
            'tecnico_asignado_id' => 'nullable|exists:users,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
            'observaciones' => 'nullable|string',
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
        $pedido->descuento = $request->descuento ?? 0;
        $pedido->igv = $request->igv ?? 0;
        $pedido->total = $request->total ?? 0;
        $pedido->estado = 'pendiente';
        $pedido->aprobacion_finanzas = false;  // Nuevo pedido = No aprobado
        $pedido->aprobacion_stock = false;     // Nuevo pedido = Sin reserva
        $pedido->direccion_instalacion = $request->direccion_instalacion;
        $pedido->distrito_id = $request->distrito_id;
        $pedido->fecha_entrega_estimada = $request->fecha_entrega_estimada;
        $pedido->tecnico_asignado_id = $request->tecnico_asignado_id;
        $pedido->almacen_id = $request->almacen_id;
        $pedido->observaciones = $request->observaciones;
        $pedido->origen = 'manual';
        $pedido->save();

        // Guardar detalles del pedido y Reservar Stock Automáticamente
        if ($request->has('detalles')) {
            $stockReservadoTotalmente = true;

            foreach ($request->detalles as $detalleData) {
                $detalle = DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $detalleData['producto_id'] ?? null,
                    'servicio_id' => $detalleData['servicio_id'] ?? null,
                    'tipo' => $detalleData['tipo'] ?? 'producto',
                    'descripcion' => $detalleData['descripcion'],
                    'cantidad' => $detalleData['cantidad'],
                    'precio_unitario' => $detalleData['precio_unitario'],
                    'descuento' => $detalleData['descuento'] ?? 0,
                    'subtotal' => $detalleData['subtotal'],
                ]);

                // LOGICA DE RESERVA INTERNA AUTOMÁTICA
                if ($detalle->producto_id) {
                    $cantidadNecesaria = $detalle->cantidad;
                    $inventarios = \App\Models\Inventario::where('id_producto', $detalle->producto_id)
                                    ->where('cantidad', '>', 0)
                                    ->orderBy('created_at', 'asc')
                                    ->get();
                    
                    $stockDisponible = $inventarios->sum('cantidad');

                    if ($stockDisponible >= $cantidadNecesaria) {
                        // Descontar
                        foreach ($inventarios as $inventario) {
                            if ($cantidadNecesaria <= 0) break;
                            if ($inventario->cantidad >= $cantidadNecesaria) {
                                $inventario->cantidad -= $cantidadNecesaria;
                                $inventario->save();
                                $cantidadNecesaria = 0;
                            } else {
                                $cantidadNecesaria -= $inventario->cantidad;
                                $inventario->cantidad = 0;
                                $inventario->save();
                            }
                        }
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
        $pedido = $admin_pedido->load(['cliente', 'usuario', 'tecnico', 'distrito', 'almacen', 'detalles.producto', 'detalles.servicio']);
        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $admin_pedido)
    {
        $pedido = $admin_pedido->load('detalles');
        $clientes = Cliente::all();
        $productos = Producto::all();
        $servicios = Servicio::all();
        $almacenes = Almacen::all();
        $distritos = Distrito::all();
        $tecnicos = User::whereHas('role', function($q) {
            $q->where('name', 'Técnico');
        })->get();
        
        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.create', compact('pedido', 'clientes', 'productos', 'servicios', 'almacenes', 'distritos', 'tecnicos'));
    }

    public function update(Request $request, Pedido $admin_pedido)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|in:pendiente,proceso,entregado,cancelado',
            'fecha_entrega_estimada' => 'nullable|date',
            'direccion_instalacion' => 'nullable|string',
            'distrito_id' => 'nullable|exists:distritos,id',
            'tecnico_asignado_id' => 'nullable|exists:users,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
            'observaciones' => 'nullable|string',
            'subtotal' => 'nullable|numeric',
            'descuento' => 'nullable|numeric',
            'igv' => 'nullable|numeric',
            'total' => 'nullable|numeric',
        ]);

        // 1. Devolver Stock actual antes de los cambios (si estaba reservado)
        if ($admin_pedido->aprobacion_stock) {
            foreach ($admin_pedido->detalles as $detalle) {
                if ($detalle->producto_id) {
                    $inventario = \App\Models\Inventario::where('id_producto', $detalle->producto_id)
                        ->where('almacen_id', $admin_pedido->almacen_id)
                        ->first();
                    if ($inventario) {
                        $inventario->cantidad += $detalle->cantidad;
                        $inventario->save();
                    }
                }
            }
            $admin_pedido->aprobacion_stock = false;
        }

        // 2. Actualizar datos principales
        $admin_pedido->update($validated);

        // 3. Actualizar Detalles (Borrar y crear nuevos)
        if ($request->has('detalles')) {
            $admin_pedido->detalles()->delete();
            $stockReservadoTotalmente = true;

            foreach ($request->detalles as $detalleData) {
                $detalle = DetallePedido::create([
                    'pedido_id' => $admin_pedido->id,
                    'producto_id' => $detalleData['producto_id'] ?? null,
                    'servicio_id' => $detalleData['servicio_id'] ?? null,
                    'tipo' => $detalleData['tipo'] ?? 'producto',
                    'descripcion' => $detalleData['descripcion'],
                    'cantidad' => $detalleData['cantidad'],
                    'precio_unitario' => $detalleData['precio_unitario'],
                    'descuento' => $detalleData['descuento'] ?? 0,
                    'subtotal' => $detalleData['subtotal'],
                ]);

                // 4. Intentar re-reservar stock si es manual y era pendiente/proceso
                if ($detalle->producto_id && in_array($admin_pedido->estado, ['pendiente', 'proceso'])) {
                    $cantidadNecesaria = $detalle->cantidad;
                    $inventarios = \App\Models\Inventario::where('id_producto', $detalle->producto_id)
                                    ->where('cantidad', '>', 0)
                                    ->orderBy('created_at', 'asc')
                                    ->get();
                    
                    if ($inventarios->sum('cantidad') >= $cantidadNecesaria) {
                        foreach ($inventarios as $inv) {
                            if ($cantidadNecesaria <= 0) break;
                            if ($inv->cantidad >= $cantidadNecesaria) {
                                $inv->cantidad -= $cantidadNecesaria;
                                $inv->save();
                                $cantidadNecesaria = 0;
                            } else {
                                $cantidadNecesaria -= $inv->cantidad;
                                $inv->cantidad = 0;
                                $inv->save();
                            }
                        }
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
        // Devolver stock si estaba aprobado
        if ($admin_pedido->aprobacion_stock) {
            foreach ($admin_pedido->detalles as $detalle) {
                // Devolver al almacén del pedido o al primero encontrado
                $inventario = \App\Models\Inventario::where('id_producto', $detalle->producto_id)
                    ->when($admin_pedido->almacen_id, function($q) use ($admin_pedido) {
                        return $q->where('almacen_id', $admin_pedido->almacen_id);
                    })
                    ->first();

                if ($inventario) {
                    $inventario->cantidad += $detalle->cantidad;
                    $inventario->save();
                }
            }
        }

        $admin_pedido->delete();
        return redirect()->route('admin-pedidos.index')->with('success', 'Pedido eliminado y stock actualizado');
    }

    public function estado(Request $request, Pedido $admin_pedido)
    {
        $admin_pedido->estado = $request->estado;
        $admin_pedido->save();

        $msg = match($request->estado) {
            'entregado' => '✅ Pedido marcado como ENTREGADO con éxito.',
            'cancelado' => '⚠️ Pedido ANULADO correctamente.',
            default     => '✅ Estado actualizado.'
        };

        return back()->with('success', $msg);
    }

    /**
     * Toggle aprobación de Finanzas
     */
    public function aprobarFinanzas(Pedido $admin_pedido)
    {
        $admin_pedido->aprobacion_finanzas = !$admin_pedido->aprobacion_finanzas;

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
            ? '✅ Finanzas aprobado. ' . ($admin_pedido->estado === 'proceso' ? 'Pedido pasó a EN PROCESO.' : '')
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
            foreach ($admin_pedido->detalles as $detalle) {
                // Solo productos tienen inventario (los servicios no)
                if (!$detalle->producto_id) continue;

                $cantidadNecesaria = $detalle->cantidad;
                $inventarios = \App\Models\Inventario::where('id_producto', $detalle->producto_id)
                                ->where('cantidad', '>', 0)
                                ->orderBy('created_at', 'asc')
                                ->get();
                
                $stockDisponible = $inventarios->sum('cantidad');

                if ($stockDisponible < $cantidadNecesaria) {
                    return back()->with('error', 
                        '❌ Stock insuficiente para "' . $detalle->descripcion . '". ' .
                        'Disponible: ' . intval($stockDisponible) . ' | Necesario: ' . $cantidadNecesaria . '. ' .
                        'Por favor ingresa más stock antes de reservar.'
                    );
                }

                foreach ($inventarios as $inventario) {
                    if ($cantidadNecesaria <= 0) break;
                    if ($inventario->cantidad >= $cantidadNecesaria) {
                        $inventario->cantidad -= $cantidadNecesaria;
                        $inventario->save();
                        $cantidadNecesaria = 0;
                    } else {
                        $cantidadNecesaria -= $inventario->cantidad;
                        $inventario->cantidad = 0;
                        $inventario->save();
                    }
                }
            }
            $admin_pedido->aprobacion_stock = true;
            $msg = '✅ Stock reservado correctamente. El inventario ha sido descontado.';
        } else {
            // Se va a desactivar: DEVOLVER STOCK
            foreach ($admin_pedido->detalles as $detalle) {
                $inventario = \App\Models\Inventario::where('id_producto', $detalle->producto_id)
                    ->when($admin_pedido->almacen_id, function($q) use ($admin_pedido) {
                        return $q->where('almacen_id', $admin_pedido->almacen_id);
                    })
                    ->first(); // Prioriza almacén asignado, sino el primero

                if (!$inventario) {
                    // Si no existe inventario (raro), buscar cualquiera para este producto
                     $inventario = \App\Models\Inventario::where('id_producto', $detalle->producto_id)->first();
                }

                if ($inventario) {
                    $inventario->cantidad += $detalle->cantidad;
                    $inventario->save();
                }
            }
            $admin_pedido->aprobacion_stock = false;
            // Si estaba en proceso y se libera stock, vuelve a pendiente
            if ($admin_pedido->estado === 'proceso') {
                $admin_pedido->estado = 'pendiente';
                $msg .= ' El pedido regresó a PENDIENTE.';
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
            'mediopago_id' => 'required|exists:mediopagos,id',
            'numero_comprobante' => 'nullable|string',
        ]);

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
            'numero_comprobante' => $validated['numero_comprobante'],
            'subtotal' => $admin_pedido->subtotal,
            'descuento' => $admin_pedido->descuento,
            'igv' => $admin_pedido->igv,
            'total' => $admin_pedido->total,
            'mediopago_id' => $validated['mediopago_id'],
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
                'descuento_porcentaje' => 0,
                'descuento_monto' => $detalle->descuento ?? 0,
                'subtotal' => $detalle->subtotal,
            ]);
        }

        return redirect()->route('admin-ventas.show', $venta)->with('success', 'Comprobante generado exitosamente: ' . $codigoVenta);
    }

    /**
     * Crear Pedido desde Venta E-commerce (Flujo B2C)
     * Se ejecuta automáticamente cuando se confirma un pago online
     */
    public function storeFromEcommerce(\App\Models\Sale $venta)
    {
        // Validar que la venta no tenga pedido asociado
        if ($venta->pedido_id) {
            return back()->with('error', 'Esta venta ya tiene un pedido asociado.');
        }

        // Generar código único
        $ultimoPedido = Pedido::latest('id')->first();
        $numero = $ultimoPedido ? $ultimoPedido->id + 1 : 1;
        $codigo = 'PED-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        // Crear pedido con estado confirmado pero aprobaciones condicionadas
        // Si el pago es por pasarela, finanzas = true. Si es manual, finanzas = false.
        // Aquí asumimos pasarela exitosa, por ende Finanzas = TRUE.
        $pedido = Pedido::create([
            'codigo' => $codigo,
            'slug' => Str::slug($codigo),
            'cliente_id' => $venta->cliente_id,
            'user_id' => $venta->user_id,
            'subtotal' => $venta->subtotal,
            'descuento' => $venta->descuento,
            'igv' => $venta->igv,
            'total' => $venta->total,
            'estado' => 'confirmado',              // Ya pagado online
            'aprobacion_finanzas' => true,         // Pago confirmado automáticamente por pasarela
            'aprobacion_stock' => true,            // Stock ya descontado en venta
            'origen' => 'ecommerce',
            'direccion_instalacion' => $venta->direccion_envio ?? null,
            'observaciones' => 'Pedido pagado con tarjeta/gateway. Generado desde venta E-commerce: ' . $venta->codigo,
        ]);

        // Copiar detalles de la venta al pedido
        foreach ($venta->detalles as $detalle) {
            \App\Models\DetallePedido::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $detalle->producto_id,
                'servicio_id' => $detalle->servicio_id,
                'tipo' => $detalle->tipo ?? 'producto',
                'descripcion' => $detalle->descripcion,
                'cantidad' => $detalle->cantidad,
                'precio_unitario' => $detalle->precio_unitario,
                'descuento' => $detalle->descuento_monto ?? 0,
                'subtotal' => $detalle->subtotal,
            ]);
        }

        // Vincular venta con pedido
        $venta->update(['pedido_id' => $pedido->id]);

        return redirect()->route('admin-pedidos.show', $pedido)->with('success', 'Pedido E-commerce generado: ' . $codigo);
    }
}
