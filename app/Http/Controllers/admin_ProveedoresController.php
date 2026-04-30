<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Identificacion;
use App\Models\Persona;
use App\Models\Proveedor;
use App\Models\Proveedorcuenta;
use App\Models\Tipo;
use App\Models\Tipocuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class admin_ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_proveedores = Persona::where('tipo_persona', '=', 'Proveedor')->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.proveedores.index', compact('admin_proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposcuentas = Tipocuenta::all();
        $bancos = Banco::all();
        $tiposdocumento = Identificacion::all();
        $tipos = Tipo::all();
        $ubigeos = DB::table('departamentos as dep')
            ->select('dep.id as departamento_ids', 'dep.nombre as departamento_name')
            ->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.proveedores.create', compact('tiposcuentas', 'bancos', 'tiposdocumento', 'tipos', 'ubigeos'));
    }

    public function getbusqueda_list_cuentas(Request $request){
        if($request->ajax()){
            $cuentas = Proveedorcuenta::where('proveedor_id', $request->id_proveedor)->get();
            foreach($cuentas as $cuenta){
                $Arraylist[$cuenta->id] = [$cuenta->tipo_cuenta_normal, $cuenta->entidad_bancaria_normal, $cuenta->nro_cuenta_normal, $cuenta->nro_cci_normal];
            }
            return response()->json($Arraylist);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $persona = new Persona();
        $persona->identificacion = $request->input('tipo_documento');
        $persona->nro_identificacion = $request->input('nro_documento');
        $persona->name = $request->input('name');
        $persona->slug = Str::slug($request->input('nro_documento'));
        $persona->email_pnatural = $request->input('email_pnatural');
        $persona->celular = $request->input('celular');
        $persona->direccion = $request->input('direccion');
        $persona->referencia = $request->input('referencia');
        $persona->tipo_persona = 'Proveedor';
        $persona->registrado_por = Auth::user()->persona->name.' '.Auth::user()->persona->surnames;
        $persona->sede_id = Auth::user()->persona->sede_id;
        $persona->save();

        $proveedor = new Proveedor();
        $proveedor->giro = $request->input('giro');
        $proveedor->direccion_fiscal  = $request->input('direccion_fiscal');
        $proveedor->name_contacto   = $request->input('name_contacto');
        $proveedor->email_contacto   = $request->input('email_contacto');
        $proveedor->nro_celular_contacto   = $request->input('nro_celular_contacto');
        $proveedor->departamento_id   = $request->input('departamento_id');
        // $proveedor->provincia_id   = $request->input('provincia_id');
        // $proveedor->distrito_id   = $request->input('distrito_id');
        $proveedor->estado = 'Activo';

        $proveedor->tipo_cuenta_detraccion = $request->input('tipo_cuenta_detraccion');
        $proveedor->entidad_bancaria_detraccion   = $request->input('entidad_bancaria_detraccion');
        $proveedor->nro_cuenta_detraccion   = $request->input('nro_cuenta_detraccion');

        $proveedor->persona_id   = $persona->id;
        $proveedor->save();

        $contandores_cuentas = $request->input('contadores');
        $tipo_cuentas = $request->input('tipo_cuenta_normal');
        $entidad_bancaria = $request->input('entidad_bancaria_normal');
        $nro_cuenta = $request->input('nro_cuenta_normal');
        $nro_cci = $request->input('nro_cci_normal');

        if($contandores_cuentas){
            foreach($contandores_cuentas as $contador => $contadores){
                    $proveedorcuenta = new Proveedorcuenta();
                    $proveedorcuenta->tipo_cuenta_normal = $tipo_cuentas[$contador];
                    $proveedorcuenta->entidad_bancaria_normal = $entidad_bancaria[$contador];
                    $proveedorcuenta->nro_cuenta_normal = $nro_cuenta[$contador];
                    $proveedorcuenta->nro_cci_normal = $nro_cci[$contador];
                    $proveedorcuenta->proveedor_id = $proveedor->id;
                    $proveedorcuenta->save();
            }
        }

        if ($request->input('tipos')) {
            $proveedor->tipos()->attach($request->input('tipos'));
        }

        return redirect()->route('admin-proveedores.index')->with('new_registration', 'ok');
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $admin_proveedor)
    {
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.proveedores.show', compact('admin_proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $admin_proveedor)
    {
        $tiposcuentas = Tipocuenta::all();
        $bancos = Banco::all();
        $tiposdocumento = Identificacion::all();
        $tipos = Tipo::all();
        $ubigeos = DB::table('departamentos as dep')
            ->select('dep.id as departamento_ids', 'dep.nombre as departamento_name')
            ->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.proveedores.edit', compact('admin_proveedor', 'ubigeos', 'tipos', 'tiposdocumento', 'tiposcuentas', 'bancos'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function estado(Request $request, Persona $admin_proveedor)
    {
        $nuevoEstado = $admin_proveedor->proveedor->estado == 'Activo' ? 'Inactivo' : 'Activo';
        $admin_proveedor->proveedor->update(['estado' => $nuevoEstado]);

        return redirect()->back()->with('update', 'ok');
    }

    public function update(Request $request, Persona $admin_proveedor)
    {
        $admin_proveedor->identificacion = $request->input('identificacion');
        $admin_proveedor->nro_identificacion = $request->input('nro_identificacion');
        $admin_proveedor->name = $request->input('name');
        $admin_proveedor->slug = Str::slug($request->input('name'));
        $admin_proveedor->email_pnatural = $request->input('email_pnatural');
        $admin_proveedor->celular = $request->input('celular');
        $admin_proveedor->direccion = $request->input('direccion');
        $admin_proveedor->referencia = $request->input('referencia');
        $admin_proveedor->save();

        $admin_proveedor->proveedor->giro = $request->input('giro');
        $admin_proveedor->proveedor->direccion_fiscal  = $request->input('direccion_fiscal');
        // $admin_proveedor->proveedor->tipo_id  = $request->input('tipo_id');
        $admin_proveedor->proveedor->name_contacto   = $request->input('name_contacto');
        $admin_proveedor->proveedor->email_contacto   = $request->input('email_contacto');
        $admin_proveedor->proveedor->nro_celular_contacto   = $request->input('nro_celular_contacto');
        $admin_proveedor->proveedor->departamento_id   = $request->input('departamento_id');
        // $admin_proveedor->proveedor->provincia_id   = $request->input('provincia_id');
        // $admin_proveedor->proveedor->distrito_id   = $request->input('distrito_id');

        $admin_proveedor->proveedor->tipo_cuenta_detraccion = $request->input('tipo_cuenta_detraccion');
        $admin_proveedor->proveedor->entidad_bancaria_detraccion   = $request->input('entidad_bancaria_detraccion');
        $admin_proveedor->proveedor->nro_cuenta_detraccion   = $request->input('nro_cuenta_detraccion');

        $admin_proveedor->proveedor->save();

        $contandores_cuentas = $request->input('contadores');
        $tipo_cuentas = $request->input('tipo_cuenta_normal');
        $entidad_bancaria = $request->input('entidad_bancaria_normal');
        $nro_cuenta = $request->input('nro_cuenta_normal');
        $nro_cci = $request->input('nro_cci_normal');

        Proveedorcuenta::where('proveedor_id', $admin_proveedor->proveedor->id)->delete();
        if($contandores_cuentas){
            foreach($contandores_cuentas as $contador => $contadores){
                    $proveedorcuenta = new Proveedorcuenta();
                    $proveedorcuenta->tipo_cuenta_normal = $tipo_cuentas[$contador];
                    $proveedorcuenta->entidad_bancaria_normal = $entidad_bancaria[$contador];
                    $proveedorcuenta->nro_cuenta_normal = $nro_cuenta[$contador];
                    $proveedorcuenta->nro_cci_normal = $nro_cci[$contador];
                    $proveedorcuenta->proveedor_id = $admin_proveedor->proveedor->id;
                    $proveedorcuenta->save();
            }
        }

        if ($request->input('tipos')) {
            $admin_proveedor->proveedor->tipos()->detach();
            $admin_proveedor->proveedor->tipos()->attach($request->input('tipos'));
        }
        return redirect()->route('admin-proveedores.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $admin_proveedore)
    {
        //
    }
}
