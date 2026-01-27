<?php

namespace Database\Seeders;

use App\Models\Motivo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MotivoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $motivo = new Motivo();
        $motivo->name = "Inventario";
        $motivo->slug = "inventario";
        $motivo->tipo_motivo = "ALMACEN";
        $motivo->estado = "Activo";
        $motivo->save();

        $motivo = new Motivo();
        $motivo->name = "Venta";
        $motivo->slug = "venta";
        $motivo->tipo_motivo = "ALMACEN";
        $motivo->estado = "Activo";
        $motivo->save();

        $motivo = new Motivo();
        $motivo->name = "Devolucion de Venta";
        $motivo->slug = "Devolucion de Venta";
        $motivo->tipo_motivo = "ALMACEN";
        $motivo->estado = "Activo";
        $motivo->save();

    }
}
