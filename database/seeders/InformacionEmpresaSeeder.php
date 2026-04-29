<?php

namespace Database\Seeders;

use App\Models\InformacionEmpresa;
use Illuminate\Database\Seeder;

class InformacionEmpresaSeeder extends Seeder
{
    /**
     * Crea el registro único con los datos iniciales de Cisnergia.
     * Si ya existe, lo actualiza.
     */
    public function run(): void
    {
        InformacionEmpresa::updateOrCreate(
            ['id' => 1],
            [
                'razon_social'      => 'CISNERGIA PERÚ S.A.C.',
                'ruc'               => '20612345678',
                'nombre_comercial'  => 'Cisnergia Perú',
                'logo'              => null,

                'direccion'         => 'Av. Principal 123, San Isidro, Lima',
                'telefono'          => '+51 999 999 999',
                'celular'           => '+51 999 999 999',
                'whatsapp'          => '+51 999 999 999',
                'email'             => 'ventas@cisnergia.pe',
                'horario_atencion'  => 'Lun-Vie: 9AM-6PM',

                'facebook'          => 'https://www.facebook.com/cisnergiaperu',
                'instagram'         => 'https://www.instagram.com/cisnergiaperu',
                'linkedin'          => 'https://www.linkedin.com/company/cisnergiaperu',
                'youtube'           => 'https://www.youtube.com/@cisnergiaperu',
            ]
        );
    }
}
