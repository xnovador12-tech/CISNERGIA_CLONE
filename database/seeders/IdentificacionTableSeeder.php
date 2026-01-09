<?php

namespace Database\Seeders;

use App\Models\Identificacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IdentificacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identificacion = new Identificacion();
        $identificacion->name = "Registro único de contribuyentes";
        $identificacion->slug = Str::slug($identificacion->name);
        $identificacion->abreviatura = "RUC";
        $identificacion->codigo = "6";
        $identificacion->save();

        $identificacion = new Identificacion();
        $identificacion->name = "Documento Nacional de identidad";
        $identificacion->slug = Str::slug($identificacion->name);
        $identificacion->abreviatura = "DNI";
        $identificacion->codigo = "1";
        $identificacion->save();

        $identificacion = new Identificacion();
        $identificacion->name = "Carnet de extranjería";
        $identificacion->slug = Str::slug($identificacion->name);
        $identificacion->abreviatura = "CE";
        $identificacion->codigo = "4";
        $identificacion->save();

        $identificacion = new Identificacion();
        $identificacion->name = "Pasaporte";
        $identificacion->slug = Str::slug($identificacion->name);
        $identificacion->abreviatura = "PP";
        $identificacion->codigo = "7";
        $identificacion->save();

        $identificacion = new Identificacion();
        $identificacion->name = "Documento tributario no domiciliado sin ruc";
        $identificacion->slug = Str::slug($identificacion->name);
        $identificacion->abreviatura = "SIN RUC";
        $identificacion->codigo = "0";
        $identificacion->save();
    }
}
