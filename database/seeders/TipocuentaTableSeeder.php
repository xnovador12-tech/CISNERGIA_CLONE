<?php

namespace Database\Seeders;

use App\Models\Tipocuenta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TipocuentaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Digital";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Premio";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Sueldo";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Ilimitada";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Corriente";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Ahorros";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Dólares";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Free";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Power";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Super Cuenta";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta Corriente de Detracciones";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();

        $tipocuenta = new Tipocuenta();
        $tipocuenta->name = "Cuenta DNI";
        $tipocuenta->slug = Str::slug($tipocuenta->name);;
        $tipocuenta->estado = "Activo";
        $tipocuenta->save();
    }
}

