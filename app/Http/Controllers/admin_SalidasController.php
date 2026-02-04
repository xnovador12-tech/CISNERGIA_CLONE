<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Motivo;
use App\Models\Salida;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        // $ocompra = DB::table('ordenescompras')->select('codigo')->where('estado','!=','Inventariado')->get();

        return view('ADMINISTRADOR.ALMACEN.salidas.create',compact('codigo','almacen','motivos','fecha_actual'));
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
