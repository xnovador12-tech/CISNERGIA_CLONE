<?php

namespace Database\Seeders;

use App\Models\AperturaCierreCaja;
use App\Models\Cuentabanco;
use App\Models\User;
use App\Models\Moneda;
use Illuminate\Database\Seeder;

class AperturaCierreCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuenta = Cuentabanco::first();
        $user = User::first();
        $moneda = Moneda::where('descripcion', 'SOLES')->first();

        if ($cuenta && $user && $moneda) {
            AperturaCierreCaja::updateOrCreate(
                ['codigo' => 'CAJA-001'],
                [
                    'cuenta_bancaria_id' => $cuenta->id,
                    'user_id' => $user->id,
                    'moneda_id' => $moneda->id,
                    'fecha_apertura' => now()->format('Y-m-d'),
                    'hora_apertura' => now()->format('H:i:s'),
                    'saldo_inicial' => 100,
                    'efectivo_inicial' => 100,
                    'estado' => 'Abierto',
                ]
            );
        }
    }
}
