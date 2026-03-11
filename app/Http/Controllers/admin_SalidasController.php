<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Detallesalida;
use App\Models\Inventario;
use App\Models\Motivo;
use App\Models\Producto;
use App\Models\Salida;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_SalidasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_salidas = Salida::all();
        return view('ADMINISTRADOR.ALMACEN.salidas.index',compact('admin_salidas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $ingresos = Salida::orderBy('id','desc')->first();
        $nubRow =$ingresos?$ingresos->id+1:1;
        $codigo = 'MS'.$now->format('Ymd').''.$nubRow;

        $almacen = Almacen::all();
        $motivos = Motivo::all();
        $fecha_actual = Carbon::now();

        $venta = Sale::where('estado','=','completada')->where('estado_msalida','=','0')->get();
        // $ocompra = DB::table('ordenescompras')->select('codigo')->where('estado','!=','Inventariado')->get();

        return view('ADMINISTRADOR.ALMACEN.salidas.create',compact('codigo','almacen','motivos','fecha_actual','venta'));
    }

    public function getbusqueda_producto_inventario(Request $request){
        if($request->ajax()){
            if($request->valormotivo == 'Venta'){
                $list_venta = DB::table('detail_sales as dts')->join('sales as sl','sl.id','=','dts.sale_id')->select('dts.producto_id')->where('tipo','producto')->where('sl.id',$request->valor_venta)->get();

                foreach($list_venta as $list_ventas){
                    $producto_inventarios = Inventario::where('id_producto',$list_ventas->producto_id)->first();
                    $valor_producto = Producto::where('id',$producto_inventarios->id_producto)->first();

                    $Arraypt[$producto_inventarios->id] = [$valor_producto->codigo, $producto_inventarios->producto, $producto_inventarios->id_producto, $valor_producto->categorie->name, $valor_producto->vida_util, $valor_producto->medida->nombre, $valor_producto->tipo->name, $producto_inventarios->precio];

                }
            }if($request->valormotivo == 'Merma' || $request->valormotivo == 'Robo o perdida'){
                $producto_inventario = Inventario::where('almacen_id',$request->valor_almacen)->get();

                foreach($producto_inventario as $producto_inventarios){
                    $valor_producto = Producto::where('id',$producto_inventarios->id_producto)->first();

                    $Arraypt[$producto_inventarios->id] = [$valor_producto->codigo, $producto_inventarios->producto, $producto_inventarios->id_producto, $valor_producto->categorie->name, $valor_producto->vida_util, $valor_producto->medida->nombre, $valor_producto->tipo->name, $producto_inventarios->precio];
                }
            }
            return response()->json($Arraypt);
        }
    }

    public function getbusqueda_lotes(Request $request){
        if($request->ajax()){
            $lotes = Inventario::where('id_producto',$request->valor_id_producto)->where('almacen_id',$request->valor_almacen)->get();

            foreach($lotes as $lote){
                $Arraylist[$lote->id] = [$lote->lote, $lote->umedida,$lote->cantidad,$lote->precio];
            }
            return response()->json($Arraylist);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salidas = new Salida();
        $salidas->codigo = $request->input('codigo');
        $salidas->slug = Str::slug($request->input('codigo'));
        $salidas->motivo = $request->input('motivo');
        $salidas->fecha = $request->input('fecha');
        $salidas->descripcion = $request->input('descripcion');
        $salidas->total_producto = $request->input('total');
        $salidas->almacen_id = $request->input('id_almacen');
        if($salidas->motivo == 'Venta'){
            $valor_venta = Sale::where('id',$request->input('id_venta'))->first();
            $salidas->codigo_venta = $valor_venta->codigo;
        }
        if(Auth::user()->id == 1 || Auth::user()->id == 2){
            $salidas->sede_id = 1;
            $salidas->registrado_por = 'ADMINISTRADOR GENERAL';
        } else {
            $salidas->sede_id = Auth::user()->persona->sede_id;
            $salidas->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->surnames;
        }
        $salidas->save();
        
        if($salidas->motivo == 'Venta'){
            $valor_venta->estado_msalida = '1';
            $valor_venta->save();
        }

        $producto_id = $request->input('producto_id');
        $producto_tipo_id = $request->input('producto_tipo_id');
        $producto = $request->input('producto');
        $lote_producto = $request->input('lote');
        $medida_producto = $request->input('medida');
        $cantidad_producto = $request->input('cantidad');
        $precio_producto = $request->input('precio');

        if(isset($producto_id)){
            foreach ($producto_id as $key => $name) {
                $valor_producto = Producto::where('id',$producto_id[$key])->first();

                $detallesalida = new Detallesalida();
                $detallesalida->salida_id = $salidas->id;
                $detallesalida->codigo = $valor_producto->codigo;
                $detallesalida->producto = $producto[$key];
                $detallesalida->producto_id = $producto_id[$key];
                $detallesalida->categoria = $valor_producto->categorie->name;
                $detallesalida->vida_util = $valor_producto->vida_util;
                $detallesalida->umedida = $medida_producto[$key];
                $detallesalida->cantidad = $cantidad_producto[$key];
                $detallesalida->tipo_id = $valor_producto->tipo_id;
                $detallesalida->lote = $lote_producto[$key];
                $detallesalida->precio = $precio_producto[$key];
                $detallesalida->areaalmacen_id = $salidas->almacen_id;
                $detallesalida->save();

                if(Inventario::where('id_producto',$producto_id[$key])->where('lote',$lote_producto[$key])->where('tipo_producto',$valor_producto->tipo->name)->exists()){
                    $almacen_producto = Inventario::where('id_producto',$producto_id[$key])->where('lote',$lote_producto[$key])->where('tipo_producto',$valor_producto->tipo->name)->first();

                    if($almacen_producto){
                        $almacen_producto->cantidad = $almacen_producto->cantidad - $cantidad_producto[$key];
                        $almacen_producto->save();
                    }
                }
            }
        }

        return redirect()->route('admin-salidas.index')->with('new_registration', 'ok');
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, Salida $admin_salida)
    {
        $admin_dtlle = Detallesalida::where('salida_id', $admin_salida->id)->get();
        return view('ADMINISTRADOR.ALMACEN.salidas.show', compact('admin_salida', 'admin_dtlle'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
