<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    public function run(): void
    {
        Moneda::firstOrCreate(
            ['simbolo' => 'S/'],
            ['descripcion' => 'Sol Peruano']
        );
    }
}
