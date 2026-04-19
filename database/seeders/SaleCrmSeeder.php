<?php

namespace Database\Seeders;

use App\Models\CotizacionCrm;
use App\Models\Detailsale;
use App\Models\Oportunidad;
use App\Models\Pedido;
use App\Models\Sale;
use App\Models\Tiposcomprobante;
use App\Models\Mediopago;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SaleCrmSeeder extends Seeder
{
    /**
     * Crea ventas (comprobantes) a partir de pedidos entregados.
     *
     * Replica el flujo real de admin_PedidosController::generarComprobante():
     *   Pedido (aprobado/entregado) → Sale + DetailSales
     *
     * Además vincula cada venta con su oportunidad y cotización CRM de origen,
     * completando la trazabilidad: Oportunidad → Cotización → Pedido → Venta
     *
     * Dependencias: PedidoCrmSeeder (debe ejecutarse antes)
     */
    public function run(): void
    {
        // Buscar pedidos entregados que NO tengan venta asociada aún
        $pedidos = Pedido::where('estado', 'entregado')
            ->whereDoesntHave('venta')
            ->with(['cliente', 'detalles', 'usuario'])
            ->orderBy('id')
            ->get();

        if ($pedidos->isEmpty()) {
            return;
        }

        // Datos de referencia
        $factura       = Tiposcomprobante::where('name', 'Factura')->first();
        $boleta        = Tiposcomprobante::where('name', 'Boleta de venta')->first();
        $transferencia = Mediopago::where('name', 'Transferencia Bancaria')->first();
        $efectivo      = Mediopago::where('name', 'Efectivo')->first();

        $totalVentas = 0;

        foreach ($pedidos as $index => $pedido) {
            $cliente = $pedido->cliente;
            if (!$cliente) {
                continue;
            }

            // ── Determinar comprobante y medio de pago ──
            // Jurídica = Factura + Transferencia, Natural = Boleta + variado
            $esJuridica  = $cliente->tipo_persona === 'juridica';
            $comprobante = $esJuridica ? $factura : $boleta;
            $medioPago   = $esJuridica ? $transferencia : ($index % 2 === 0 ? $transferencia : $efectivo);

            // ── Buscar oportunidad y cotización de origen (trazabilidad CRM) ──
            $oportunidad = null;
            $cotizacion  = null;

            if ($cliente->prospecto_id) {
                $oportunidad = Oportunidad::where('prospecto_id', $cliente->prospecto_id)
                    ->where('etapa', 'ganada')
                    ->first();

                if ($oportunidad) {
                    $cotizacion = CotizacionCrm::where('oportunidad_id', $oportunidad->id)
                        ->where('estado', 'aceptada')
                        ->first();

                    // Fallback: tomar la más reciente si no hay aceptada
                    if (!$cotizacion) {
                        $cotizacion = CotizacionCrm::where('oportunidad_id', $oportunidad->id)
                            ->latest()
                            ->first();
                    }
                }
            }

            // ── Generar código de venta ──
            $numero     = Sale::count() + 1;
            $codigoVenta = 'VTA-' . date('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

            // ── Generar número de comprobante ──
            $seriePrefix     = $esJuridica ? 'F001' : 'B001';
            $numComprobante  = $seriePrefix . '-' . str_pad($numero, 7, '0', STR_PAD_LEFT);

            // ── Datos del proyecto solar (desde oportunidad) ──
            $tipoProyecto = $oportunidad->tipo_proyecto ?? $cliente->segmento ?? null;
            $potenciaKw   = null;

            // Estimar potencia desde los paneles del pedido
            if ($pedido->detalles->isNotEmpty()) {
                $panelItems = $pedido->detalles->filter(function ($d) {
                    return $d->producto_id && Str::contains(strtolower($d->descripcion), 'panel');
                });
                // Estimación: cada panel ≈ 0.5kW
                $totalPaneles = $panelItems->sum('cantidad');
                $potenciaKw   = $totalPaneles > 0 ? round($totalPaneles * 0.55, 1) : null;
            }

            // ── Crear venta ──
            $venta = Sale::create([
                'codigo'              => $codigoVenta,
                'slug'                => Str::slug($codigoVenta),
                'pedido_id'           => $pedido->id,
                'cliente_id'          => $cliente->id,
                'tiposcomprobante_id' => $comprobante?->id,
                'numero_comprobante'  => $numComprobante,
                'subtotal'            => $pedido->subtotal,
                'descuento'           => $pedido->descuento_monto,
                'igv'                 => $pedido->igv,
                'total'               => $pedido->total,
                'mediopago_id'        => $medioPago?->id,
                'estado'              => 'completada',
                'user_id'             => $pedido->user_id,
                'sede_id'             => $cliente->sede_id,
                'tipo_venta'          => $cliente->origen === 'ecommerce' ? 'ecommerce' : 'pedido',
                'tipo_proyecto'       => $tipoProyecto,
                'potencia_kw'         => $potenciaKw,
                'fecha_instalacion'   => $pedido->fecha_entrega_estimada,
                'garantia_sistema_años' => $tipoProyecto === 'industrial' ? 15 : 10,
                'consumo_mensual_kwh' => match ($tipoProyecto) {
                    'residencial' => rand(200, 500),
                    'comercial'   => rand(800, 3000),
                    'industrial'  => rand(5000, 15000),
                    'agricola'    => rand(1000, 4000),
                    default       => null,
                },
                'numero_proyecto'     => $oportunidad?->codigo,
                'observaciones'       => "Comprobante generado desde Pedido {$pedido->codigo}."
                    . ($oportunidad ? " Oportunidad: {$oportunidad->codigo}." : '')
                    . ($cotizacion ? " Cotización: {$cotizacion->codigo}." : ''),
            ]);

            // ── Copiar detalles del pedido a la venta ──
            foreach ($pedido->detalles as $detalle) {
                Detailsale::create([
                    'sale_id'              => $venta->id,
                    'producto_id'          => $detalle->producto_id,
                    'servicio_id'          => $detalle->servicio_id,
                    'tipo'                 => $detalle->tipo ?? 'producto',
                    'descripcion'          => $detalle->descripcion,
                    'cantidad'             => $detalle->cantidad,
                    'precio_unitario'      => $detalle->precio_unitario,
                    'descuento_porcentaje' => 0,
                    'descuento_monto'      => $detalle->descuento_monto ?? 0,
                    'subtotal'             => $detalle->subtotal,
                    'garantia_años'        => Str::contains(strtolower($detalle->descripcion), 'panel') ? 25
                        : (Str::contains(strtolower($detalle->descripcion), 'inversor') ? 10
                        : (Str::contains(strtolower($detalle->descripcion), 'bater') ? 10
                        : null)),
                ]);
            }

            $totalVentas++;
            $comprobanteLabel = $esJuridica ? 'Factura' : 'Boleta';
        }

        $montoTotal = Sale::sum('total');
    }
}
