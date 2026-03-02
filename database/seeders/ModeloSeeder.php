<?php

namespace Database\Seeders;

use App\Models\Modelo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModeloSeeder extends Seeder
{
    public function run(): void
    {
        $modelos = [
            // Paneles Solares
            'JAM72S30-550/MR',
            'Tiger Neo N-Type 580',
            'Vertex S+ DEG21C.20',
            'Hi-MO 5m LR5-72HPH-500M',

            // Inversores
            'MIN 5000TL-X',
            'MIN 10000TL-X',
            'SUN-5K-SG03LP1-EU',
            'SG3.0RS-L',

            // Baterías
            'US5000',
            'Battery-Box Premium HVS 10.2',

            // Estructuras
            'Rail AL-6005 T5',
            'Triangle Mount 15°',

            // Cables y Conectores
            'PV1-F 6mm²',
            'MC4-IP67',
            'DC Combiner Box 2-in',
        ];

        foreach ($modelos as $nombre) {
            Modelo::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'nombre' => $nombre,
                    'slug' => Str::slug($nombre),
                    'estado' => 'Activo',
                ]
            );
        }
    }
}
