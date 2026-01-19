<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Producto;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_categorias = Category::all();
        $tipos = Tipo::where('estado', 'Activo')->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.categorias.index',compact('admin_categorias','tipos'));
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
        $categoria = new Category();
        $categoria->name = $request->input('name');
        $categoria->slug = Str::slug($request->input('name'));
        $categoria->tipo_id = $request->input('tipo_id');
        $categoria->save();
        return redirect()->route('admin-categorias.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $admin_categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $admin_categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $admin_categoria)
    {
        if ($request->input('name') == $admin_categoria->name) {
            $admin_categoria->estado = $admin_categoria->estado === 'Activo' ? 'Inactivo' : 'Activo';
            $admin_categoria->save();
            return redirect()->route('admin-categorias.index')->with('update', 'ok');
        }else{
            if(Category::where('name', $request->input('name'))->exists()){
                return redirect()->route('admin-categorias.index')->with('exists', 'ok');
            }else{
                $admin_categoria['name'] = $request->input('name');
                $admin_categoria['slug'] = Str::slug($request->input('name'));
                $admin_categoria->save();
                return redirect()->route('admin-categorias.index')->with('update', 'ok');
            }
        }
    }

    public function estado(Request $request, Category $admin_categoria)
    {         
        $admin_categoria->estado = $admin_categoria->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_categoria->save();

        return redirect()->route('admin-categorias.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $admin_categoria)
    {
        if(Producto::where('categoria_id',$admin_categoria->id)->exists()){
            return redirect()->route('admin-categorias.index')->with('error', 'ok');
        }else{
            $admin_categoria->delete();
            return redirect()->route('admin-categorias.index')->with('delete', 'ok');
        }
    }
}
