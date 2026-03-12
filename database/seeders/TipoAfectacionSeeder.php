<?php

namespace Database\Seeders;

use App\Models\TipoAfectacion;
use Illuminate\Database\Seeder;

class TipoAfectacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'code' => '10',
                'descripcion' => 'Gravado - Operación Onerosa',
                'codigo_tributo' => '1000',
                'tipo_tributo' => 'VAT',
                'name_tributo' => 'IGV',
                'porcentaje' => 18,
            ],
            [
                'code' => '20',
                'descripcion' => 'Exonerado - Operación Onerosa',
                'codigo_tributo' => '9997',
                'tipo_tributo' => 'VAT',
                'name_tributo' => 'EXO',
                'porcentaje' => 0,
            ],
            [
                'code' => '30',
                'descripcion' => 'Inafecto - Operación Onerosa',
                'codigo_tributo' => '9998',
                'tipo_tributo' => 'FRE',
                'name_tributo' => 'INA',
                'porcentaje' => 0,
            ],
            [
                'code' => '17',
                'descripcion' => 'Gravado - IVAP',
                'codigo_tributo' => '1016',
                'tipo_tributo' => 'VAT',
                'name_tributo' => 'IVAP',
                'porcentaje' => 4,
            ],
        ];

        foreach ($data as $item) {
            TipoAfectacion::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
