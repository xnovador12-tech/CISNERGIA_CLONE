<?php

namespace Database\Seeders;

use App\Models\Formapago;
use Illuminate\Database\Seeder;

class FormaspagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comprobante = new Formapago();
        $comprobante->name = "Contado";
        $comprobante->slug = "contado";
        $comprobante->estado = "Activo";
        $comprobante->save();

        $comprobante = new Formapago();
        $comprobante->name = "Credito";
        $comprobante->slug = "credito";
        $comprobante->estado = "Activo";
        $comprobante->save();
    }
}