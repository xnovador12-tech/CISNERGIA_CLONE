<?php

namespace Database\Seeders;

use App\Models\TipoOperacion;
use Illuminate\Database\Seeder;

class TipoOperacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'code' => '0101',
                'descripcion' => 'Venta interna (Normal)',
            ],
            [
                'code' => '1001',
                'descripcion' => 'Operacion Sujeta a Detraccion(Detraccion)',
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoOperacion::updateOrCreate(
                ['code' => $tipo['code']],
                ['descripcion' => $tipo['descripcion']]
            );
        }
    }
}
