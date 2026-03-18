<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Detailsale;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Tiposcomprobante;
use App\Models\Mediopago;
use App\Models\Producto;
use App\Models\Cuentabanco;
use App\Models\TipoOperacion;
use App\Models\TipoDetraccion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class admin_VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::with(['cliente', 'tipocomprobante', 'mediopago', 'usuario', 'sede'])->orderBy('created_at', 'desc')->get();
        $pedidosPendientes = Pedido::with(['cliente', 'usuario'])
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.index', compact('ventas', 'pedidosPendientes'));
    }

    public function create()
    {
        $pedido = null;
        if (request('pedido')) {
            $pedido = Pedido::with(['cliente', 'detalles', 'usuario', 'cuotas'])->findOrFail(request('pedido'));

            if ($pedido->venta) {
                return redirect()->route('admin-ventas.show', $pedido->venta)
                    ->with('info', 'Este pedido ya tiene una venta registrada: ' . $pedido->venta->codigo);
            }
        }

        $tiposComprobante = Tiposcomprobante::where('tipo', 'ventas')->get();
        $mediosPago = Mediopago::all();
        $cuentasBancarias = Cuentabanco::with(['banco', 'moneda', 'tipocuenta'])->get();
        $tiposOperacion = TipoOperacion::all();
        $tiposDetraccion = TipoDetraccion::all();

        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.create', compact('pedido', 'tiposComprobante', 'mediosPago', 'cuentasBancarias', 'tiposOperacion', 'tiposDetraccion'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'tiposcomprobante_id' => 'required|exists:tiposcomprobantes,id',
            'tipo_operacion_id' => 'required|exists:tipos_operaciones,id',
            'tipo_detraccion_id' => 'nullable|exists:tipo_detraccion,id',
            'condicion_pago' => 'required|in:Contado,Crédito',
            'numero_comprobante' => 'nullable|string',
            'pagos' => 'nullable|array',
            'pagos.*.mediopago_id' => 'nullable|exists:mediopagos,id',
            'pagos.*.billetera' => 'nullable|string',
            'pagos.*.cuenta_bancaria_id' => 'nullable|integer',
            'cuotas' => 'nullable|array',
            'cuotas.*.importe' => 'required_with:cuotas|numeric|min:0.01',
            'cuotas.*.fecha_vencimiento' => 'required_with:cuotas|date',
        ]);

        $pedido = Pedido::with('detalles')->findOrFail($validated['pedido_id']);

        if ($pedido->venta) {
            return redirect()->route('admin-ventas.show', $pedido->venta)
                ->with('error', 'Este pedido ya tiene un comprobante generado: ' . $pedido->venta->codigo);
        }

        // Aprobar finanzas automáticamente al registrar pago
        if (!$pedido->aprobacion_finanzas) {
            $pedido->aprobacion_finanzas = true;
            $pedido->save();
        }

        // Generar número de comprobante
        $numeroComprobante = $validated['numero_comprobante'];
        if (empty($numeroComprobante)) {
            $tipoComprobante = Tiposcomprobante::find($validated['tiposcomprobante_id']);
            $prefijo = match(strtolower($tipoComprobante->name)) {
                'factura' => 'F001',
                'boleta', 'boleta de venta' => 'B001',
                'nota de crédito' => 'NC01',
                'nota de débito' => 'ND01',
                'guía de remisión' => 'GR01',
                default => 'T001'
            };

            $ultimoComprobante = Sale::where('numero_comprobante', 'like', $prefijo . '%')
                ->orderBy('numero_comprobante', 'desc')
                ->first();

            if ($ultimoComprobante && preg_match('/-(\d+)$/', $ultimoComprobante->numero_comprobante, $matches)) {
                $siguienteNumero = intval($matches[1]) + 1;
            } else {
                $siguienteNumero = 1;
            }

            $numeroComprobante = $prefijo . '-' . str_pad($siguienteNumero, 8, '0', STR_PAD_LEFT);
        }

        // Generar código de venta
        $ultimaVenta = Sale::latest('id')->first();
        $numero = $ultimaVenta ? $ultimaVenta->id + 1 : 1;
        $codigoVenta = 'VTA-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        // Tomar el primer medio de pago como principal (si existe)
        $primerPago = $validated['pagos'][0] ?? null;

        // Calcular detracción si aplica
        $montoDetraccion = 0;
        $montoNeto = $pedido->total;
        if (!empty($validated['tipo_detraccion_id'])) {
            $tipoDetraccion = TipoDetraccion::find($validated['tipo_detraccion_id']);
            if ($tipoDetraccion) {
                $montoDetraccion = round($pedido->total * ($tipoDetraccion->porcentaje / 100), 2);
                $montoNeto = round($pedido->total - $montoDetraccion, 2);
            }
        }

        // Crear la venta
        $venta = Sale::create([
            'codigo' => $codigoVenta,
            'slug' => Str::slug($codigoVenta),
            'pedido_id' => $pedido->id,
            'cliente_id' => $pedido->cliente_id,
            'tiposcomprobante_id' => $validated['tiposcomprobante_id'],
            'tipo_operacion_id' => $validated['tipo_operacion_id'],
            'tipo_detraccion_id' => $validated['tipo_detraccion_id'] ?? null,
            'numero_comprobante' => $numeroComprobante,
            'subtotal' => $pedido->subtotal,
            'descuento' => $pedido->descuento_monto,
            'igv' => $pedido->igv,
            'total' => $pedido->total,
            'monto_detraccion' => $montoDetraccion,
            'monto_neto' => $montoNeto,
            'mediopago_id' => $primerPago['mediopago_id'] ?? null,
            'condicion_pago' => $validated['condicion_pago'],
            'estado' => 'completada',
            'user_id' => auth()->id(),
            'sede_id' => auth()->user()->persona->sede_id ?? null,
            'tipo_venta' => 'pedido',
            'observaciones' => 'Venta registrada desde Pedido ' . $pedido->codigo,
        ]);

        // Copiar detalles del pedido
        foreach ($pedido->detalles as $detalle) {
            Detailsale::create([
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

        // Guardar pagos en Ingresos Financieros (solo si hay pagos)
        $pagos = $validated['pagos'] ?? [];
        $pagos = array_filter($pagos, fn($p) => !empty($p['mediopago_id']));

        if (count($pagos) > 0) {
        $totalPagos = count($pagos);
        $montoPorPago = $venta->total / $totalPagos;

        foreach ($pagos as $pagoData) {
            \App\Models\IngresoFinanciero::create([
                'user_id' => auth()->id(),
                'cliente_id' => $pedido->cliente_id,
                'fecha_movimiento' => now()->format('Y-m-d'),
                'hora_movimiento' => now()->format('H:i:s'),
                'venta_id' => $venta->id,
                'monto' => $montoPorPago,
                'moneda_id' => 1, // Soles por defecto
                'tipo_ingreso_id' => 1, // Venta
                'cuenta_bancaria_id' => $pagoData['cuenta_bancaria_id'] ?? 1, // Fallback si no viene, pero debería venir
                'metodo_pago_id' => $pagoData['mediopago_id'],
                'descripcion' => 'Pago Venta ' . $venta->codigo . (!empty($pagoData['billetera']) ? ' - Billetera: ' . $pagoData['billetera'] : ''),
                'apertura_caja_id' => 1, // Asumimos caja 1 si no hay sistema de apertura en este flujo aún
                'origen_tipo' => 'Venta',
            ]);
        }
        }

        // Guardar cuotas si es crédito
        if ($validated['condicion_pago'] === 'Crédito' && !empty($validated['cuotas'])) {
            foreach ($validated['cuotas'] as $index => $cuotaData) {
                \App\Models\SaleCuota::create([
                    'sale_id' => $venta->id,
                    'numero_cuota' => $index + 1,
                    'importe' => $cuotaData['importe'],
                    'fecha_vencimiento' => $cuotaData['fecha_vencimiento'],
                ]);
            }
        }

        // Actualizar estado del pedido
        $pedido->update([
            'estado' => 'proceso',
            'estado_operativo' => 'sin_asignar',
            'condicion_pago' => $validated['condicion_pago'],
        ]);

        return redirect()->route('admin-ventas.show', $venta)
            ->with('success', 'Venta registrada exitosamente: ' . $venta->codigo);
    }

    public function show(Sale $admin_venta)
    {
        $venta = $admin_venta->load(['cliente', 'pedido', 'tipocomprobante', 'mediopago', 'usuario', 'detalles', 'tipoOperacion', 'tipoDetraccion']);
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.show', compact('venta'));
    }

    public function edit(Sale $admin_venta)
    {
        //
    }

    public function update(Request $request, Sale $admin_venta)
    {
        //
    }

    public function destroy(Sale $admin_venta)
    {
        // IMPORTANTE: Las ventas NO deben eliminarse por razones fiscales y de auditoría
        // Este método se mantiene solo para cumplir con el contrato del Resource Controller
        // pero siempre deniega la acción
        
        return back()->with('error', '❌ No se pueden eliminar ventas. Las ventas son documentos fiscales/contables que deben conservarse por ley. Si necesita anular una venta, contacte al área de Finanzas.');
    }

    public function estado(Request $request, Sale $admin_venta)
    {
        $admin_venta->estado = $request->estado;
        $admin_venta->save();

        return response()->json(['success' => true, 'message' => 'Estado actualizado']);
    }

    public function voucher(Sale $admin_venta)
    {
        $admin_venta->load([
            'tipocomprobante',
            'mediopago',
            'pedido.cliente',
            'pedido.detalles',
            'pedido.usuario',
            'pedido.cuotas',
            'pedido.venta.tipocomprobante',
            'pedido.venta.mediopago',
            'pedido.venta.tipoOperacion',
            'pedido.venta.tipoDetraccion',
        ]);
        $pedido = $admin_venta->pedido;

        if (!$pedido) {
            return back()->with('error', 'Esta venta no tiene un registro de pedido asociado para generar el voucher de validación.');
        }

        $pdf = Pdf::loadView('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.voucher_pdf', compact('pedido'));
        return $pdf->download('Comprobante-' . $pedido->codigo . '.pdf');
    }
}
