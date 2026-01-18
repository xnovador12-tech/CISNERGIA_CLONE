<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_servicios = Servicio::all();
        $proveedores = Proveedor::where('estado', 'Activo')->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.servicios.index',compact('admin_servicios', 'proveedores'));
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
        $now = Carbon::now();
        $servici = Servicio::orderBy('id','desc')->first();
        $nubRow =$servici?$servici->id+1:1;
        $codigo = 'SERV-'.$now->format('Ymd').'-'.$nubRow;

        $servicios = new Servicio();
        $servicios->name = $request->input('name');
        $servicios->slug = Str::slug($codigo);
        $servicios->codigo = $codigo;
        $servicios->tipo_servicio = $request->input('tipo_servicio');
        $servicios->proveedor_id = $request->input('proveedor_id');
        $servicios->descripcion = $request->input('descripcion');
        $servicios->save();

        return redirect()->route('admin-servicios.index')->with('new_registration', 'ok');
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

    public function estado(Request $request, Servicio $admin_servicio)
    {         
        $admin_servicio->estado = $admin_servicio->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_servicio->save();

        return redirect()->route('admin-servicios.index')->with('update', 'ok');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Servicio $admin_servicio)
    {
        $admin_servicio->fill($request->except('codigo', 'slug'));
        $admin_servicio->save();

        return redirect()->route('admin-servicios.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Servicio $admin_servicio)
    {
        //
    }
}
