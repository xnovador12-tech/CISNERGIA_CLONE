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
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'usuario', 'distrito'])->orderBy('created_at', 'desc')->get();
        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
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
        $pedido->direccion_instalacion = $request->direccion_instalacion;
        $pedido->distrito_id = $request->distrito_id;
        $pedido->fecha_entrega_estimada = $request->fecha_entrega_estimada;
        $pedido->tecnico_asignado_id = $request->tecnico_asignado_id;
        $pedido->almacen_id = $request->almacen_id;
        $pedido->observaciones = $request->observaciones;
        $pedido->origen = 'manual';
        $pedido->save();

        // Guardar detalles del pedido
        if ($request->has('detalles')) {
            foreach ($request->detalles as $detalle) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $detalle['producto_id'] ?? null,
                    'servicio_id' => $detalle['servicio_id'] ?? null,
                    'tipo' => $detalle['tipo'] ?? 'producto',
                    'descripcion' => $detalle['descripcion'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'descuento' => $detalle['descuento'] ?? 0,
                    'subtotal' => $detalle['subtotal'],
                ]);
            }
        }

        return redirect()->route('admin-pedidos.index')->with('success', 'Pedido creado exitosamente');
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
        
        return view('ADMINISTRADOR.PRINCIPAL.ventas.pedidos.edit', compact('pedido', 'clientes', 'productos', 'servicios', 'almacenes', 'distritos', 'tecnicos'));
    }

    public function update(Request $request, Pedido $admin_pedido)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|in:pendiente,confirmado,preparacion,despacho,entregado,cancelado',
            'fecha_entrega_estimada' => 'nullable|date',
            'direccion_instalacion' => 'nullable|string',
            'distrito_id' => 'nullable|exists:distritos,id',
            'tecnico_asignado_id' => 'nullable|exists:users,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
            'observaciones' => 'nullable|string',
        ]);

        $admin_pedido->update($validated);

        return redirect()->route('admin-pedidos.index')->with('success', 'Pedido actualizado exitosamente');
    }

    public function destroy(Pedido $admin_pedido)
    {
        $admin_pedido->delete();
        return redirect()->route('admin-pedidos.index')->with('success', 'Pedido eliminado exitosamente');
    }

    public function estado(Request $request, Pedido $admin_pedido)
    {
        $admin_pedido->estado = $request->estado;
        $admin_pedido->save();

        return response()->json(['success' => true, 'message' => 'Estado actualizado']);
    }
}
