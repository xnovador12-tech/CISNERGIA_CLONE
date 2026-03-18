<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Nota;
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

        // Cargar notas asociadas y recalcular saldo considerando NC/ND
        $notas = $venta->notas()->with('tipocomprobante')->where('estado', 'emitida')->get();
        $totalNC = $notas->filter(fn($n) => $n->tipocomprobante && $n->tipocomprobante->codigo === '07')->sum('total');
        $totalND = $notas->filter(fn($n) => $n->tipocomprobante && $n->tipocomprobante->codigo === '08')->sum('total');

        $saldoPendiente = $venta->total - $totalPagado - $totalNC + $totalND;

        return view('ADMINISTRADOR.FINANZAS.comprobantes.show', compact('venta', 'totalPagado', 'saldoPendiente', 'notas', 'totalNC', 'totalND'));
    }
}
