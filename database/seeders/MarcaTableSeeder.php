<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaTableSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            ['name' => 'Generica', 'slug' => 'generica', 'estado' => 'activo'],
            ['name' => 'Jinko Solar', 'slug' => 'jinko-solar', 'estado' => 'activo'],
            ['name' => 'Huawei', 'slug' => 'huawei', 'estado' => 'activo'],
            ['name' => 'Longi', 'slug' => 'longi', 'estado' => 'activo'],
            ['name' => 'Growatt', 'slug' => 'growatt', 'estado' => 'activo'],
            ['name' => 'Victron Energy', 'slug' => 'victron-energy', 'estado' => 'activo'],
        ];

        foreach ($marcas as $marca) {
            DB::table('marcas')->insert([
                'name' => $marca['name'],
                'slug' => $marca['slug'],
                'estado' => $marca['estado'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('✅ Marcas creadas exitosamente');
    }
}
