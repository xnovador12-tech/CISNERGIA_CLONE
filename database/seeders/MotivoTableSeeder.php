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
        $motivo->slug = "devolucion-de-venta";
        $motivo->tipo_motivo = "ALMACEN";
        $motivo->estado = "Activo";
        $motivo->save();

        $motivo = new Motivo();
        $motivo->name = "Merma";
        $motivo->slug = "merma";
        $motivo->tipo_motivo = "ALMACEN";
        $motivo->estado = "Activo";
        $motivo->save();

        $motivo = new Motivo();
        $motivo->name = "Robo o perdida";
        $motivo->slug = "robo-o-perdida";
        $motivo->tipo_motivo = "ALMACEN";
        $motivo->estado = "Activo";
        $motivo->save();

    }
}
