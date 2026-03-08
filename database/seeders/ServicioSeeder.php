<?php

namespace Database\Seeders;

use App\Models\Servicio;
use App\Models\Sede;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServicioSeeder extends Seeder
{
    /**
     * Catálogo de servicios de Cisnergia.
     *
     * tipo_servicio: 'publico'  → contratado con entidades públicas (distribuidoras, OSINERGMIN, MEM)
     *               'privado' → servicio directo al cliente privado
     *
     * El 'name' es el tipo de trabajo que se realiza.
     */
    public function run(): void
    {
        $sedeId = Sede::first()?->id ?? 1;

        $servicios = [
            [
                'tipo_servicio' => 'privado',
                'name'          => 'Instalación',
                'descripcion'   => 'Instalación completa de sistema solar fotovoltaico: montaje de paneles, cableado, conexión a inversores y puesta en marcha.',
            ],
            [
                'tipo_servicio' => 'privado',
                'name'          => 'Mantenimiento Preventivo',
                'descripcion'   => 'Revisión periódica del sistema solar: limpieza de paneles, inspección de conexiones, verificación de inversores y reporte de rendimiento.',
            ],
            [
                'tipo_servicio' => 'privado',
                'name'          => 'Mantenimiento Correctivo',
                'descripcion'   => 'Diagnóstico y reparación de fallas en el sistema solar: inversor, paneles, cableado y protecciones eléctricas.',
            ],
            [
                'tipo_servicio' => 'privado',
                'name'          => 'Ampliación',
                'descripcion'   => 'Adición de paneles, baterías o equipos a un sistema solar existente para aumentar su capacidad de generación.',
            ],
            [
                'tipo_servicio' => 'publico',
                'name'          => 'Trámite ante Distribuidora',
                'descripcion'   => 'Gestión y tramitación de expediente técnico ante la empresa distribuidora eléctrica para habilitación de medidor bidireccional.',
            ],
            [
                'tipo_servicio' => 'publico',
                'name'          => 'Trámite ante OSINERGMIN',
                'descripcion'   => 'Gestión de registros, declaraciones y autorizaciones ante OSINERGMIN para sistemas de generación distribuida.',
            ],
        ];

        foreach ($servicios as $index => $data) {
            $numero = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $codigo = 'SERV-' . date('Y') . '-' . $numero;

            Servicio::firstOrCreate(
                ['name' => $data['name']],
                [
                    'codigo'         => $codigo,
                    'slug'           => Str::slug($data['name'] . '-' . $codigo),
                    'tipo_servicio'  => $data['tipo_servicio'],
                    'descripcion'    => $data['descripcion'],
                    'estado'         => 'Activo',
                    'registrado_por' => 'Sistema',
                    'sede_id'        => $sedeId,
                ]
            );
        }

        $this->command->info('✔ ServicioSeeder: ' . count($servicios) . ' servicios creados.');
    }
}
