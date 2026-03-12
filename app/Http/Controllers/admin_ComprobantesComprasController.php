<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteCompra;
use App\Models\DetalleComprobanteCompra;
use App\Models\Ordencompra;
use App\Models\Proveedor;
use App\Models\Tiposcomprobante;
use App\Models\Moneda;
use App\Models\Mediopago;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_ComprobantesComprasController extends Controller
{
    public function index(Request $request)
    {
        $query = ComprobanteCompra::with(['proveedor', 'tipocomprobante', 'ordencompra']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $comprobantes = $query->orderBy('created_at', 'desc')->get();

        return view('ADMINISTRADOR.FINANZAS.comprobantes compras.index', compact('comprobantes'));
    }

    public function create(Request $request)
    {
        $ordencompra = null;
        if ($request->has('id_oc')) {
            $ordencompra = Ordencompra::with(['proveedor.persona', 'detallecompra'])->find($request->id_oc);
        }

        $proveedores = Proveedor::with('persona')->where('estado', 'Activo')->get();
        $tiposcomprobante = Tiposcomprobante::all();
        $monedas = Moneda::all();
        $mediopagos = Mediopago::all();
        $ordenes_pendientes = Ordencompra::where('estado_pago', 'Pendiente')->get();

        return view('ADMINISTRADOR.FINANZAS.comprobantes compras.create', compact(
            'ordencompra', 
            'proveedores', 
            'tiposcomprobante', 
            'monedas', 
            'mediopagos',
            'ordenes_pendientes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required',
            'tiposcomprobante_id' => 'required',
            'numero_comprobante' => 'required',
            'subtotal' => 'required',
            'igv' => 'required',
            'total' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $comprobante = new ComprobanteCompra();
            $comprobante->codigo = 'CP-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $comprobante->slug = Str::slug($comprobante->codigo);
            $comprobante->user_id = Auth::id();
            $comprobante->proveedor_id = $request->proveedor_id;
            $comprobante->sede_id = Auth::user()->persona->sede_id ?? 1;
            $comprobante->ordencompra_id = $request->ordencompra_id;
            $comprobante->tiposcomprobante_id = $request->tiposcomprobante_id;
            $comprobante->numero_comprobante = $request->numero_comprobante;
            $comprobante->subtotal = $request->subtotal;
            $comprobante->igv = $request->igv;
            $comprobante->total = $request->total;
            $comprobante->moneda_id = $request->moneda_id;
            $comprobante->mediopago_id = $request->mediopago_id;
            $comprobante->condicion_pago = $request->condicion_pago;
            $comprobante->estado = 'completada';
            $comprobante->observaciones = $request->observaciones;
            $comprobante->save();

            // Guardar detalles si vienen en el request (desde la OC)
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $detalle = new DetalleComprobanteCompra();
                    $detalle->comprobante_compra_id = $comprobante->id;
                    $detalle->producto_id = $item['producto_id'] ?? null;
                    $detalle->descripcion = $item['descripcion'];
                    $detalle->cantidad = $item['cantidad'];
                    $detalle->precio_unitario = $item['precio'];
                    $detalle->subtotal = $item['cantidad'] * $item['precio'];
                    $detalle->igv = isset($item['igv']) ? $item['igv'] : ($detalle->subtotal * 0.18);
                    $detalle->total = $detalle->subtotal + $detalle->igv;
                    $detalle->save();
                }
            }

            // Actualizar estado de la Orden de Compra
            if ($comprobante->ordencompra_id) {
                $oc = Ordencompra::find($comprobante->ordencompra_id);
                if ($oc) {
                    $oc->estado_pago = 'Facturado';
                    $oc->save();
                }
            }

            DB::commit();
            return redirect()->route('admin-comprobantes-compras.index')->with('new_registration', 'ok');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(ComprobanteCompra $admin_comprobantes_compra)
    {
        $admin_comprobantes_compra->load(['proveedor.persona', 'tipocomprobante', 'detalles']);
        return view('ADMINISTRADOR.FINANZAS.comprobantes compras.show', compact('admin_comprobantes_compra'));
    }
}
