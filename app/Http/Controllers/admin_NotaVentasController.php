<?php

namespace App\Http\Controllers;

use App\Models\Detailsale;
use App\Models\Sale;
use App\Models\Serie;
use App\Models\SunatMotivoNota;
use App\Models\Tiposcomprobante;
use App\Models\VentaReferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_NotaVentasController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['cliente', 'tipocomprobante', 'ventaReferencia.ventaReferenciada.tipocomprobante', 'ventaReferencia.sunatMotivoNota', 'usuario'])
            ->whereHas('tipocomprobante', fn($q) => $q->whereIn('codigo', ['07', '08']))
            ->where('estado', 'emitida')
            ->orderBy('created_at', 'desc');

        if ($request->has('tipo') && in_array($request->tipo, ['nc', 'nd'])) {
            $codigoTipo = $request->tipo === 'nc' ? '07' : '08';
            $query->whereHas('tipocomprobante', fn($q) => $q->where('codigo', $codigoTipo));
        }

        $notas = $query->get();

        $notasCredito = $notas->filter(fn($n) => $n->tipocomprobante?->codigo === '07');
        $notasDebito  = $notas->filter(fn($n) => $n->tipocomprobante?->codigo === '08');

        return view('ADMINISTRADOR.FINANZAS.notas.index', compact('notas', 'notasCredito', 'notasDebito'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'tipo'    => 'required|in:nc,nd',
        ]);

        $venta = Sale::with(['cliente', 'tipocomprobante', 'detalles'])->findOrFail($request->sale_id);

        if (!in_array($venta->tipocomprobante?->codigo, ['01', '03'])) {
            return back()->with('error', 'Solo se pueden emitir notas sobre Facturas o Boletas.');
        }

        if ($venta->anulado) {
            return back()->with('error', 'Este comprobante ha sido anulado y no admite más notas.');
        }

        $tipo     = $request->tipo;
        $codigo   = $tipo === 'nc' ? '07' : '08';
        $motivos  = SunatMotivoNota::activos()->paraTipoComprobante($codigo)->orderBy('codigo')->get();

        $serie = $this->determinarSerie($venta, $tipo);
        $previewNumero = $serie
            ? $serie->serie . '-' . str_pad($serie->correlativo + 1, 8, '0', STR_PAD_LEFT)
            : 'N/A';

        $totalNCPrevias = $this->calcularTotalNCPrevias($venta);

        return view('ADMINISTRADOR.FINANZAS.notas.create', compact(
            'venta', 'tipo', 'motivos', 'previewNumero', 'totalNCPrevias'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id'              => 'required|exists:sales,id',
            'tipo'                 => 'required|in:nc,nd',
            'sunat_motivo_nota_id' => 'required|exists:sunat_motivos_nota,id',
            'observaciones'        => 'nullable|string',
            'items'                => 'required|array|min:1',
            'items.*.detalle_id'   => 'required|integer|exists:detail_sales,id',
            'items.*.descripcion'  => 'required|string',
            'items.*.cantidad'     => 'required|numeric|min:0.01',
            'items.*.producto_id'  => 'nullable|integer',
            'items.*.servicio_id'  => 'nullable|integer',
        ]);

        $venta = Sale::with(['tipocomprobante', 'detalles'])->findOrFail($validated['sale_id']);
        $tipo  = $validated['tipo'];

        if ($venta->anulado) {
            return back()->with('error', 'Este comprobante ha sido anulado y no admite más notas.')->withInput();
        }

        $codigoNota = $tipo === 'nc' ? '07' : '08';
        $motivo = SunatMotivoNota::whereHas('tipocomprobante', fn($q) => $q->where('codigo', $codigoNota))
            ->findOrFail($validated['sunat_motivo_nota_id']);

        // Calcular montos proporcionalmente respetando descuentos globales de la venta original
        $detallesMap       = $venta->detalles->keyBy('id');
        $sumAllSubtotales  = $venta->detalles->sum('subtotal');

        $selectedSubtotal = collect($validated['items'])->sum(function ($item) use ($detallesMap) {
            $detalle    = $detallesMap[$item['detalle_id']] ?? null;
            $originalQty = $detalle?->cantidad ?: 1;
            $detalleSubtotal = $detalle?->subtotal ?: 0;
            return ($item['cantidad'] / $originalQty) * $detalleSubtotal;
        });

        $ratio    = $sumAllSubtotales > 0 ? $selectedSubtotal / $sumAllSubtotales : 0;
        $subtotal = round($ratio * $venta->subtotal, 2);
        $igv      = round($ratio * $venta->igv, 2);
        $total    = round($ratio * $venta->total, 2);

        // Validar que NC no exceda total disponible
        if ($tipo === 'nc') {
            $totalNCPrevias = $this->calcularTotalNCPrevias($venta);
            if ($total > ($venta->total - $totalNCPrevias + 0.05)) {
                return back()
                    ->with('error', 'El monto de la Nota de Crédito (S/ ' . number_format($total, 2) .
                        ') excede el saldo disponible del comprobante (S/ ' .
                        number_format($venta->total - $totalNCPrevias, 2) . ').')
                    ->withInput();
            }
        }

        $serie = $this->determinarSerie($venta, $tipo);
        if (!$serie) {
            return back()->with('error', 'No se encontró una serie disponible para este tipo de nota.')->withInput();
        }

        $tipoComprobante = Tiposcomprobante::where('codigo', $codigoNota)->firstOrFail();

        DB::transaction(function () use ($validated, $venta, $tipo, $motivo, $serie, $tipoComprobante, $subtotal, $igv, $total, $detallesMap) {
            $numeroComprobante = $serie->generarNumero();

            $prefijo  = $tipo === 'nc' ? 'NC' : 'ND';
            $ultimaNC = Sale::whereHas('tipocomprobante', fn($q) => $q->where('codigo', $tipoComprobante->codigo))
                ->where('codigo', 'like', $prefijo . '-' . date('Y') . '-%')
                ->orderBy('id', 'desc')
                ->first();
            $secuencia = 1;
            if ($ultimaNC) {
                $partes    = explode('-', $ultimaNC->codigo);
                $secuencia = (int) end($partes) + 1;
            }
            $codigo = $prefijo . '-' . date('Y') . '-' . str_pad($secuencia, 5, '0', STR_PAD_LEFT);

            $notaVenta = Sale::create([
                'codigo'              => $codigo,
                'slug'                => Str::slug($codigo),
                'cliente_id'          => $venta->cliente_id,
                'tiposcomprobante_id' => $tipoComprobante->id,
                'serie_id'            => $serie->id,
                'serie'               => $serie->serie,
                'correlativo'         => $serie->correlativo,
                'numero_comprobante'  => $numeroComprobante,
                'subtotal'            => $subtotal,
                'descuento'           => 0,
                'igv'                 => $igv,
                'total'               => $total,
                'mediopago_id'        => $venta->mediopago_id,
                'condicion_pago'      => $venta->condicion_pago,
                'estado'              => 'emitida',
                'user_id'             => auth()->id(),
                'sede_id'             => $venta->sede_id,
                'observaciones'       => $validated['observaciones'],
            ]);

            foreach ($validated['items'] as $item) {
                $detalle     = $detallesMap[$item['detalle_id']] ?? null;
                $originalQty = $detalle?->cantidad ?: 1;
                // Precio efectivo por unidad (ya incluye descuentos del ítem)
                $precioEfectivo = $detalle ? round($detalle->subtotal / $originalQty, 6) : 0;
                $itemSubtotal   = round($item['cantidad'] * $precioEfectivo, 2);

                Detailsale::create([
                    'sale_id'          => $notaVenta->id,
                    'producto_id'      => $item['producto_id'] ?? null,
                    'servicio_id'      => $item['servicio_id'] ?? null,
                    'tipo'             => ($item['producto_id'] ?? null) ? 'producto' : 'servicio',
                    'descripcion'      => $item['descripcion'],
                    'cantidad'         => $item['cantidad'],
                    'precio_unitario'  => $precioEfectivo,
                    'subtotal'         => $itemSubtotal,
                ]);
            }

            VentaReferencia::create([
                'sale_id'              => $notaVenta->id,
                'venta_referenciada_id' => $venta->id,
                'sunat_motivo_nota_id'  => $motivo->id,
            ]);

            // Para NC con motivos de anulación/devolución total, marcar venta original como anulada
            if ($tipo === 'nc' && in_array($motivo->codigo, ['01', '06'])) {
                $venta->update(['estado' => 'anulada', 'anulado' => true]);
            }
        });

        $prefijo = $tipo === 'nc' ? 'Nota de Crédito' : 'Nota de Débito';
        return redirect()->route('admin-nota-ventas.index')->with('success', $prefijo . ' emitida exitosamente.');
    }

    public function show(Sale $admin_nota_venta)
    {
        $nota = $admin_nota_venta->load([
            'cliente',
            'tipocomprobante',
            'detalles.producto',
            'detalles.servicio',
            'ventaReferencia.ventaReferenciada.cliente',
            'ventaReferencia.ventaReferenciada.tipocomprobante',
            'ventaReferencia.sunatMotivoNota',
            'usuario',
        ]);

        return view('ADMINISTRADOR.FINANZAS.notas.show', compact('nota'));
    }

    public function anular(Sale $admin_nota_venta)
    {
        $admin_nota_venta->update(['estado' => 'anulada']);

        return back()->with('success', 'Nota anulada exitosamente.');
    }

    private function calcularTotalNCPrevias(Sale $venta): float
    {
        return (float) Sale::where('estado', 'emitida')
            ->whereHas('tipocomprobante', fn($q) => $q->where('codigo', '07'))
            ->whereHas('ventaReferencia', fn($q) => $q->where('venta_referenciada_id', $venta->id))
            ->sum('total');
    }

    private function determinarSerie(Sale $sale, string $tipo): ?Serie
    {
        $codigoOriginal = $sale->tipocomprobante?->codigo;
        $codigoNota     = $tipo === 'nc' ? '07' : '08';

        $serieMap = [
            '01' => ['07' => 'FC01', '08' => 'FD01'],
            '03' => ['07' => 'BC01', '08' => 'BD01'],
        ];

        if (!isset($serieMap[$codigoOriginal][$codigoNota])) {
            return null;
        }

        $tipoNota = Tiposcomprobante::where('codigo', $codigoNota)->first();
        if (!$tipoNota) return null;

        return Serie::where('tiposcomprobante_id', $tipoNota->id)
            ->where('serie', $serieMap[$codigoOriginal][$codigoNota])
            ->first();
    }
}
