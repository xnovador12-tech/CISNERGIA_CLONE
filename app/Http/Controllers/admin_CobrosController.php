<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Mediopago;
use App\Models\Cuentabanco;
use App\Models\MovimientoCaja;
use App\Models\AperturaCierreCaja;
use Illuminate\Http\Request;

class admin_CobrosController extends Controller
{
    public function index()
    {
        $ventas = Sale::with(['cliente', 'tipocomprobante', 'usuario', 'sede', 'pagos'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($venta) {
                $venta->total_pagado = $venta->pagos->sum('monto');
                $venta->saldo_pendiente = $venta->total - $venta->total_pagado;
                return $venta;
            });

        $ventasPendientes = $ventas->where('saldo_pendiente', '>', 0.05);
        $ventasCompletadas = $ventas->where('saldo_pendiente', '<=', 0.05);

        return view('ADMINISTRADOR.FINANZAS.cobros.index', compact('ventas', 'ventasPendientes', 'ventasCompletadas'));
    }

    public function show(Sale $admin_cobro)
    {
        $venta = $admin_cobro->load(['cliente', 'tipocomprobante', 'usuario', 'sede', 'detalles', 'pagos.metodoPago', 'pagos.cuentaBancaria.banco', 'cuotas']);

        $totalPagado = $venta->pagos->sum('monto');
        $saldoPendiente = $venta->total - $totalPagado;

        $mediosPago = Mediopago::all();
        $cuentasBancarias = Cuentabanco::with(['banco', 'moneda', 'tipocuenta'])->get();

        return view('ADMINISTRADOR.FINANZAS.cobros.show', compact('venta', 'totalPagado', 'saldoPendiente', 'mediosPago', 'cuentasBancarias'));
    }

    public function store(Request $request, Sale $admin_cobro)
    {
        $validated = $request->validate([
            'mediopago_id' => 'required|exists:mediopagos,id',
            'monto' => 'required|numeric|min:0.01',
            'billetera' => 'nullable|string',
            'cuenta_bancaria_id' => 'nullable|integer',
            'numero_operacion' => 'nullable|string',
        ]);

        // Verificar caja abierta
        $cajaAbierta = AperturaCierreCaja::where('estado', 'Abierto')->first();
        if (!$cajaAbierta) {
            return back()->with('error', 'No hay una caja abierta. Debe abrir una caja antes de registrar cobros.');
        }

        $venta = $admin_cobro;
        $totalPagado = $venta->pagos()->sum('monto');
        $saldoPendiente = $venta->total - $totalPagado;

        if ($validated['monto'] > $saldoPendiente + 0.05) {
            return back()->with('error', 'El monto ingresado (S/ ' . number_format($validated['monto'], 2) . ') supera el saldo pendiente (S/ ' . number_format($saldoPendiente, 2) . ').');
        }

        MovimientoCaja::create([
            'tipo' => 'ingreso',
            'monto' => round(floatval($validated['monto']), 2),
            'apertura_caja_id' => $cajaAbierta->id,
            'user_id' => auth()->id(),
            'fecha_movimiento' => now()->format('Y-m-d'),
            'hora_movimiento' => now()->format('H:i:s'),
            'venta_id' => $venta->id,
            'cliente_id' => $venta->cliente_id,
            'metodo_pago_id' => $validated['mediopago_id'],
            'cuenta_bancaria_id' => $validated['cuenta_bancaria_id'] ?? null,
            'numero_operacion' => $validated['numero_operacion'] ?? null,
            'descripcion' => 'Cobro Venta ' . $venta->codigo . (!empty($validated['billetera']) ? ' - Billetera: ' . $validated['billetera'] : ''),
        ]);

        // Actualizar estado de la venta
        $nuevoTotalPagado = $venta->pagos()->sum('monto');
        if ($nuevoTotalPagado >= $venta->total - 0.05) {
            $venta->update(['estado' => 'completada']);
        }

        // Actualizar fecha_vencimiento: si tiene cuotas, apuntar a la siguiente cuota pendiente
        if ($venta->condicion_pago === 'Crédito' && $venta->cuotas->count() > 0) {
            $montoCubierto = $nuevoTotalPagado;
            $siguienteFecha = null;

            foreach ($venta->cuotas()->orderBy('numero_cuota')->get() as $cuota) {
                if ($montoCubierto >= $cuota->importe - 0.05) {
                    $montoCubierto -= $cuota->importe;
                } else {
                    $siguienteFecha = $cuota->fecha_vencimiento;
                    break;
                }
            }

            // Si todas las cuotas están cubiertas, fecha_vencimiento queda en la última
            if (!$siguienteFecha) {
                $siguienteFecha = $venta->cuotas()->orderBy('numero_cuota', 'desc')->first()->fecha_vencimiento;
            }

            $venta->update(['fecha_vencimiento' => $siguienteFecha]);
        }

        return back()->with('success', 'Cobro registrado exitosamente por S/ ' . number_format($validated['monto'], 2));
    }
}
