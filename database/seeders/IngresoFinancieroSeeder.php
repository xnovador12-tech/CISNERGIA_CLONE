<?php

namespace Database\Seeders;

use App\Models\AperturaCierreCaja;
use App\Models\Cliente;
use App\Models\Cuentabanco;
use App\Models\IngresoFinanciero;
use App\Models\Mediopago;
use App\Models\Moneda;
use App\Models\TipoComprobante;
use App\Models\TipoIngreso;
use App\Models\User;
use Illuminate\Database\Seeder;

class IngresoFinancieroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $cliente = Cliente::first();
        $cuenta = Cuentabanco::first();
        $apertura = AperturaCierreCaja::first();
        $moneda = Moneda::where('descripcion', 'SOLES')->first();
        $tipoIngreso = TipoIngreso::first();
        $tipoComprobante = TipoComprobante::first();
        $metodoPago = Mediopago::first();

        if ($user && $cliente && $cuenta && $apertura && $moneda && $tipoIngreso) {
            IngresoFinanciero::create([
                'user_id' => $user->id,
                'cliente_id' => $cliente->id,
                'fecha_movimiento' => now()->format('Y-m-d'),
                'hora_movimiento' => now()->format('H:i:s'),
                'cuenta_bancaria_id' => $cuenta->id,
                'origen_tipo' => 'VENTA',
                'apertura_caja_id' => $apertura->id,
                'monto' => 500.00,
                'moneda_id' => $moneda->id,
                'nombre' => 'Recibo de Pago 001',
                'numero_operacion' => '123456789',
                'tipo_ingreso_id' => $tipoIngreso->id,
                'tipo_comprobante_id' => $tipoComprobante ? $tipoComprobante->id : null,
                'comprobante' => 'F001-000001',
                'descripcion' => 'Pago de factura de venta',
                'metodo_pago_id' => $metodoPago ? $metodoPago->id : null,
            ]);
        }
    }
}
