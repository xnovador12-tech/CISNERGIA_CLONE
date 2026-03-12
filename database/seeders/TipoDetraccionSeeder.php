<?php

namespace Database\Seeders;

use App\Models\TipoDetraccion;
use Illuminate\Database\Seeder;

class TipoDetraccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => '037', 'descripcion' => 'Demás servicios gravados con el IGV', 'porcentaje' => 12],
            ['code' => '012', 'descripcion' => 'Intermediación laboral y tercerización', 'porcentaje' => 12],
            ['code' => '014', 'descripcion' => 'Mantenimiento y reparación de bienes muebles', 'porcentaje' => 12],
            ['code' => '017', 'descripcion' => 'Arrendamiento de bienes', 'porcentaje' => 12],
            ['code' => '019', 'descripcion' => 'Transporte de carga', 'porcentaje' => 4],
            ['code' => '021', 'descripcion' => 'Contratos de construcción', 'porcentaje' => 4],
        ];

        foreach ($data as $item) {
            TipoDetraccion::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
