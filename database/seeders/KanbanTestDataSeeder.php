<?php

namespace Database\Seeders;

use App\Models\ChecklistItem;
use App\Models\Persona;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KanbanTestDataSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. DISTRITOS (Lima) - usa datos del UbigeoSeeder
        // =============================================
        $provinciaId = DB::table('provincias')->where('nombre', 'Lima')->value('id');

        // Obtener distritos existentes del UbigeoSeeder
        $distritosNombres = ['San Isidro', 'Miraflores', 'Santiago de Surco', 'La Molina', 'San Borja', 'Jesús María', 'Lince', 'Pueblo Libre'];
        $distritoIds = [];
        foreach ($distritosNombres as $nombre) {
            $id = DB::table('distritos')->where('nombre', $nombre)->where('provincia_id', $provinciaId)->value('id');
            if ($id) {
                $distritoIds[] = $id;
            }
        }

        // =============================================
        // 2. MARCAS (para productos solares)
        // =============================================
        $marcaIds = [];
        $marcas = ['JA Solar', 'Huawei', 'Canadian Solar', 'Growatt', 'BYD'];
        foreach ($marcas as $marca) {
            $marcaIds[] = DB::table('marcas')->insertGetId([
                'name' => $marca,
                'slug' => Str::slug($marca),
                'estado' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 3. PRODUCTOS SOLARES
        // =============================================
        // tipo_id=3 (Kits), tipo_id=4 (Modulo Solar)
        // medida_id=1 (Unidad), categorie_id=1 (Monocristalinos)
        // sede_id=1 (Central)
        $productos = [
            ['name' => 'Panel Solar 450W Monocristalino', 'codigo' => 'PS-450W', 'precio' => 1200.00, 'tipo_id' => 4, 'marca_id' => $marcaIds[0], 'categorie_id' => 1],
            ['name' => 'Panel Solar 550W Bifacial', 'codigo' => 'PS-550W-BF', 'precio' => 1650.00, 'tipo_id' => 4, 'marca_id' => $marcaIds[2], 'categorie_id' => 1],
            ['name' => 'Inversor Híbrido 5kW', 'codigo' => 'INV-5KW', 'precio' => 4500.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[1], 'categorie_id' => 3],
            ['name' => 'Inversor String 8kW', 'codigo' => 'INV-8KW', 'precio' => 6200.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[3], 'categorie_id' => 3],
            ['name' => 'Batería Litio 10kWh', 'codigo' => 'BAT-10KWH', 'precio' => 8500.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[4], 'categorie_id' => 3],
            ['name' => 'Batería Litio 5kWh', 'codigo' => 'BAT-5KWH', 'precio' => 4800.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[4], 'categorie_id' => 3],
            ['name' => 'Kit Solar Residencial 3kW', 'codigo' => 'KIT-3KW', 'precio' => 9500.00, 'tipo_id' => 3, 'marca_id' => $marcaIds[0], 'categorie_id' => 1],
            ['name' => 'Kit Solar Residencial 5kW', 'codigo' => 'KIT-5KW', 'precio' => 14500.00, 'tipo_id' => 3, 'marca_id' => $marcaIds[2], 'categorie_id' => 1],
            ['name' => 'Kit Solar Comercial 15kW', 'codigo' => 'KIT-15KW', 'precio' => 42000.00, 'tipo_id' => 3, 'marca_id' => $marcaIds[1], 'categorie_id' => 1],
            ['name' => 'Estructura de Montaje Techo', 'codigo' => 'EST-TECHO', 'precio' => 350.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[0], 'categorie_id' => 4],
            ['name' => 'Controlador MPPT 60A', 'codigo' => 'CTRL-60A', 'precio' => 1200.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[3], 'categorie_id' => 3],
            ['name' => 'Cables Solares 6mm 50m', 'codigo' => 'CBL-6MM', 'precio' => 280.00, 'tipo_id' => 1, 'marca_id' => $marcaIds[0], 'categorie_id' => 4],
        ];

        $productoIds = [];
        foreach ($productos as $p) {
            $productoIds[] = DB::table('productos')->insertGetId([
                'codigo' => $p['codigo'],
                'slug' => Str::slug($p['name']),
                'name' => $p['name'],
                'precio' => $p['precio'],
                'estado' => 'Activo',
                'tipo_id' => $p['tipo_id'],
                'medida_id' => 1,
                'marca_id' => $p['marca_id'],
                'categorie_id' => $p['categorie_id'],
                'sede_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 4. TÉCNICOS (personas + users)
        // =============================================
        $tecnicosData = [
            ['name' => 'Carlos', 'surnames' => 'Mendoza Ríos', 'email' => 'carlos.mendoza@cisnergia.pe', 'role_id' => 3],
            ['name' => 'María', 'surnames' => 'López Herrera', 'email' => 'maria.lopez@cisnergia.pe', 'role_id' => 3],
            ['name' => 'Juan', 'surnames' => 'Pérez Soto', 'email' => 'juan.perez@cisnergia.pe', 'role_id' => 4],
            ['name' => 'Ana', 'surnames' => 'García Vega', 'email' => 'ana.garcia@cisnergia.pe', 'role_id' => 4],
        ];

        $tecnicoUserIds = [];
        foreach ($tecnicosData as $t) {
            $personaId = DB::table('personas')->insertGetId([
                'name' => $t['name'],
                'surnames' => $t['surnames'],
                'slug' => Str::slug($t['name'] . ' ' . $t['surnames']),
                'avatar' => 'user.png',
                'celular' => '9' . rand(10000000, 99999999),
                'pais' => 'Peru',
                'ciudad' => 'Lima',
                'identificacion' => 'Dni',
                'nro_identificacion' => strval(rand(40000000, 79999999)),
                'tipo_persona' => 'Empleado',
                'sede_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $tecnicoUserIds[] = DB::table('users')->insertGetId([
                'email' => $t['email'],
                'password' => Hash::make('password'),
                'estado' => 'Activo',
                'role_id' => $t['role_id'],
                'persona_id' => $personaId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================================
        // 5. CLIENTES (personas + users + clientes)
        // =============================================
        $clientesData = [
            ['name' => 'Juan Carlos', 'surnames' => 'Rodríguez Paredes', 'email' => 'jcrodriguez@email.com', 'celular' => '987654321'],
            ['name' => 'María Elena', 'surnames' => 'Sánchez Torres', 'email' => 'mesanchez@email.com', 'celular' => '976543210'],
            ['name' => 'Roberto', 'surnames' => 'Fernández Luna', 'email' => 'rfernandez@email.com', 'celular' => '965432109'],
            ['name' => 'Patricia', 'surnames' => 'Gómez Vargas', 'email' => 'pgomez@email.com', 'celular' => '954321098'],
            ['name' => 'Luis Alberto', 'surnames' => 'Díaz Flores', 'email' => 'ladiaz@email.com', 'celular' => '943210987'],
            ['name' => 'Carmen', 'surnames' => 'Ruiz Torres', 'email' => 'cruiz@email.com', 'celular' => '932109876'],
            ['name' => 'Andrés', 'surnames' => 'Villanueva Castro', 'email' => 'avillanueva@email.com', 'celular' => '921098765'],
            ['name' => 'Diana', 'surnames' => 'Castillo Ramos', 'email' => 'dcastillo@email.com', 'celular' => '910987654'],
            ['name' => 'Eduardo', 'surnames' => 'Paredes Huamán', 'email' => 'eparedes@email.com', 'celular' => '998765432'],
            ['name' => 'Sofía', 'surnames' => 'Mendoza Quispe', 'email' => 'smendoza@email.com', 'celular' => '987654320'],
            ['name' => 'Fernando', 'surnames' => 'Quiroz Salazar', 'email' => 'fquiroz@email.com', 'celular' => '976543211'],
            ['name' => 'Gabriela', 'surnames' => 'Montoya Vega', 'email' => 'gmontoya@email.com', 'celular' => '965432100'],
            ['name' => 'Martín', 'surnames' => 'Quispe Chávez', 'email' => 'mquispe@email.com', 'celular' => '954321000'],
            ['name' => 'Verónica', 'surnames' => 'Salazar Medina', 'email' => 'vsalazar@email.com', 'celular' => '943210000'],
            ['name' => 'Alejandro', 'surnames' => 'Huamán Rivas', 'email' => 'ahuaman@email.com', 'celular' => '932100000'],
            ['name' => 'Ricardo', 'surnames' => 'Valenzuela Ortiz', 'email' => 'rvalenzuela@email.com', 'celular' => '921000000'],
            ['name' => 'Lucía', 'surnames' => 'Herrera Campos', 'email' => 'lherrera@email.com', 'celular' => '910000000'],
        ];

        $clienteIds = [];
        foreach ($clientesData as $c) {
            $personaId = DB::table('personas')->insertGetId([
                'name' => $c['name'],
                'surnames' => $c['surnames'],
                'slug' => Str::slug($c['name'] . ' ' . $c['surnames']),
                'avatar' => 'user.png',
                'celular' => $c['celular'],
                'pais' => 'Peru',
                'ciudad' => 'Lima',
                'identificacion' => 'Dni',
                'nro_identificacion' => strval(rand(40000000, 79999999)),
                'tipo_persona' => 'Cliente',
                'sede_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $userId = DB::table('users')->insertGetId([
                'email' => $c['email'],
                'password' => Hash::make('password'),
                'estado' => 'Activo',
                'role_id' => 6, // Cliente
                'persona_id' => $personaId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $clienteIds[] = Cliente::create([
                'nombre'    => $c['name'],
                'apellidos' => $c['surnames'],
                'email'     => $c['email'],
                'celular'   => $c['celular'],
                'user_id'   => $userId,
                'tipo_persona' => 'natural',
                'estado'    => 'activo',
                'origen'    => 'directo',
                'segmento'  => 'residencial',
            ])->id;
        }

        // =============================================
        // 6. PEDIDOS CON DISTRIBUCIÓN EN KANBAN
        // =============================================
        $pedidosConfig = [
            // SIN ASIGNAR (5 pedidos)
            ['cliente_idx' => 0, 'estado_op' => 'sin_asignar', 'prioridad' => 'alta', 'tecnico_idx' => null, 'dias_atras' => 2],
            ['cliente_idx' => 1, 'estado_op' => 'sin_asignar', 'prioridad' => 'alta', 'tecnico_idx' => null, 'dias_atras' => 3],
            ['cliente_idx' => 2, 'estado_op' => 'sin_asignar', 'prioridad' => 'media', 'tecnico_idx' => null, 'dias_atras' => 4],
            ['cliente_idx' => 3, 'estado_op' => 'sin_asignar', 'prioridad' => 'baja', 'tecnico_idx' => null, 'dias_atras' => 5],
            ['cliente_idx' => 4, 'estado_op' => 'sin_asignar', 'prioridad' => 'media', 'tecnico_idx' => null, 'dias_atras' => 6],

            // LOGÍSTICA (3 pedidos)
            ['cliente_idx' => 5, 'estado_op' => 'logistica', 'prioridad' => 'alta', 'tecnico_idx' => 0, 'dias_atras' => 7],
            ['cliente_idx' => 6, 'estado_op' => 'logistica', 'prioridad' => 'media', 'tecnico_idx' => 1, 'dias_atras' => 8],
            ['cliente_idx' => 7, 'estado_op' => 'logistica', 'prioridad' => 'baja', 'tecnico_idx' => 2, 'dias_atras' => 9],

            // ALMACÉN (4 pedidos)
            ['cliente_idx' => 8, 'estado_op' => 'almacen', 'prioridad' => 'alta', 'tecnico_idx' => 3, 'dias_atras' => 10],
            ['cliente_idx' => 9, 'estado_op' => 'almacen', 'prioridad' => 'media', 'tecnico_idx' => 0, 'dias_atras' => 11],
            ['cliente_idx' => 15, 'estado_op' => 'almacen', 'prioridad' => 'media', 'tecnico_idx' => 1, 'dias_atras' => 12],
            ['cliente_idx' => 16, 'estado_op' => 'almacen', 'prioridad' => 'baja', 'tecnico_idx' => 2, 'dias_atras' => 13],

            // CONTROL DE CALIDAD (2 pedidos)
            ['cliente_idx' => 14, 'estado_op' => 'calidad', 'prioridad' => 'alta', 'tecnico_idx' => 1, 'dias_atras' => 11],
            ['cliente_idx' => 9, 'estado_op' => 'calidad', 'prioridad' => 'media', 'tecnico_idx' => 1, 'dias_atras' => 12],

            // DESPACHO (2 pedidos)
            ['cliente_idx' => 10, 'estado_op' => 'despacho', 'prioridad' => 'alta', 'tecnico_idx' => 3, 'dias_atras' => 14],
            ['cliente_idx' => 11, 'estado_op' => 'despacho', 'prioridad' => 'media', 'tecnico_idx' => 0, 'dias_atras' => 15],

            // COMPLETADO (2 pedidos)
            ['cliente_idx' => 12, 'estado_op' => 'completado', 'prioridad' => 'alta', 'tecnico_idx' => 1, 'dias_atras' => 20],
            ['cliente_idx' => 13, 'estado_op' => 'completado', 'prioridad' => 'baja', 'tecnico_idx' => 2, 'dias_atras' => 25],
        ];

        // Detalle de productos por pedido (índices de $productoIds)
        $detallesPorPedido = [
            // Sin Asignar
            [['prod' => 0, 'qty' => 2], ['prod' => 2, 'qty' => 1]],                    // Paneles 450W x2 + Inversor 5kW
            [['prod' => 6, 'qty' => 1]],                                                  // Kit 3kW
            [['prod' => 4, 'qty' => 1], ['prod' => 10, 'qty' => 1]],                    // Batería 10kWh + MPPT
            [['prod' => 1, 'qty' => 4]],                                                  // Paneles 550W x4
            [['prod' => 9, 'qty' => 6], ['prod' => 11, 'qty' => 1]],                    // Estructura x6 + Cables
            // Logística
            [['prod' => 7, 'qty' => 1], ['prod' => 4, 'qty' => 1]],                     // Kit 5kW + Batería 10kWh
            [['prod' => 0, 'qty' => 3], ['prod' => 9, 'qty' => 3]],                     // Paneles x3 + Estructura x3
            [['prod' => 11, 'qty' => 2], ['prod' => 10, 'qty' => 1]],                   // Cables x2 + MPPT
            // Almacén
            [['prod' => 1, 'qty' => 8], ['prod' => 3, 'qty' => 1]],                     // Paneles 550W x8 + Inversor 8kW
            [['prod' => 2, 'qty' => 2]],                                                  // Inversor 5kW x2 (Microinversores)
            [['prod' => 0, 'qty' => 3], ['prod' => 5, 'qty' => 1]],                     // Paneles + Batería 5kWh
            [['prod' => 9, 'qty' => 2], ['prod' => 11, 'qty' => 1]],                    // Estructura + Cables
            // Control Calidad
            [['prod' => 7, 'qty' => 1], ['prod' => 5, 'qty' => 1]],                     // Kit 5kW + Batería 5kWh
            [['prod' => 2, 'qty' => 1], ['prod' => 11, 'qty' => 2]],                    // Inversor + Cables
            // Despacho
            [['prod' => 8, 'qty' => 1]],                                                  // Kit Comercial 15kW
            [['prod' => 0, 'qty' => 6], ['prod' => 9, 'qty' => 6]],                     // Paneles x6 + Estructura x6
            // Completado
            [['prod' => 8, 'qty' => 1]],                                                  // Kit Comercial 15kW
            [['prod' => 0, 'qty' => 2], ['prod' => 9, 'qty' => 2]],                     // Paneles x2 + Estructura x2
        ];

        $direcciones = [
            'Av. Los Pinos 456, Urb. San Isidro',
            'Jr. Las Begonias 234, Miraflores',
            'Calle Los Olivos 789, La Molina',
            'Av. Primavera 1200, Surco',
            'Jr. Camaná 550, Jesús María',
            'Av. Brasil 1500, Pueblo Libre',
            'Calle Los Eucaliptos 320, San Borja',
            'Av. Javier Prado 3000, San Isidro',
        ];

        $now = Carbon::now();

        foreach ($pedidosConfig as $i => $config) {
            $fechaCreacion = $now->copy()->subDays($config['dias_atras']);
            $numero = Pedido::count() + 1;
            $codigo = 'PED-' . $now->format('Y') . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);

            // Calcular totales desde detalles
            $subtotal = 0;
            foreach ($detallesPorPedido[$i] as $det) {
                $prodIdx = $det['prod'];
                $subtotal += $productos[$prodIdx]['precio'] * $det['qty'];
            }
            $igv = round($subtotal * 0.18, 2);
            $total = $subtotal + $igv;

            $tecnicoId = $config['tecnico_idx'] !== null ? $tecnicoUserIds[$config['tecnico_idx']] : null;
            $fechaAsignacion = $tecnicoId ? $fechaCreacion->copy()->addHours(rand(2, 8)) : null;

            $pedidoId = DB::table('pedidos')->insertGetId([
                'codigo' => $codigo,
                'slug' => Str::slug($codigo),
                'cliente_id' => $clienteIds[$config['cliente_idx']],
                'user_id' => 2, // Admin creó el pedido
                'subtotal' => $subtotal,
                'descuento_monto' => 0,
                'igv' => $igv,
                'total' => $total,
                'estado' => $config['estado_op'] === 'completado' ? 'entregado' : 'proceso',
                'estado_operativo' => $config['estado_op'],
                'area_actual' => $config['estado_op'],
                'prioridad' => $config['prioridad'],
                'direccion_instalacion' => $direcciones[array_rand($direcciones)],
                'distrito_id' => $distritoIds[array_rand($distritoIds)],
                'fecha_entrega_estimada' => $fechaCreacion->copy()->addDays(rand(5, 15))->format('Y-m-d'),
                'tecnico_asignado_id' => $tecnicoId,
                'fecha_asignacion' => $fechaAsignacion,
                'almacen_id' => 1,
                'observaciones' => null,
                'observaciones_operativas' => $tecnicoId ? 'Asignado por administración.' : null,
                'origen' => 'directo',
                'created_at' => $fechaCreacion,
                'updated_at' => $fechaCreacion,
            ]);

            // Insertar detalles
            foreach ($detallesPorPedido[$i] as $det) {
                $prodIdx = $det['prod'];
                $precioUnit = $productos[$prodIdx]['precio'];
                $qty = $det['qty'];

                DB::table('detalle_pedidos')->insert([
                    'pedido_id' => $pedidoId,
                    'producto_id' => $productoIds[$prodIdx],
                    'tipo' => 'producto',
                    'descripcion' => $productos[$prodIdx]['name'],
                    'cantidad' => $qty,
                    'precio_unitario' => $precioUnit,
                    'descuento_porcentaje' => 0,
                    'descuento_monto' => 0,
                    'subtotal' => $precioUnit * $qty,
                    'created_at' => $fechaCreacion,
                    'updated_at' => $fechaCreacion,
                ]);
            }

            // Crear venta completada asociada al pedido (requisito para entrar a asignaciones)
            $numeroVenta = DB::table('sales')->count() + 1;
            $codigoVenta = 'VTA-' . $now->format('Y') . '-' . str_pad($numeroVenta, 5, '0', STR_PAD_LEFT);
            DB::table('sales')->insert([
                'codigo' => $codigoVenta,
                'slug' => Str::slug($codigoVenta),
                'pedido_id' => $pedidoId,
                'cliente_id' => $clienteIds[$config['cliente_idx']],
                'subtotal' => $subtotal,
                'descuento' => 0,
                'igv' => $igv,
                'total' => $total,
                'estado' => 'completada',
                'user_id' => 2,
                'sede_id' => 1,
                'tipo_venta' => 'pedido',
                'created_at' => $fechaCreacion,
                'updated_at' => $fechaCreacion,
            ]);

            // Crear registros de calidad para pedidos en estado 'calidad'
            if ($config['estado_op'] === 'calidad') {
                $calidadId = DB::table('pedido_calidad')->insertGetId([
                    'pedido_id' => $pedidoId,
                    'estado_calidad' => 'pendiente',
                    'created_at' => $fechaCreacion,
                    'updated_at' => $fechaCreacion,
                ]);

                $checklistItems = ChecklistItem::activo()->orderBy('seccion')->orderBy('orden')->get();
                foreach ($checklistItems as $item) {
                    DB::table('pedido_verificaciones')->insert([
                        'pedido_calidad_id' => $calidadId,
                        'checklist_item_id' => $item->id,
                        'cumple' => false,
                        'created_at' => $fechaCreacion,
                        'updated_at' => $fechaCreacion,
                    ]);
                }
            }
        }
    }
}
