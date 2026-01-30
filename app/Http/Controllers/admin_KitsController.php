<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use App\Models\Etiqueta;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class admin_KitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_kits = Combo::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.kits.index', compact('admin_kits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $kits = Combo::orderBy('id','desc')->first();
        $nubRow =$kits?$kits->id+1:1;
        $codigo = 'KI-'.$now->format('Ymd').'-'.$nubRow;

        $etiquetas = Etiqueta::where('estado', 'Activo')->get();
        $productos = Producto::where('estado', 'Activo')->where('tipo_id','!=','3')->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.kits.create', compact('codigo', 'etiquetas', 'productos'));
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
