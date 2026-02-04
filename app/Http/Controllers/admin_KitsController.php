<?php

namespace App\Http\Controllers;

use App\Models\Combo;
use App\Models\Detallecombo;
use App\Models\Etiqueta;
use App\Models\Image;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
    public function edit(Request $request, Combo $admin_kit)
    {
        $etiquetas = Etiqueta::where('estado', 'Activo')->get();
        $productos = Producto::where('estado', 'Activo')->where('tipo_id','!=','3')->get();
        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.kits.edit', compact('admin_kit', 'etiquetas', 'productos'));
    }

    public function getdtlle_kits(Request $request)
    {
        if($request->ajax()){
            $combo = Combo::where('codigo', $request->codigo_kits)->first();
            if (Detallecombo::where('combo_id', $combo->id)->exists()) {
                $detalles = Detallecombo::where('combo_id', $combo->id)->with('producto')->get();
                foreach ($detalles as $detalle) {
                    $arraylist[$detalle->id] = [$detalle->producto_id, $detalle->producto->name, $detalle->cantidad, $detalle->combo_id];
                }
            }
            return response()->json($arraylist);
        }
    }

    public function deleteImage($id)
    {
        $image = Image::find($id);
        $file_path = public_path(). $image->url; 
        File::delete($file_path);
        $image->delete();
        return redirect()->back();
    }

    public function estado(Request $request, Combo $admin_kit)
    {
        if ($admin_kit->estado == 'Activo') {
            $admin_kit->estado = 'Inactivo';
        } else {
            $admin_kit->estado = 'Activo';
        }
        $admin_kit->save();
        return redirect()->route('admin-kits.index')->with('update', 'ok');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Combo $admin_kit)
    {
        // condicion para guardar el nombre de las imagenes opcionales
        $urlimagenes = [];
        if ($request->hasFile('images_opcional')){
            // eliminar imagenes anteriores (archivos y registros)
            foreach ($admin_kit->images as $image) {
                $file_path = public_path() . $image->url;
                File::delete($file_path);
                $image->delete();
            }

            $imagenes = $request->file('images_opcional');
            foreach ($imagenes as $imagen) {
                $nombre = time().'_'.$imagen->getClientOriginalName();
                $imagen->move(public_path().'/images/kits-opcional/', $nombre);
                $urlimagenes[]['url']='/images/kits-opcional/'.$nombre;
            }
        }
        
        $admin_kit->precio_total = $request->precio_total;
        $admin_kit->cantidad_total = $request->cantidad_total;
        $admin_kit->descripcion = $request->descripcion;
        $admin_kit->estado = 'Activo';
        $admin_kit->save();

        // guardar las imagenes opcionales
        if (!empty($urlimagenes)) {
            $admin_kit->images()->createMany($urlimagenes);
        }

        //guardar las etiquetas asociadas al kit
        if ($request->has('etiquetas')) {
            $admin_kit->etiquetas()->detach();
            $admin_kit->etiquetas()->attach($request->etiquetas);
        }

        // Guardar los productos asociados al kit
        $producto_id = $request->input('producto_id');
        $cantidad = $request->input('cantidad');

        Detallecombo::where('combo_id', $admin_kit->id)->delete();

        if ($request->has('producto_id')) {
            foreach ($producto_id as $key => $name) {

                $dtllecombo = new Detallecombo();
                $dtllecombo->combo_id = $admin_kit->id;
                $dtllecombo->producto_id = $producto_id[$key];
                $dtllecombo->cantidad = $cantidad[$key];
                $dtllecombo->save();
            }
        }

        return redirect()->route('admin-kits.index')->with('update', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Combo $admin_kit)
    {
        // eliminar imagenes anteriores (archivos y registros)
        foreach ($admin_kit->images as $image) {
            $file_path = public_path() . $image->url;
            File::delete($file_path);
            $image->delete();
        }

        Detallecombo::where('combo_id', $admin_kit->id)->delete();
        $admin_kit->etiquetas()->detach();
        $admin_kit->delete();

        return redirect()->route('admin-kits.index')->with('delete', 'ok');
    }
}
