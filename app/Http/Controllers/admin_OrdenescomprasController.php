<?php

namespace App\Http\Controllers;

use App\Models\Ordencompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Detallecompra;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_OrdenescomprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_ordencompras = Ordencompra::all();
        return view('ADMINISTRADOR.compras.ocompras.index',compact('admin_ordencompras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $proveedores = Proveedor::where('estado','Activo')->get();
        return view('ADMINISTRADOR.compras.ocompras.create', compact('fecha_actual', 'proveedores'));
    }

    public function getBusqueda_compra_biene(Request $request){
        if($request->ajax()){
            $productos_values = Producto::whereHas('producto_proveedor', function($query) use ($request){
                $query->where('proveedor_id', $request->proveedor_ids);
            })->where('estado','Activo')->get();
            foreach($productos_values as $productos_value){
                    $Arrayprod[$productos_value->id] = [$productos_value->name, $productos_value->medida->nombre, $productos_value->tipo->name];
                
            }
            return response()->json($Arrayprod);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $now = Carbon::now();
        $ordenes = Ordencompra::orderBy('id','desc')->first();
        $nubRow =$ordenes?$ordenes->id+1:1;
        $codigos = $now->format('Ymd-').$nubRow.'-OC';
        $fecha_orden = $now->format('Y-m-d');

        $comp = Ordencompra::orderBy('id','desc')->first();
        
        $ordenC = new Ordencompra();
        // $ordenC->serie_compra = $codigsc;
        // $ordenC->correlativo_compra = $new_valor_correl;
        $ordenC->codigo = $codigos;
        $ordenC->slug = Str::slug($codigos);
        $ordenC->fecha = $fecha_orden;
        // $ordenC->codigo_solicitud = $request->input('codigo_solicitud');
        // $ordenC->registrado_por_compra = $request->input('registrado_por_compra');
        // $ordenC->definicion = $request->input('definicion');    
        // $ordenC->motivo = $request->input('motivo');
        // $ordenC->fecha_compra = $request->input('fecha_compra');
        $ordenC->total = $request->input('total');
        $ordenC->total_pago = $request->input('total');
        // $ordenC->sede_id = Auth::user()->persona->sede_id;
        $ordenC->tipo_moneda = $request->input('tipo_moneda');
        $ordenC->estado_proceso = 'Pendiente';
        // $ordenC->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->lastname_padre.' '.Auth::user()->persona->lastname_madre;
        $ordenC->registrado_por = 'usuario_admin';
        $ordenC->observacion = $request->input('observacion');
        $ordenC->proveedor_id = $request->input('proveedor_id');
        $ordenC->save();

        $tipo_producto = $request->input('tipo_producto');
        $bienes = $request->input('bienes');
        $bien_id = $request->input('bien_id');
        $cantidad = $request->input('cantidad');
        $precio = $request->input('precio');
        $tipo_impuesto_value = $request->input('tipo_impuesto_value');
        $medida = $request->input('medida');
        $subtotal = $request->input('subtotal');
        
        foreach ($bienes as $key => $name_producto) {

                $detalle = new Detallecompra();
                $detalle->producto = $bienes[$key];
                $detalle->producto_id = $bien_id[$key];
                $detalle->tipo_producto = $tipo_producto[$key];
                $detalle->umedida = $medida[$key];
                $detalle->cantidad = $cantidad[$key];
                $detalle->cantidadp_ingresar = $cantidad[$key];
                $detalle->precio = $precio[$key];
                $detalle->tipo_impuesto_value = $tipo_impuesto_value[$key];
                $detalle->subtotal = $subtotal[$key];
                $detalle->ordencompra_id = $ordenC->id;
                $detalle->save();
                
        }
        return redirect()->route('admin-ordencompras.index')->with('new_registration', 'ok');
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
