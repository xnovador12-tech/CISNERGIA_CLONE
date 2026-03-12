<?php

namespace Database\Seeders;

use App\Models\Banco;
use App\Models\Cuentabanco;
use App\Models\Moneda;
use App\Models\Tipocuenta;
use Illuminate\Database\Seeder;

class CuentabancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banco = Banco::first();
        $tipo = Tipocuenta::first();
        $moneda = Moneda::where('descripcion', 'SOLES')->first();
        $sede = \App\Models\Sede::first();

        if ($banco && $tipo && $moneda && $sede) {
            Cuentabanco::updateOrCreate(
                ['numero_cuenta' => '191-12345678-0-99'],
                [
                    'banco_id' => $banco->id,
                    'tipocuenta_id' => $tipo->id,
                    'moneda_id' => $moneda->id,
                    'sede_id' => $sede->id,
                    'titular' => 'MI EMPRESA S.A.C.',
                    'saldo_inicial' => 1000,
                    'saldo_actual' => 1000,
                    'cci' => '002-191-12345678099-55',
                    'descripcion' => 'Cuenta Principal BCP Soles',
                    'estado' => true,
                    'cuenta_principal' => true,
                    'fecha_apertura' => now()->format('Y-m-d'),
                ]
            );
        }
    }
}
