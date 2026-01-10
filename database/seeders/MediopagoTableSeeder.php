<?php

namespace Database\Seeders;

use App\Models\Mediopago;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MediopagoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mediopago = new Mediopago();
        $mediopago->name = "Efectivo";
        $mediopago->slug = Str::slug($mediopago->name);
        $mediopago->estado = "Activo";
        $mediopago->save();

        $mediopago = new Mediopago();
        $mediopago->name = "Transferencia Bancaria";
        $mediopago->slug = Str::slug($mediopago->name);
        $mediopago->estado = "Activo";
        $mediopago->save();

        $mediopago = new Mediopago();
        $mediopago->name = "Billetera Digital";
        $mediopago->slug = Str::slug($mediopago->name);
        $mediopago->estado = "Activo";
        $mediopago->save();
    }
}
