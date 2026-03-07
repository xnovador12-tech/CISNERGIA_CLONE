<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Detailsale;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Tiposcomprobante;
use App\Models\Mediopago;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class admin_VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::with(['cliente', 'tipocomprobante', 'mediopago', 'usuario', 'sede'])->orderBy('created_at', 'desc')->get();
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.index', compact('ventas'));
    }

    public function create()
    {
        // Redirigir al flujo correcto: Crear Pedido
        return redirect()->route('admin-pedidos.create')->with('info', 'Para realizar una venta, primero debe generar un Pedido.');
    }

    public function store(Request $request)
    {
        // Este método ya no se usa manualmente.
        // Las ventas se crean automáticamente desde admin_PedidosController::generarComprobante
        return redirect()->route('admin-pedidos.index');
    }

    public function show(Sale $admin_venta)
    {
        $venta = $admin_venta->load(['cliente', 'pedido', 'tipocomprobante', 'mediopago', 'usuario', 'detalles']);
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
        ]);
        $pedido = $admin_venta->pedido;

        if (!$pedido) {
            return back()->with('error', 'Esta venta no tiene un registro de pedido asociado para generar el voucher de validación.');
        }

        $pdf = Pdf::loadView('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.voucher_pdf', compact('pedido'));
        return $pdf->download('Comprobante-' . $pedido->codigo . '.pdf');
    }
}
