<?php

namespace Database\Seeders;

use App\Models\Ordencompra;
use App\Models\OrdencompraCuota;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdenCompraCuotasTestSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = Proveedor::all();

        if ($proveedores->isEmpty()) {
            $this->command->warn('No hay proveedores. Ejecute OrdenCompraTestSeeder primero.');
            return;
        }

        // OC 1: Crédito 30 días - 3 cuotas
        $oc1 = Ordencompra::create([
            'codigo' => date('Ymd') . '-C1-OC',
            'slug' => Str::slug(date('Ymd') . '-C1-OC'),
            'fecha' => now()->subDays(15)->format('Y-m-d'),
            'total' => 9000.00,
            'total_pago' => 0,
            'tipo_moneda' => 'PEN',
            'comprobante' => 'Factura',
            'forma_pago' => 'Crédito',
            'plazo_pago' => '30',
            'estado' => 'Pendiente',
            'estado_pago' => 'Pendiente',
            'estado_proceso' => 'Pendiente',
            'proveedor_id' => $proveedores->random()->id,
            'sede_id' => 1,
        ]);

        OrdencompraCuota::create(['ordencompra_id' => $oc1->id, 'numero_cuota' => 1, 'importe' => 3000.00, 'fecha_vencimiento' => now()->subDays(5)->format('Y-m-d')]);
        OrdencompraCuota::create(['ordencompra_id' => $oc1->id, 'numero_cuota' => 2, 'importe' => 3000.00, 'fecha_vencimiento' => now()->addDays(15)->format('Y-m-d')]);
        OrdencompraCuota::create(['ordencompra_id' => $oc1->id, 'numero_cuota' => 3, 'importe' => 3000.00, 'fecha_vencimiento' => now()->addDays(45)->format('Y-m-d')]);

        // OC 2: Crédito 60 días - 2 cuotas
        $oc2 = Ordencompra::create([
            'codigo' => date('Ymd') . '-C2-OC',
            'slug' => Str::slug(date('Ymd') . '-C2-OC'),
            'fecha' => now()->subDays(10)->format('Y-m-d'),
            'total' => 16400.00,
            'total_pago' => 0,
            'tipo_moneda' => 'PEN',
            'comprobante' => 'Factura',
            'forma_pago' => 'Crédito',
            'plazo_pago' => '60',
            'estado' => 'Pendiente',
            'estado_pago' => 'Pendiente',
            'estado_proceso' => 'Pendiente',
            'proveedor_id' => $proveedores->random()->id,
            'sede_id' => 1,
        ]);

        OrdencompraCuota::create(['ordencompra_id' => $oc2->id, 'numero_cuota' => 1, 'importe' => 8200.00, 'fecha_vencimiento' => now()->addDays(20)->format('Y-m-d')]);
        OrdencompraCuota::create(['ordencompra_id' => $oc2->id, 'numero_cuota' => 2, 'importe' => 8200.00, 'fecha_vencimiento' => now()->addDays(50)->format('Y-m-d')]);

        // OC 3: Crédito 90 días - 4 cuotas (una ya vencida)
        $oc3 = Ordencompra::create([
            'codigo' => date('Ymd') . '-C3-OC',
            'slug' => Str::slug(date('Ymd') . '-C3-OC'),
            'fecha' => now()->subDays(40)->format('Y-m-d'),
            'total' => 24000.00,
            'total_pago' => 0,
            'tipo_moneda' => 'PEN',
            'comprobante' => 'Factura',
            'forma_pago' => 'Crédito',
            'plazo_pago' => '90',
            'estado' => 'Pendiente',
            'estado_pago' => 'Pendiente',
            'estado_proceso' => 'Pendiente',
            'proveedor_id' => $proveedores->random()->id,
            'sede_id' => 1,
        ]);

        OrdencompraCuota::create(['ordencompra_id' => $oc3->id, 'numero_cuota' => 1, 'importe' => 6000.00, 'fecha_vencimiento' => now()->subDays(10)->format('Y-m-d')]);
        OrdencompraCuota::create(['ordencompra_id' => $oc3->id, 'numero_cuota' => 2, 'importe' => 6000.00, 'fecha_vencimiento' => now()->addDays(20)->format('Y-m-d')]);
        OrdencompraCuota::create(['ordencompra_id' => $oc3->id, 'numero_cuota' => 3, 'importe' => 6000.00, 'fecha_vencimiento' => now()->addDays(50)->format('Y-m-d')]);
        OrdencompraCuota::create(['ordencompra_id' => $oc3->id, 'numero_cuota' => 4, 'importe' => 6000.00, 'fecha_vencimiento' => now()->addDays(80)->format('Y-m-d')]);
    }
}
