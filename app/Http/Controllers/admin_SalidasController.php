<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Detallemovimiento;
use App\Models\Detallesalida;
use App\Models\Inventario;
use App\Models\Motivo;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Salida;
use App\Models\Sale;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class admin_SalidasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_salidas = Movimiento::where('tipo_movimiento', 'SALIDA')->get();
        return view('ADMINISTRADOR.ALMACEN.salidas.index',compact('admin_salidas'));
    }

    public function salida_general(Request $request){
        $fi = $request->fecha_inicio. ' 00:00:00';
        $ff = $request->fecha_fin. ' 23:59:59';
        $admin_salidas = Movimiento::where('tipo_movimiento', 'SALIDA')->whereBetween('created_at', [$fi, $ff])->get();
        return view('ADMINISTRADOR.ALMACEN.salidas.index',compact('admin_salidas'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $ingresos = Movimiento::where('tipo_movimiento', 'SALIDA')->orderBy('id','desc')->first();
        $nubRow =$ingresos?$ingresos->id+1:1;
        $codigo = 'MS'.$now->format('Ymd').''.$nubRow;

        $almacen = Almacen::all();
        $motivos = Motivo::all();
        $fecha_actual = Carbon::now();

        $venta = Sale::whereIn('estado', ['pagado', 'parcial'])->where('estado_msalida','=','0')->get();
        $clientes = Cliente::all();
        // $ocompra = DB::table('ordenescompras')->select('codigo')->where('estado','!=','Inventariado')->get();

        return view('ADMINISTRADOR.ALMACEN.salidas.create',compact('codigo','almacen','motivos','fecha_actual','venta','clientes'));
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
            }if($request->valormotivo == 'Merma' || $request->valormotivo == 'Robo o perdida' || $request->valormotivo == 'Muestra'){
                $producto_inventario = Inventario::where('almacen_id',$request->valor_almacen)->get();

                foreach($producto_inventario as $producto_inventarios){
                    $valor_producto = Producto::where('id',$producto_inventarios->id_producto)->first();

                    $Arraypt[$producto_inventarios->id] = [$valor_producto->codigo, $producto_inventarios->producto, $producto_inventarios->id_producto, $valor_producto->categorie->name, $valor_producto->vida_util, $valor_producto->medida->nombre, $valor_producto->tipo->name, $producto_inventarios->precio];
                }
            }
            return response()->json($Arraypt);
        }
    }

    public function getbusqueda_inventarios(Request $request){
        if($request->ajax()){
            $list_inventario = Inventario::where('id_producto',$request->valor_id_producto)->where('almacen_id',$request->valor_almacen)->get();

            foreach($list_inventario as $list_inventarios){
                $Arraylist[$list_inventarios->id] = [$list_inventarios->umedida,$list_inventarios->cantidad,$list_inventarios->precio];
            }
            return response()->json($Arraylist);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salidas = new Movimiento();
        $salidas->codigo = $request->input('codigo');
        $salidas->slug = Str::slug($request->input('codigo'));
        $salidas->motivo = $request->input('motivo');
        $salidas->fecha = $request->input('fecha');
        $salidas->tipo_movimiento = 'SALIDA';
        $salidas->descripcion = $request->input('descripcion');
        $salidas->total = $request->input('total');
        $salidas->almacen_id = $request->input('id_almacen');
        if($salidas->motivo == 'Venta'){
            $valor_venta = Sale::where('id',$request->input('id_venta'))->first();
            $salidas->codigo_venta = $valor_venta->codigo;
        }
        if($salidas->motivo == 'Muestra'){
            $salidas->cliente = $request->input('cliente');;
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
        $producto = $request->input('producto');
        $medida_producto = $request->input('medida');
        $cantidad_producto = $request->input('cantidad');
        $precio_producto = $request->input('precio');

        if(isset($producto_id)){
            foreach ($producto_id as $key => $name) {
                $valor_producto = Producto::where('id',$producto_id[$key])->first();

                $detallesalida = new Detallemovimiento();
                $detallesalida->movimiento_id = $salidas->id;
                $detallesalida->id_producto = $producto_id[$key];
                $detallesalida->tipo_producto = $valor_producto->tipo->name;
                $detallesalida->producto = $producto[$key];
                $detallesalida->umedida = $medida_producto[$key];
                $detallesalida->cantidad = $cantidad_producto[$key];
                $detallesalida->precio = $precio_producto[$key];
                $detallesalida->save();

                if(Inventario::where('id_producto',$producto_id[$key])->where('tipo_producto',$valor_producto->tipo->name)->exists()){
                    $almacen_producto = Inventario::where('id_producto',$producto_id[$key])->where('tipo_producto',$valor_producto->tipo->name)->first();

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
    public function show(Request $request, Movimiento $admin_salida)
    {
        $admin_dtlle = Detallemovimiento::where('movimiento_id', $admin_salida->id)->get();
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

    // Reporte para ver de forma general por fecha - pdf
    public function reporteSalidasPrintPdfSede(Request $request)
    {
        $now = Carbon::now();
        $fi = $request->fecha_ini. ' 00:00:00';
        $ff = $request->fecha_fin. ' 23:59:59';
        $name_sede = Sede::where('id', 1)->first();
        $salidas = Movimiento::where('tipo_movimiento', 'SALIDA')->whereBetween('created_at', [$fi, $ff])->where('sede_id', "=", $name_sede->id)->get();
        $pdf = PDF::loadView('ADMINISTRADOR.REPORTES.movimiento-salidas.pdf.movsalidaPDF', ['salidas'=>$salidas, 'fi'=>$fi, 'ff'=>$ff, 'now'=>$now, 'name_sede'=>$name_sede]);
        return $pdf->stream('MOVIMIENTOS-SALIDA - '.$name_sede->name.'.pdf');
    }
    // 

    // Reporte para ver de forma individual
    public function getSalidapdf(Movimiento $admin_salida)
    {
        $now = Carbon::now();
        $dtlle_salida = Detallemovimiento::where('movimiento_id',$admin_salida->id)->get();
        $pdf = Pdf::loadView('ADMINISTRADOR.REPORTES.movimiento-salidas.pdf.detalle_movsalidaPDF', ['admin_salida'=>$admin_salida, 'dtlle_salida'=>$dtlle_salida, 'now'=>$now]);
        return $pdf->stream('DETALLE-MOVIMIENTO-SALIDA-'.$admin_salida->codigo.'.pdf');
    }
    // 
}
