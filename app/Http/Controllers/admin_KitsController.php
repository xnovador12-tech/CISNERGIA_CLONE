<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use App\Models\Detallecombo;
use App\Models\Etiqueta;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class admin_KitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_kits = Combo::all();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.kits.index', compact('admin_kits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $kits = Combo::orderBy('id','desc')->first();
        $nubRow =$kits?$kits->id+1:1;
        $codigo = 'KI-'.$now->format('Ymd').'-'.$nubRow;

        $etiquetas = Etiqueta::where('estado', 'Activo')->get();
        $productos = Producto::where('estado', 'Activo')->where('tipo_id','!=','3')->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.kits.create', compact('codigo', 'etiquetas', 'productos'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // condicion para guardar el nombre de las imagenes opcionales
        $urlimagenes = [];
        if ($request->hasFile('images_opcional')){
            $imagenes = $request->file('images_opcional');
            foreach ($imagenes as $imagen) {
                $nombre = time().'_'.$imagen->getClientOriginalName();
                $imagen->move(public_path().'/images/kits-opcional/', $nombre);
                $urlimagenes[]['url']='/images/kits-opcional/'.$nombre;
            }
        }

        $combo = new Combo();
        $combo->codigo = $request->input('codigo');
        $combo->slug = Str::slug($request->input('codigo'));
        $combo->precio_total = $request->precio_total;
        $combo->cantidad_total = $request->cantidad_total;
        $combo->descripcion = $request->descripcion;
        $combo->estado = 'Activo';
        $combo->save();

        // guardar las imagenes opcionales
        $combo->images()->createMany($urlimagenes);

        //guardar las etiquetas asociadas al kit
        if ($request->has('etiquetas')) {
            $combo->etiquetas()->attach($request->etiquetas);
        }

        // Guardar los productos asociados al kit
        $producto_id = $request->input('producto_id');
        $cantidad = $request->input('cantidad');

        if ($request->has('producto_id')) {
            foreach ($producto_id as $key => $name) {

                $dtllecombo = new Detallecombo();
                $dtllecombo->combo_id = $combo->id;
                $dtllecombo->producto_id = $producto_id[$key];
                $dtllecombo->cantidad = $cantidad[$key];
                $dtllecombo->save();
            }
        }

        return redirect()->route('admin-kits.index')->with('new_registration', 'ok');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
