<?php

namespace App\Http\Controllers;

use App\Models\Ordencompra;
use App\Models\Mediopago;
use App\Models\Cuentabanco;
use App\Models\MovimientoCaja;
use App\Models\AperturaCierreCaja;
use Illuminate\Http\Request;

class admin_PagosController extends Controller
{
    public function index()
    {
        $ordenes = Ordencompra::with(['proveedor.persona', 'pagos'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($orden) {
                $orden->total_pagado = $orden->pagos->sum('monto');
                $orden->saldo_pendiente = $orden->total - $orden->total_pagado;
                return $orden;
            });

        $ordenesPendientes = $ordenes->where('saldo_pendiente', '>', 0.05);
        $ordenesCompletadas = $ordenes->where('saldo_pendiente', '<=', 0.05);

        return view('ADMINISTRADOR.FINANZAS.pagos.index', compact('ordenes', 'ordenesPendientes', 'ordenesCompletadas'));
    }

    public function show(Ordencompra $admin_pago)
    {
        $orden = $admin_pago->load(['proveedor.persona', 'detallecompra', 'pagos.metodoPago', 'pagos.cuentaBancaria.banco', 'cuotas']);

        $totalPagado = $orden->pagos->sum('monto');
        $saldoPendiente = $orden->total - $totalPagado;

        $mediosPago = Mediopago::all();
        $cuentasBancarias = Cuentabanco::with(['banco', 'moneda', 'tipocuenta'])->get();

        return view('ADMINISTRADOR.FINANZAS.pagos.show', compact('orden', 'totalPagado', 'saldoPendiente', 'mediosPago', 'cuentasBancarias'));
    }

    public function store(Request $request, Ordencompra $admin_pago)
    {
        $validated = $request->validate([
            'mediopago_id' => 'required|exists:mediopagos,id',
            'monto' => 'required|numeric|min:0.01',
            'cuenta_bancaria_id' => 'nullable|integer',
            'numero_operacion' => 'nullable|string',
            'numero_cuota' => 'nullable|integer',
        ]);

        // Verificar caja abierta
        $cajaAbierta = AperturaCierreCaja::where('estado', 'Abierto')->first();
        if (!$cajaAbierta) {
            return back()->with('error', 'No hay una caja abierta. Debe abrir una caja antes de registrar pagos.');
        }

        $orden = $admin_pago;
        $totalPagado = $orden->pagos()->sum('monto');
        $saldoPendiente = $orden->total - $totalPagado;

        if ($validated['monto'] > $saldoPendiente + 0.05) {
            return back()->with('error', 'El monto ingresado (S/ ' . number_format($validated['monto'], 2) . ') supera el saldo pendiente (S/ ' . number_format($saldoPendiente, 2) . ').');
        }

        MovimientoCaja::create([
            'tipo' => 'egreso',
            'monto' => round(floatval($validated['monto']), 2),
            'apertura_caja_id' => $cajaAbierta->id,
            'user_id' => auth()->id(),
            'fecha_movimiento' => now()->format('Y-m-d'),
            'hora_movimiento' => now()->format('H:i:s'),
            'ordencompra_id' => $orden->id,
            'proveedor_id' => $orden->proveedor_id,
            'metodo_pago_id' => $validated['mediopago_id'],
            'cuenta_bancaria_id' => $validated['cuenta_bancaria_id'] ?? null,
            'numero_operacion' => $validated['numero_operacion'] ?? null,
            'descripcion' => 'Pago OC ' . $orden->codigo . (isset($validated['numero_cuota']) ? ' - Cuota ' . $validated['numero_cuota'] : ''),
        ]);

        // Actualizar estado de pago de la orden
        $nuevoTotalPagado = $orden->pagos()->sum('monto');
        if ($nuevoTotalPagado >= $orden->total - 0.05) {
            $orden->update(['estado_pago' => 'Pagado']);
        }

        return back()->with('success', 'Pago registrado exitosamente por S/ ' . number_format($validated['monto'], 2));
    }
}
