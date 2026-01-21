<?php

namespace App\Http\Controllers;

use App\Models\Detalleoservicio;
use App\Models\Ordenservicio;
use App\Models\Formapago;
use App\Models\Producto;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_OrdenesserviciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_ordenservicios = Ordenservicio::all();
        return view('ADMINISTRADOR.compras.oservicios.index',compact('admin_ordenservicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();

        $ordens = Ordenservicio::orderBy('id','desc')->first();
        $nubRow =$ordens?$ordens->id+1:1;
        $codigo = 'ORDS-'.$now->format('Ymd').$nubRow;

        $fecha_actual = Carbon::now();
        $clientes = DB::table('personas as per')->join('users as us','us.persona_id','=','per.id')->join('clientes as cli','cli.user_id','=','us.id')->select('cli.id','per.name','per.surnames')->get();
        $forma_pago = Formapago::all();

        return view('ADMINISTRADOR.compras.oservicios.create', compact('codigo','clientes','forma_pago','fecha_actual'));
    }

    public function getver_tipos(Request $request)
    {
        if($request->ajax()){
            if(Servicio::where('tipo_servicio', $request->tipo_servicio)->where('estado', 'Activo')->exists()){
                $servicios = Servicio::where('tipo_servicio', $request->tipo_servicio)->where('estado', 'Activo')->get();
                foreach($servicios as $servicio){
                    $Arraylist[$servicio->id] =  [$servicio->codigo, $servicio->name];
                }
            }else{
                $Arraylist[1] =  ['sin valor'];
            }
            return response()->json($Arraylist);

        }
    }

    public function getver_fecha_vigencia(Request $request)
    {
        if($request->ajax()){
            $ArrayFC[1] = [Carbon::now()->addMonth((int)$request->value_tiempo)->format('Y-m-d')];
            return response()->json($ArrayFC);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ordens = new Ordenservicio();
        $ordens->codigo = $request->input('codigo');
        $ordens->slug = Str::slug($request->input('codigo'));
        $ordens->motivo = $request->input('motivo');
        $ordens->fecha = $request->input('fecha');
        $ordens->formapago = $request->input('formapago');
        $ordens->plazo_pago = $request->input('plazo_pago');
        $ordens->total = $request->input('total');
        $ordens->nota = $request->input('nota');
        // $ordens->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->lastname_padre.' '.Auth::user()->persona->lastname_madre;
        $ordens->registrado_por = 'Administrador Principal';
        $ordens->save();

        $tipo_servicio = $request->input('tipo_servicio');
        $codigo_servicio = $request->input('codigo_servicio');
        $servicio = $request->input('servicio');
        $precio = $request->input('precio');
        $tiempo_meses = $request->input('tiempo_meses');
        $vigencia = $request->input('vigencia');
        $subtotal = $request->input('subtotal');


        if(isset($codigo_servicio)){
            foreach ($codigo_servicio as $key => $name) {
                $dtlleos = new Detalleoservicio();
                $dtlleos->ordenservicio_id = $ordens->id;
                $dtlleos->tipo_servicio = $tipo_servicio[$key];
                $dtlleos->codigo_servicio = $codigo_servicio[$key];
                $dtlleos->servicio = $servicio[$key];
                $dtlleos->precio = (float)$precio[$key] ?? 0;
                $dtlleos->tiempo_meses = $tiempo_meses[$key];
                $dtlleos->vigencia = $vigencia[$key];
                $dtlleos->subtotal = (float)$precio[$key] ?? 0;
                $dtlleos->save();
            }
        }

        return redirect()->route('admin-ordenservicios.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ordenservicio $admin_ordenservicio)
    {
        $dtlleservicio = Detalleoservicio::where('ordenservicio_id', $admin_ordenservicio->id)->get();
        return view('ADMINISTRADOR.compras.oservicios.show',compact('admin_ordenservicio','dtlleservicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Ordenservicio $admin_ordenservicio)
    {
        $forma_pago = Formapago::all();
        return view('ADMINISTRADOR.compras.oservicios.edit',compact('admin_ordenservicio','forma_pago'));
    }

    public function getver_dt_servicio(Request $request)
    {
        if($request->ajax()){
            $servicio = Ordenservicio::where('codigo', $request->codigo_servicio)->first();
            $dtlleos = Detalleoservicio::where('ordenservicio_id', $servicio->id)->get();

            foreach($dtlleos as $dtlle_servicio){
                    $Arraylist[$dtlle_servicio->id] =  [$dtlle_servicio->id, $dtlle_servicio->tipo_servicio, $dtlle_servicio->codigo_servicio, $dtlle_servicio->servicio, $dtlle_servicio->precio, $dtlle_servicio->tiempo_meses, $dtlle_servicio->vigencia, $dtlle_servicio->subtotal];
            }
            return response()->json($Arraylist);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordenservicio $admin_ordenservicio)
    {
        $admin_ordenservicio->motivo = $request->input('motivo');
        $admin_ordenservicio->fecha = $request->input('fecha');
        $admin_ordenservicio->formapago = $request->input('formapago');
        $admin_ordenservicio->plazo_pago = $request->input('plazo_pago');
        $admin_ordenservicio->total = $request->input('total');
        $admin_ordenservicio->nota = $request->input('nota');
        // $admin_ordenservicio->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->lastname_padre.' '.Auth::user()->persona->lastname_madre;
        $admin_ordenservicio->registrado_por = 'Administrador Principal';
        $admin_ordenservicio->save();

        Detalleoservicio::where('ordenservicio_id', $admin_ordenservicio->id)->delete();

        $tipo_servicio = $request->input('tipo_servicio');
        $codigo_servicio = $request->input('codigo_servicio');
        $servicio = $request->input('servicio');
        $precio = $request->input('precio');
        $tiempo_meses = $request->input('tiempo_meses');
        $vigencia = $request->input('vigencia');
        $subtotal = $request->input('subtotal');

        if(isset($codigo_servicio)){
            foreach ($codigo_servicio as $key => $name) {
                $dtlleos = new Detalleoservicio();
                $dtlleos->ordenservicio_id = $admin_ordenservicio->id;
                $dtlleos->tipo_servicio = $tipo_servicio[$key];
                $dtlleos->codigo_servicio = $codigo_servicio[$key];
                $dtlleos->servicio = $servicio[$key];
                $dtlleos->precio = (float)$precio[$key] ?? 0;
                $dtlleos->tiempo_meses = $tiempo_meses[$key];
                $dtlleos->vigencia = $vigencia[$key];
                $dtlleos->subtotal = (float)$precio[$key] ?? 0;
                $dtlleos->save();
            }
        }

        return redirect()->route('admin-ordenservicios.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
