<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar
        DB::table('detalle_pedidos')->delete();
        DB::table('pedidos')->delete();

        // Obtener IDs validos
        $clienteId = DB::table('clientes')->value('id');
        $almacenId = DB::table('almacenes')->value('id');
        $cotizacionId = DB::table('cotizaciones')->value('id');
        $productoId = DB::table('productos')->value('id');

        // Lógica de fallback para CLIENTE
        if (!$clienteId) {
             // A. Sede
             $sedeId = DB::table('sedes')->value('id');
             if (!$sedeId) {
                 $sedeId = DB::table('sedes')->insertGetId([
                     'titulo' => 'Sede Principal',
                     'descripcion' => 'Sede generada automáticamente',
                     'created_at' => now(), 'updated_at' => now()
                 ]);
             }
             // B. Persona
             $personaId = DB::table('personas')->insertGetId([
                 'name' => 'Juan Perez (Pedido)',
                 'slug' => 'juan-perez-pedido-' . rand(1000,9999), 
                 'tipo_persona' => 'natural',
                 'sede_id' => $sedeId,
                 'created_at' => now(), 'updated_at' => now(),
             ]);
             // C. Usuario
             $roleId = DB::table('roles')->value('id') ?? 1;
             $userId = DB::table('users')->insertGetId([
                 'email' => 'cliente_pedido_' . rand(100,999) . '@test.com',
                 'password' => bcrypt('password'),
                 'role_id' => $roleId,
                 'persona_id' => $personaId,
                 'created_at' => now(), 'updated_at' => now(),
             ]);
             // D. Cliente
             $clienteId = DB::table('clientes')->insertGetId([
                 'user_id' => $userId,
                 'created_at' => now(), 'updated_at' => now(),
             ]);
        }
        
        $userId = DB::table('users')->value('id'); // Get valid user for order creator

        // Lógica de fallback para PRODUCTO
        if (!$productoId) {
             // Dependencies
             $catId = DB::table('categories')->value('id');
             if (!$catId) {
                 $tipoId = DB::table('tipos')->value('id') ?? DB::table('tipos')->insertGetId(['titulo'=>'TIPO TEST', 'created_at'=>now(), 'updated_at'=>now()]);
                 $catId = DB::table('categories')->insertGetId(['name'=>'CAT TEST', 'slug'=>'cat-test', 'tipo_id'=>$tipoId, 'created_at'=>now(), 'updated_at'=>now()]);
             }
             $marcaId = DB::table('marcas')->value('id') ?? DB::table('marcas')->insertGetId(['name'=>'MARCA TEST', 'slug'=>'marca-test', 'created_at'=>now(), 'updated_at'=>now()]);
             $medidaId = DB::table('medidas')->value('id') ?? DB::table('medidas')->insertGetId(['titulo'=>'UND', 'codigo'=>'UN','created_at'=>now(), 'updated_at'=>now()]);
             $sedeId = DB::table('sedes')->value('id');

             $productoId = DB::table('productos')->insertGetId([
                'name' => 'Producto Pedido Fallback',
                'slug' => 'prod-fallback-' . rand(100,999), 
                'precio' => 100.00,
                'costo' => '50.00',
                'codigo' => 'PROD-FB-01',
                'tipo_id' => $tipoId ?? DB::table('tipos')->value('id'),
                'medida_id' => $medidaId,
                'marca_id' => $marcaId,
                'categorie_id' => $catId,
                'sede_id' => $sedeId,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Si no hay almacen, creamos uno dummy
        if (!$almacenId) {
             $almacenId = DB::table('almacenes')->insertGetId([
                'nombre' => 'Almacén Central',
                'direccion' => 'Av. Industrial 555',
                'capacidad' => '1000m2',
                'estado' => 'Activo',
                'tipo_almacen_id' => 1, // Asumiendo ID 1 existe, sino fallará. Pero seeders previos deberian tenerlo.
                'sede_id' => 1,
                'created_at' => now(), 'updated_at' => now()
             ]);
        }

        // -------------------------------------------------------------
        // 1. PEDIDO NUEVO (Requiere Aprobación) - Viene de Cotización
        // -------------------------------------------------------------
        $pedidoId1 = DB::table('pedidos')->insertGetId([
            'codigo' => 'PED-2024-001',
            'slug' => 'ped-2024-001',
            'cliente_id' => $clienteId,
            'user_id' => $userId,
            'subtotal' => 5000.00,
            'igv' => 900.00,
            'total' => 5900.00,
            'estado' => 'pendiente',
            'aprobacion_finanzas' => false,
            'aprobacion_stock' => false,
            'direccion_instalacion' => 'Calle Las Begonias 123',
            'fecha_entrega_estimada' => now()->addDays(5),
            'almacen_id' => $almacenId,
            'origen' => 'directo',
            'created_at' => now(), 'updated_at' => now()
        ]);

        DB::table('detalle_pedidos')->insert([
            'pedido_id' => $pedidoId1,
            'producto_id' => $productoId,
            'cantidad' => 10,
            'precio_unitario' => 500.00,
            'subtotal' => 5000.00,
            'descripcion' => 'Item 1 - Producto General',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // -------------------------------------------------------------
        // 2. PEDIDO LISTO PARA DESPACHO (Aprobado)
        // -------------------------------------------------------------
        $pedidoId2 = DB::table('pedidos')->insertGetId([
            'codigo' => 'PED-2024-002',
            'slug' => 'ped-2024-002',
            'cliente_id' => $clienteId,
            'user_id' => $userId,
            'subtotal' => 1500.00,
            'igv' => 270.00,
            'total' => 1770.00,
            'estado' => 'proceso',
            'aprobacion_finanzas' => true,
            'aprobacion_stock' => true,
            'direccion_instalacion' => 'Av. Javier Prado 4500',
            'fecha_entrega_estimada' => now()->addDays(2),
            'almacen_id' => $almacenId,
            'created_at' => now()->subDays(1), 'updated_at' => now()
        ]);

         DB::table('detalle_pedidos')->insert([
            'pedido_id' => $pedidoId2,
            'producto_id' => $productoId,
            'cantidad' => 3,
            'precio_unitario' => 500.00,
            'subtotal' => 1500.00,
             'descripcion' => 'Item 2 - Producto General',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // -------------------------------------------------------------
        // 3. PEDIDO ENTREGADO (Listo para Facturar)
        // -------------------------------------------------------------
        $pedidoId3 = DB::table('pedidos')->insertGetId([
            'codigo' => 'PED-OLD-999',
            'slug' => 'ped-old-999',
            'cliente_id' => $clienteId,
            'user_id' => $userId,
            'subtotal' => 8000.00,
            'igv' => 1440.00,
            'total' => 9440.00,
            'estado' => 'entregado',
            'aprobacion_finanzas' => true,
            'aprobacion_stock' => true,
            'direccion_instalacion' => 'Jr. de la Union 500',
            'fecha_entrega_estimada' => now()->subDays(5),
            'almacen_id' => $almacenId,
            'created_at' => now()->subDays(10), 'updated_at' => now()
        ]);

        DB::table('detalle_pedidos')->insert([
            'pedido_id' => $pedidoId3,
            'producto_id' => $productoId,
            'cantidad' => 16,
            'precio_unitario' => 500.00,
            'subtotal' => 8000.00,
            'descripcion' => 'Item 3 - Producto General',
            'created_at' => now(), 'updated_at' => now()
        ]);
    }
}
