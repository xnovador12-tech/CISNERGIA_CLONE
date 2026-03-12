<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\PedidoCuota;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestComprobantesVentasDataSeeder extends Seeder
{
    public function run()
    {
        // Limpiamos datos previos de prueba
        Pedido::where('codigo', 'like', 'PED-VT-%')->delete();
        Cliente::where('codigo', 'like', 'CLI-VT-%')->delete();

        $user = User::first() ?? User::factory()->create();

        // 1. Clientes de Prueba
        $clientes = [
            [
                'nombre' => 'Tecnología Global SAC',
                'razon_social' => 'Tecnología Global SAC',
                'ruc' => '20601234567',
                'direccion' => 'Av. Javier Prado 456, San Isidro',
                'tipo_persona' => 'juridica',
                'codigo' => 'CLI-VT-001',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'María',
                'apellidos' => 'Rodríguez López',
                'dni' => '12345678',
                'direccion' => 'Calle Los Álamos 789, Miraflores',
                'tipo_persona' => 'natural',
                'codigo' => 'CLI-VT-002',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Constructor Cisnergia EIRL',
                'razon_social' => 'Constructor Cisnergia EIRL',
                'ruc' => '20559988776',
                'direccion' => 'Parque Industrial Sur, Chorrillos',
                'tipo_persona' => 'juridica',
                'codigo' => 'CLI-VT-003',
                'estado' => 'activo'
            ]
        ];

        $clienteModels = [];
        foreach ($clientes as $c) {
            $c['slug'] = Str::slug($c['codigo']);
            $clienteModels[] = Cliente::create($c);
        }

        $servicio = Servicio::first();
        $producto = Producto::first();

        // 2. Pedidos de Prueba
        $pedidos = [
            [
                'codigo' => 'PED-VT-001',
                'cliente_id' => $clienteModels[0]->id, // Juridica
                'condicion_pago' => 'Credito',
                'subtotal' => 2000.00,
                'igv' => 360.00,
                'total' => 2360.00,
                'observaciones' => 'Prueba 1: Empresa SAC a Crédito. Sugerido: FACTURA.'
            ],
            [
                'codigo' => 'PED-VT-002',
                'cliente_id' => $clienteModels[1]->id, // Natural
                'condicion_pago' => 'Contado',
                'subtotal' => 150.00,
                'igv' => 27.00,
                'total' => 177.00,
                'observaciones' => 'Prueba 2: Persona Natural al Contado. Sugerido: BOLETA.'
            ],
            [
                'codigo' => 'PED-VT-003',
                'cliente_id' => $clienteModels[2]->id, // Juridica
                'condicion_pago' => 'Contado',
                'subtotal' => 5000.00,
                'igv' => 900.00,
                'total' => 5900.00,
                'observaciones' => 'Prueba 3: Empresa EIRL al Contado con Detracción. Sugerido: FACTURA.'
            ]
        ];

        foreach ($pedidos as $pData) {
            $pData['slug'] = Str::slug($pData['codigo']);
            $pData['user_id'] = $user->id;
            $pData['estado'] = 'pendiente';
            $pData['tipo'] = 'servicio';

            $pedido = Pedido::create($pData);

            // Detalle
            DetallePedido::create([
                'pedido_id' => $pedido->id,
                'descripcion' => 'Servicio Técnico Especializado - ' . $pedido->codigo,
                'servicio_id' => $servicio ? $servicio->id : null,
                'cantidad' => 1,
                'precio_unitario' => $pedido->subtotal,
                'subtotal' => $pedido->subtotal
            ]);

            // Cuotas si es crédito
            if ($pedido->condicion_pago === 'Credito') {
                for ($i = 1; $i <= 2; $i++) {
                    PedidoCuota::create([
                        'pedido_id' => $pedido->id,
                        'numero_cuota' => $i,
                        'importe' => $pedido->total / 2,
                        'fecha_vencimiento' => now()->addMonths($i)->format('Y-m-d')
                    ]);
                }
            }
        }

        echo "Se han creado 3 nuevos pedidos de prueba (PED-VT-001 a 003) para Comprobantes de Ventas.\n";
    }
}
