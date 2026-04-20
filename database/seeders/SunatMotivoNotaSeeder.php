<?php

namespace Database\Seeders;

use App\Models\SunatMotivoNota;
use App\Models\Tiposcomprobante;
use Illuminate\Database\Seeder;

class SunatMotivoNotaSeeder extends Seeder
{
    public function run(): void
    {
        $nc = Tiposcomprobante::where('codigo', '07')->firstOrFail();
        $nd = Tiposcomprobante::where('codigo', '08')->firstOrFail();

        $motivosNC = [
            ['codigo' => '01', 'descripcion' => 'Anulación de la operación'],
            ['codigo' => '02', 'descripcion' => 'Anulación por error en el RUC'],
            ['codigo' => '03', 'descripcion' => 'Corrección por error en la descripción'],
            ['codigo' => '04', 'descripcion' => 'Descuento global'],
            ['codigo' => '05', 'descripcion' => 'Descuento por ítem'],
            ['codigo' => '06', 'descripcion' => 'Devolución total'],
            ['codigo' => '07', 'descripcion' => 'Devolución por ítem'],
            ['codigo' => '09', 'descripcion' => 'Disminución en el valor'],
            ['codigo' => '10', 'descripcion' => 'Otros conceptos'],
        ];

        $motivosND = [
            ['codigo' => '01', 'descripcion' => 'Intereses por mora'],
            ['codigo' => '02', 'descripcion' => 'Aumento en el valor'],
            ['codigo' => '03', 'descripcion' => 'Penalidades / otros conceptos'],
        ];

        foreach ($motivosNC as $motivo) {
            SunatMotivoNota::firstOrCreate(
                ['codigo' => $motivo['codigo'], 'tiposcomprobante_id' => $nc->id],
                ['descripcion' => $motivo['descripcion'], 'estado' => true]
            );
        }

        foreach ($motivosND as $motivo) {
            SunatMotivoNota::firstOrCreate(
                ['codigo' => $motivo['codigo'], 'tiposcomprobante_id' => $nd->id],
                ['descripcion' => $motivo['descripcion'], 'estado' => true]
            );
        }
    }
}
