<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\NotaDetalle;
use App\Models\Sale;
use App\Models\Tiposcomprobante;
use App\Models\SerieComprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class admin_NotasController extends Controller
{
    public function index(Request $request)
    {
        $query = Nota::with(['sale.cliente', 'sale.tipocomprobante', 'tipocomprobante', 'usuario'])
            ->where('estado', 'emitida')
            ->orderBy('created_at', 'desc');

        if ($request->has('tipo') && in_array($request->tipo, ['nc', 'nd'])) {
            $codigoTipo = $request->tipo === 'nc' ? '07' : '08';
            $query->whereHas('tipocomprobante', fn($q) => $q->where('codigo', $codigoTipo));
        }

        $notas = $query->get();

        $notasCredito = $notas->filter(fn($n) => $n->tipocomprobante && $n->tipocomprobante->codigo === '07');
        $notasDebito = $notas->filter(fn($n) => $n->tipocomprobante && $n->tipocomprobante->codigo === '08');

        return view('ADMINISTRADOR.FINANZAS.notas.index', compact('notas', 'notasCredito', 'notasDebito'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'tipo' => 'required|in:nc,nd',
        ]);

        $venta = Sale::with(['cliente', 'tipocomprobante', 'detalles'])->findOrFail($request->sale_id);

        // Solo facturas y boletas pueden tener NC/ND
        if (!in_array($venta->tipocomprobante->codigo, ['01', '03'])) {
            return back()->with('error', 'Solo se pueden emitir notas sobre Facturas o Boletas.');
        }

        $tipo = $request->tipo;
        $motivos = $tipo === 'nc' ? Nota::MOTIVOS_NC : Nota::MOTIVOS_ND;

        // Determinar serie automáticamente
        $serie = $this->determinarSerie($venta, $tipo);
        $previewNumero = $serie
            ? $serie->serie . '-' . str_pad(($serie->correlativo->numero ?? 0) + 1, 8, '0', STR_PAD_LEFT)
            : 'N/A';

        // Calcular total NC previas para validación
        $totalNCPrevias = $venta->notas()
            ->whereHas('tipocomprobante', fn($q) => $q->where('codigo', '07'))
            ->where('estado', 'emitida')
            ->sum('total');

        return view('ADMINISTRADOR.FINANZAS.notas.create', compact('venta', 'tipo', 'motivos', 'previewNumero', 'totalNCPrevias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'tipo' => 'required|in:nc,nd',
            'motivo_codigo' => 'required|string|max:2',
            'observaciones' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.descripcion' => 'required|string',
            'items.*.cantidad' => 'required|numeric|min:0.01',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.producto_id' => 'nullable|integer',
            'items.*.servicio_id' => 'nullable|integer',
        ]);

        $venta = Sale::with(['tipocomprobante'])->findOrFail($validated['sale_id']);
        $tipo = $validated['tipo'];

        // Obtener motivos y validar código
        $motivos = $tipo === 'nc' ? Nota::MOTIVOS_NC : Nota::MOTIVOS_ND;
        if (!isset($motivos[$validated['motivo_codigo']])) {
            return back()->with('error', 'Motivo inválido.')->withInput();
        }

        // Calcular montos
        $subtotal = 0;
        foreach ($validated['items'] as $item) {
            $subtotal += round($item['cantidad'] * $item['precio_unitario'], 2);
        }
        $igv = round($subtotal * 0.18, 2);
        $total = round($subtotal + $igv, 2);

        // Validar que NC no exceda total disponible
        if ($tipo === 'nc') {
            $totalNCPrevias = $venta->notas()
                ->whereHas('tipocomprobante', fn($q) => $q->where('codigo', '07'))
                ->where('estado', 'emitida')
                ->sum('total');

            if ($total > ($venta->total - $totalNCPrevias + 0.05)) {
                return back()->with('error', 'El monto de la Nota de Crédito (S/ ' . number_format($total, 2) . ') excede el saldo disponible del comprobante (S/ ' . number_format($venta->total - $totalNCPrevias, 2) . ').')->withInput();
            }
        }

        // Determinar serie y tipo comprobante
        $serie = $this->determinarSerie($venta, $tipo);
        if (!$serie) {
            return back()->with('error', 'No se encontró una serie disponible para este tipo de nota.')->withInput();
        }

        $codigoNota = $tipo === 'nc' ? '07' : '08';
        $tipoComprobante = Tiposcomprobante::where('codigo', $codigoNota)->first();

        DB::transaction(function () use ($validated, $venta, $tipo, $motivos, $serie, $tipoComprobante, $subtotal, $igv, $total) {
            // Generar número de comprobante
            $numeroComprobante = $serie->generarNumero();

            // Generar código interno
            $prefijo = $tipo === 'nc' ? 'NC' : 'ND';
            $ultimaNota = Nota::where('codigo', 'like', $prefijo . '-' . date('Y') . '-%')->orderBy('id', 'desc')->first();
            $secuencia = 1;
            if ($ultimaNota) {
                $partes = explode('-', $ultimaNota->codigo);
                $secuencia = (int) end($partes) + 1;
            }
            $codigo = $prefijo . '-' . date('Y') . '-' . str_pad($secuencia, 5, '0', STR_PAD_LEFT);
            $slug = Str::slug($codigo);

            // Crear nota
            $nota = Nota::create([
                'codigo' => $codigo,
                'slug' => $slug,
                'sale_id' => $venta->id,
                'tiposcomprobante_id' => $tipoComprobante->id,
                'numero_comprobante' => $numeroComprobante,
                'motivo_codigo' => $validated['motivo_codigo'],
                'motivo_descripcion' => $motivos[$validated['motivo_codigo']],
                'subtotal' => $subtotal,
                'igv' => $igv,
                'total' => $total,
                'observaciones' => $validated['observaciones'],
                'estado' => 'emitida',
                'user_id' => auth()->id(),
                'sede_id' => $venta->sede_id,
                'fecha_emision' => now()->format('Y-m-d'),
            ]);

            // Crear detalles
            foreach ($validated['items'] as $item) {
                NotaDetalle::create([
                    'nota_id' => $nota->id,
                    'producto_id' => $item['producto_id'] ?? null,
                    'servicio_id' => $item['servicio_id'] ?? null,
                    'descripcion' => $item['descripcion'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => round($item['cantidad'] * $item['precio_unitario'], 2),
                ]);
            }

            // Efecto en venta original (solo NC)
            if ($tipo === 'nc' && in_array($validated['motivo_codigo'], ['01', '06'])) {
                $venta->update(['estado' => 'anulada']);
            }
        });

        $prefijo = $tipo === 'nc' ? 'Nota de Crédito' : 'Nota de Débito';
        return redirect()->route('admin-notas.index')->with('success', $prefijo . ' emitida exitosamente.');
    }

    public function show(Nota $admin_nota)
    {
        $nota = $admin_nota->load(['sale.cliente', 'sale.tipocomprobante', 'detalles', 'tipocomprobante', 'usuario']);

        return view('ADMINISTRADOR.FINANZAS.notas.show', compact('nota'));
    }

    public function anular(Nota $admin_nota)
    {
        $admin_nota->update(['estado' => 'anulada']);

        return back()->with('success', 'Nota anulada exitosamente.');
    }

    private function determinarSerie(Sale $sale, string $tipo): ?SerieComprobante
    {
        $codigoOriginal = $sale->tipocomprobante->codigo;
        $codigoNota = $tipo === 'nc' ? '07' : '08';

        $serieMap = [
            '01' => ['07' => 'FC01', '08' => 'FD01'],
            '03' => ['07' => 'BC01', '08' => 'BD01'],
        ];

        if (!isset($serieMap[$codigoOriginal][$codigoNota])) {
            return null;
        }

        $serieCodigo = $serieMap[$codigoOriginal][$codigoNota];
        $tipoNota = Tiposcomprobante::where('codigo', $codigoNota)->first();

        if (!$tipoNota) return null;

        return SerieComprobante::where('tiposcomprobante_id', $tipoNota->id)
            ->where('serie', $serieCodigo)
            ->where('activo', true)
            ->first();
    }
}
