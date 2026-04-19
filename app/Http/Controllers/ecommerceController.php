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
use App\Models\Comment;
use App\Models\Coupon;
use App\Models\Inventario;
use App\Models\Likecomment;
use App\Models\Marca;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use App\Models\Persona;
use App\Models\Prospecto;
use App\Models\Sale;
use App\Models\Detailsale;
use App\Models\Direccioncliente;
use App\Models\User;
use App\Models\Usercoupon;
use App\Models\WishList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Throwable;

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

        public function limpiarSesioncisnergia(Request $request)
    {
        $request->session()->forget('carrito');

        return redirect()->route('ecommerce.index');
    }

    public function getmiperfil(){
        if(Auth::check()){
            $cliente = $this->resolveAuthenticatedCliente();
            $direcciones = $cliente
                ? Direccioncliente::where('cliente_id', $cliente->id)->get()
                : collect();
            $departamentos = Departamento::all();

            $cupons = Coupon::where('estado', 'Activo')->get();
            $ultimos_productos = Producto::where('estado', 'Activo')->where('created_at', '>=', Carbon::now()->subDays(5))->orderBy('created_at', 'desc')->take(5)->get();
            return view('ECOMMERCE.cuenta.mi_perfil', compact('direcciones', 'departamentos', 'cupons', 'ultimos_productos'));
        }else{
            return redirect()->route('ecommerce.index');
        }
    }

    public function crearDireccion(Request $request){
        if(Auth::check()){
            $cliente = $this->resolveAuthenticatedCliente();
            if (!$cliente) {
                return redirect()->route('ecommerce.index');
            }

            $direccion = new Direccioncliente();
            $direccion->referencia = $request->referencia; 
            $direccion->direccion = $request->direccion;
            $direccion->departamento_id = $request->departamento_id;
            $direccion->provincia_id = $request->provincia_id;
            $direccion->distrito_id = $request->distrito_id;
            $direccion->cliente_id = $cliente->id;
            $direccion->save();

            return redirect()->route('ecommerce.mi_perfil')->with('registrar_direccion', 'ok');
        }else{
            return redirect()->route('ecommerce.index');
        }
    }
    public function getMisDirecciones(Request $request, $id){
        if(Auth::check()){
            $cliente = $this->resolveAuthenticatedCliente();
            $direccion = Direccioncliente::findOrFail($id);
            $direccion->referencia = $request->referencia; 
            $direccion->direccion = $request->direccion;
            $direccion->departamento_id = $request->departamento_id;
            $direccion->provincia_id = $request->provincia_id;
            $direccion->distrito_id = $request->distrito_id;
            $direccion->save();

            $direcciones = $cliente
                ? Direccioncliente::where('cliente_id', $cliente->id)->get()
                : collect();
            $departamentos = Departamento::all();

            return redirect()->route('ecommerce.mi_perfil', compact('direcciones', 'departamentos'))->with('success', 'ok');
        }else{
            return redirect()->route('ecommerce.index');
        }
    }

    public function eliminardireccion(Request $request, $id){
        if(Auth::check()){
            $direccion = Direccioncliente::findOrFail($id);
            $direccion->delete();

            return redirect()->route('ecommerce.mi_perfil')->with('eliminar_direccion', 'ok');
        }else{
            return redirect()->route('ecommerce.index');
        }
    }

    public function cambiarContrasena(Request $request){
        if(Auth::check()){
            $request->validate([
                'current_password' => 'required|current_password',
                'new_password' => 'required|min:8|confirmed|different:current_password',
            ],[
                'current_password.required' => 'Debes ingresar tu contraseña actual.',
                'current_password.current_password' => 'La contraseña actual es incorrecta.',
                'new_password.required' => 'Debes ingresar una nueva contraseña.',
                'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
                'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
                'new_password.different' => 'La nueva contraseña debe ser diferente a la contraseña actual.',
            ],[
                'current_password' => 'contraseña actual',
                'new_password' => 'nueva contraseña',
            ]);

            $user = User::findOrFail(Auth::id());
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('ecommerce.mi_perfil')->with('actualizar_contrasena', 'ok');

        }else{
            return redirect()->route('ecommerce.index');
        }
    }

    // enviar codigo de recuperacion por correo mendiante OTP (One Time Password)
    public function enviarCodigoRecuperacion(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Debes ingresar un correo electrónico.',
            'email.email' => 'El formato del correo no es válido.',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'No encontramos una cuenta registrada con ese correo.'
            ], 422);
        }

        $otpCode = (string) random_int(100000, 999999);
        $cacheKey = 'perfil_password_otp_' . $user->id;
        $expiresAt = now()->addMinutes(10);

        Cache::put($cacheKey, [
            'email' => $email,
            'otp_hash' => Hash::make($otpCode),
            'attempts' => 0,
            'expires_at' => $expiresAt->toDateTimeString(),
        ], $expiresAt);

        try {
            Mail::raw("Tu código de verificación es: {$otpCode}. Este código vence en 10 minutos.", function ($message) use ($email, $user) {
                $message->to($email, $user->name)
                    ->subject('Código de verificación - Cambio de contraseña');
            });
        } catch (Throwable $e) {
            Log::error('Error enviando OTP de cambio de contraseña', [
                'user_id' => $user->id,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'No se pudo enviar el correo. Revisa la configuración SMTP e inténtalo nuevamente.'
            ], 500);
        }

        return response()->json([
            'message' => 'Te enviamos un código de 6 dígitos a tu correo.'
        ]);
    }

    // Actualizar contraseña usando OTP
    public function cambiarContrasenaConOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Debes ingresar tu correo.',
            'email.email' => 'El correo ingresado no es válido.',
            'otp.required' => 'Debes ingresar el código de verificación.',
            'otp.digits' => 'El código debe tener 6 dígitos.',
            'new_password.required' => 'Debes ingresar una nueva contraseña.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'No encontramos una cuenta registrada con ese correo.'
            ], 422);
        }

        $cacheKey = 'perfil_password_otp_' . $user->id;
        $otpData = Cache::get($cacheKey);

        if (!$otpData) {
            return response()->json([
                'message' => 'El código expiró o no fue solicitado. Solicita uno nuevo.'
            ], 422);
        }

        if ($email !== strtolower($otpData['email'])) {
            return response()->json([
                'message' => 'El correo no coincide con el de la verificación.'
            ], 422);
        }

        $expiresAt = Carbon::parse($otpData['expires_at']);
        if (now()->greaterThan($expiresAt)) {
            Cache::forget($cacheKey);
            return response()->json([
                'message' => 'El código ya expiró. Solicita uno nuevo.'
            ], 422);
        }

        $attempts = (int) ($otpData['attempts'] ?? 0);
        if ($attempts >= 5) {
            Cache::forget($cacheKey);
            return response()->json([
                'message' => 'Superaste el número de intentos permitidos. Solicita un nuevo código.'
            ], 429);
        }

        if (!Hash::check($request->otp, $otpData['otp_hash'])) {
            $otpData['attempts'] = $attempts + 1;
            Cache::put($cacheKey, $otpData, $expiresAt);

            return response()->json([
                'message' => 'El código ingresado es incorrecto.'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Cache::forget($cacheKey);

        return response()->json([
            'message' => 'Contraseña actualizada correctamente.'
        ]);
    }

    // mis ultimas compras
    public function misCompras ()
    {
        $clienteId = $this->resolveAuthenticatedCliente()?->id;

        if (!$clienteId) {
            $ventas = collect();
            $stats = [
                'total_pedidos' => 0,
                'entregados' => 0,
                'total_invertido' => 0,
            ];

            return view('ECOMMERCE.cuenta.mis_compras', compact('ventas', 'stats'));
        }

        $ventas = Sale::with(['pedido', 'detalles.producto'])
            ->where('cliente_id', $clienteId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_pedidos' => $ventas->count(),
            'entregados' => $ventas->filter(fn ($venta) => optional($venta->pedido)->estado === 'entregado')->count(),
            'total_invertido' => $ventas->sum('total'),
        ];

        return view('ECOMMERCE.cuenta.mis_compras', compact('ventas', 'stats'));
    }

    // lista de mis favoritos
    public function getMisFavoritos(){
        if(Auth::check()){
            $favoritos = WishList::with('producto')
                ->where('user_id', Auth::user()->id)
                ->get();

            return view('ECOMMERCE.cuenta.favoritos', compact('favoritos'));
        }else{
            return redirect()->route('ecommerce.index');
        }
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

        // ← Ordenamiento
        $orden = $request->orden ?? 'relevantes';
        $query = Producto::where('estado', 'Activo')
            ->whereIn('id', $productos_inventario)
            ->with(['inventarios']);

        match($orden) {
            'menor_precio' => $query->orderBy('precio', 'asc'),
            'mayor_precio' => $query->orderBy('precio', 'desc'),
            'recientes'    => $query->orderBy('created_at', 'desc'),
            default        => $query->orderBy('created_at', 'desc'),
        };

        $todos_productos = $query->paginate(6)->appends(['orden' => $orden]);

        // resto del filtrado para $productos (sidebar)
        $queryFiltro = Producto::where('estado', 1);
        if ($request->has('categoria') && $request->categoria != '') {
            $queryFiltro->where('categoria_id', $request->categoria);
        }
        if ($request->has('marca') && $request->marca != '') {
            $queryFiltro->where('marca_id', $request->marca);
        }
        if ($request->has('search') && $request->search != '') {
            $queryFiltro->where('name', 'like', '%' . $request->search . '%');
        }

        $productos = $queryFiltro->orderBy('created_at', 'desc')->paginate(12);
        $categorias = Category::all();
        $marcas = Marca::all();

        return view('ECOMMERCE.productos.index', compact(
            'productos', 'categorias', 'marcas',
            'tipos_producto', 'marcas_producto',
            'todos_productos', 'orden'  // ← pasa $orden a la vista
        ));
    }

    public function getbusqueda_pmarca(Request $request)
    {
        if($request->ajax()){
            $productos_inventario = Inventario::where('cantidad', '>', 0)
                ->pluck('id_producto')
                ->toArray();

            $productos = Producto::where('estado', 'Activo')
                ->whereIn('id', $productos_inventario)
                ->where('tipo_id', $request->valor_check_tipo)
                ->with(['marca', 'inventarios'])  // ← quita tipo, agrega marca
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('marca_id');  // ← agrupa por marca, no tipo

            $arraylist = [];  // ← inicializa siempre

            foreach($productos as $marca_id => $prods){
                $arraylist[] = [
                    $marca_id,                          // value[0] = marca_id
                    $prods->first()->marca->name ?? 'Sin marca', // value[1] = nombre marca
                    $prods->sum(fn($p) => $p->inventarios->sum('cantidad')), // value[2] = stock total
                ];
            }

            return response()->json($arraylist);
        }
    }

    public function getbusqueda_pproducto_categoria(Request $request)
    {
        if($request->ajax()){
            $productos_inventario = Inventario::where('cantidad', '>', 0)
                ->pluck('id_producto')
                ->toArray();

            // ← Ordenamiento
            $orden = $request->orden ?? 'relevantes';
            $query = Producto::where('estado', 'Activo')
                ->whereIn('id', $productos_inventario)
                ->where('tipo_id', $request->valor_check_tipo)
                ->with(['inventarios', 'marca']);

            match($orden) {
                'menor_precio' => $query->orderBy('precio', 'asc'),
                'mayor_precio' => $query->orderBy('precio', 'desc'),
                'recientes'    => $query->orderBy('created_at', 'desc'),
                default        => $query->orderBy('created_at', 'desc'),
            };

            $productos = $query->paginate(10);

            $arraylist = [];
            foreach($productos as $prod){
                $arraylist[] = [
                    $prod->id,
                    $prod->name,
                    $prod->inventarios->sum('cantidad'),
                    $prod->imagen ? asset('images/productos/' . $prod->imagen) : asset('images/logo.webp'),
                    $prod->marca->name,
                    $prod->potencia_nominal ?? '--',
                    $prod->eficiencia ?? '--',
                    $prod->num_celdas ?? '--',
                    $prod->dimensiones ?? '--',
                    $prod->tipo_celula ?? '--',
                    $prod->garantia ?? '--',
                    $prod->precio_descuento > 0 ? $prod->precio_descuento : 0,
                    $prod->porcentaje > 0 ? $prod->porcentaje : 0,
                    $prod->precio,
                    $prod->slug,
                ];
            }

            return response()->json([
                'productos'  => $arraylist,
                'pagination' => [
                    'total'        => $productos->total(),
                    'per_page'     => $productos->perPage(),
                    'current_page' => $productos->currentPage(),
                    'last_page'    => $productos->lastPage(),
                ]
            ]);
        }
    }

    public function getbusqueda_pproducto_marca(Request $request)
    {
        if($request->ajax()){
            $productos_inventario = Inventario::where('cantidad', '>', 0)
                ->pluck('id_producto')
                ->toArray();

            // ← Ordenamiento
            $orden = $request->orden ?? 'relevantes';
            $query = Producto::where('estado', 'Activo')
                ->whereIn('id', $productos_inventario)
                ->where('tipo_id', $request->valor_check_tipo)
                ->whereIn('marca_id', (array) $request->valor_check_marca)
                ->with(['inventarios', 'marca']);

            match($orden) {
                'menor_precio' => $query->orderBy('precio', 'asc'),
                'mayor_precio' => $query->orderBy('precio', 'desc'),
                'recientes'    => $query->orderBy('created_at', 'desc'),
                default        => $query->orderBy('created_at', 'desc'),
            };

            $productos = $query->paginate(10);

            $arraylist = [];
            foreach($productos as $prod){
                $arraylist[] = [
                    $prod->id,
                    $prod->name,
                    $prod->inventarios->sum('cantidad'),
                    $prod->imagen ? asset('images/productos/' . $prod->imagen) : asset('images/logo.webp'),
                    $prod->marca->name,
                    $prod->potencia_nominal ?? '--',
                    $prod->eficiencia ?? '--',
                    $prod->num_celdas ?? '--',
                    $prod->dimensiones ?? '--',
                    $prod->tipo_celula ?? '--',
                    $prod->garantia ?? '--',
                    $prod->precio_descuento > 0 ? $prod->precio_descuento : 0,
                    $prod->porcentaje > 0 ? $prod->porcentaje : 0,
                    $prod->precio,
                    $prod->slug,
                ];
            }

            return response()->json([
                'productos'  => $arraylist,
                'pagination' => [
                    'total'        => $productos->total(),
                    'per_page'     => $productos->perPage(),
                    'current_page' => $productos->currentPage(),
                    'last_page'    => $productos->lastPage(),
                ]
            ]);
        }
    }

    // Detalle de producto
    public function show_product($slug)
    {
        $productos_inventario = Inventario::where('cantidad', '>', 0)
                ->pluck('id_producto')
                ->toArray();
        $producto = Producto::where('slug', $slug)->whereIn('id', $productos_inventario)->with(['inventarios'])->firstOrFail();
        $comments_producto = Comment::where('producto_id', '=', $producto->id)->where('tipo','producto')->paginate(5);
        
        $otros_productos = Producto::where('tipo_id',  $producto->tipo_id)->where('id', '!=', $producto->id)->whereIn('id', $productos_inventario)->with(['inventarios'])->get();

        $relacionados = Producto::where('categorie_id', $producto->categorie_id)
            ->whereIn('id', $productos_inventario)
            ->where('id', '!=', $producto->id)
            ->with(['inventarios'])
            ->where('estado', 'Activo')
            ->limit(4)
            ->get();

        return view('ECOMMERCE.productos.show', compact('producto', 'relacionados','comments_producto','otros_productos'));
    }

    public function postcomments(Request $request)
    {
        $request->validate([
            'comentario' => 'required|string|max:2000',
            'producto_id' => 'required|integer|exists:productos,id',
        ]);

        $comment = new Comment();
        $comment->titulo = $request->input('titulo');
        $comment->comentario = $request->input('comentario');
        $comment->tipo = 'producto';
        $comment->valoracion = $request->input('valoracion') == '' ? 0 : $request->input('valoracion');
        $comment->user_id = Auth::user()->id;
        $comment->producto_id = $request->input('producto_id');
        $comment->save();

        return redirect()->back()->with('success', 'Comentario publicado exitosamente.');
    }


    public function getlikecomments(Request $request)
    {
        if ($request->ajax()) {
            $tipo_like = $request->input('valor_comment');
            $user_id = $request->input('user_id');
            $comment_id = $request->input('comment_id');

            $userLike = Likecomment::where('user_id', $user_id)->where('comment_id', $comment_id)->first();

            if ($userLike) {
                if ($userLike->like == $tipo_like) {
                    // Eliminar like
                    $userLike->delete();
                    return response()->json([
                        'status' => 'removed',
                        'like_count' => Likecomment::where('comment_id', $comment_id)->where('like', 1)->count(),
                        'dislike_count' => Likecomment::where('comment_id', $comment_id)->where('like', 0)->count()
                    ]);
                } else {
                    // Actualizar like
                    $userLike->update(['like' => $tipo_like]);
                    return response()->json([
                        'status' => 'updated',
                        'like_count' => Likecomment::where('comment_id', $comment_id)->where('like', 1)->count(),
                        'dislike_count' => Likecomment::where('comment_id', $comment_id)->where('like', 0)->count()
                    ]);
                }
            } else {
                // Crear nuevo like
                Likecomment::create([
                    'like' => $tipo_like,
                    'tipo' => 'Article',
                    'user_id' => $user_id,
                    'comment_id' => $comment_id
                ]);
                return response()->json([
                    'status' => 'created',
                    'like_count' => Likecomment::where('comment_id', $comment_id)->where('like', 1)->count(),
                    'dislike_count' => Likecomment::where('comment_id', $comment_id)->where('like', 0)->count()
                ]);
            }
        }
    }

    public function getcargar_carrito(Request $request)
    {
        if($request->ajax()){
            if($request->procedencia == 'cuponera'){
                    $descuento_cuponera = Coupon::where('codigo',$request->valor_cuponera)->where('estado','Activo')->first();
                    if(!$descuento_cuponera){
                        $ArrayList[1] = ['cupon_ya_aplicado'];
                        return response()->json($ArrayList);
                    }
                    if(UserCoupon::where('user_id',Auth::user()->id)->where('coupon_id',$descuento_cuponera->id)->exists()){
                        $ArrayList[1] = ['cupon_ya_aplicado'];
                        return response()->json($ArrayList);
                        
                    }else{
                        if($descuento_cuponera){
                            $valor_total = (float) $request->valor_total;
                            $precio_descuento = round($valor_total * ($descuento_cuponera->porcentaje / 100), 2);
                            $nuevo_total = round($valor_total - $precio_descuento, 2);

                            $user_coupon = new UserCoupon();
                            $user_coupon->user_id = Auth::user()->id;
                            $user_coupon->coupon_id = $descuento_cuponera->id;
                            $user_coupon->save();

                            session(['cupon_carrito' => $descuento_cuponera->id]);
                            $ArrayList[1] = ['cupon_aplicado', $precio_descuento, $nuevo_total, $descuento_cuponera->porcentaje];
                        }
                    }
                    
                    return response()->json($ArrayList);
            }else{
                if($request->validar_carrito == 'verificar_carrito'){
                    if(session('carrito', []) && count(session('carrito', [])) > 0){
                        foreach(session('carrito',[]) as $key => $value){
                            $ArrayList[$key] = [
                                $value['slug'],
                                $value['ymdhis'],
                                $value['name_producto'],
                                $value['imagen_producto'],
                                $value['precio'],
                                $value['producto_id'],
                                $value['cantidad'],
                                $value['precio_descuento'],
                                $value['porcentaje'],
                                count(session('carrito', [])),
                            ];
                        }
                        return response()->json($ArrayList);
                    }else{
                        session()->forget('carrito');
                        $ArrayList[1] = ['no existe'];
                        return response()->json($ArrayList);
                    }
                }else{
                    // $request->session()->flush();
                    $carrito = session('carrito',[]);
    
                    // Check if course already exists in cart
                    $exists = collect($carrito)->contains('producto_id', $request->id_element_producto);
                    
                    if($exists) {
                        $ArrayList[1] = ['producto_ya_en_carrito'];
                        return response()->json($ArrayList);
                    }

                    $product = DB::table('productos')->where('id', $request->id_element_producto)->first();

                    $item = [
                        'slug' => $product->slug,
                        'ymdhis' => date('YmdHis'),
                        'name_producto' => $product->name,
                        'imagen_producto' => $product->imagen ? asset('images/productos/' . $product->imagen) : asset('images/logo.webp'),
                        'precio' => $product->precio,
                        'producto_id' => $product->id,
                        'cantidad' => 1,
                        'precio_descuento' => $product->precio_descuento > 0 ? $product->precio_descuento : 0,
                        'porcentaje' => $product->porcentaje > 0 ? $product->porcentaje : 0,
                    ];
                    $carrito[] = $item;
                    
                    $request->session()->put('carrito',$carrito);
                    
                    $ArrayList[1] = ['producto_agregado_al_carrito', count($carrito)];
                    return response()->json($ArrayList);
                }
            }
        }
    }


    public function getagregar_compra_carrito(Request $request)
    {
        if($request->ajax()){
            if($request->ajax()){
                $id_element_producto = $request->id_element_producto;
                $carrito = session('carrito', []);

                // Check if product already exists in cart
                $exists = collect($carrito)->contains('producto_id', $id_element_producto);
                
                if($exists) {
                    $ArrayList[1] = ['producto_ya_en_carrito'];
                    return response()->json($ArrayList);
                }

                // Product not in cart, add it
                $product = DB::table('productos')->where('id', $id_element_producto)->first();

                $carrito[] = [
                    'slug' => $product->slug,
                    'ymdhis' => date('YmdHis'),
                    'name_producto' => $product->name,
                    'imagen_producto' => $product->imagen ? asset('images/productos/' . $product->imagen) : asset('images/logo.webp'),
                    'precio' => $product->precio,
                    'producto_id' => $product->id,
                    'cantidad' => 1,
                    'precio_descuento' => $product->precio_descuento > 0 ? $product->precio_descuento : 0,
                    'porcentaje' => $product->porcentaje > 0 ? $product->porcentaje : 0,
                ];

                session(['carrito' => $carrito]);

                $ArrayList[1] = ['producto_agregado_al_carrito', count($carrito)];
                return response()->json($ArrayList);
            }

        }

    }

    public function pago_carrito_compra()
    {
        $cart = session('carrito');

        $subtotal = collect($cart)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $igv      = $subtotal * 0.18;
        $total    = $subtotal + $igv;

        return view('ECOMMERCE.carrito.carrito', compact('cart', 'subtotal', 'igv', 'total'));
    }

    public function geteliminar_carrito(Request $request)
    {
        if($request->ajax()){
            $id_element_producto = (int) $request->id_element_producto;
            $carrito = session('carrito', []);
            $ncarrito = [];

            // recorremos el carrito y eliminamos el elemento que no coincida
            foreach ($carrito as $key => $item) {
                
                //Realizamos la busqueda de la cuponera, si existe la eliminamos
                    // if(isset($key) && $key == $id_element_carrito && Usercoupon::where('user_id',Auth::user()->id)->where('course_id',$item['curso_id'])->exists()){
                    //     $eliminar_cuponera = Usercoupon::where('user_id',Auth::user()->id)->where('course_id',$item['curso_id'])->first();
                    //     $eliminar_cuponera->delete();
                    // }
                //fin de validacion de cuponera

                if (isset($key) && (int) $item['producto_id'] !== $id_element_producto) {
                    $ncarrito[$key] = $item;
                }
            }

            // Reindexar y guardar
            $request->session()->put('carrito', $ncarrito);

            return response()->json($this->buildSessionCartPayload(session('carrito', [])));
        }
    }

    public function getactualizar_cantidad_carrito(Request $request)
    {
        if($request->ajax()){
            $id_element_producto = (int) $request->id_element_producto;
            $cantidad = max(1, (int) $request->cantidad);
            $carrito = session('carrito', []);

            foreach ($carrito as $key => $item) {
                if ((int) ($item['producto_id'] ?? 0) === $id_element_producto) {
                    $carrito[$key]['cantidad'] = $cantidad;
                    break;
                }
            }

            $request->session()->put('carrito', $carrito);

            return response()->json($this->buildSessionCartPayload(session('carrito', [])));
        }
    }

    private function buildSessionCartPayload(array $carritoActual): array
    {
        if(count($carritoActual) === 0){
            session()->forget('carrito');

            return [
                'status' => 'empty',
                'items' => [],
                'summary' => [
                    'count' => 0,
                    'subtotal' => 0,
                    'igv' => 0,
                    'total' => 0,
                ],
            ];
        }

        $productoIds = collect($carritoActual)
            ->pluck('producto_id')
            ->filter()
            ->unique()
            ->values();

        $productos = Producto::with('marca')
            ->whereIn('id', $productoIds)
            ->get()
            ->keyBy('id');

        $items = [];
        $subtotal = 0;

        foreach($carritoActual as $value){
            $producto = $productos->get((int) $value['producto_id']);
            $precioUnitario = (float) ($value['precio'] ?? 0);
            $cantidad = (int) ($value['cantidad'] ?? 0);
            $itemSubtotal = $precioUnitario * $cantidad;
            $subtotal += $itemSubtotal;

            $items[] = [
                'slug' => $value['slug'] ?? null,
                'ymdhis' => $value['ymdhis'] ?? null,
                'name_producto' => $value['name_producto'] ?? '',
                'imagen_producto' => $value['imagen_producto'] ?? asset('images/logo.webp'),
                'precio' => $precioUnitario,
                'producto_id' => (int) ($value['producto_id'] ?? 0),
                'cantidad' => $cantidad,
                'precio_descuento' => (float) ($value['precio_descuento'] ?? 0),
                'porcentaje' => (float) ($value['porcentaje'] ?? 0),
                'valor_marca' => optional($producto?->marca)->name,
                'valor_codigo' => $producto->codigo ?? 'N/A',
                'item_subtotal' => $itemSubtotal,
            ];
        }

        $igv = $subtotal * 0.18;
        $total = $subtotal + $igv;

        return [
            'status' => 'ok',
            'items' => $items,
            'summary' => [
                'count' => count($items),
                'subtotal' => round($subtotal, 2),
                'igv' => round($igv, 2),
                'total' => round($total, 2),
            ],
        ];
    }





    public function installation()
    {
        return view('ECOMMERCE.installation');
    }

    public function contact()
    {
        return view('ECOMMERCE.contact');
    }


    // Página de checkout
    public function checkout()
    {
        if(Auth::check()){
            $cart = session('carrito', []);
    
            if (count($cart) == 0) {
                return redirect()->route('ecommerce_pago_carrito_compras.index')->with('error', 'El carrito está vacío');
            }
    
            $subtotal = collect($cart)->sum(fn($item) => ((float) ($item['precio'] ?? 0)) * ((int) ($item['cantidad'] ?? 1)));
            $igv = $subtotal * 0.18;
            $total = $subtotal + $igv;
    
            $departamentos = Departamento::all();
            $culqiAmountPenCents = (int) round($total * 100);

            $cliente = $this->resolveAuthenticatedCliente();
            $direcciones = $cliente
                ? Direccioncliente::where('cliente_id', Auth::user()->cliente->id)->get()
                : collect();
    

            $descuento = 0;
            $cupon_aplicado = null;
            $cupon_id = session('cupon_carrito');
            if ($cupon_id) {
                $cupon = Coupon::find($cupon_id);
                if ($cupon && UserCoupon::where('user_id', Auth::user()->id)->where('coupon_id', $cupon_id)->exists()) {
                    $descuento = round($total * ($cupon->porcentaje / 100), 2);
                    $total = round($total - $descuento, 2);
                    $cupon_aplicado = $cupon;
                }
            }

            $culqiAmountPenCents = (int) round($total * 100);

            return view('ECOMMERCE.carrito.checkout', compact('cart', 'subtotal', 'igv', 'total', 'descuento', 'cupon_aplicado', 'departamentos', 'culqiAmountPenCents', 'direcciones'));
        }else{
            return redirect()->route('login')->with('error_ingreso', 'ok');
        }
    }

    public function getprovincias(Request $request)
    {
        if ($request->ajax()) {
            $provincias = Provincia::where('departamento_id', $request->valor_departamento)->get();

            foreach ($provincias as $provincia) {
                $arraylist[$provincia->id] = [$provincia->nombre];
            }
            return response()->json($arraylist);
        }
    }
    public function getdistritos(Request $request)
    {
        if ($request->ajax()) {
            $distritos = Distrito::where('provincia_id', $request->valor_provincia)->get();

            foreach ($distritos as $distrito) {
                $arraylist[$distrito->id] = [$distrito->nombre];
            }
            return response()->json($arraylist);
        }
    }

    //crear orden de culqi
    public function createCulqiCharge(Request $request)
    {
        try {
            // $validated = $request->validate([
            //     'token' => 'required|string',
            //     'email' => 'required|email',
            // ]);

            $cartItems = session('carrito', []);
            if (empty($cartItems)) {
                return response()->json(['success' => false, 'message' => 'No hay items en la sesión'], 400);
            }

            if (!Auth::check()) {
                return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
            }

            $email = $request->email;

            $subtotal = collect($cartItems)->sum(function ($item) {
                return ((float) ($item['precio'] ?? 0)) * ((int) ($item['cantidad'] ?? 1));
            });
            $igv = round($subtotal * 0.18, 2);
            $totalPen = round($subtotal + $igv, 2);
            $amountInCents = (int) round($totalPen * 100);

            // Mapeo ecommerce: 2 = Transferencia Bancaria, 3 = Billetera Digital.
            $metodoPagoSeleccionado = strtolower((string) $request->input('metodo_pago', ''));
            $mediopagoId = in_array($metodoPagoSeleccionado, ['yape', 'plin', 'billetera', 'billetera_digital'], true) ? 3 : 2;

            // ── CULQI DESACTIVADO TEMPORALMENTE (modo prueba) ──
            // $culqiClass = '\\Culqi\\Culqi';
            // $culqi = new $culqiClass(['api_key' => $secretKey]);
            // $charge = $culqi->Charges->create([
            //     'amount' => $amountInCents,
            //     'currency_code' => 'PEN',
            //     'email' => $email,
            //     'source_id' => $request->token,
            // ]);
            $charge = (object) ['id' => 'TEST-' . date('YmdHis')]; // ← carga simulada

            // $outcomeType = $charge->outcome->type ?? null;
            // if ($outcomeType !== 'venta_exitosa') {
            //     $message = $charge->outcome->merchant_message ?? 'Pago rechazado por Culqi';
            //     return response()->json(['success' => false, 'message' => $message], 400);
            // }

            $now = Carbon::now();
            $ultimoPedido = Pedido::latest('id')->first();
            $numero = $ultimoPedido ? $ultimoPedido->id + 1 : 1;
            $codigo = 'PED-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

            $longitud = strlen((string) $request->documento);
            $tipoPersona = $longitud === 11 ? 'juridica' : 'natural';
            $documento = (string) $request->documento;

            $user = Auth::user();
            $prospecto = Prospecto::where('registered_user_id', $user->id)->first();
            if (! $prospecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró prospecto asociado al usuario.',
                ], 422);
            }

            $clienteOverrides = [
                'nombre' => $request->nombre,
                'razon_social' => $tipoPersona === 'juridica' ? $request->nombre : null,
                'ruc' => $tipoPersona === 'juridica' ? $documento : null,
                'dni' => $tipoPersona === 'natural' ? $documento : null,
                'tipo_persona' => $tipoPersona,
                'email' => $email,
                'telefono' => $request->telefono,
                'celular' => $request->telefono,
                'direccion' => $request->direccion,
                'distrito_id' => $request->distrito_id,
                'origen' => 'ecommerce',
                'estado' => 'activo',
                'segmento' => 'comercial',
                'user_id' => $user->id,
                'fecha_primera_compra' => now(),
            ];

            $cliente = $prospecto->convertir($clienteOverrides);

            if(Auth::user()->persona){
                $actualizar_persona = Persona::where('id',Auth::user()->persona->id)->first();
                if ($longitud === 11) {
                    $actualizar_persona->nro_identificacion = $documento;
                    $actualizar_persona->identificacion = 'RUC';
                } else {
                    $actualizar_persona->nro_identificacion = $documento;
                    $actualizar_persona->identificacion = 'DNI';
                }

                $actualizar_persona->nro_identificacion = $request->documento;
                $actualizar_persona->celular = $request->telefono;
                $actualizar_persona->direccion = $request->direccion;
                $actualizar_persona->save();
            }

            if ($request->direccion_id) {
                // Usar dirección guardada
                $direccion = Direccioncliente::findOrFail($request->direccion_id);
                $distritoId = $direccion->distrito_id;
                $direccionTexto = $direccion->direccion;

            } else {
                // Nueva dirección
                $request->validate([
                    'direccion'  => 'required|string|max:255',
                    'distrito_id' => 'required|exists:distritos,id',
                ]);

                $distritoId     = $request->distrito_id;
                $direccionTexto = $request->direccion;

                // Guardar si el usuario lo pidió
                if ($request->guardar_direccion == '1') {
                    Direccioncliente::create([
                        'cliente_id'      => $cliente->id,  // ← usa la variable ya resuelta
                        'direccion'       => $direccionTexto,
                        'distrito_id'     => $distritoId,
                        'provincia_id'    => $request->provincia_id,
                        'departamento_id' => $request->departamento_id,
                    ]);
                }
            }

            $pedido = new Pedido();
            $pedido->codigo = $codigo;
            $pedido->slug = Str::slug($codigo);
            $pedido->cliente_id = $cliente->id;
            $pedido->user_id = Auth::id();
            $pedido->subtotal = $subtotal;
            $pedido->descuento_porcentaje = $request->descuento_porcentaje ?? 0;
            $pedido->descuento_monto = $request->descuento ?? 0;
            $pedido->igv = $igv;
            $pedido->total = $request->total ?? 0;
            $pedido->estado = 'proceso';
            $pedido->aprobacion_finanzas = true;   // Pago online ya confirmado
            $pedido->aprobacion_stock = false;     // Se intenta reservar después
            $pedido->direccion_instalacion = $request->direccion_id ? null : $direccionTexto; // Solo guardar texto si no se usó una dirección guardada
            $pedido->distrito_id = $request->distrito_id;
            $pedido->fecha_entrega_estimada = $now->addDays(3)->toDateString(); // Ejemplo: entrega en 3 días
            $pedido->almacen_id = 1;
            $pedido->prioridad = 'alta';
            $pedido->condicion_pago = 'Contado';
            $pedido->observaciones = $request->observaciones;
            $pedido->origen = 'ecommerce';
            $pedido->save();

            foreach ($cartItems as $item) {
                $cantidad = (int) ($item['cantidad'] ?? 1);
                $precioUnitario = (float) ($item['precio'] ?? 0);

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['producto_id'] ?? null,
                    'tipo' => 'producto',
                    'descripcion' => $item['name_producto'] ?? 'Producto ecommerce',
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'descuento_monto' => 0,
                    'subtotal' => round($precioUnitario * $cantidad, 2),
                ]);
            }

            // Intentar reservar stock automáticamente
            try {
                $stockService = new \App\Services\StockService();
                $detallesProducto = $pedido->detalles()->whereNotNull('producto_id')->get();

                if ($detallesProducto->count() > 0 && $stockService->hasStock($detallesProducto, $pedido->almacen_id)) {
                    $stockService->deductStock($detallesProducto, $pedido->almacen_id);
                    $pedido->aprobacion_stock = true;
                    $pedido->save();
                }
            } catch (\Exception $e) {
                // Stock insuficiente: queda con aprobacion_stock = false
            }

            $serieComprobante = \App\Models\SerieComprobante::where('tiposcomprobante_id', $request->tiposcomprobante_id ?? 1)
            ->where('activo', true)
            ->first();

            $numeroComprobante = $serieComprobante->generarNumero();

            $prefijoCodigo = 'VTA-' . date('Y') . '-';
            $ultimaVentaEcom = Sale::where('codigo', 'like', $prefijoCodigo . '%')->orderBy('codigo', 'desc')->first();
            $numeroVtaEcom = 1;
            if ($ultimaVentaEcom && preg_match('/-(\d+)$/', $ultimaVentaEcom->codigo, $matchesEcom)) {
                $numeroVtaEcom = intval($matchesEcom[1]) + 1;
            }

            $venta = new Sale();
            $venta->codigo = $prefijoCodigo . str_pad($numeroVtaEcom, 5, '0', STR_PAD_LEFT);
            $venta->slug = Str::slug($venta->codigo);
            $venta->pedido_id = $pedido->id;
            $venta->cliente_id = $cliente->id;
            $venta->tiposcomprobante_id = $request->tiposcomprobante_id ?? 1; // Default a factura
            $venta->numero_comprobante = $numeroComprobante;
            $venta->subtotal = $subtotal;
            $venta->descuento = $request->descuento ?? 0;
            $venta->igv = $igv;
            $venta->total = $request->total ?? 0;
            $venta->condicion_pago = 'Contado';
            $venta->estado = 'pagado';
            $venta->mediopago_id = $mediopagoId;
            $venta->user_id = Auth::id();
            $venta->sede_id = 1;
            $venta->tipo_venta = 'ecommerce';
            $venta->tipo_proyecto = 'comercial';
            $venta->save();

            foreach ($cartItems as $item) {
                $cantidad = (int) ($item['cantidad'] ?? 1);
                $precioUnitario = (float) ($item['precio'] ?? 0);

                Detailsale::create([
                    'sale_id' => $venta->id,
                    'producto_id' => $item['producto_id'] ?? null,
                    'tipo' => 'producto',
                    'descripcion' => $item['name_producto'] ?? 'Producto ecommerce',
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'descuento_porcentaje' => 0,
                    'descuento_monto' => 0,
                    'subtotal' => round($precioUnitario * $cantidad, 2),
                ]);
            }

            session()->forget('carrito');

            return response()->json([
                'success' => true,
                'message' => 'Pago procesado correctamente con Culqi',
                'charge_id' => $charge->id ?? null,
                'mediopago_id' => $mediopagoId,
                'total' => $request->total ?? 0,
                'venta_slug' => $venta->slug,
            ]);
        } catch (\Throwable $e) {
            logger()->error('Culqi charge error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al procesar pago con Culqi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Confirmación de pedido, parte final despues de realizar el pago
    public function confirmation(Request $request, Sale $sale)
    {
        if(Auth::check()){
            $clienteId = $this->resolveAuthenticatedCliente()?->id;

            if (!$clienteId) {
                return redirect()->route('ecommerce.index');
            }

            $dtlle_venta = Detailsale::where('sale_id', $sale->id)->get();
            $pedido = Pedido::where('id', $sale->pedido_id)->first();

            $productos_destacados = Producto::where('estado', 'Activo')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();


            return view('ECOMMERCE.carrito.confirmacion', compact('pedido','sale','dtlle_venta','productos_destacados'));
        }else{
            return redirect()->route('ecommerce.index');
        }

    }

    //codigo para generar el comprobante de compra en PDF
    public function comprobante_compra(Sale $sale)
    {
        $now = Carbon::now();
        $dtlle_venta = Detailsale::where('sale_id',$sale->id)->get();

        $tipos = [
            '1' => 'Factura',
            '2' => 'Boleta de Venta',
            '3' => 'Nota de Venta',
        ];

        $tipo_comprobante = $sale->tiposcomprobante_id;
        $tipo_label       = $tipos[$tipo_comprobante] ?? 'Comprobante';

        $pdf = Pdf::loadView('ECOMMERCE.carrito.comprobante_pago', ['sale'=>$sale, 'dtlle_venta'=>$dtlle_venta, 'now'=>$now, 'tipo_label'=>$tipo_label, 'tipo_comprobante'=>$tipo_comprobante]);
        return $pdf->stream('DETALLE-VENTA-'.$sale->codigo.'.pdf');
    }

    //agregar a la lista de deseos desde el detalle del producto o desde el carrito de compras
    public function getlista_deseo_carrito(Request $request)
    {
        if($request->ajax()){
            $id_element_producto = $request->id_element_producto;

            if(WishList::where('user_id', Auth::user()->id)->where('producto_id', $id_element_producto)->exists()){
                // El producto ya está en la lista de deseos

                $ArrayList[1] = ['deseo_ya_existe'];

                return response()->json($ArrayList);
            }else{
                $wishlist = new WishList();
                $wishlist->deseo = '1';
                $wishlist->user_id = Auth::user()->id;
                $wishlist->producto_id = $id_element_producto;
                $wishlist->save();

                $ArrayList[1] = ['deseo_guardado'];

                return response()->json($ArrayList);
            }
        }

    }

    //eliminar de la lista de deseos desde el detalle del producto o desde el carrito de compras o eliminar toda la lista de deseos
    public function geteliminarlista_deseo_carrito(Request $request)
    {
        if($request->ajax()){
            if($request->eliminar_todo == true){
                Wishlist::where('user_id', Auth::user()->id)->delete();
                $ArrayList[1] = ['lista_deseos_eliminada'];
                return response()->json($ArrayList);
            }else{
                $id_element_producto = $request->id_element_producto;
                
                Wishlist::where('user_id', Auth::user()->id)->where('producto_id', $id_element_producto)->delete();

                $ArrayList[1] = ['producto_eliminado_de_lista_deseos'];

                return response()->json($ArrayList);
            }
        }
    }

    //agregar productos al carrito de compras
    public function getagregar_compra_carritofavoritos(Request $request)
    {
        if($request->ajax()){
            if($request->ajax()){
                $id_element_producto = $request->id_element_producto;
                $carrito = session('carrito', []);

                // Check if product already exists in cart
                $exists = collect($carrito)->contains('producto_id', $id_element_producto);
                
                if($exists) {
                    $ArrayList[1] = ['producto_ya_en_carrito'];
                    return response()->json($ArrayList);
                }

                // Product not in cart, add it
                $product = DB::table('productos')->where('id', $id_element_producto)->first();

                $carrito[] = [
                    'slug' => $product->slug,
                    'ymdhis' => date('YmdHis'),
                    'name_producto' => $product->name,
                    'imagen_producto' => $product->imagen ? asset('images/productos/' . $product->imagen) : asset('images/logo.webp'),
                    'precio' => $product->precio,
                    'producto_id' => $product->id,
                    'cantidad' => $request->valor_cantidad ?? 1,
                    'precio_descuento' => $product->precio_descuento > 0 ? $product->precio_descuento : 0,
                    'porcentaje' => $product->porcentaje > 0 ? $product->porcentaje : 0,
                ];

                session(['carrito' => $carrito]);

                $ArrayList[1] = ['producto_agregado_al_carrito', count($carrito)];
                return response()->json($ArrayList);
            }

        }

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
            return redirect()->route('ecommerce_pago_carrito_compras.index')->with('error', 'El carrito está vacío');
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
                    'user_id'     => Auth::check() ? Auth::id() : null,
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
            $prefijoVta = 'VTA-' . date('Y') . '-';
            $ultimaVenta = Sale::where('codigo', 'like', $prefijoVta . '%')->orderBy('codigo', 'desc')->first();
            $numeroVenta = 1;
            if ($ultimaVenta && preg_match('/-(\d+)$/', $ultimaVenta->codigo, $matchesVta)) {
                $numeroVenta = intval($matchesVta[1]) + 1;
            }
            $codigoVenta = $prefijoVta . str_pad($numeroVenta, 5, '0', STR_PAD_LEFT);

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
            $venta = Sale::create([
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
                'estado' => 'pagado',
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
                Detailsale::create([
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

            return redirect()->route('ecommerce.confirmation', ['sale' => $venta->slug])
                ->with('success', 'Pedido realizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el pedido: ' . $e->getMessage());
        }
    }

    // Método auxiliar para obtener o crear carrito
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            // Usuario autenticado
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id()],
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

    private function resolveAuthenticatedCliente(): ?Cliente
    {
        if (!Auth::check()) {
            return null;
        }

        $cliente = Auth::user()->cliente;

        if ($cliente) {
            return $cliente;
        }

        $prospecto = Prospecto::where('registered_user_id', Auth::id())->first();
        if (!$prospecto) {
            return null;
        }

        $cliente = $prospecto->cliente()->first();
        if ($cliente && !$cliente->user_id) {
            $cliente->update(['user_id' => Auth::id()]);
        }

        return $cliente;
    }

    // Obtener cantidad de items en carrito (para header)
    public function getCartCount()
    {
        $cart = $this->getOrCreateCart();
        return response()->json(['count' => $cart->getTotalItems()]);
    }
}
