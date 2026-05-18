<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Resena;
use Illuminate\Http\Request;

class admin_CrmReseñasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_crm_reseñas = Resena::all();
        $clientes = Cliente::all();
        return view('ADMINISTRADOR.CRM.reseñas.index', compact('admin_crm_reseñas', 'clientes'));
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
        $new_resenas = new Resena();
        $new_resenas->comentarios = $request->comentarios;
        $new_resenas->valoracion = $request->valoracion;
        $new_resenas->cliente_id = $request->cliente_id;
        $new_resenas->save();

        return redirect()->route('admin-crm-reseñas.index')->with('new_registration', 'ok');
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
        
    }

    public function estados(Request $request, string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->estado = $request->estado;
        $resena->save();

        return redirect()->route('admin-crm-reseñas.index')->with('update', 'ok');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->comentarios = $request->comentarios;
        $resena->valoracion = $request->valoracion;
        $resena->cliente_id = $request->cliente_id;
        $resena->save();

        return redirect()->route('admin-crm-reseñas.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return redirect()->route('admin-crm-reseñas.index')->with('delete', 'ok'); 
    }
}
