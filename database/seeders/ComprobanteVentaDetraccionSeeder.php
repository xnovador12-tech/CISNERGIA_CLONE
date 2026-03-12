<?php

namespace Database\Seeders;

use App\Models\ComprobanteVenta;
use App\Models\ComprobanteVentaDetraccion;
use App\Models\TipoDetraccion;
use App\Models\MedioPagoDetraccion;
use Illuminate\Database\Seeder;

class ComprobanteVentaDetraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comprobante = ComprobanteVenta::first();
        $tipoDetraccion = TipoDetraccion::where('code', '037')->first(); // Demás servicios
        $medioPago = MedioPagoDetraccion::where('codigo', '001')->first();

        if ($comprobante && $tipoDetraccion && $medioPago) {
            $montoDetraccion = $comprobante->total * ($tipoDetraccion->porcentaje / 100);
            $montoNeto = $comprobante->total - $montoDetraccion;

            ComprobanteVentaDetraccion::create([
                'comprobante_venta_id' => $comprobante->id,
                'tipo_detraccion_id' => $tipoDetraccion->id,
                'medio_pago_detraccion_id' => $medioPago->id,
                'porcentaje' => $tipoDetraccion->porcentaje,
                'monto_detraccion' => $montoDetraccion,
                'monto_neto' => $montoNeto,
                'estado' => 'Pendiente',
            ]);
        }
    }
}
