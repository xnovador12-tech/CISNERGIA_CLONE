<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar que existan los registros necesarios en tablas relacionadas
        $tipoId = DB::table('tipos')->first()->id ?? null;
        $medidaId = DB::table('medidas')->first()->id ?? null;
        $marcaId = DB::table('marcas')->first()->id ?? null;
        $categorieId = DB::table('categories')->first()->id ?? null;
        $sedeId = DB::table('sedes')->first()->id ?? null;

        if (!$tipoId || !$medidaId || !$marcaId || !$categorieId || !$sedeId) {
            $this->command->error('❌ Faltan datos en tablas relacionadas (tipos, medidas, marcas, categories, sedes)');
            $this->command->info('Ejecuta primero: php artisan migrate:fresh --seed');
            return;
        }

        // Panel Solar 450W
        DB::table('productos')->insert([
            'codigo' => 'PANEL-450W-MONO',
            'slug' => 'panel-solar-450w-monocristalino',
            'name' => 'Panel Solar 450W Monocristalino',
            'descripcion' => 'Panel solar de alta eficiencia 450W',
            'precio' => 450.00,
            'precio_descuento' => 420.00,
            'porcentaje' => 7,
            'tipo_afectacion' => '10',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $categorieId,
            'sede_id' => $sedeId,
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Panel Solar 550W
        DB::table('productos')->insert([
            'codigo' => 'PANEL-550W-BIFA',
            'slug' => 'panel-solar-550w-bifacial',
            'name' => 'Panel Solar 550W Bifacial',
            'descripcion' => 'Panel solar bifacial de última generación 550W',
            'precio' => 580.00,
            'precio_descuento' => 550.00,
            'porcentaje' => 5,
            'tipo_afectacion' => '10',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $categorieId,
            'sede_id' => $sedeId,
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inversor Híbrido 5kW
        DB::table('productos')->insert([
            'codigo' => 'INV-HYB-5KW',
            'slug' => 'inversor-hibrido-5kw',
            'name' => 'Inversor Híbrido 5kW',
            'descripcion' => 'Inversor híbrido on-grid/off-grid 5kW con MPPT',
            'precio' => 1850.00,
            'precio_descuento' => 1750.00,
            'porcentaje' => 5,
            'tipo_afectacion' => '10',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $categorieId,
            'sede_id' => $sedeId,
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inversor On-Grid 10kW
        DB::table('productos')->insert([
            'codigo' => 'INV-ONGRID-10KW',
            'slug' => 'inversor-on-grid-10kw',
            'name' => 'Inversor On-Grid 10kW',
            'descripcion' => 'Inversor conectado a red 10kW trifásico',
            'precio' => 3800.00,
            'precio_descuento' => 3600.00,
            'porcentaje' => 5,
            'tipo_afectacion' => '10',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $categorieId,
            'sede_id' => $sedeId,
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Batería Litio 5kWh
        DB::table('productos')->insert([
            'codigo' => 'BAT-LIT-5KWH',
            'slug' => 'bateria-litio-5kwh',
            'name' => 'Batería Litio 5kWh',
            'descripcion' => 'Batería de litio LiFePO4 5kWh, 6000 ciclos',
            'precio' => 2900.00,
            'precio_descuento' => 2750.00,
            'porcentaje' => 5,
            'tipo_afectacion' => '10',
            'tipo_id' => $tipoId,
            'medida_id' => $medidaId,
            'marca_id' => $marcaId,
            'categorie_id' => $categorieId,
            'sede_id' => $sedeId,
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ 5 Productos creados exitosamente');
    }
}
