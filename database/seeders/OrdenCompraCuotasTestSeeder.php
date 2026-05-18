<?php

namespace Database\Seeders;

use App\Models\Detallecompra;
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

        Detallecompra::create(['ordencompra_id' => $oc1->id, 'producto' => 'Transformador de distribución 25 KVA', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 2, 'cantidadp_ingresar' => 2, 'precio' => 2500.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 5000.00]);
        Detallecompra::create(['ordencompra_id' => $oc1->id, 'producto' => 'Cable eléctrico LSOH 16mm²', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'MTR', 'cantidad' => 500, 'cantidadp_ingresar' => 500, 'precio' => 5.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 2500.00]);
        Detallecompra::create(['ordencompra_id' => $oc1->id, 'producto' => 'Interruptor termomagnético 3x100A', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 5, 'cantidadp_ingresar' => 5, 'precio' => 300.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 1500.00]);

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

        Detallecompra::create(['ordencompra_id' => $oc2->id, 'producto' => 'Tablero eléctrico metálico 24 polos', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 4, 'cantidadp_ingresar' => 4, 'precio' => 1800.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 7200.00]);
        Detallecompra::create(['ordencompra_id' => $oc2->id, 'producto' => 'Luminaria LED industrial 200W', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 20, 'cantidadp_ingresar' => 20, 'precio' => 320.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 6400.00]);
        Detallecompra::create(['ordencompra_id' => $oc2->id, 'producto' => 'Conductor NYY 3x10mm² (rollo 100m)', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'RLL', 'cantidad' => 8, 'cantidadp_ingresar' => 8, 'precio' => 350.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 2800.00]);

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

        Detallecompra::create(['ordencompra_id' => $oc3->id, 'producto' => 'Generador eléctrico trifásico 50 KVA', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 2, 'cantidadp_ingresar' => 2, 'precio' => 8500.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 17000.00]);
        Detallecompra::create(['ordencompra_id' => $oc3->id, 'producto' => 'UPS industrial 10 KVA', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 3, 'cantidadp_ingresar' => 3, 'precio' => 1500.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 4500.00]);
        Detallecompra::create(['ordencompra_id' => $oc3->id, 'producto' => 'Banco de condensadores 30 KVAR', 'producto_id' => '0', 'tipo_producto' => 'Producto', 'umedida' => 'UND', 'cantidad' => 1, 'cantidadp_ingresar' => 1, 'precio' => 2500.00, 'tipo_impuesto_value' => 'IGV', 'subtotal' => 2500.00]);
    }
}
