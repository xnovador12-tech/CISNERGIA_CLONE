<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Detallecompra;
use App\Models\Ingreso;
use App\Models\Motivo;
use App\Models\Ordencompra;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
