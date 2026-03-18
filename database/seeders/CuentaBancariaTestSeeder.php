<?php

namespace Database\Seeders;

use App\Models\Cuentabanco;
use Illuminate\Database\Seeder;

class CuentaBancariaTestSeeder extends Seeder
{
    public function run(): void
    {
        Cuentabanco::firstOrCreate(
            ['numero_cuenta' => '191-12345678-0-99'],
            [
                'banco_id' => 1, // BCP
                'moneda_id' => 1,
                'sede_id' => 1,
                'titular' => 'Cisnergia SAC',
                'saldo_inicial' => 50000.00,
                'saldo_actual' => 50000.00,
                'cci' => '00219112345678099',
                'estado' => true,
                'cuenta_principal' => true,
                'fecha_apertura' => now()->format('Y-m-d'),
            ]
        );

        Cuentabanco::firstOrCreate(
            ['numero_cuenta' => '200-98765432-1-55'],
            [
                'banco_id' => 5, // Interbank
                'moneda_id' => 1,
                'sede_id' => 1,
                'titular' => 'Cisnergia SAC',
                'saldo_inicial' => 25000.00,
                'saldo_actual' => 25000.00,
                'cci' => '00320098765432155',
                'estado' => true,
                'cuenta_principal' => false,
                'fecha_apertura' => now()->format('Y-m-d'),
            ]
        );

        Cuentabanco::firstOrCreate(
            ['numero_cuenta' => '011-23456789-0-33'],
            [
                'banco_id' => 4, // BBVA
                'moneda_id' => 1,
                'sede_id' => 1,
                'titular' => 'Cisnergia SAC',
                'saldo_inicial' => 15000.00,
                'saldo_actual' => 15000.00,
                'cci' => '01101123456789033',
                'estado' => true,
                'cuenta_principal' => false,
                'fecha_apertura' => now()->format('Y-m-d'),
            ]
        );
    }
}
