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
use App\Models\Inventario;
use App\Models\Marca;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ecommerceController extends Controller
{
    // Página principal
    public function index()
    {

        $productos_inventario = Inventario::where('cantidad', '>', 0)->pluck('id_producto')->toArray();
        $productos = Producto::where('estado', 'Activo')
            ->whereIn('id', $productos_inventario)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('ECOMMERCE.index', compact('productos'));
    }

    // Lista de productos
    public function products(Request $request)
    {
        $productos_inventario = Inventario::where('cantidad', '>', 0)->pluck('id_producto')->toArray();
        $tipos_producto = Producto::where('estado', 'Activo')
            ->whereIn('id', $productos_inventario)
            ->with(['tipo', 'inventarios'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('tipo_id');

        $marcas_producto = Producto::where('estado', 'Activo')
            ->whereIn('id', $productos_inventario)
            ->with(['marca', 'inventarios'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('marca_id');

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

        return view('ECOMMERCE.productos.index', compact('productos', 'categorias', 'marcas','tipos_producto','marcas_producto'));
    }

    // Detalle de producto
    public function show_product($slug)
    {
        $producto = Producto::where('slug', $slug)->firstOrFail();
        $relacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->where('estado', 1)
            ->limit(4)
            ->get();

        return view('ECOMMERCE.productos.show', compact('producto', 'relacionados'));
    }

    public function installation()
    {
        return view('ECOMMERCE.installation');
    }

    public function contact()
    {
        return view('ECOMMERCE.contact');
    }

    // Agregar al carrito
    public function addToCart(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        // Validar Stock
        $stockDisponible = \App\Models\Inventario::where('id_producto', $producto->id)->sum('cantidad');

        // Calcular cantidad actual en carrito para este producto
        $cantidadEnCarrito = 0;
        if (auth()->check()) {
            $existingCart = Cart::where('user_id', auth()->id())->first();
            if ($existingCart) {
                $existingItem = CartItem::where('cart_id', $existingCart->id)->where('producto_id', $producto->id)->first();
                $cantidadEnCarrito = $existingItem ? $existingItem->cantidad : 0;
            }
        } else {
            $sessionId = Session::get('cart_session_id');
            if ($sessionId) {
                $existingCart = Cart::where('session_id', $sessionId)->first();
                if ($existingCart) {
                    $existingItem = CartItem::where('cart_id', $existingCart->id)->where('producto_id', $producto->id)->first();
                    $cantidadEnCarrito = $existingItem ? $existingItem->cantidad : 0;
                }
            }
        }

        if (($cantidadEnCarrito + $request->cantidad) > $stockDisponible) {
            return response()->json([
                'success' => false,
                'message' => 'No hay suficiente stock disponible. Stock actual: ' . intval($stockDisponible)
            ], 422);
        }

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
            'documento' => 'required|string|min:8|max:11',
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
            // Determinar si el documento es DNI (8 dígitos) o RUC (11 dígitos)
            $documento = $request->documento;
            $esDni = strlen($documento) <= 8;

            // Crear o buscar cliente
            $cliente = Cliente::firstOrCreate(
                ['email' => $request->email],
                [
                    'nombre'      => $request->nombre,
                    'telefono'    => $request->telefono,
                    'dni'         => $esDni ? $documento : null,
                    'ruc'         => !$esDni ? $documento : null,
                    'tipo_persona' => $esDni ? 'natural' : 'juridica',
                    'direccion'   => $request->direccion,
                    'distrito_id' => $request->distrito_id,
                    'origen'      => 'ecommerce',
                    'user_id'     => auth()->check() ? auth()->id() : null,
                ]
            );

            // =====================================================
            // FLUJO ECOMMERCE: Crear VENTA + PEDIDO juntos
            // =====================================================

            // 1. Generar código de pedido
            $year = date('Y');
            $lastPedido = Pedido::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
            $nextNumber = $lastPedido ? intval(substr($lastPedido->codigo, -5)) + 1 : 1;
            $codigoPedido = 'PED-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // 2. Generar código de venta
            $ultimaVenta = \App\Models\Sale::latest('id')->first();
            $numeroVenta = $ultimaVenta ? $ultimaVenta->id + 1 : 1;
            $codigoVenta = 'VTA-' . date('Y') . '-' . str_pad($numeroVenta, 5, '0', STR_PAD_LEFT);

            // 3. Crear pedido (estado confirmado porque pago ya verificado online)
            $pedido = new Pedido();
            $pedido->codigo = $codigoPedido;
            $pedido->slug = Str::slug($codigoPedido);
            $pedido->cliente_id = $cliente->id;
            $pedido->subtotal = $cart->subtotal;
            $pedido->descuento_monto = $cart->descuento;
            $pedido->igv = $cart->igv;
            $pedido->total = $cart->total;
            $pedido->estado = 'proceso'; // Ya pagado online y en operación
            $pedido->aprobacion_stock = true; // Stock descontado al crear
            $pedido->aprobacion_finanzas = true; // Pago online confirmado automáticamente
            $pedido->direccion_instalacion = $request->direccion;
            $pedido->distrito_id = $request->distrito_id;
            $pedido->condicion_pago = $request->metodo_pago === 'credito' ? 'Crédito' : 'Contado';
            $pedido->observaciones = $request->observaciones ?? null;
            $pedido->origen = 'ecommerce';
            $pedido->estado_operativo = 'sin_asignar';
            $pedido->area_actual = 'logistica';
            $pedido->save();

            // 4. Crear venta vinculada al pedido
            $venta = \App\Models\Sale::create([
                'codigo' => $codigoVenta,
                'slug' => Str::slug($codigoVenta),
                'pedido_id' => $pedido->id,
                'cliente_id' => $cliente->id,
                'tiposcomprobante_id' => 1, // Boleta por defecto para ecommerce
                'numero_comprobante' => 'ECOM-' . $codigoPedido,
                'subtotal' => $cart->subtotal,
                'descuento' => $cart->descuento,
                'igv' => $cart->igv,
                'total' => $cart->total,
                'mediopago_id' => 1, // Configurar según metodo_pago
                'condicion_pago' => $request->metodo_pago === 'credito' ? 'Crédito' : 'Contado',
                'estado' => 'completada',
                'tipo_venta' => 'ecommerce',
                'observaciones' => 'Venta generada automáticamente desde E-commerce: ' . $codigoPedido,
            ]);

            // Descontar Stock del Inventario mediante StockService
            $stockService = new \App\Services\StockService();
            $stockService->deductStock($cart->items);

            // 5. Crear detalles del pedido
            foreach ($cart->items as $item) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'servicio_id' => $item->servicio_id,
                    'tipo' => $item->tipo,
                    'descripcion' => $item->nombre,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'descuento_monto' => $item->descuento,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // 6. Crear detalles de la venta (copia de los detalles del pedido)
            foreach ($cart->items as $item) {
                \App\Models\Detailsale::create([
                    'sale_id' => $venta->id,
                    'producto_id' => $item->producto_id,
                    'servicio_id' => $item->servicio_id,
                    'tipo' => $item->tipo,
                    'descripcion' => $item->nombre,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'descuento_monto' => $item->descuento,
                    'subtotal' => $item->subtotal,
                ]);
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
