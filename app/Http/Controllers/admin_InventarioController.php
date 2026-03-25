<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Movimiento;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Producto;

class admin_InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_inventarios = Inventario::all();
        $sedes = Sede::all();

        $al_por_tipos = DB::table('inventarios')->select('id_producto','producto','umedida',DB::raw('sum(cantidad) as cantidad'))->groupby('id_producto','producto','umedida')->where('sede_id', 1)->get();

        return view('ADMINISTRADOR.ALMACEN.inventarios.index',compact('admin_inventarios', 'sedes', 'al_por_tipos'));
    }

    // Reporte para ver de forma general por fecha - pdf
    public function reporteInventariosPrintPdfSede(Request $request)
    {
        $now = Carbon::now();
        $fi = $request->fecha_ini. ' 00:00:00';
        $ff = $request->fecha_fin. ' 23:59:59';
        $name_sede = Sede::where('id', $request->sede_id)->first();
        $alm_tipo_producto = Inventario::where('sede_id', "=", $name_sede->id)->where('tipo_producto', $request->tipo_producto)->get();
        $pdf = PDF::loadView('ADMINISTRADOR.REPORTES.inventarios.inventariosPDF', ['alm_tipo_producto'=>$alm_tipo_producto, 'now'=>$now, 'name_sede'=>$name_sede]);
        return $pdf->stream('MOVIMIENTOS-SALIDA - '.$name_sede->name.'.pdf');
    }
    // 

    // Reporte para ver de forma general por fecha - pdf
    public function getbusqueda_inventarios_general(Request $request)
    {
        $now = Carbon::now();
        $fi = $request->fecha_ini. ' 00:00:00';
        $ff = $request->fecha_fin. ' 23:59:59';
        $name_sede = Sede::where('id', 1)->first();
        $ingresos = DB::table('movimientos as mov')
            ->join('detallemovimientos as dtll', 'dtll.movimiento_id', '=', 'mov.id')
            ->select(
                'mov.id',
                'mov.codigo as codigo',
                'mov.codigo_ocompra',
                'mov.codigo_venta',
                'mov.cliente',
                'mov.tipo_movimiento',
                'mov.motivo',
                'mov.sede_id',
                'mov.registrado_por',
                'mov.fecha',
                DB::raw('mov.created_at as created_at'),
                'dtll.cantidad',        // ✅ cantidad del detalle
                'dtll.id_producto'
            )
            ->where('mov.sede_id', $name_sede->id)
            ->where('dtll.id_producto', $request->id_producto)
            ->whereBetween('mov.created_at', [$fi, $ff])
            ->get();

        // Convertir created_at a Carbon para usar ->format() en la vista
        $ingresos->transform(function ($item) {
            $item->created_at = Carbon::parse($item->created_at);
            return $item;
        });

        $valor_producto = Producto::where('id', $request->id_producto)->first();

        $pdf = PDF::loadView('ADMINISTRADOR.REPORTES.inventarios.movinventarioPDF', [
            'ingresos'   => $ingresos,
            'fi'         => $request->fecha_ini,
            'ff'         => $request->fecha_fin,
            'now'        => $now,
            'name_sede'  => $name_sede,
            'producto'   => $valor_producto,
        ]);
        return $pdf->stream('MOVIMIENTOS-INGRESO - '.$name_sede->name.'.pdf');
    }
    // 

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
        //
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
