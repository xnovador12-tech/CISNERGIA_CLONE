<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Kits' => ['Monocristalinos', 'Policristalinos', 'Híbridos', 'Templado'],
            'Panel Solar' => ['Monocristalino PERC', 'Monocristalino TOPCon', 'Bifacial'],
            'Inversor' => ['On-Grid (String)', 'Híbrido', 'Microinversor', 'Off-Grid'],
            'Batería' => ['Litio LFP', 'Litio NMC', 'Plomo-Ácido'],
            'Estructura' => ['Techo Inclinado', 'Techo Plano', 'Piso/Suelo'],
            'Cable y Conector' => ['Cable Solar', 'Conector MC4', 'Protección Eléctrica'],
        ];

        foreach ($categorias as $tipoName => $cats) {
            $tipo = Tipo::where('name', $tipoName)->first();
            if (!$tipo) continue;

            foreach ($cats as $catName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($catName)],
                    [
                        'name' => $catName,
                        'slug' => Str::slug($catName),
                        'estado' => 'Activo',
                        'tipo_id' => $tipo->id,
                    ]
                );
            }
        }
    }
}
