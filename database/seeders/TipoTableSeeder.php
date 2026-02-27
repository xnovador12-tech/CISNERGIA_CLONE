<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TipoTableSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            'Kit Solares',
            'Paneles Solares ',
            'Soportes Paneles Solares',
            'Baterías',
            'Inversores Solares',
            'Controladores de Carga ',
            'Cargador de Baterías',
            'Iluminación Solar',
            'Accesorios Eléctricos',
            'Cables',
            'Protecciones Eléctricas',
            'Tableros Eléctricos',
            'Automatización y Control',
            'Scooters Eléctricos',
            'Motos Eléctricas'
        ];

        foreach ($tipos as $nombre) {
            Tipo::updateOrCreate(
                ['slug' => Str::slug($nombre)],
                ['name' => $nombre, 'slug' => Str::slug($nombre), 'estado' => 'Activo']
            );
        }
    }
}
