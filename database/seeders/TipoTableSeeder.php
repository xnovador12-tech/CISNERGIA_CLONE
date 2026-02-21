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
            'Accesorios',
            'Repuestos',
            'Kits',
            'Modulo Solar',
            'Panel Solar',
            'Inversor',
            'Batería',
            'Estructura',
            'Cable y Conector',
        ];

        foreach ($tipos as $nombre) {
            Tipo::updateOrCreate(
                ['slug' => Str::slug($nombre)],
                ['name' => $nombre, 'slug' => Str::slug($nombre), 'estado' => 'Activo']
            );
        }
    }
}
