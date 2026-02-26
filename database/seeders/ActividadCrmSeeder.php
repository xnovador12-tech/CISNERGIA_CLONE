<?php

namespace Database\Seeders;

use App\Models\ActividadCrm;
use App\Models\Prospecto;
use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActividadCrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendedor = User::first();
        $prospectos = Prospecto::all();
        $oportunidades = Oportunidad::all();

        // Actividades completadas para prospectos
        $actividadesProspectos = [
            [
                'tipo' => 'llamada',
                'titulo' => 'Llamada de primer contacto',
                'descripcion' => 'Presentación de servicios CISNERGIA y captación de necesidades.',
                'resultado' => 'Cliente interesado, solicita cotización para sistema residencial.',
                'estado' => 'completada',
            ],
            [
                'tipo' => 'email',
                'titulo' => 'Envío de información comercial',
                'descripcion' => 'Envío de brochure, casos de éxito y calculadora de ahorro.',
                'resultado' => 'Email entregado, cliente confirmó recepción.',
                'estado' => 'completada',
            ],
            [
                'tipo' => 'whatsapp',
                'titulo' => 'Seguimiento por WhatsApp',
                'descripcion' => 'Recordatorio de cotización enviada y respuesta a consultas.',
                'resultado' => 'Cliente confirma reunión para revisión de propuesta.',
                'estado' => 'completada',
            ],
            [
                'tipo' => 'visita_tecnica',
                'titulo' => 'Visita técnica para evaluación',
                'descripcion' => 'Medición de área disponible, análisis de orientación y sombras, revisión de instalación eléctrica.',
                'resultado' => 'Área óptima: 60m2, orientación norte, sin sombras. Medidor monofásico, requiere cambio a trifásico.',
                'ubicacion' => 'Av. La Molina 1234, La Molina, Lima',
                'estado' => 'completada',
            ],
            [
                'tipo' => 'reunion',
                'titulo' => 'Presentación de propuesta técnica',
                'descripcion' => 'Revisión de cotización, explicación técnica y financiera del proyecto.',
                'resultado' => 'Cliente acepta propuesta con algunas modificaciones. Solicita incluir monitoreo remoto.',
                'estado' => 'completada',
            ],
            [
                'tipo' => 'reunion',
                'titulo' => 'Negociación de condiciones',
                'descripcion' => 'Revisión de términos comerciales y definición de fechas (virtual vía Google Meet).',
                'resultado' => 'Acordado 5% descuento adicional. Instalación programada para próximo mes.',
                'estado' => 'completada',
            ],
        ];

        // Actividades programadas
        $actividadesProgramadas = [
            [
                'tipo' => 'llamada',
                'titulo' => 'Llamada de seguimiento',
                'descripcion' => 'Seguimiento a cotización enviada hace 5 días.',
                'prioridad' => 'alta',
                'estado' => 'programada',
                'dias_futuro' => 1,
            ],
            [
                'tipo' => 'visita_tecnica',
                'titulo' => 'Visita técnica programada',
                'descripcion' => 'Evaluación de techo para instalación de paneles.',
                'prioridad' => 'alta',
                'estado' => 'programada',
                'dias_futuro' => 3,
            ],
            [
                'tipo' => 'reunion',
                'titulo' => 'Reunión de cierre',
                'descripcion' => 'Firma de contrato y definición de cronograma.',
                'prioridad' => 'alta',
                'estado' => 'programada',
                'dias_futuro' => 5,
            ],
            [
                'tipo' => 'email',
                'titulo' => 'Envío de propuesta actualizada',
                'descripcion' => 'Enviar nueva cotización con descuento especial.',
                'prioridad' => 'media',
                'estado' => 'programada',
                'dias_futuro' => 2,
            ],
        ];

        $contador = 1;

        // Crear actividades para prospectos
        foreach ($prospectos->take(6) as $prospecto) {
            foreach ($actividadesProspectos as $actividad) {
                $codigo = 'ACT-' . date('Y') . '-' . str_pad($contador++, 5, '0', STR_PAD_LEFT);
                
                ActividadCrm::updateOrCreate(
                    ['codigo' => $codigo],
                    array_merge($actividad, [
                        'codigo' => $codigo,
                        'slug' => Str::slug($actividad['titulo'] . '-' . $codigo),
                        'actividadable_type' => Prospecto::class,
                        'actividadable_id' => $prospecto->id,
                        'fecha_programada' => now()->subDays(rand(1, 30)),
                        'fecha_realizada' => now()->subDays(rand(1, 30)),
                        'user_id' => $vendedor?->id,
                        'created_by' => $vendedor?->id,
                        'recordatorio_activo' => false,
                    ])
                );
            }
        }

        // Crear actividades para oportunidades
        foreach ($oportunidades->take(5) as $oportunidad) {
            foreach (array_slice($actividadesProspectos, 2, 3) as $actividad) {
                $codigo = 'ACT-' . date('Y') . '-' . str_pad($contador++, 5, '0', STR_PAD_LEFT);
                
                ActividadCrm::updateOrCreate(
                    ['codigo' => $codigo],
                    array_merge($actividad, [
                        'codigo' => $codigo,
                        'slug' => Str::slug($actividad['titulo'] . '-' . $codigo),
                        'actividadable_type' => Oportunidad::class,
                        'actividadable_id' => $oportunidad->id,
                        'fecha_programada' => now()->subDays(rand(1, 15)),
                        'fecha_realizada' => now()->subDays(rand(1, 15)),
                        'user_id' => $vendedor?->id,
                        'created_by' => $vendedor?->id,
                        'recordatorio_activo' => false,
                    ])
                );
            }
        }

        // Crear actividades programadas
        foreach ($prospectos->take(4) as $index => $prospecto) {
            $actividad = $actividadesProgramadas[$index];
            $codigo = 'ACT-' . date('Y') . '-' . str_pad($contador++, 5, '0', STR_PAD_LEFT);
            
            // Remover dias_futuro antes de guardar
            $diasFuturo = $actividad['dias_futuro'] ?? 1;
            unset($actividad['dias_futuro']);
            
            ActividadCrm::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($actividad, [
                    'codigo' => $codigo,
                    'slug' => Str::slug($actividad['titulo'] . '-' . $codigo),
                    'actividadable_type' => Prospecto::class,
                    'actividadable_id' => $prospecto->id,
                    'fecha_programada' => now()->addDays($diasFuturo),
                    'user_id' => $vendedor?->id,
                    'created_by' => $vendedor?->id,
                    'recordatorio_activo' => true,
                    'recordatorio_minutos_antes' => 30,
                ])
            );
        }
    }
}
