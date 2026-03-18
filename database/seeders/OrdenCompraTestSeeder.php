<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Proveedor;
use App\Models\Ordencompra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdenCompraTestSeeder extends Seeder
{
    public function run(): void
    {
        // Crear personas para proveedores
        $proveedoresData = [
            ['name' => 'Distribuidora Solar SAC', 'nro_identificacion' => '20512345678'],
            ['name' => 'Importaciones Eléctricas EIRL', 'nro_identificacion' => '20598765432'],
            ['name' => 'Ferretería Industrial Perú SA', 'nro_identificacion' => '20534567890'],
        ];

        foreach ($proveedoresData as $data) {
            $persona = Persona::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'surnames' => '',
                'identificacion' => 'RUC',
                'nro_identificacion' => $data['nro_identificacion'],
                'tipo_persona' => 'juridica',
                'sede_id' => 1,
            ]);

            Proveedor::create([
                'persona_id' => $persona->id,
                'giro' => 'Suministros',
                'estado' => 'Activo',
                'departamento_id' => 1,
            ]);
        }

        $proveedores = Proveedor::all();

        // Crear órdenes de compra
        $ordenes = [
            ['total' => 12500.00, 'estado_pago' => 'Pendiente', 'forma_pago' => 'Transferencia'],
            ['total' => 8750.50, 'estado_pago' => 'Pendiente', 'forma_pago' => 'Transferencia'],
            ['total' => 3200.00, 'estado_pago' => 'Pendiente', 'forma_pago' => 'Efectivo'],
            ['total' => 15800.00, 'estado_pago' => 'Pendiente', 'forma_pago' => 'Crédito 30 días'],
            ['total' => 4500.75, 'estado_pago' => 'Pendiente', 'forma_pago' => 'Transferencia'],
        ];

        foreach ($ordenes as $i => $data) {
            $codigo = date('Ymd') . '-' . ($i + 1) . '-OC';

            Ordencompra::create([
                'codigo' => $codigo,
                'slug' => Str::slug($codigo),
                'fecha' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'total' => $data['total'],
                'total_pago' => 0,
                'tipo_moneda' => 'PEN',
                'comprobante' => 'Factura',
                'forma_pago' => $data['forma_pago'],
                'estado' => 'Pendiente',
                'estado_pago' => $data['estado_pago'],
                'estado_proceso' => 'Pendiente',
                'proveedor_id' => $proveedores->random()->id,
                'sede_id' => 1,
            ]);
        }
    }
}
