<?php

namespace Database\Seeders;

use App\Models\Almacen;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AlmacenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fecha_actual = Carbon::now()->format('Y-m-d');
        
        $almace = new Almacen();
        $almace->name = "Almacen central";
        $almace->slug = Str::slug($almace->name);
        $almace->fecha = $fecha_actual;
        $almace->registrado_por = 'Administrador';
        $almace->clasificacion = 'General';
        $almace->estado = "Activo";
        $almace->sede_id = 1;
        $almace->save();
    }
}
