<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Etiqueta;
use App\Models\Marca;
use App\Models\Medida;
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
        $productos = Producto::orderBy('id','desc')->first();
        $nubRow =$productos?$productos->id+1:1;
        $codigo = 'PR-'.$now->format('Ymd').'-'.$nubRow;

        $marcas = Marca::all()->where('estado', 'Activo');
        $tipos = Tipo::all()->where('estado', 'Activo');
        $etiquetas = Etiqueta::all()->where('estado', 'Activo');
        $medidas = Medida::all()->where('estado', 'Activo');
        $proveedores = Proveedor::where('estado', 'Activo')->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.productos.create',compact('productos','tipos','marcas','etiquetas','medidas','proveedores','codigo'));
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

        if($request->input('tipo_id') == 1){
            $producto->tipo_id = '1';
        }if($request->input('tipo_id') == 2){
            $producto->tipo_id = '2';
            $producto->vida_util = $request->input('vida_util');
            $producto->depreciacion = $request->input('depreciacion');
            
            $producto->tipo_adquisicion = $request->input('tipo_adquisicion');
        }if($request->input('tipo_id') == 3){
            $producto->tipo_id = '3';
            $producto->tipo_afectacion = $request->input('tipo_afectacion');
        }

        $producto->marca_id = $request->input('marca_id');
        $producto->descripcion = $request->input('descripcion');
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

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.productos.edit', compact('admin_producto', 'etiquetas', 'proveedores','categorias','marcas','tipos','medidas'));
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
        Producto::destroy($admin_producto->id);
        return redirect()->route('admin-productos.index')->with('delete', 'ok');
    }
}
