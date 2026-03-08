<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Mantenimiento;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $agente   = User::first();
        $clientes = Cliente::all();

        if ($clientes->isEmpty()) return;

        $tickets = [
            [
                'asunto'              => 'Mantenimiento preventivo anual del sistema',
                'descripcion'         => 'El cliente solicita el mantenimiento preventivo anual incluido en la garantía.',
                'categoria'           => 'mantenimiento',
                'tipo_mantenimiento'  => 'preventivo',
                'fecha_mantenimiento' => now()->addDays(5)->toDateString(),
                'hora_mantenimiento'  => '09:00',
                'prioridad'           => 'media',
                'estado'              => 'en_progreso',
                'canal'               => 'whatsapp',
            ],
            [
                'asunto'              => 'Inversor muestra error de sobretensión E023',
                'descripcion'         => 'Desde hace 2 días el inversor muestra el código E023. El sistema dejó de inyectar energía a la red.',
                'categoria'           => 'soporte_tecnico',
                'componente_afectado' => 'Inversor Fronius 5kW',
                'prioridad'           => 'alta',
                'estado'              => 'en_progreso',
                'canal'               => 'whatsapp',
            ],
            [
                'asunto'              => 'Panel solar con rajadura visible',
                'descripcion'         => 'Uno de los paneles tiene una rajadura en la esquina inferior derecha.',
                'categoria'           => 'garantia',
                'componente_afectado' => 'Panel Monocristalino 400W (panel #3)',
                'prioridad'           => 'media',
                'estado'              => 'asignado',
                'canal'               => 'telefono',
            ],
            [
                'asunto'              => 'Sistema genera 30% menos de lo cotizado',
                'descripcion'         => 'Según la app estoy generando 30% menos. Mi sistema es de 5kW y solo genera 15kWh diarios.',
                'categoria'           => 'consulta_reclamo',
                'prioridad'           => 'alta',
                'estado'              => 'en_progreso',
                'canal'               => 'telefono',
            ],
            [
                'asunto'              => 'Cobro duplicado en última factura',
                'descripcion'         => 'Revisé mi estado de cuenta y veo un cargo duplicado por el mismo servicio.',
                'categoria'           => 'facturacion',
                'prioridad'           => 'media',
                'estado'              => 'resuelto',
                'solucion'            => 'Se verificó el cobro y se emitió nota de crédito por el monto duplicado.',
                'tipo_solucion'       => 'resuelto_remoto',
                'canal'               => 'email',
            ],
        ];

        foreach ($tickets as $index => $data) {
            $cliente  = $clientes->random();
            $codigo   = 'TK-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $slaHoras = Ticket::SLA_POR_PRIORIDAD[$data['prioridad']] ?? 48;
            $fechaApertura = now()->subDays(rand(0, 10))->subHours(rand(0, 8));

            $ticket = Ticket::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo'                  => $codigo,
                    'slug'                    => Str::slug($codigo . '-' . Str::random(5)),
                    'cliente_id'              => $cliente->id,
                    'sla_horas'               => $slaHoras,
                    'sla_vencimiento'         => $fechaApertura->copy()->addHours($slaHoras),
                    'sla_cumplido'            => $data['estado'] === 'resuelto' ? true : null,
                    'fecha_primera_respuesta' => $fechaApertura->copy()->addHours(rand(1, 4)),
                    'fecha_resolucion'        => $data['estado'] === 'resuelto' ? now()->subDays(rand(0, 3)) : null,
                    'fecha_cierre'            => $data['estado'] === 'resuelto' ? now()->subDays(rand(0, 2)) : null,
                    'user_id'                 => $agente?->id,
                ])
            );

            // Crear mantenimiento automáticamente si el ticket es de categoría mantenimiento
            if ($ticket->categoria === 'mantenimiento' && !$ticket->mantenimiento) {
                $tipo = $data['tipo_mantenimiento'] ?? 'preventivo';
                Mantenimiento::updateOrCreate(
                    ['ticket_id' => $ticket->id],
                    [
                        'cliente_id'       => $ticket->cliente_id,
                        'ticket_id'        => $ticket->id,
                        'titulo'           => $ticket->asunto,
                        'tipo'             => $tipo,
                        'descripcion'      => $ticket->descripcion,
                        'fecha_programada' => $data['fecha_mantenimiento'] ?? now()->addDays(7)->toDateString(),
                        'hora_programada'  => $data['hora_mantenimiento'] ?? '09:00',
                        'direccion'        => 'Por confirmar',
                        'tecnico_id'       => $agente?->id,
                        'estado'           => 'programado',
                    ]
                );
            }
        }
    }
}
