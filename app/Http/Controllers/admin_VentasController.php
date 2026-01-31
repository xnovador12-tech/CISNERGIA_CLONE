<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Detailsale;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Tiposcomprobante;
use App\Models\Mediopago;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::with(['cliente', 'tipocomprobante', 'mediopago', 'usuario'])->orderBy('created_at', 'desc')->get();
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'Activo')->get();
        $pedidos = Pedido::where('estado', 'entregado')->whereDoesntHave('venta')->get();
        $tiposcomprobantes = Tiposcomprobante::where('tipo', 'ventas')->where('estado', 'Activo')->get();
        $mediospago = Mediopago::where('estado', 'Activo')->get();
        
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.create', compact('clientes', 'pedidos', 'tiposcomprobantes', 'mediospago'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'pedido_id' => 'nullable|exists:pedidos,id',
            'tiposcomprobante_id' => 'required|exists:tiposcomprobantes,id',
            'numero_comprobante' => 'nullable|string',
            'mediopago_id' => 'required|exists:mediopagos,id',
            'observaciones' => 'nullable|string',
        ]);

        // Generar código único
        $ultimaVenta = Sale::latest('id')->first();
        $numero = $ultimaVenta ? $ultimaVenta->id + 1 : 1;
        $codigo = 'VTA-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

        $venta = new Sale();
        $venta->codigo = $codigo;
        $venta->slug = Str::slug($codigo);
        $venta->pedido_id = $request->pedido_id;
        $venta->cliente_id = $request->cliente_id;
        $venta->tiposcomprobante_id = $request->tiposcomprobante_id;
        $venta->numero_comprobante = $request->numero_comprobante;
        $venta->subtotal = $request->subtotal ?? 0;
        $venta->descuento = $request->descuento ?? 0;
        $venta->igv = $request->igv ?? 0;
        $venta->total = $request->total ?? 0;
        $venta->mediopago_id = $request->mediopago_id;
        $venta->estado = 'completada';
        $venta->user_id = auth()->id();
        $venta->observaciones = $request->observaciones;
        $venta->save();

        // Guardar detalles de venta
        if ($request->has('detalles')) {
            foreach ($request->detalles as $detalle) {
                Detailsale::create([
                    'sale_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'] ?? null,
                    'productos' => $detalle['productos'],
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $detalle['precio'],
                    'precio_descuento' => $detalle['precio_descuento'] ?? 0,
                    'descuento' => $detalle['descuento'] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin-ventas.index')->with('success', 'Venta registrada exitosamente');
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
        $admin_venta->delete();
        return redirect()->route('admin-ventas.index')->with('success', 'Venta eliminada exitosamente');
    }

    public function estado(Request $request, Sale $admin_venta)
    {
        $admin_venta->estado = $request->estado;
        $admin_venta->save();

        return response()->json(['success' => true, 'message' => 'Estado actualizado']);
    }
}
