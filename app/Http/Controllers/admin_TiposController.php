<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_TiposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_tipos = Tipo::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.tipos.index',compact('admin_tipos'));
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
        $tipo = new Tipo();
        $tipo->name = $request->input('name');
        $tipo->slug = Str::slug($request->input('name'));
        $tipo->save();
        return redirect()->route('admin-tipos.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(admin_TiposController $admin_TiposController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(admin_TiposController $admin_TiposController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipo $admin_tipo)
    {
        if ($request->input('name') == $admin_tipo->name) {
            $admin_tipo->estado = $admin_tipo->estado === 'Activo' ? 'Inactivo' : 'Activo';
            $admin_tipo->save();
            return redirect()->route('admin-tipos.index')->with('update', 'ok');
        }else{
            if(Tipo::where('name', $request->input('name'))->exists()){
                return redirect()->route('admin-tipos.index')->with('exists', 'ok');
            }else{
                $admin_tipo['name'] = $request->input('name');
                $admin_tipo['slug'] = Str::slug($request->input('name'));
                $admin_tipo->save();
                return redirect()->route('admin-tipos.index')->with('update', 'ok');
            }
        }
    }

    public function estado(Request $request, Tipo $admin_tipo)
    {         
        $admin_tipo->estado = $admin_tipo->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_tipo->save();

        return redirect()->route('admin-tipos.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipo $admin_tipo)
    {
        if(Producto::where('tipo_id',$admin_tipo->id)->exists()){
            return redirect()->route('admin-tipos.index')->with('error', 'ok');
        }else{
            $admin_tipo->delete();
            return redirect()->route('admin-tipos.index')->with('delete', 'ok');
        }
    }
}
