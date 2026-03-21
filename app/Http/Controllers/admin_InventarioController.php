<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class admin_InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_inventarios = Inventario::all();
        $sedes = Sede::all();

        $al_por_tipos = DB::table('inventarios')->select('id_producto','producto','umedida',DB::raw('sum(cantidad) as cantidad'))->groupby('id_producto','producto','umedida')->where('sede_id', 1)->get();

        return view('ADMINISTRADOR.ALMACEN.inventarios.index',compact('admin_inventarios', 'sedes', 'al_por_tipos'));
    }

    // Reporte para ver de forma general por fecha - pdf
    public function reporteInventariosPrintPdfSede(Request $request)
    {
        $now = Carbon::now();
        $fi = $request->fecha_ini. ' 00:00:00';
        $ff = $request->fecha_fin. ' 23:59:59';
        $name_sede = Sede::where('id', 1)->first();
        $salidas = Movimiento::where('tipo_movimiento', 'SALIDA')->whereBetween('created_at', [$fi, $ff])->where('sede_id', "=", $name_sede->id)->get();
        $pdf = PDF::loadView('ADMINISTRADOR.REPORTES.movimiento-salidas.pdf.movsalidaPDF', ['salidas'=>$salidas, s, 'now'=>$now, 'name_sede'=>$name_sede]);
        return $pdf->stream('MOVIMIENTOS-SALIDA - '.$name_sede->name.'.pdf');
    }
    // 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
