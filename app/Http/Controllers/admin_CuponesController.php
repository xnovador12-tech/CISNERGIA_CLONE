<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class admin_CuponesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_cupones = Coupon::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.cupones.index',compact('admin_cupones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getsearch_codigo(Request $request)
    {
        if ($request->ajax()) {
            if($request->buscar == 'buscar_codigo'){
                if(Coupon::where('codigo',$request->codigo)->exists()){
                    $random = strtoupper(Str::random(8));
                    $data[1] = [$random];
                }else{
                    $random = strtoupper(Str::random(8));
                    $data[1] = [$random];
                }
                return response()->json($data);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $admin_cupones = new Coupon();
        $admin_cupones->titulo = $request->input('titulo');
        $admin_cupones->slug = Str::slug($request->input('titulo'));
        $admin_cupones->codigo = $request->input('codigo');
        $admin_cupones->porcentaje = $request->input('porcentaje');
        $admin_cupones->fecha_inicio = $request->input('fecha_inicio');
        $admin_cupones->fecha_fin = $request->input('fecha_fin');
        $admin_cupones->save(); 

        return redirect()->route('admin-cupones.index')->with('new_registration', 'ok');
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
    public function update(Request $request, Coupon $admin_cupone)
    {
        $admin_cupone->titulo = $request->input('titulo');
        $admin_cupone->slug = Str::slug($request->input('titulo'));
        $admin_cupone->codigo = $request->input('codigo');
        $admin_cupone->porcentaje = $request->input('porcentaje');
        $admin_cupone->fecha_inicio = $request->input('fecha_inicio');
        $admin_cupone->fecha_fin = $request->input('fecha_fin');
        $admin_cupone->save(); 

        return redirect()->route('admin-cupones.index')->with('update', 'ok');
    }

    public function estado(Request $request, Coupon $admin_cupon)
    {
        $admin_cupon->estado = $admin_cupon->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $admin_cupon->save();

        return redirect()->route('admin-cupones.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request, Coupon $admin_cupon)
    {
        $admin_cupon->delete();
        return redirect()->route('admin-cupones.index')->with('delete', 'ok');
    }

    public function getver_cuponera(Request $request)
    {
        if($request->ajax()){
            $fecha_actual = \Carbon\Carbon::now()->format('Y-m-d');
            if(Coupon::exists()){
                    
                $cupons_val = DB::table('coupons as cou')->select('cou.*')->get();

                foreach($cupons_val as $cupons_values){
                    if($cupons_values->fecha_inicio <= $fecha_actual && $cupons_values->fecha_fin >= $fecha_actual){
                        // el cupon esta activo

                        $cuponeras = Coupon::where('id',$cupons_values->id)->first();
                        $cuponeras->estado = 'Activo';
                        $cuponeras->save();

                        $Arraylist[1] = ['existe'];

                    }else{
                        // el cupon ya no es valido
                        $cuponeras = Coupon::where('id',$cupons_values->id)->first();
                        $cuponeras->estado = 'Inactivo';
                        $cuponeras->save();

                        $Arraylist[1] = ['no_existe'];
                    }
                }
            }else{
                $Arraylist[1] = ['no_existe'];
            }
            return response()->json($Arraylist);
        }
    }
}
