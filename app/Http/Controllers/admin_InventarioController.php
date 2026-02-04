<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Sede;
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

        $al_accesorios = DB::table('inventarios')->select('id_producto','producto','umedida',DB::raw('sum(cantidad) as cantidad'))->groupby('id_producto','producto','umedida')->where('tipo_producto', 'Accesorios')->where('sede_id', 1)->get();
        $al_repuestos = DB::table('inventarios')->select('id_producto','producto','umedida',DB::raw('sum(cantidad) as cantidad'))->groupby('id_producto','producto','umedida')->where('tipo_producto', 'Repuestos')->where('sede_id', 1)->get();
        $al_modulo_solar = DB::table('inventarios')->select('id_producto','producto','umedida',DB::raw('sum(cantidad) as cantidad'))->groupby('id_producto','producto','umedida')->where('tipo_producto', 'Modulo Solar')->where('sede_id', 1)->get();

        return view('ADMINISTRADOR.ALMACEN.inventarios.index',compact('admin_inventarios', 'sedes', 'al_accesorios', 'al_repuestos', 'al_modulo_solar'));
    }

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
