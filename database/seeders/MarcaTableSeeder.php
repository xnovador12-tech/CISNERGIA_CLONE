<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarcaTableSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            'JA Solar', 'Jinko Solar', 'Trina Solar', 'LONGi', 'Canadian Solar', 'Risen',
            'Growatt', 'Huawei', 'Sungrow', 'Goodwe', 'Deye', 'Fronius', 'SMA',
            'Pylontech', 'BYD', 'Tesla',
            'Genérico',
        ];

        foreach ($marcas as $nombre) {
            Marca::updateOrCreate(
                ['slug' => Str::slug($nombre)],
                ['name' => $nombre, 'slug' => Str::slug($nombre), 'estado' => 'Activo']
            );
        }
    }
}
