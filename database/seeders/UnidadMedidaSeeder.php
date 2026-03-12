<?php

namespace Database\Seeders;

use App\Models\UnidadMedida;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['codigo_sunat' => 'NIU', 'descripcion' => 'Unidades', 'simbolo_comercial' => 'UND'],
            ['codigo_sunat' => 'ZZ', 'descripcion' => 'Servicios', 'simbolo_comercial' => 'SERV'],
            ['codigo_sunat' => 'KGM', 'descripcion' => 'Kilogramos', 'simbolo_comercial' => 'KG'],
            ['codigo_sunat' => 'BX', 'descripcion' => 'Cajas', 'simbolo_comercial' => 'CJ'],
        ];

        foreach ($data as $item) {
            UnidadMedida::updateOrCreate(['codigo_sunat' => $item['codigo_sunat']], $item);
        }
    }
}
