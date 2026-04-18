<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\Tiposcomprobante;
use Illuminate\Database\Seeder;

class SerieComprobanteSeeder extends Seeder
{
    public function run(): void
    {
        $series = [
            ['codigo' => '01', 'serie' => 'F001'],   // Factura
            ['codigo' => '03', 'serie' => 'B001'],   // Boleta
            ['codigo' => '00', 'serie' => 'N001'],   // Nota de Venta
            ['codigo' => '07', 'serie' => 'FC01'],   // Nota de Crédito
            ['codigo' => '07', 'serie' => 'BC01'],   // Nota de Crédito
            ['codigo' => '08', 'serie' => 'FD01'],   // Nota de Débito
            ['codigo' => '08', 'serie' => 'BD01'],   // Nota de Débito
            ['codigo' => '09', 'serie' => 'T001'],   // Guía Remisión Remitente
            ['codigo' => '31', 'serie' => 'V001'],   // Guía Remisión Transportista
        ];

        foreach ($series as $data) {
            $tipo = Tiposcomprobante::where('codigo', $data['codigo'])->first();
            if (!$tipo) continue;

            Serie::firstOrCreate(
                ['tiposcomprobante_id' => $tipo->id, 'serie' => $data['serie']],
                ['correlativo' => 0]
            );
        }
    }
}
