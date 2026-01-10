<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_EtiquetasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_etiquetas = Etiqueta::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.etiquetas.index',compact('admin_etiquetas'));
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
        $etiqueta = new Etiqueta();
        $etiqueta->name = $request->input('name');
        $etiqueta->slug = Str::slug($request->input('name'));
        $etiqueta->save();
        return redirect()->route('admin-etiquetas.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etiqueta $admin_etiqueta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etiqueta $admin_etiqueta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etiqueta $admin_etiqueta)
    {
        if ($request->input('name') == $admin_etiqueta->name) {
            $admin_etiqueta->estado = $admin_etiqueta->estado === 'Activo' ? 'Inactivo' : 'Activo';
            $admin_etiqueta->save();
            return redirect()->route('admin-etiquetas.index')->with('update', 'ok');
        }else{
            if(Etiqueta::where('name', $request->input('name'))->exists()){
                return redirect()->route('admin-etiquetas.index')->with('exists', 'ok');
            }else{
                $admin_etiqueta['name'] = $request->input('name');
                $admin_etiqueta['slug'] = Str::slug($request->input('name'));
                $admin_etiqueta->save();
                return redirect()->route('admin-etiquetas.index')->with('update', 'ok');
            }
        }
    }

    public function estado(Request $request, Etiqueta $admin_etiqueta)
    {         
        $admin_etiqueta->estado = $admin_etiqueta->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_etiqueta->save();

        return redirect()->route('admin-etiquetas.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etiqueta $admin_etiqueta)
    {
        if(Producto::where('tag_id',$admin_etiqueta->id)->exists()){
            return redirect()->route('admin-etiquetas.index')->with('error', 'ok');
        }else{
            $admin_etiqueta->delete();
            return redirect()->route('admin-etiquetas.index')->with('delete', 'ok');
        }
    }
}
