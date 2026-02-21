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

class admin_VentasController extends Controller
{
    public function index()
    {
        $ventas = Sale::with(['cliente', 'tipocomprobante', 'mediopago', 'usuario', 'sede'])->orderBy('created_at', 'desc')->get();
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.index', compact('ventas'));
    }

    public function create()
    {
        $clientes = Cliente::all(); // Todos los clientes (crear columna estado después)
        $productos = Producto::all(); // Todos los productos para POS
        $pedidos = Pedido::where('estado', 'entregado')->whereDoesntHave('venta')->get();
        $tiposcomprobantes = Tiposcomprobante::where('tipo', 'ventas')->get();
        $mediospago = Mediopago::all();
        
        return view('ADMINISTRADOR.PRINCIPAL.ventas.ventas.create', compact('clientes', 'productos', 'pedidos', 'tiposcomprobantes', 'mediospago'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'pedido_id' => 'nullable|exists:pedidos,id',
            'tiposcomprobante_id' => 'required|exists:tiposcomprobantes,id',
            'numero_comprobante' => 'nullable|string',
            'mediopago_id' => 'required|exists:mediopagos,id',
            'tipo_venta' => 'required|in:pos,pedido',
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
        $venta->sede_id = auth()->user()->persona->sede_id ?? null;
        $venta->tipo_venta = $request->tipo_venta ?? 'pos';
        $venta->observaciones = $request->observaciones;
        $venta->save();

        // Guardar detalles de venta
        if ($request->has('detalles')) {
            foreach ($request->detalles as $detalle) {
                Detailsale::create([
                    'sale_id' => $venta->id,
                    'producto_id' => $detalle['producto_id'] ?? null,
                    'servicio_id' => $detalle['servicio_id'] ?? null,
                    'tipo' => $detalle['tipo'] ?? 'producto',
                    'descripcion' => $detalle['descripcion'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'descuento_porcentaje' => $detalle['descuento_porcentaje'] ?? 0,
                    'descuento_monto' => $detalle['descuento_monto'] ?? 0,
                    'subtotal' => $detalle['subtotal'],
                    'garantia_años' => $detalle['garantia_años'] ?? null,
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
