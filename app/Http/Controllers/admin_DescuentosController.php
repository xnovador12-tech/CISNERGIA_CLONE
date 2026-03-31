<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Detaildiscount;
use App\Models\Discount;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_DescuentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_descuentos = Discount::all();
        $admin_categorias = Category::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.descuentos.index',compact('admin_descuentos','admin_categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getfiltro_producto(Request $request)
    {

        if($request->ajax()){
            $descuentos_productos = DB::table('categories as cat')
                ->join('productos as prod','prod.categorie_id','=','cat.id')
                ->select('prod.name','prod.precio','prod.imagen','prod.slug','prod.id')
                ->where('prod.categorie_id',$request->categoria_id)
                ->get();
    
            foreach($descuentos_productos as $descuentos_producto){
                $Arraylist[$descuentos_producto->id] = [$descuentos_producto->name,$descuentos_producto->slug,$descuentos_producto->precio,$descuentos_producto->imagen ?? ''];
            }
            return response()->json($Arraylist);
        }
    }

    public function getver_descuento(Request $request)
    {
        if($request->ajax()){
            $fecha_actual = date('Y-m-d');
            if(DB::table('detail_discounts as detdis')->join('discounts as dis','dis.id','=','detdis.discount_id')->where('dis.estado','Activo')->exists()){
                    
                $detalle_descuento = DB::table('detail_discounts as detdis')
                        ->join('discounts as dis','dis.id','=','detdis.discount_id')
                        ->select('detdis.*','dis.titulo','dis.fecha_inicio','dis.fecha_fin')
                        ->where('dis.estado','Activo')
                        ->get();

                foreach($detalle_descuento as $detalle){
                    if($detalle->fecha_inicio <= $fecha_actual && $detalle->fecha_fin >= $fecha_actual){
                        // el descuento esta activo

                        $discuount = Discount::where('id',$detalle->discount_id)->first();
                        $discuount->estado = 'Activo';
                        $discuount->save();

                        $product = Producto::where('id',$detalle->producto_id)->first();
                        $product->precio = $detalle->precio;
                        $product->precio_descuento = $detalle->precio_descuento;
                        $product->porcentaje = $detalle->porcentaje;
                        $product->save();

                        $Arraylist[1] = ['existe'];

                    }else{
                        // el descuento ya no es valido
                        $discuount = Discount::where('id',$detalle->discount_id)->first();
                        $discuount->estado = 'Inactivo';
                        $discuount->save();

                        $product = Producto::where('id',$detalle->producto_id)->first();
                        $product->precio = $detalle->precio;
                        $product->precio_descuento = 0;
                        $product->porcentaje = 0;
                        $product->save();

                        $Arraylist[1] = ['no_existe'];
                    }
                }
            }else{
                $Arraylist[1] = ['no_existe'];
            }
            return response()->json($Arraylist);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('fecha_inicio') != '' && $request->input('hora_inicio') != '' && $request->input('fecha_fin') != '' && $request->input('hora_fin') != ''){
            $descuento = new Discount();
            $descuento->titulo = $request->input('titulo');
            $descuento->slug = Str::slug($request->input('titulo'));
            $descuento->fecha_inicio = $request->input('fecha_inicio');
            $descuento->fecha_fin = $request->input('fecha_fin');
            $descuento->estado = 'Activo';
            $descuento->categorie_id = $request->input('categorie_id');
            $descuento->save();
    
            $producto_id = $request->input('producto_id');
            $codigo_producto = $request->input('codigo_producto');
            $precio = $request->input('precio');
            $porcentajes = $request->input('porcentaje');
            $fecha_inicios = $request->input('fecha_inicios');
            $fecha_finales = $request->input('fecha_finales');
    
            foreach ($producto_id as $key => $name) {
                $detalle = new Detaildiscount();
                $detalle->discount_id  = $descuento->id;
                $detalle->precio = $precio[$key];
                $detalle->porcentaje = $porcentajes[$key];
                $detalle->precio_descuento = $detalle->precio - ($detalle->precio*($detalle->porcentaje/100));
                $detalle->producto_id  = $producto_id[$key];
                $detalle->codigo_producto = $codigo_producto[$key];
                $detalle->fecha_inicio = $fecha_inicios[$key];
                $detalle->fecha_fin = $fecha_finales[$key];
                $detalle->save();

                $product = Producto::where('id',$producto_id[$key])->first();
                $product->precio = $detalle->precio;
                $product->precio_descuento = $detalle->precio_descuento;
                $product->porcentaje = $detalle->porcentaje;
                $product->save();
            }
    
            return redirect()->route('admin-descuentos.index')->with('new_registration', 'ok');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $admin_descuento)
    {
        if($request->input('fecha_inicio') != '' && $request->input('fecha_fin') != ''){
            $admin_descuento->fecha_inicio = $request->input('fecha_inicio');
            $admin_descuento->fecha_fin = $request->input('fecha_fin');
            $admin_descuento->estado = 'Activo';
            $admin_descuento->save();

            $producto_id = $request->input('producto_id');
            $codigo_producto = $request->input('codigo_producto');
            $precio = $request->input('precio');
            $porcentajes = $request->input('porcentajes');
            $fecha_inicios = $request->input('fecha_inicios') != ''?$request->input('fecha_inicios'):$request->input('fecha_inicios'). ' 00:00:00';
            $fecha_finales = $request->input('fecha_finales') != ''?$request->input('fecha_finales'):$request->input('fecha_finales'). ' 23:59:59';

            $detalle = Detaildiscount::where('discount_id',$admin_descuento->id)->get();

            foreach ($detalle as $key => $name) {
                $detalle->discount_id  = $admin_descuento->id;
                $detalle->precio = $precio[$key];
                $detalle->porcentaje = $porcentajes[$key];
                $detalle->precio_descuento = $detalle->precio - ($detalle->precio*($detalle->porcentaje/100));
                $detalle->producto_id  = $producto_id[$key];
                $detalle->codigo_producto = $codigo_producto[$key];
                $detalle->fecha_inicio = $fecha_inicios[$key];
                $detalle->fecha_fin = $fecha_finales[$key];
                $detalle->save();

                $product = Producto::where('id',$producto_id[$key])->first();
                $product->precio = $detalle->precio;
                $product->precio_descuento = $detalle->precio_descuento;
                $product->porcentaje = $detalle->porcentaje;
                $product->save();
            }
        }

        return redirect()->route('admin-descuentos.index')->with('update', 'ok');
    }

    public function estado(Request $request, Discount $admin_descuento)
     {         
        $admin_descuento->estado = $admin_descuento->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_descuento->save();

        $dtail_discount = Detaildiscount::where('discount_id',$admin_descuento->id)->get();
        foreach($dtail_discount as $dtail_discounts){
            $product = Producto::where('id',$dtail_discounts->producto_id)->first();
            if($admin_descuento->estado === 'Activo'){
                $product->precio = $dtail_discounts->precio;
                $product->precio_descuento = $dtail_discounts->precio_descuento;
                $product->porcentaje = $dtail_discounts->porcentaje;
            }else{
                $product->precio = $dtail_discounts->precio;
                $product->precio_descuento = 0;
                $product->porcentaje = 0;
            }
            $product->save();
        }

        return redirect()->back()->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $admin_descuento)
    {
        if($admin_descuento){
            $dtail_discount = Detaildiscount::where('discount_id',$admin_descuento->id)->get();
            foreach($dtail_discount as $dtail_discounts){
                $product = Producto::where('id',$dtail_discounts->producto_id)->first();
                $product->precio_descuento = 0;
                $product->porcentaje = 0;
                $product->save();
            }
            $admin_descuento->delete();
        }

        return redirect()->route('admin-descuentos.index')->with('delete', 'ok');
    }
}
