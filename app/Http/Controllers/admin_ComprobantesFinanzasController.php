<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class admin_ComprobantesFinanzasController extends Controller
{
    public function index()
    {
        // Solo ventas con Factura o Boleta (excluir Nota de Salida)
        $comprobantes = Sale::with(['cliente', 'tipocomprobante', 'usuario', 'sede', 'pagos'])
            ->whereHas('tipocomprobante', function ($q) {
                $q->whereIn('codigo', ['01', '03']); // 01=Factura, 03=Boleta
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($venta) {
                $venta->total_pagado = $venta->pagos->sum('monto');
                $venta->saldo_pendiente = $venta->total - $venta->total_pagado;
                return $venta;
            });

        return view('ADMINISTRADOR.FINANZAS.comprobantes.index', compact('comprobantes'));
    }

    public function show(Sale $admin_comprobante)
    {
        $venta = $admin_comprobante->load(['cliente', 'tipocomprobante', 'usuario', 'sede', 'detalles', 'pagos.metodoPago', 'pagos.cuentaBancaria.banco', 'cuotas']);

        $totalPagado = $venta->pagos->sum('monto');

        // Calcular NC/ND emitidas sobre este comprobante usando ventas_referencias
        $notasVentas = Sale::with(['tipocomprobante', 'ventaReferencia.sunatMotivoNota'])
            ->where('estado', 'emitida')
            ->whereHas('tipocomprobante', fn($q) => $q->whereIn('codigo', ['07', '08']))
            ->whereHas('ventaReferencia', fn($q) => $q->where('venta_referenciada_id', $venta->id))
            ->get();

        $totalNC = $notasVentas->filter(fn($n) => $n->tipocomprobante?->codigo === '07')->sum('total');
        $totalND = $notasVentas->filter(fn($n) => $n->tipocomprobante?->codigo === '08')->sum('total');

        $saldoPendiente = $venta->total - $totalPagado - $totalNC + $totalND;

        return view('ADMINISTRADOR.FINANZAS.comprobantes.show', compact('venta', 'totalPagado', 'saldoPendiente', 'notasVentas', 'totalNC', 'totalND'));
    }
}
