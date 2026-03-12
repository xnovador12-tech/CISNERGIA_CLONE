<?php

namespace Database\Seeders;

use App\Models\TipoIngreso;
use Illuminate\Database\Seeder;

class TipoIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Compra',
                'descripcion' => 'Ingreso por compra a proveedores',
            ],
            [
                'nombre' => 'Donación',
                'descripcion' => 'Ingreso por donaciones externas',
            ],
            [
                'nombre' => 'Ajuste',
                'descripcion' => 'Ingreso por ajuste de inventario',
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoIngreso::updateOrCreate(
                ['nombre' => $tipo['nombre']],
                ['descripcion' => $tipo['descripcion']]
            );
        }
    }
}
