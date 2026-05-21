<?php

namespace App\Observers;

use App\Models\Campania;
use App\Models\CampaniaMetrica;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleObserver
{
    public function saved(Sale $sale): void
    {
        try {
            $entraEnPagado =
                ($sale->wasRecentlyCreated && $sale->estado === 'Pagado' && !$sale->anulado)
                || ($sale->wasChanged('estado') && $sale->estado === 'Pagado' && !$sale->anulado);

            if (!$entraEnPagado) {
                return;
            }

            if (DB::table('sale_campania')->where('sale_id', $sale->id)->exists()) {
                return;
            }

            $sale->load('detalles.producto');

            $porCampania = [];

            foreach ($sale->detalles as $detalle) {
                if (!$detalle->producto_id || !$detalle->producto) {
                    continue;
                }

                $precioOriginal = (float) $detalle->producto->precio;
                $precioUnitario = (float) $detalle->precio_unitario;

                if ($precioOriginal <= $precioUnitario) {
                    continue;
                }

                $campania = Campania::activas()
                    ->whereHas('productos', fn($q) => $q->where('productos.id', $detalle->producto_id))
                    ->first();

                if (!$campania) {
                    continue;
                }

                $cantidad = (float) $detalle->cantidad;
                $monto = $precioUnitario * $cantidad;
                $descuento = ($precioOriginal - $precioUnitario) * $cantidad;

                if (!isset($porCampania[$campania->id])) {
                    $porCampania[$campania->id] = ['monto' => 0.0, 'descuento' => 0.0, 'productos' => 0];
                }
                $porCampania[$campania->id]['monto'] += $monto;
                $porCampania[$campania->id]['descuento'] += $descuento;
                $porCampania[$campania->id]['productos'] += (int) $cantidad;
            }

            foreach ($porCampania as $campaniaId => $data) {
                DB::table('sale_campania')->insert([
                    'sale_id'            => $sale->id,
                    'campania_id'        => $campaniaId,
                    'monto_aplicado'     => round($data['monto'], 2),
                    'descuento_aplicado' => round($data['descuento'], 2),
                    'productos_count'    => (int) $data['productos'],
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);

                CampaniaMetrica::registrarPedido(
                    (int) $campaniaId,
                    (float) round($data['monto'], 2),
                    (float) round($data['descuento'], 2),
                    (int) $data['productos']
                );
            }
        } catch (\Throwable $e) {
            Log::error('Error registrando métricas de campaña al pagar venta', [
                'sale_id' => $sale->id ?? null,
                'error'   => $e->getMessage(),
            ]);
        }
    }
}
