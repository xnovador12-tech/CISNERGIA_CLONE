<?php

namespace Database\Seeders;

use App\Models\Moneda;
use App\Models\TipoNotaCredito;
use App\Models\TipoNotaDebito;
use Illuminate\Database\Seeder;

class FinanceSeeds extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Monedas
        $monedas = [
            ['descripcion' => 'SOLES', 'simbolo' => 'S/'],
            ['descripcion' => 'DOLARES', 'simbolo' => '$'],
        ];

        foreach ($monedas as $moneda) {
            Moneda::updateOrCreate(['descripcion' => $moneda['descripcion']], $moneda);
        }

        // Tipo Nota Credito
        $notasCredito = [
            ['code' => '01', 'descripcion' => 'Anulación de la operación'],
            ['code' => '02', 'descripcion' => 'Anulación por error en el RUC'],
            ['code' => '03', 'descripcion' => 'Corrección por error en la descripción'],
            ['code' => '04', 'descripcion' => 'Descuento global'],
            ['code' => '05', 'descripcion' => 'Descuento por ítem'],
            ['code' => '06', 'descripcion' => 'Devolución total'],
            ['code' => '07', 'descripcion' => 'Devolución por ítem'],
            ['code' => '08', 'descripcion' => 'Bonificación'],
            ['code' => '09', 'descripcion' => 'Disminución en el valor'],
            ['code' => '10', 'descripcion' => 'Otros Conceptos '],
        ];

        foreach ($notasCredito as $nota) {
            TipoNotaCredito::updateOrCreate(['code' => $nota['code']], $nota);
        }

        // Tipo Nota Debito
        $notasDebito = [
            ['code' => '01', 'descripcion' => 'Intereses por mora'],
            ['code' => '02', 'descripcion' => 'Aumento en el valor'],
            ['code' => '03', 'descripcion' => 'Penalidades/ otros conceptos '],
        ];

        foreach ($notasDebito as $nota) {
            TipoNotaDebito::updateOrCreate(['code' => $nota['code']], $nota);
        }
    }
}
