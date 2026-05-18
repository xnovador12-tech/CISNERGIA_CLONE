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
        $sede->name = "Cisnergia PERU SAC";
        $sede->slug = Str::slug($sede->name);
        $sede->ruc = "20601599881";
        $sede->direccion = "Calle Atahualpa 210 Of. C-115, Miraflores, Lima";
        $sede->referencia = "Frente a Restaurante La Gloria";
        $sede->nro_contacto = "922720320";
        $sede->estado = "Activo";
        $sede->departamento_id= "15";
        $sede->imagen = "NULL";
        $sede->save();
    }
}
