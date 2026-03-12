<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\PedidoCuota;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestPedidosSeeder extends Seeder
{
    public function run()
    {
        // Limpiamos pedidos de prueba previos para evitar errores de duplicidad
        Pedido::where('codigo', 'like', 'PED-TEST-%')->delete();

        // 1. Obtener o crear clientes de prueba
        $clienteRuc = Cliente::whereNotNull('ruc')->first() ?: Cliente::create([
            'nombre' => 'Empresa Test SAC',
            'ruc' => '20123456789',
            'direccion' => 'Av. Industrial 123, Lima',
            'tipo_persona' => 'juridica',
            'estado' => 'activo',
            'codigo' => 'CLI-TEST-001',
            'slug' => 'empresa-test-sac'
        ]);

        $clienteDni = Cliente::whereNotNull('dni')->first() ?: Cliente::create([
            'nombre' => 'Juan',
            'apellidos' => 'Perez Test',
            'dni' => '44556677',
            'direccion' => 'Calle Las Flores 456, Surco',
            'tipo_persona' => 'natural',
            'estado' => 'activo',
            'codigo' => 'CLI-TEST-002',
            'slug' => 'juan-perez-test'
        ]);

        $servicio = Servicio::first();
        $producto = Producto::first();

        // 2. CREAR PEDIDO 1: CRÉDITOS CON CUOTAS (PARA FACTURA)
        $p1 = Pedido::create([
            'codigo' => 'PED-TEST-CREDITO',
            'slug' => 'ped-test-credito',
            'cliente_id' => $clienteRuc->id,
            'user_id' => 1,
            'condicion_pago' => 'Credito',
            'tipo' => 'servicio',
            'subtotal' => 1000.00,
            'igv' => 180.00,
            'total' => 1180.00,
            'estado' => 'pendiente',
            'observaciones' => 'Pedido de prueba a crédito con 3 cuotas. Sugerido: FACTURA | Pago: TRANSFERENCIA'
        ]);

        DetallePedido::create([
            'pedido_id' => $p1->id,
            'descripcion' => 'Servicio de Consultoría Premium',
            'servicio_id' => $servicio ? $servicio->id : null,
            'cantidad' => 1,
            'precio_unitario' => 1000.00,
            'subtotal' => 1000.00
        ]);

        // 3 Cuotas
        for ($i = 1; $i <= 3; $i++) {
            PedidoCuota::create([
                'pedido_id' => $p1->id,
                'numero_cuota' => $i,
                'importe' => 1180.00 / 3,
                'fecha_vencimiento' => now()->addMonths($i)->format('Y-m-d')
            ]);
        }

        // 3. CREAR PEDIDO 2: CONTADO (PARA BOLETA)
        $p2 = Pedido::create([
            'codigo' => 'PED-TEST-CONTADO',
            'slug' => 'ped-test-contado',
            'cliente_id' => $clienteDni->id,
            'user_id' => 1,
            'condicion_pago' => 'Contado',
            'tipo' => 'servicio',
            'subtotal' => 500.00,
            'igv' => 90.00,
            'total' => 590.00,
            'estado' => 'pendiente',
            'observaciones' => 'Pedido de prueba al contado. Sugerido: BOLETA | Pago: EFECTIVO'
        ]);

        DetallePedido::create([
            'pedido_id' => $p2->id,
            'descripcion' => 'Producto de Prueba ABC',
            'producto_id' => $producto ? $producto->id : null,
            'cantidad' => 2,
            'precio_unitario' => 250.00,
            'subtotal' => 500.00
        ]);

        echo "Pedidos de prueba creados exitosamente.\n";
    }
}
