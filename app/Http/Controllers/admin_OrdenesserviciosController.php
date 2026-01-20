<?php

namespace App\Http\Controllers;

use App\Models\Ordenservicio;
use App\Models\Formapago;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $productos = Producto::all();
        return view('ADMINISTRADOR.compras.oservicios.create', compact('codigo','clientes','forma_pago','fecha_actual','productos'));
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
