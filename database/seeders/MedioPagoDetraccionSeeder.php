<?php

namespace Database\Seeders;

use App\Models\MedioPagoDetraccion;
use Illuminate\Database\Seeder;

class MedioPagoDetraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MedioPagoDetraccion::updateOrCreate(
            ['codigo' => '001'],
            ['descripcion' => 'Depósito en cuenta']
        );
    }
}
