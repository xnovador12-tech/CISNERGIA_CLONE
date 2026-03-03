<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Detallecompra;
use App\Models\Etiqueta;
use App\Models\Inventario;
use App\Models\Marca;
use App\Models\Medida;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class admin_ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_productos = Producto::all();
        $categorias = Category::where('estado', 'Activo')->get();
        $medidas = Medida::where('estado', 'Activo')->get();
        $marcas = Marca::where('estado', 'Activo')->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.productos.index', compact(
            'admin_productos',
            'categorias',
            'medidas',
            'marcas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $marcas = Marca::all()->where('estado', 'Activo');
        $tipos = Tipo::all()->where('estado', 'Activo')->where('id','!=',3);
        $etiquetas = Etiqueta::all()->where('estado', 'Activo');
        $medidas = Medida::all()->where('estado', 'Activo');
        $modelos = Modelo::all()->where('estado', 'Activo');
        $proveedores = Proveedor::where('estado', 'Activo')->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.productos.create',compact('tipos','marcas','etiquetas','medidas','modelos','proveedores'));
    }

    public function getbusqueda_codigo_producto(Request $request){
        if($request->ajax()){
            $now = Carbon::now()->format('dmY');
            $valor_tipo = Tipo::where('id',$request->tipo_val)->first();

            if(Category::where('id',$request->cate_val)->exists()){
                $valor_categoria = Category::where('id',$request->cate_val)->first();
            }else{
                $valor_categoria = '';
            }

            $cantidad_productos_tipo = Producto::where('tipo_id', $valor_tipo->id)->count();
            $orden_registro_producto = $cantidad_productos_tipo + 1;

            // validacion para igualar la palabra de tipo y categoria y excluir palabras comunes
            $nombre_tipo = (string) ($valor_tipo->name ?? '');
            $nombre_categoria = (string) ($valor_categoria->name ?? '');

            $palabras_excluidas = ['de'];

            $normalizar_palabras = function (string $texto) use ($palabras_excluidas): array {
                $texto = Str::lower(Str::ascii($texto));
                $texto = preg_replace('/[^a-z0-9\s]/', ' ', $texto);
                $partes = preg_split('/\s+/', trim($texto));

                return array_values(array_filter(
                    $partes,
                    fn($palabra) => $palabra !== '' && !in_array($palabra, $palabras_excluidas, true)
                ));
            };

            $palabras_tipo = $normalizar_palabras($nombre_tipo);
            $palabras_categoria_original = preg_split('/\s+/', trim($nombre_categoria));

            $palabras_categoria_no_coinciden = array_values(array_filter(
                $palabras_categoria_original,
                function ($palabra) use ($palabras_tipo, $palabras_excluidas) {
                    $palabra_normalizada = Str::lower(Str::ascii((string) $palabra));
                    return $palabra_normalizada !== ''
                        && !in_array($palabra_normalizada, $palabras_excluidas, true)
                        && !in_array($palabra_normalizada, $palabras_tipo, true);
                }
            ));

            $categoria_diferente = implode(' ', $palabras_categoria_no_coinciden);
            // Fin de cogio de validacion de palabras iguales y exclusión de palabras comunes


            $prefijo_tipo = Str::upper(Str::substr($nombre_tipo, 0, 3));
            $prefijo_categoria = $categoria_diferente !== ''
                ? Str::upper(Str::substr($categoria_diferente, 0, 3))
                : ($nombre_categoria !== '' ? Str::upper(Str::substr($nombre_categoria, 0, 3)) : '000');

            $valor_codigo = $prefijo_tipo.''.$prefijo_categoria.''.(substr((string) $now, -2)).'_'.$orden_registro_producto;

            $Arraylist[1] = [Str::upper($valor_codigo)];

            return response()->json($Arraylist);
        }
    }

    public function getBusqueda_categoria_productos(Request $request){
        if($request->ajax()){
            $categorias = DB::table('categories')
            ->where('categories.tipo_id',$request->valor_bienes)
            ->where('categories.estado','Activo')
            ->get();

            foreach($categorias as $categoria){
                $ArrayCategoria[$categoria->id] = [$categoria->name];
            }

            return response()->json($ArrayCategoria);
        }
    }

    public function getBusquedaproved(Request $request){
        if($request->ajax()){
            $proveedores = DB::table('personas as pe')->join('proveedors as prov','prov.persona_id','=','pe.id')
            ->join('proveedor_tipo as provt','provt.proveedor_id','=','prov.id')
            ->select('prov.id','pe.name','prov.name_contacto')->where('provt.tipo_id', $request->valor_tip)->where('prov.estado','Activo')->get();

            foreach($proveedores as $proveedor){
                $ArrayProve[$proveedor->id] = ['RS: '.$proveedor->name_contacto.' || PN: '.$proveedor->name];
            }

            return response()->json($ArrayProve);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $img_producto = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/productos/', $img_producto);
        }else{
            $img_producto = '';
        }
        $tipo_value = Tipo::where('id',$request->input('tipo_id'))->first();
        // condicion para guardar el nombre de las imagenes opcionales
        $urlimagenes = [];
        if ($request->hasFile('images_opcional')){
            $imagenes = $request->file('images_opcional');
            foreach ($imagenes as $imagen) {
                $nombre = time().'_'.$imagen->getClientOriginalName();
                $imagen->move(public_path().'/images/productos-opcional/', $nombre);
                $urlimagenes[]['url']='/images/productos-opcional/'.$nombre;
            }
        }
        
        $producto = new Producto();
        $producto->codigo = $request->input('codigo');
        $producto->slug = Str::slug($request->input('codigo'));
        $producto->name = $request->input('name');
        $producto->medida_id = $request->input('medida_id');
        $producto->categorie_id = $request->input('categorie_id');
        $producto->peso = $request->input('peso');
        $producto->costo = $request->input('costo');
        $producto->precio = $request->input('precio');
        $producto->precio_descuento = $request->input('precio_descuento');
        $producto->tipo_id = $request->input('tipo_id');
        $producto->vida_util = $request->input('vida_util');
        $producto->depreciacion = $request->input('depreciacion');
        $producto->tipo_adquisicion = $request->input('tipo_adquisicion');
        $producto->marca_id = $request->input('marca_id');
        $producto->modelo_id = $request->input('modelo_id');
        $producto->datos = $request->input('datos');
        $producto->garantias = $request->input('garantias');
        $producto->ficha_tecnica = $request->input('ficha_tecnica');
        $producto->descripcion = $request->input('descripcion');
        $producto->fabricante = $request->input('fabricante');
        $producto->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->surnames;
        $producto->estado = 'Inactivo';
        $producto->imagen = $img_producto;
        $producto->sede_id = Auth::user()->persona->sede_id;
        $producto->save();
        
        if($request->input('etiquetas')){
            $producto->etiquetas()->attach($request->input('etiquetas'));
        }
        // guardar las imagenes opcionales
        $producto->images()->createMany($urlimagenes);

        if($request->input('proveedores')){
            $producto->proveedores()->attach($request->input('proveedores'));
        }

        return redirect()->route('admin-productos.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $admin_producto)
    {
        $etiquetas = Etiqueta::where('estado', 'Activo')->get();
        $proveedores = Proveedor::where('estado', 'Activo')->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.productos.show', compact('admin_producto', 'etiquetas', 'proveedores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $admin_producto)
    {
        $marcas = Marca::all()->where('estado', 'Activo');
        $tipos = Tipo::all()->where('estado', 'Activo')->where('definicion','!=','Servicios');
        $etiquetas = Etiqueta::all()->where('estado', 'Activo');
        $medidas = Medida::all()->where('estado', 'Activo');
        $proveedores = Proveedor::where('estado', 'Activo')->get();
        $categorias = Category::where('estado', 'Activo')->get();
        $modelos = Modelo::all()->where('estado', 'Activo');

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.productos.edit', compact('admin_producto', 'etiquetas', 'proveedores','categorias','marcas','tipos','medidas','modelos'));
    }

    public function getbusqueda_proved_edit(Request $request){
        if($request->ajax()){
            $proveedores = DB::table('personas as pe')->join('proveedors as prov','prov.persona_id','=','pe.id')
            ->join('proveedor_tipo as provt','provt.proveedor_id','=','prov.id')
            ->select('prov.id','pe.name','prov.name_contacto')->where('provt.tipo_id', $request->valor_tip)->where('prov.estado','Activo')->get();

            foreach($proveedores as $proveedor){
                if($proveedor){
                    $provd_exits = DB::table('producto_proveedor')->select('producto_proveedor.producto_id')
                    ->where('producto_proveedor.producto_id',$request->valor_id_prod)
                    ->where('producto_proveedor.proveedor_id',$proveedor->id)
                    ->exists();
                }else{
                    $provd_exits = '';
                }
                $ArrayProve[$proveedor->id] = ['RS: '.$proveedor->name_contacto.' || PN: '.$proveedor->name,$provd_exits];
            }

            return response()->json($ArrayProve);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $admin_producto)
    {
        // condicion para guardar el nombre de las imagenes opcionales
        $urlimagenes = [];
        if ($request->hasFile('images_opcional')){
            $imagenes = $request->file('images_opcional');
            foreach ($imagenes as $imagen) {
                $nombre = time().'_'.$imagen->getClientOriginalName();
                $imagen->move(public_path().'/images/productos-opcional/', $nombre);
                $urlimagenes[]['url']='/images/productos-opcional/'.$nombre;
            }
        }
        
        $admin_producto['slug'] = Str::slug($request->input('name'));
        $admin_producto->fill($request->except('imagen'));
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $imagen = time().$file->getClientOriginalName();
            if ($admin_producto->imagen) {
                $file_path = public_path(). '/images/productos/'.$admin_producto->imagen;
                File::delete($file_path);
                $admin_producto->update([
                    $admin_producto->imagen = $imagen,
                    $file->move(public_path().'/images/productos/', $imagen)
                ]);
            }else{
                $admin_producto['imagen'] = $admin_producto->imagen;
            }
        }

        $admin_producto->fill($request->except(['codigo', 'slug']));
        $admin_producto->precio_descuento = $request->input('precio_descuento');
        $admin_producto->save();

        if($request->input('etiquetas')){
            $admin_producto->etiquetas()->detach();
            $admin_producto->etiquetas()->attach($request->input('etiquetas'));
        }

        if($request->input('proveedores')){
            $admin_producto->proveedores()->detach();
            $admin_producto->proveedores()->attach($request->input('proveedores'));
        }
        
        // guardar las imagenes opcionales
        $admin_producto->images()->createMany($urlimagenes);

        return redirect()->route('admin-productos.index')->with('update', 'ok');
    }

    public function estado(Request $request, Producto $admin_producto)
    {
        $admin_producto->estado = $admin_producto->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_producto->save();

        return redirect()->route('admin-productos.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $admin_producto)
    {
        if(Detallecompra::where('producto_id',$admin_producto->id)->exists() || Inventario::where('id_producto',$admin_producto->id)->exists()){
            return redirect()->route('admin-productos.index')->with('error', 'ok');
        }else{
            Producto::destroy($admin_producto->id);
            return redirect()->route('admin-productos.index')->with('delete', 'ok');
        }
    }
}
