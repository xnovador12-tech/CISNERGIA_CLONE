<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Detallecompra;
use App\Models\Ingreso;
use App\Models\Motivo;
use App\Models\Ordencompra;
use App\Models\Producto;
use App\Models\Detalleingreso;
use App\Models\Inventario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_IngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_ingresos = Ingreso::all();
        return view('ADMINISTRADOR.ALMACEN.ingresos.index',compact('admin_ingresos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $ingresos = Ingreso::orderBy('id','desc')->first();
        $nubRow =$ingresos?$ingresos->id+1:1;
        $codigo = 'MI'.$now->format('Ymd').''.$nubRow;

        $almacen = Almacen::all();
        $motivos = Motivo::all();
        $fecha_actual = Carbon::now();

        $ocompra = DB::table('ordenescompras')->select('codigo')->where('estado','!=','Inventariado')->get();

        return view('ADMINISTRADOR.ALMACEN.ingresos.create', compact('motivos', 'fecha_actual', 'codigo', 'almacen', 'ocompra'));
    }

    public function getbusqueda_det_oc(Request $request){
        if($request->ajax()){
            $or_compra = Ordencompra::where('estado','!=','Inventariado')->where('codigo',$request->codigo_orden)->first();
            $dtlle_compra = Detallecompra::where('ordencompra_id',$or_compra->id)->get();

            foreach($dtlle_compra as $dtlle_compras){
                $Arraydtc[$dtlle_compras->id] = [$dtlle_compras->producto_id,$dtlle_compras->producto, $dtlle_compras->tipo_producto, $dtlle_compras->umedida, $dtlle_compras->cantidad,$dtlle_compras->precio, $dtlle_compras->cantidadp_ingresar];
            }

            return response()->json($Arraydtc);
        }
    }

    public function getbusqueda_pterminado(Request $request){
        if($request->ajax()){
            if($request->pterm){
                $producto_terminado = Producto::where('tipo_id',3)->get();
                foreach($producto_terminado as $prod_terminado){
                    $Arraypt[$prod_terminado->id] = [$prod_terminado->nombre,$prod_terminado->tipo->name, $prod_terminado->medida->name, '0', $prod_terminado->precio,'0'];
                }
                return response()->json($Arraypt);
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ingresos = new Ingreso();
        $ingresos->codigo = $request->input('codigo');
        $ingresos->slug = Str::slug($request->input('codigo'));
        $ingresos->motivo = $request->input('motivo');
        $ingresos->fecha = $request->input('fecha');
        if($request->input('motivo') == 'Inventario'){
            $ingresos->codigo_ocompra = $request->input('codigo_ocompra');

            $orden_c = Ordencompra::where('codigo',$request->input('codigo_ocompra'))->first();
            if($orden_c->estado == 'Pendiente' || $orden_c->estado == 'En progreso'){
                $orden_c->estado = 'Inventariado';
            }elseif($orden_c->estado == 'Inventariado'){
                $orden_c->estado = 'Inventariado';
            }else{
                $orden_c->estado = 'Pendiente';
            }
            $orden_c->save();
        }

        $ingresos->total = $request->input('total');
        $ingresos->descripcion = $request->input('descripcion');
        $ingresos->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->surnames;
        $ingresos->almacen_id = $request->input('id_almacen');
        $ingresos->sede_id = Auth::user()->persona->sede_id;
        $ingresos->save();

        $producto_id = $request->input('producto_id');
        $producto_tipo_id = $request->input('producto_tipo_id');
        $producto = $request->input('producto');
        $lote_producto = $request->input('lote');
        $medida_producto = $request->input('medida');
        $cantidad_producto = $request->input('cantidad');
        $precio_producto = $request->input('precio');

        if(isset($producto_id)){
            foreach ($producto_id as $key => $name) {
                $cod_prod = Producto::where('id',$producto_id[$key])->first(); 
                
                $detalleingreso = new Detalleingreso();
                $detalleingreso->ingreso_id = $ingresos->id;
                $detalleingreso->id_producto = $producto_id[$key];
                $detalleingreso->tipo_producto = $producto_tipo_id[$key];
                $detalleingreso->producto = $producto[$key];
                $detalleingreso->lote = $lote_producto[$key];
                $detalleingreso->umedida = $medida_producto[$key];
                $detalleingreso->cantidad = $cantidad_producto[$key];
                $detalleingreso->precio = $precio_producto[$key];
                $detalleingreso->save();

                if($request->input('motivo') == 'Inventario'){
                    if(Inventario::where('id_producto',$producto_id[$key])->where('lote',$lote_producto[$key])->where('tipo_producto',$producto_tipo_id[$key])->exists()){
                        $almacen_producto = Inventario::where('id_producto',$producto_id[$key])->where('lote',$lote_producto[$key])->where('tipo_producto',$producto_tipo_id[$key])->first();
    
                        if($almacen_producto){
                            $almacen_producto->cantidad = $almacen_producto->cantidad + $cantidad_producto[$key];
                            $almacen_producto->save();
                        }
                    }else{
                        $almacen_producto = new Inventario();
                        $almacen_producto->id_producto = $producto_id[$key];
                        $almacen_producto->tipo_producto = $producto_tipo_id[$key];
                        $almacen_producto->producto = $producto[$key];
                        $almacen_producto->lote = $lote_producto[$key];
                        $almacen_producto->umedida = $medida_producto[$key];
                        $almacen_producto->cantidad = $cantidad_producto[$key];
                        $almacen_producto->precio = $precio_producto[$key];
                        $almacen_producto->almacen_id = $request->input('id_almacen');
                        $almacen_producto->sede_id = Auth::user()->persona->sede_id;
                        $almacen_producto->save();
                    }
                }
            }
        }

        return redirect()->route('admin-ingresos.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ingreso $admin_ingreso)
    {
        $admin_dtlle = Detalleingreso::where('ingreso_id', $admin_ingreso->id)->get();
        return view('ADMINISTRADOR.ALMACEN.ingresos.show', compact('admin_ingreso', 'admin_dtlle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Ingreso $admin_ingreso)
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
