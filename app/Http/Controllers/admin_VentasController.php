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
use App\Models\MovimientoCaja;
use App\Models\TipoOperacion;
use App\Models\TipoDetraccion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class admin_VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::with(['cliente', 'tipocomprobante', 'mediopago', 'usuario', 'sede', 'pagos'])->orderBy('created_at', 'desc')->get();
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

        $tiposComprobante = Tiposcomprobante::whereHas('series')->get();
        $mediosPago = Mediopago::all();
        $cuentasBancarias = Cuentabanco::with(['banco', 'moneda', 'tipocuenta'])->get();
        $tiposOperacion = TipoOperacion::all();
        $tiposDetraccion = TipoDetraccion::all();

        // Series con correlativos para preview
        $seriesComprobante = \App\Models\Serie::all()
            ->groupBy('tiposcomprobante_id')
            ->map(function ($series) {
                $serie = $series->first();
                $siguiente = $serie->correlativo + 1;
                return $serie->serie . '-' . str_pad($siguiente, 8, '0', STR_PAD_LEFT);
            });

        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.create', compact('pedido', 'tiposComprobante', 'mediosPago', 'cuentasBancarias', 'tiposOperacion', 'tiposDetraccion', 'seriesComprobante'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'tiposcomprobante_id' => 'required|exists:tiposcomprobantes,id',
            'tipo_operacion_id' => 'required|exists:tipos_operaciones,id',
            'tipo_detraccion_id' => 'nullable|exists:tipo_detraccion,id',
            'condicion_pago' => 'required|in:Contado,Crédito',
            'pagos' => 'nullable|array',
            'pagos.*.mediopago_id' => 'nullable|exists:mediopagos,id',
            'pagos.*.billetera' => 'nullable|string',
            'pagos.*.cuenta_bancaria_id' => 'nullable|integer',
            'pagos.*.monto' => 'nullable|numeric|min:0',
            'cuotas' => 'nullable|array',
            'cuotas.*.importe' => 'required_with:cuotas|numeric|min:0.01',
            'cuotas.*.fecha_vencimiento' => 'required_with:cuotas|date',
        ]);

        // Validar regla: Boleta solo permite Contado
        $tipoComprobante = Tiposcomprobante::find($validated['tiposcomprobante_id']);
        if ($tipoComprobante && str_contains(strtolower($tipoComprobante->name), 'boleta') && $validated['condicion_pago'] === 'Crédito') {
            return back()->with('error', 'La Boleta solo permite condición de pago al Contado.');
        }

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

        // Generar número de comprobante usando series
        $serieComprobante = \App\Models\Serie::where('tiposcomprobante_id', $validated['tiposcomprobante_id'])
            ->first();

        if (!$serieComprobante) {
            return back()->with('error', 'No hay una serie activa para este tipo de comprobante.');
        }

        $numeroComprobante = $serieComprobante->generarNumero();

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
            'serie_id' => $serieComprobante->id,
            'serie' => $serieComprobante->serie,
            'correlativo' => $serieComprobante->correlativo,
            'numero_comprobante' => $numeroComprobante,
            'subtotal' => $pedido->subtotal,
            'descuento' => $pedido->descuento_monto,
            'igv' => $pedido->igv,
            'total' => $pedido->total,
            'monto_detraccion' => $montoDetraccion,
            'monto_neto' => $montoNeto,
            'mediopago_id' => $primerPago['mediopago_id'] ?? null,
            'condicion_pago' => $validated['condicion_pago'],
            'estado' => 'Pendiente',
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

        // Guardar pagos como movimientos de caja (solo si hay pagos con monto > 0)
        $pagos = $validated['pagos'] ?? [];
        $pagos = array_filter($pagos, fn($p) => !empty($p['mediopago_id']) && !empty($p['monto']) && floatval($p['monto']) > 0);

        $sumaPagos = 0;
        $cajaAbierta = \App\Models\AperturaCierreCaja::where('estado', 'Abierto')->first();

        foreach ($pagos as $pagoData) {
            $montoPago = round(floatval($pagoData['monto']), 2);
            $sumaPagos += $montoPago;

            if ($cajaAbierta) {
                MovimientoCaja::create([
                    'tipo' => 'ingreso',
                    'monto' => $montoPago,
                    'apertura_caja_id' => $cajaAbierta->id,
                    'user_id' => auth()->id(),
                    'fecha_movimiento' => now()->format('Y-m-d'),
                    'hora_movimiento' => now()->format('H:i:s'),
                    'venta_id' => $venta->id,
                    'cliente_id' => $pedido->cliente_id,
                    'metodo_pago_id' => $pagoData['mediopago_id'],
                    'cuenta_bancaria_id' => $pagoData['cuenta_bancaria_id'] ?? null,
                    'descripcion' => 'Pago Venta ' . $venta->codigo . (!empty($pagoData['billetera']) ? ' - Billetera: ' . $pagoData['billetera'] : ''),
                ]);
            }
        }

        // Determinar estado según monto pagado
        if ($sumaPagos >= $venta->total - 0.05) {
            $venta->estado = 'completada';
        } else {
            $venta->estado = 'parcial';
        }
        $venta->save();

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
