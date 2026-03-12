<?php

namespace Database\Seeders;

use App\Models\ComprobanteVentaDetraccion;
use App\Models\IngresoFinanciero;
use App\Models\MovimientoCuentaDetraccion;
use Illuminate\Database\Seeder;

class MovimientoCuentaDetraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detraccion = ComprobanteVentaDetraccion::first();
        $ingreso = IngresoFinanciero::first();

        if ($detraccion && $ingreso) {
            MovimientoCuentaDetraccion::create([
                'tipo_movimiento' => 'Detracción',
                'monto' => $detraccion->monto_detraccion,
                'comprobante_venta_detraccion_id' => $detraccion->id,
                'ingreso_financiero_id' => $ingreso->id,
                'descripcion' => 'Registro automático de detracción',
            ]);
        }
    }
}
