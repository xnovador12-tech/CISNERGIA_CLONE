<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SedeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sede = new Sede();
        $sede->name = "Central";
        $sede->slug = Str::slug($sede->name);
        $sede->estado = "Activo";
        $sede->departamento_id= "15";
        $sede->imagen = "NULL";
        $sede->save();
    }
}
