<?php

namespace Database\Seeders;

use App\Models\TipoComprobante;
use Illuminate\Database\Seeder;

class TipoComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'code' => '00',
                'descripcion' => 'NOTA DE VENTA',
            ],
            [
                'code' => '01',
                'descripcion' => 'FACTURA',
            ],
            [
                'code' => '03',
                'descripcion' => 'BOLETA',
            ],
            [
                'code' => '09',
                'descripcion' => 'GUIA DE REMISION REMITENTE',
            ],
            [
                'code' => '31',
                'descripcion' => 'GUIA DE REMISION TRANSPORTISTA',
            ],
            [
                'code' => '07',
                'descripcion' => 'NOTA DE CREDITO',
            ],
            [
                'code' => '08',
                'descripcion' => 'NOTA DE DEBITO',
            ],
        ];

        foreach ($tipos as $tipo) {
            TipoComprobante::updateOrCreate(
                ['code' => $tipo['code']],
                ['descripcion' => $tipo['descripcion']]
            );
        }
    }
}
