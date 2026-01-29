<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = new Tipo();
        $tipo->name = "Accesorios";
        $tipo->slug = Str::slug($tipo->name);
        $tipo->estado = "Activo";
        // $tipo->definicion = "Bienes";
        // $tipo->clasificacion = "Compras";
        $tipo->save();

        $tipo = new Tipo();
        $tipo->name = "Repuestos";
        $tipo->slug = Str::slug($tipo->name);
        $tipo->estado = "Activo";
        // $tipo->definicion = "Bienes";
        // $tipo->clasificacion = "Compras";
        $tipo->save();

        $tipo = new Tipo();
        $tipo->name = "Kits";
        $tipo->slug = Str::slug($tipo->name);
        $tipo->estado = "Activo";
        // $tipo->definicion = "Bienes";
        // $tipo->clasificacion = "Producto Terminado";
        $tipo->save();

        $tipo = new Tipo();
        $tipo->name = "Modulo Solar";
        $tipo->slug = Str::slug($tipo->name);
        $tipo->estado = "Activo";
        $tipo->save();
        
    }
}
