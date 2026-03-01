<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_modelos = Modelo::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.modelos.index',compact('admin_modelos'));
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
        $modelo = new Modelo();
        $modelo->nombre = $request->input('name');
        $modelo->slug = Str::slug($request->input('name'));
        $modelo->save();
        return redirect()->route('admin-modelos.index')->with('new_registration', 'ok');
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
    public function update(Request $request, Modelo $admin_modelo)
    {
        if ($request->input('name') == $admin_modelo->name) {
            $admin_modelo->estado = $admin_modelo->estado === 'Activo' ? 'Inactivo' : 'Activo';
            $admin_modelo->save();
            return redirect()->route('admin-modelos.index')->with('update', 'ok');
        }else{
            if(Modelo::where('nombre', $request->input('name'))->exists()){
                return redirect()->route('admin-modelos.index')->with('exists', 'ok');
            }else{
                $admin_modelo['nombre'] = $request->input('name');
                $admin_modelo['slug'] = Str::slug($request->input('name'));
                $admin_modelo->save();
                return redirect()->route('admin-modelos.index')->with('update', 'ok');
            }
        }
    }

    public function estado(Request $request, Modelo $admin_modelo)
    {         
        $admin_modelo->estado = $admin_modelo->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_modelo->save();

        return redirect()->route('admin-modelos.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $admin_modelo)
    {
        if(Producto::where('modelo_id',$admin_modelo->id)->exists()){
            return redirect()->route('admin-modelos.index')->with('error', 'ok');
        }else{
            $admin_modelo->delete();
            return redirect()->route('admin-modelos.index')->with('delete', 'ok');
        }
    }
}
