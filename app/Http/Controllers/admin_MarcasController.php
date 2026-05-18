<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_marcas = Marca::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.marcas.index',compact('admin_marcas'));
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
        $marca = new Marca();
        $marca->name = $request->input('name');
        $marca->slug = Str::slug($request->input('name'));
        $marca->url = $request->input('url');
        $marca->save();
        return redirect()->route('admin-marcas.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $admin_MarcasController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $admin_MarcasController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $admin_marca)
    {
        if ($request->input('name') == $admin_marca->name) {
            $admin_marca->name = $request->input('name');
            $admin_marca->slug = Str::slug($request->input('name'));
            $admin_marca->url = $request->input('url');
            $admin_marca->estado = $admin_marca->estado === 'Activo' ? 'Inactivo' : 'Activo';
            $admin_marca->save();
            return redirect()->route('admin-marcas.index')->with('update', 'ok');
        }else{
            if(Marca::where('name', $request->input('name'))->exists()){
                $admin_marca['name'] = $request->input('name');
                $admin_marca['slug'] = Str::slug($request->input('name'));
                $admin_marca['url'] = $request->input('url');
                $admin_marca->save();
                return redirect()->route('admin-marcas.index')->with('exists', 'ok');
            }else{
                $admin_marca['name'] = $request->input('name');
                $admin_marca['slug'] = Str::slug($request->input('name'));
                $admin_marca['url'] = $request->input('url');
                $admin_marca->save();
                return redirect()->route('admin-marcas.index')->with('update', 'ok');
            }
        }
    }

    public function estado(Request $request, Marca $admin_marca)
    {         
        $admin_marca->estado = $admin_marca->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_marca->save();

        return redirect()->route('admin-marcas.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $admin_marca)
    {
        if(Producto::where('marca_id',$admin_marca->id)->exists()){
            return redirect()->route('admin-marcas.index')->with('error', 'ok');
        }else{
            $admin_marca->delete();
            return redirect()->route('admin-marcas.index')->with('delete', 'ok');
        }
    }
}
