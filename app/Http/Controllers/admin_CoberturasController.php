<?php

namespace App\Http\Controllers;

use App\Models\Cobertura;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_CoberturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_coberturas = Cobertura::all();
        $ubigeos = DB::table('departamentos as dep')
            ->join('provincias as prov','prov.departamento_id','dep.id')
            ->join('distritos as dis','dis.provincia_id','prov.id')
            ->select('dep.id as departamento_ids','dis.id as distrito_ids','prov.id as provincia_ids','dep.name as departamento_name','dis.name as distrito_name','prov.name as provincia_name')
            ->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.coberturas.index',compact('admin_coberturas', 'ubigeos'));
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
        $cobertura = new Cobertura();
        $cobertura->name = $request->name;
        $cobertura->slug = Str::slug($request->name);
        $cobertura->precio = $request->precio;
        $cobertura->estado = 'Activo';
        // $cobertura->registrado_por = auth()->user()->name;
        $cobertura->departamento_id = $request->departamento_id;
        $cobertura->provincia_id = $request->provincia_id;
        $cobertura->distrito_id = $request->distrito_id;
        $cobertura->registrado_por = 'Administrador';
        $cobertura->save();

        return redirect()->route('admin-coberturas.index')->with('new_registration', 'ok');
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

    public function estado(Request $request, Cobertura $admin_cobertura)
    {
        $admin_cobertura->estado = $admin_cobertura->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_cobertura->save();

        return redirect()->route('admin-coberturas.index')->with('update', 'ok');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cobertura $admin_cobertura)
    {
        $admin_cobertura->fill($request->all());
        $admin_cobertura->save();

        return redirect()->route('admin-coberturas.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
