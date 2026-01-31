<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Cliente;
use App\Models\Category;
use App\Models\Marca;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ecommerceController extends Controller
{
    // Página principal
    public function index()
    {
        $productos = Producto::where('estado', 1)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        return view('ECOMMERCE.index', compact('productos'));
    }

    // Lista de productos
    public function products(Request $request)
    {
        $query = Producto::where('estado', 1);

        // Filtrar por categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtrar por marca
        if ($request->has('marca') && $request->marca != '') {
            $query->where('marca_id', $request->marca);
        }

        // Buscar por nombre
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $productos = $query->orderBy('created_at', 'desc')->paginate(12);
        $categorias = Category::all();
        $marcas = Marca::all();

        return view('ECOMMERCE.productos.index', compact('productos', 'categorias', 'marcas'));
    }

    // Detalle de producto
    public function show($slug)
    {
        $producto = Producto::where('slug', $slug)->firstOrFail();
        $relacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->where('estado', 1)
            ->limit(4)
            ->get();

        return view('ECOMMERCE.productos.show', compact('producto', 'relacionados'));
    }

    // Agregar al carrito
    public function addToCart(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // Obtener o crear carrito
        $cart = $this->getOrCreateCart();

        // Verificar si el producto ya está en el carrito
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('producto_id', $producto->id)
            ->first();

        if ($cartItem) {
            // Actualizar cantidad
            $cartItem->cantidad += $request->cantidad;
            $cartItem->calculateSubtotal();
        } else {
            // Crear nuevo item
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->producto_id = $producto->id;
            $cartItem->tipo = 'producto';
            $cartItem->nombre = $producto->name;
            $cartItem->descripcion = $producto->descripcion;
            $cartItem->cantidad = $request->cantidad;
            $cartItem->precio_unitario = $producto->precio_descuento ?? $producto->precio;
            $cartItem->descuento = 0;
            $cartItem->calculateSubtotal();
        }

        // Recalcular totales del carrito
        $cart->calculateTotals();

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart_count' => $cart->getTotalItems()
        ]);
    }

    // Ver carrito
    public function cart()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.producto');

        return view('ECOMMERCE.carrito', compact('cart'));
    }

    // Actualizar cantidad en carrito
    public function updateCart(Request $request, $itemId)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $itemId)
            ->firstOrFail();

        $cartItem->cantidad = $request->cantidad;
        $cartItem->calculateSubtotal();
        $cart->calculateTotals();

        return response()->json([
            'success' => true,
            'subtotal' => number_format($cartItem->subtotal, 2),
            'cart_total' => number_format($cart->total, 2)
        ]);
    }

    // Eliminar del carrito
    public function removeFromCart($itemId)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $itemId)
            ->firstOrFail();

        $cartItem->delete();
        $cart->calculateTotals();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'cart_count' => $cart->getTotalItems()
        ]);
    }

    // Página de checkout
    public function checkout()
    {
        $cart = $this->getOrCreateCart();
        
        if ($cart->items->count() == 0) {
            return redirect()->route('ecommerce.cart')->with('error', 'El carrito está vacío');
        }

        $cart->load('items.producto');

        return view('ECOMMERCE.checkout', compact('cart'));
    }

    // Procesar pago
    public function processCheckout(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'documento' => 'required|string|max:20',
            'direccion' => 'required|string',
            'distrito_id' => 'required|exists:distritos,id',
            'metodo_pago' => 'required|string',
        ]);

        $cart = $this->getOrCreateCart();

        if ($cart->items->count() == 0) {
            return redirect()->route('ecommerce.cart')->with('error', 'El carrito está vacío');
        }

        DB::beginTransaction();
        try {
            // Crear o buscar cliente
            $cliente = Cliente::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->nombre,
                    'telefono' => $request->telefono,
                    'documento' => $request->documento,
                    'direccion' => $request->direccion,
                ]
            );

            // Generar código de pedido
            $year = date('Y');
            $lastPedido = Pedido::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
            $nextNumber = $lastPedido ? intval(substr($lastPedido->codigo, -5)) + 1 : 1;
            $codigo = 'PED-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Crear pedido
            $pedido = new Pedido();
            $pedido->codigo = $codigo;
            $pedido->slug = Str::slug($codigo);
            $pedido->cliente_id = $cliente->id;
            $pedido->subtotal = $cart->subtotal;
            $pedido->descuento = $cart->descuento;
            $pedido->igv = $cart->igv;
            $pedido->total = $cart->total;
            $pedido->estado = 'pendiente';
            $pedido->direccion_instalacion = $request->direccion;
            $pedido->distrito_id = $request->distrito_id;
            $pedido->observaciones = $request->observaciones ?? null;
            $pedido->origen = 'ecommerce';
            $pedido->save();

            // Crear detalles del pedido
            foreach ($cart->items as $item) {
                $detalle = new DetallePedido();
                $detalle->pedido_id = $pedido->id;
                $detalle->producto_id = $item->producto_id;
                $detalle->servicio_id = $item->servicio_id;
                $detalle->tipo = $item->tipo;
                $detalle->descripcion = $item->nombre;
                $detalle->cantidad = $item->cantidad;
                $detalle->precio_unitario = $item->precio_unitario;
                $detalle->descuento = $item->descuento;
                $detalle->subtotal = $item->subtotal;
                $detalle->save();
            }

            // Limpiar carrito
            $cart->items()->delete();
            $cart->delete();

            // Limpiar sesión
            if (Session::has('cart_session_id')) {
                Session::forget('cart_session_id');
            }

            DB::commit();

            return redirect()->route('ecommerce.confirmation', $pedido->slug)
                ->with('success', 'Pedido realizado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    // Confirmación de pedido
    public function confirmation($slug)
    {
        $pedido = Pedido::where('slug', $slug)->with(['cliente', 'detalles.producto'])->firstOrFail();
        
        return view('ECOMMERCE.confirmacion', compact('pedido'));
    }

    // Método auxiliar para obtener o crear carrito
    private function getOrCreateCart()
    {
        if (auth()->check()) {
            // Usuario autenticado
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['session_id' => null]
            );
        } else {
            // Usuario invitado
            $sessionId = Session::get('cart_session_id');
            
            if (!$sessionId) {
                $sessionId = Str::uuid()->toString();
                Session::put('cart_session_id', $sessionId);
            }

            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId],
                ['user_id' => null]
            );
        }

        return $cart;
    }

    // Obtener cantidad de items en carrito (para header)
    public function getCartCount()
    {
        $cart = $this->getOrCreateCart();
        return response()->json(['count' => $cart->getTotalItems()]);
    }
}
