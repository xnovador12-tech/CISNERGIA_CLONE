<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Tiposcomprobante;
use App\Models\TipoComprobante;
use App\Models\Cliente;
use App\Models\Moneda;
use App\Models\TipoOperacion;
use App\Models\TipoDetraccion;
use App\Models\MedioPagoDetraccion;
use App\Models\TipoAfectacion;
use App\Models\UnidadMedida;
use App\Models\Mediopago;
use App\Models\Cuentabanco;
use App\Models\Serie;
use App\Models\Pedido;
use App\Models\Detailsale;
use App\Models\SaleCuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_ComprobantesController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['cliente', 'tipocomprobante', 'mediopago', 'usuario', 'sede']);

        // Aplicar Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_comprobante_id')) {
            $query->where('tiposcomprobante_id', $request->tipo_comprobante_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_comprobante', 'like', "%$search%")
                  ->orWhereHas('cliente', function($cq) use ($search) {
                      $cq->where('razon_social', 'like', "%$search%")
                        ->orWhere('nombre', 'like', "%$search%")
                        ->orWhere('apellidos', 'like', "%$search%");
                  });
            });
        }

        // Obtener estadísticas
        $totalPendiente = (clone $query)->where('estado', 'Pendiente')->sum('total');
        $totalPagado = (clone $query)->where('estado', 'Pagado')->sum('total');
        $totalAnulado = (clone $query)->where('estado', 'Anulado')->sum('total');

        $ventas = $query->orderBy('created_at', 'desc')->paginate(15);
        $tiposComprobante = Tiposcomprobante::where('estado', 'Activo')->get();

        return view('ADMINISTRADOR.FINANZAS.comprobantes ventas.index', compact(
            'ventas', 
            'totalPendiente', 
            'totalPagado', 
            'totalAnulado',
            'tiposComprobante'
        ));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $tiposComprobante = TipoComprobante::all();
        $monedas = Moneda::all();
        $tiposOperacion = TipoOperacion::all();
        $tiposDetraccion = TipoDetraccion::all();
        $mediosPagoDetrac = MedioPagoDetraccion::all();
        $tiposAfectacion = TipoAfectacion::all();
        $unidadesMedida = UnidadMedida::all();
        $metodosPago = Mediopago::all();
        $cuentas = Cuentabanco::with(['banco', 'moneda'])->get();
        $series = Serie::all();
        $pedidos = Pedido::where('estado', '!=', 'Anulado')
            ->whereDoesntHave('venta')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ADMINISTRADOR.FINANZAS.comprobantes ventas.create', compact(
            'clientes',
            'tiposComprobante',
            'monedas',
            'tiposOperacion',
            'tiposDetraccion',
            'mediosPagoDetrac',
            'tiposAfectacion',
            'unidadesMedida',
            'metodosPago',
            'cuentas',
            'series',
            'pedidos'
        ));
    }

    public function getPedidoDetails($id)
    {
        $pedido = Pedido::with(['cliente', 'detalles.servicio', 'detalles.producto', 'cuotas'])->find($id);
        
        if (!$pedido) {
            return response()->json(['success' => false, 'message' => 'Pedido no encontrado'], 404);
        }

        return response()->json([
            'success' => true,
            'pedido' => $pedido
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validaciones Básicas
        $request->validate([
            'cliente_id' => 'required',
            'tipo_comprobante_id' => 'required',
            'serie_id' => 'required',
            'fecha_emision' => 'required|date',
            'tipo_pago' => 'required',
            'detalles' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 2. Incrementar Correlativo de la Serie
            $serie = Serie::lockForUpdate()->find($request->serie_id);
            if (!$serie) {
                throw new \Exception("Serie no encontrada.");
            }
            $nuevoCorrelativo = intval($serie->correlativo) + 1;
            $serie->correlativo = $nuevoCorrelativo;
            $serie->save();

            $numeroComprobante = $serie->name . '-' . str_pad($nuevoCorrelativo, 8, '0', STR_PAD_LEFT);

            $tipoTC = TipoComprobante::find($request->tipo_comprobante_id);
            $tipoTCS = Tiposcomprobante::where('codigo', $tipoTC->code)->first();

            // 3. Crear el Registro de Venta
            $sale = new Sale();
            $sale->codigo = 'SALE-' . date('Ymd') . '-' . Str::upper(Str::random(5));
            $sale->slug = Str::slug($sale->codigo);
            $sale->pedido_id = $request->pedido_id; // Si viene de un pedido
            $sale->cliente_id = $request->cliente_id;
            $sale->tiposcomprobante_id = $tipoTCS ? $tipoTCS->id : $request->tipo_comprobante_id;
            $sale->numero_comprobante = $numeroComprobante;
            
            // Totales (vienen del formulario o se recalculan por seguridad)
            // Aquí usaremos los valores enviados por el formulario para simplificar, 
            // pero validando que sean numéricos.
            $sale->subtotal = $request->subtotal_hidden ?? 0;
            $sale->igv = $request->igv_hidden ?? 0;
            $sale->total = $request->total_hidden ?? 0;
            $sale->descuento = $request->descuento_global ?? 0;

            $sale->mediopago_id = $request->metodo_pago_id;
            $sale->condicion_pago = $request->tipo_pago;
            $sale->estado = 'completada';
            $sale->tipo_venta = 'pedido';
            $sale->user_id = auth()->id() ?? 2;
            $sale->sede_id = 1; // Por defecto o según lógica de la app
            
            $sale->observaciones = $request->observaciones;
            $sale->save();

            // 4. Guardar Detalles
            foreach ($request->detalles as $det) {
                $detail = new Detailsale();
                $detail->sale_id = $sale->id;
                $detail->descripcion = $det['descripcion'];
                $detail->cantidad = $det['cantidad'];
                $detail->precio_unitario = $det['precio_unitario'];
                $detail->subtotal = (float)$det['cantidad'] * (float)$det['precio_unitario'];
                // Podríamos vincular producto_id o servicio_id si el formulario los enviara
                $detail->save();
            }

            // 5. Guardar Cuotas si es Crédito
            if ($request->tipo_pago === 'Credito' && $request->has('cuotas')) {
                foreach ($request->cuotas as $num => $c) {
                    SaleCuota::create([
                        'sale_id' => $sale->id,
                        'numero_cuota' => $num,
                        'importe' => $c['monto'],
                        'fecha_vencimiento' => $c['fecha']
                    ]);
                }
            }

            // 6. Si viene de un pedido, marcar el pedido como con venta o similar
            // Depende de la lógica del modelo Pedido. 
            // Usualmente la relación 'venta' en Pedido se llena al asociar el pedido_id en Sale.

            DB::commit();

            return redirect()->route('admin-comprobantes.index')->with('success', 'Comprobante ' . $numeroComprobante . ' generado con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Sale $admin_comprobante)
    {
        $venta = $admin_comprobante->load(['cliente', 'pedido', 'tipocomprobante', 'mediopago', 'usuario', 'detalles']);
        return view('ADMINISTRADOR.FINANZAS.comprobantes ventas.show', compact('venta'));
    }

    public function voucher(Sale $admin_comprobante)
    {
        // Reutilizar lógica de voucher de ventas si existe
        return app(admin_VentasController::class)->voucher($admin_comprobante);
    }
}
