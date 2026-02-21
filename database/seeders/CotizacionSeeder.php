<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CotizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tablas
        DB::table('detalle_cotizaciones')->delete();
        DB::table('cotizaciones')->delete();

        // ---------------------------------------------------------
        // 1. PRE-REQUISITOS (Datos Maestros)
        // ---------------------------------------------------------
        
        // Sede
        $sedeId = DB::table('sedes')->value('id');
        if (!$sedeId) {
            $sedeId = DB::table('sedes')->insertGetId([
                'titulo' => 'Sede Principal',
                'descripcion' => 'Sede generada automáticamente',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // Tipo (Requerido por Categoría)
        $tipoId = DB::table('tipos')->value('id');
        if (!$tipoId) {
             $tipoId = DB::table('tipos')->insertGetId([
                'titulo' => 'Producto Terminado',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
        
        // Categoría (Requiere Tipo)
        $catId = DB::table('categories')->value('id');
        if (!$catId) {
            $catId = DB::table('categories')->insertGetId([
                'name' => 'Energía Solar',
                'slug' => 'energia-solar',
                'tipo_id' => $tipoId,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // Marca
        $marcaId = DB::table('marcas')->value('id');
        if (!$marcaId) {
            $marcaId = DB::table('marcas')->insertGetId([
                'name' => 'SolarTech',
                'slug' => 'solartech',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // Medida
        $medidaId = DB::table('medidas')->value('id');
        if (!$medidaId) {
            $medidaId = DB::table('medidas')->insertGetId([
                'titulo' => 'Unidad',
                'codigo' => 'UND',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // ---------------------------------------------------------
        // 2. CLIENTE (Persona -> User -> Cliente)
        // ---------------------------------------------------------
        $clienteId = DB::table('clientes')->value('id');
        if (!$clienteId) {
            $personaId = DB::table('personas')->insertGetId([
                'name' => 'Juan Perez (Cliente)',
                'slug' => 'juan-perez-cliente-' . rand(1000,9999), 
                'tipo_persona' => 'natural',
                'sede_id' => $sedeId,
                'created_at' => now(), 'updated_at' => now(),
            ]);

            $roleId = DB::table('roles')->value('id') ?? 1;
            $userId = DB::table('users')->insertGetId([
                'email' => 'cliente_seed_' . rand(100,999) . '@test.com',
                'password' => bcrypt('password'),
                'role_id' => $roleId,
                'persona_id' => $personaId,
                'created_at' => now(), 'updated_at' => now(),
            ]);

            $clienteId = DB::table('clientes')->insertGetId([
                'user_id' => $userId,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // ---------------------------------------------------------
        // 3. PRODUCTOS
        // ---------------------------------------------------------
        $prod1Id = DB::table('productos')->insertGetId([
            'name' => 'Panel Solar Demo 550W',
            'slug' => 'panel-solar-demo-550w-' . rand(10000,99999), 
            'precio' => 450.00,
            'costo' => '300.00',
            'codigo' => 'PROD-DEMO-01-' . rand(100,999),
            'descripcion' => 'Producto generado por Seeder',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $catId,
            'sede_id' => $sedeId,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $prod2Id = DB::table('productos')->insertGetId([
            'name' => 'Inversor Demo 5kW',
            'slug' => 'inversor-demo-5kw-' . rand(10000,99999),
            'precio' => 1000.00,
            'costo' => '800.00',
            'codigo' => 'PROD-DEMO-02-' . rand(100,999),
            'descripcion' => 'Producto generado por Seeder',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $catId,
            'sede_id' => $sedeId,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // ---------------------------------------------------------
        // 4. COTIZACIONES
        // ---------------------------------------------------------
        $vendedorUserId = 1; // Forzamos usuario 1 como vendedor

        // Cotización Proyecto
        $cot1Id = DB::table('cotizaciones')->insertGetId([
            'codigo' => 'COT-2024-001-' . rand(100,999),
            'slug' => 'cot-2024-001-' . rand(100,999),
            'cliente_id' => $clienteId,
            'oportunidad' => 'Sistema Comercial 15kW - Carlos Mendoza',
            'user_id' => $vendedorUserId,
            'subtotal' => 10000.00,
            'descuento' => 0.00,
            'igv' => 1800.00,
            'total' => 11800.00,
            'estado' => 'aceptada',
            'fecha_vigencia' => now()->addDays(15),
            'potencia_monitorizada' => '15 kW',
            'produccion_anual' => '24,500 kWh',
            'ahorro_anual_estimado' => 12250.00,
            'observaciones' => 'Instalación incluida en el precio.',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        DB::table('detalle_cotizaciones')->insert([
            [
                'cotizacion_id' => $cot1Id,
                'producto_id' => $prod1Id,
                'descripcion' => 'Panel Solar Monocristalino 550W',
                'cantidad' => 20,
                'precio_unitario' => 450.00,
                'subtotal' => 9000.00,
                'descuento' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'cotizacion_id' => $cot1Id,
                'producto_id' => $prod2Id,
                'descripcion' => 'Inversor Híbrido 5kW',
                'cantidad' => 1,
                'precio_unitario' => 1000.00,
                'subtotal' => 1000.00,
                'descuento' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ]
        ]);

        // Cotización Borrador
        $cot2Id = DB::table('cotizaciones')->insertGetId([
            'codigo' => 'COT-2024-002-' . rand(100,999),
            'slug' => 'cot-2024-002-' . rand(100,999),
            'cliente_id' => $clienteId,
            'oportunidad' => null,
            'user_id' => $vendedorUserId,
            'subtotal' => 200.00,
            'igv' => 36.00,
            'total' => 236.00,
            'estado' => 'borrador',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        DB::table('detalle_cotizaciones')->insert([
            [
                'cotizacion_id' => $cot2Id,
                'producto_id' => $prod1Id, 
                'descripcion' => 'Panel Solar Demo (Unitario)',
                'cantidad' => 1,
                'precio_unitario' => 200.00, 
                'subtotal' => 200.00,
                'descuento' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ]
        ]);
    }
}
