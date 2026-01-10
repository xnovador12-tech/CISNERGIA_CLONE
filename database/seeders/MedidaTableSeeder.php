<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Medida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MedidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medida = new Medida();
        $medida->name = "Unidad";
        $medida->slug = Str::slug($medida->name);
        $medida->estado = "Activo";
        $medida->save();
    }
}