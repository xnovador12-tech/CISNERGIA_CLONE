<?php

namespace Database\Seeders;

use App\Models\Mantenimiento;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $tecnico = User::first();
        $clientes = Cliente::all();

        if ($clientes->isEmpty()) {
            return;
        }

        // Checklists sincronizados con el controller
        $checklistPreventivo = [
            ['tarea' => 'Inspección visual de paneles y estructura', 'completado' => false],
            ['tarea' => 'Limpieza general de paneles',               'completado' => false],
            ['tarea' => 'Revisión de conexiones y cableado',         'completado' => false],
            ['tarea' => 'Revisión del inversor',                     'completado' => false],
            ['tarea' => 'Revisión de protecciones eléctricas',       'completado' => false],
            ['tarea' => 'Verificación de funcionamiento general',    'completado' => false],
            ['tarea' => 'Registro fotográfico',                      'completado' => false],
        ];
        $checklistCorrectivo = [
            ['tarea' => 'Diagnóstico del problema',              'completado' => false],
            ['tarea' => 'Identificación del componente fallado', 'completado' => false],
            ['tarea' => 'Reparación o reemplazo realizado',      'completado' => false],
            ['tarea' => 'Pruebas posteriores a la reparación',   'completado' => false],
            ['tarea' => 'Verificación de funcionamiento normal', 'completado' => false],
            ['tarea' => 'Registro fotográfico',                  'completado' => false],
        ];
        $checklistLimpieza = [
            ['tarea' => 'Limpieza de superficie de paneles',  'completado' => false],
            ['tarea' => 'Limpieza de marcos y estructura',    'completado' => false],
            ['tarea' => 'Limpieza de área del inversor',      'completado' => false],
            ['tarea' => 'Retiro de residuos acumulados',      'completado' => false],
            ['tarea' => 'Verificación visual post-limpieza',  'completado' => false],
            ['tarea' => 'Registro fotográfico',               'completado' => false],
        ];

        $mantenimientos = [

            // ── COMPLETADOS ──────────────────────────────────────────────
            [
                'tipo'                    => 'preventivo',
                'titulo'                  => 'Mantenimiento preventivo anual - Sistema 5kW',
                'descripcion'             => 'Mantenimiento preventivo programado para sistema residencial de 5kW.',
                'estado'                  => 'completado',
                'duracion_estimada_horas' => 3,
                'duracion_real_horas'     => 3,
                'hallazgos'               => 'Sin anomalías. Sistema en buen estado general.',
                'recomendaciones'         => 'Programar próximo mantenimiento en 6 meses.',
                'costo_mano_obra'         => 0,
                'costo_materiales'        => 0,
                'costo_transporte'        => 0,
                'costo_total'             => 0,
                'checklist' => array_map(fn($t) => array_merge($t, ['completado' => true]), $checklistPreventivo),
            ],
            [
                'tipo'                    => 'correctivo',
                'titulo'                  => 'Reparación de conexión suelta - Sistema 10kW',
                'descripcion'             => 'Cliente reporta bajo rendimiento. Revisar conexiones y cableado.',
                'estado'                  => 'completado',
                'duracion_estimada_horas' => 2,
                'duracion_real_horas'     => 2,
                'hallazgos'               => 'Se encontró conector MC4 suelto en string 2. Causaba pérdida de 3 paneles.',
                'recomendaciones'         => 'Revisar periódicamente las conexiones. Considerar protectores UV para conectores.',
                'costo_mano_obra'         => 150,
                'costo_materiales'        => 45,
                'costo_transporte'        => 50,
                'costo_total'             => 245,
                'checklist' => array_map(fn($t) => array_merge($t, ['completado' => true]), $checklistCorrectivo),
            ],
            [
                'tipo'                    => 'preventivo',
                'titulo'                  => 'Mantenimiento semestral - Sistema Industrial 100kW',
                'descripcion'             => 'Mantenimiento preventivo para planta industrial con contrato.',
                'estado'                  => 'completado',
                'duracion_estimada_horas' => 8,
                'duracion_real_horas'     => 7,
                'hallazgos'               => 'Algunos paneles presentan microfisuras por impacto de aves. Requiere monitoreo.',
                'recomendaciones'         => 'Instalar protección anti-aves en estructura. Programar termografía en 3 meses.',
                'costo_mano_obra'         => 800,
                'costo_materiales'        => 200,
                'costo_transporte'        => 150,
                'costo_total'             => 1150,
                'checklist' => array_map(fn($t) => array_merge($t, ['completado' => true]), $checklistPreventivo),
            ],

            // ── PROGRAMADOS / CONFIRMADOS ────────────────────────────────
            [
                'tipo'                    => 'preventivo',
                'titulo'                  => 'Mantenimiento preventivo - Sistema 8kW Híbrido',
                'descripcion'             => 'Incluye revisión de sistema de baterías.',
                'estado'                  => 'programado',
                'duracion_estimada_horas' => 3,
                'dias_futuro'             => 5,
                'checklist'               => $checklistPreventivo,
            ],
            [
                'tipo'                    => 'preventivo',
                'titulo'                  => 'Mantenimiento anual - Sistema comercial 25kW',
                'descripcion'             => 'Mantenimiento incluido en garantía de instalación.',
                'estado'                  => 'confirmado',
                'duracion_estimada_horas' => 4,
                'dias_futuro'             => 10,
                'checklist'               => $checklistPreventivo,
            ],
            [
                'tipo'                    => 'correctivo',
                'titulo'                  => 'Revisión de inversor con falla intermitente',
                'descripcion'             => 'Inversor se desconecta de la red en horas pico.',
                'estado'                  => 'programado',
                'duracion_estimada_horas' => 2,
                'dias_futuro'             => 2,
                'checklist'               => $checklistCorrectivo,
            ],

            // ── EN PROGRESO ──────────────────────────────────────────────
            [
                'tipo'                    => 'limpieza',
                'titulo'                  => 'Limpieza profunda de paneles - Sistema 12kW',
                'descripcion'             => 'Limpieza especial por acumulación de polvo de obra cercana.',
                'estado'                  => 'en_progreso',
                'duracion_estimada_horas' => 3,
                'costo_mano_obra'         => 180,
                'costo_materiales'        => 30,
                'costo_transporte'        => 40,
                'checklist' => [
                    ['tarea' => 'Limpieza de superficie de paneles', 'completado' => true],
                    ['tarea' => 'Limpieza de marcos y estructura',   'completado' => true],
                    ['tarea' => 'Limpieza de área del inversor',     'completado' => false],
                    ['tarea' => 'Retiro de residuos acumulados',     'completado' => false],
                    ['tarea' => 'Verificación visual post-limpieza', 'completado' => false],
                    ['tarea' => 'Registro fotográfico',              'completado' => false],
                ],
            ],
        ];

        foreach ($mantenimientos as $index => $data) {
            $cliente = $clientes->random();
            $codigo  = 'MANT-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            $fechaProgramada = match($data['estado']) {
                'completado'  => now()->subDays(rand(5, 30)),
                'en_progreso' => now(),
                default       => now()->addDays($data['dias_futuro'] ?? rand(3, 15)),
            };

            unset($data['dias_futuro']);

            Mantenimiento::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo'           => $codigo,
                    'slug'             => Str::slug($codigo . '-' . Str::random(5)),
                    'cliente_id'       => $cliente->id,
                    'fecha_programada' => $fechaProgramada,
                    'hora_programada'  => '09:00',
                    'fecha_realizada'  => $data['estado'] === 'completado' ? $fechaProgramada : null,
                    'direccion'        => $cliente->direccion ?? 'Dirección por confirmar',
                    'tecnico_id'       => $tecnico?->id,
                    'fecha_proximo_mantenimiento' => $data['estado'] === 'completado'
                        ? $fechaProgramada->copy()->addMonths(6)
                        : null,
                ])
            );
        }
    }
}
