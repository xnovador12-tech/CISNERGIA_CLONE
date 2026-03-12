<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\TipoComprobante;
use Illuminate\Database\Seeder;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $series = [
            ['code' => '00', 'name' => 'N001', 'correlativo' => 1], // NOTA DE VENTA
            ['code' => '01', 'name' => 'F001', 'correlativo' => 1], // FACTURA
            ['code' => '03', 'name' => 'B001', 'correlativo' => 1], // BOLETA
            ['code' => '07', 'name' => 'FNC1', 'correlativo' => 1], // NOTA DE CREDITO
            ['code' => '07', 'name' => 'BNC1', 'correlativo' => 1], // NOTA DE CREDITO
            ['code' => '08', 'name' => 'FND1', 'correlativo' => 1], // NOTA DE DEBITO
            ['code' => '08', 'name' => 'BND1', 'correlativo' => 1], // NOTA DE DEBITO
        ];

        foreach ($series as $item) {
            $tipo = TipoComprobante::where('code', $item['code'])->first();
            if ($tipo) {
                Serie::updateOrCreate(
                    [
                        'tipo_comprobante_id' => $tipo->id,
                        'name' => $item['name'],
                    ],
                    ['correlativo' => $item['correlativo']]
                );
            }
        }
    }
}
