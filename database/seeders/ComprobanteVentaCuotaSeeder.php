<?php

namespace Database\Seeders;

use App\Models\ComprobanteVenta;
use App\Models\ComprobanteVentaCuota;
use Illuminate\Database\Seeder;

class ComprobanteVentaCuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comprobante = ComprobanteVenta::first();

        if ($comprobante) {
            $montoCuota = $comprobante->total / 2;

            ComprobanteVentaCuota::create([
                'comprobante_venta_id' => $comprobante->id,
                'numero_cuota' => 1,
                'monto' => $montoCuota,
                'fecha_vencimiento' => now()->addMonth(1)->format('Y-m-d'),
                'estado' => 'Pendiente',
            ]);

            ComprobanteVentaCuota::create([
                'comprobante_venta_id' => $comprobante->id,
                'numero_cuota' => 2,
                'monto' => $montoCuota,
                'fecha_vencimiento' => now()->addMonth(2)->format('Y-m-d'),
                'estado' => 'Pendiente',
            ]);
        }
    }
}
