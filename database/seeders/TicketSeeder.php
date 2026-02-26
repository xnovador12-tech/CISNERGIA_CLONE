<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketMensaje;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Crea tickets de soporte para clientes existentes.
     *
     * Dependencia: ClienteSeeder (debe ejecutarse antes).
     * Los clientes ya existen porque fueron creados desde oportunidades ganadas.
     */
    public function run(): void
    {
        $agente = User::first();

        $clientes = Cliente::all();
        if ($clientes->isEmpty()) {
            $this->command->warn('⚠️ No hay clientes. Se omitió TicketSeeder.');
            $this->command->warn('   Ejecuta ClienteSeeder primero.');
            return;
        }

        $tickets = [
            [
                'asunto' => 'Inversor muestra error de sobretensión',
                'descripcion' => 'Desde hace 2 días el inversor muestra el código de error E023 en la pantalla. El sistema dejó de inyectar energía a la red. Ya intenté reiniciar el equipo pero el error persiste.',
                'tipo' => 'soporte_tecnico',
                'categoria' => 'inversor',
                'prioridad' => 'alta',
                'estado' => 'en_progreso',
                'canal' => 'whatsapp',
                'mensajes' => [
                    ['mensaje' => 'Buenos días, recibimos su reporte. Nuestro equipo técnico revisará el caso.', 'tipo' => 'respuesta'],
                    ['mensaje' => 'El error E023 indica sobretensión en la red. ¿Ha notado fluctuaciones de voltaje en su zona?', 'tipo' => 'respuesta'],
                    ['mensaje' => 'Sí, he notado que las luces parpadean por las noches.', 'tipo' => 'respuesta', 'es_cliente' => true],
                    ['mensaje' => 'Programaremos visita técnica para mañana. Un técnico verificará la configuración del inversor.', 'tipo' => 'respuesta'],
                ],
            ],
            [
                'asunto' => 'Panel solar con rajadura visible',
                'descripcion' => 'Detecté que uno de los paneles tiene una rajadura en la esquina inferior derecha. No sé cómo ocurrió pero está afectando la generación. Es el panel número 3 de la fila del frente.',
                'tipo' => 'garantia',
                'categoria' => 'paneles',
                'prioridad' => 'media',
                'estado' => 'asignado',
                'canal' => 'telefono',
                'mensajes' => [
                    ['mensaje' => 'Gracias por reportar. ¿Puede enviarnos fotos del panel afectado?', 'tipo' => 'respuesta'],
                    ['mensaje' => 'Foto recibida. Procederemos con la evaluación bajo garantía.', 'tipo' => 'nota_interna'],
                ],
            ],
            [
                'asunto' => 'Consulta sobre monitoreo remoto',
                'descripcion' => 'No puedo acceder a la aplicación de monitoreo. Me pide una contraseña que no tengo. ¿Cómo puedo ver la producción de mi sistema?',
                'tipo' => 'consulta',
                'categoria' => 'monitoreo',
                'prioridad' => 'baja',
                'estado' => 'resuelto',
                'solucion' => 'Se resetearon las credenciales y se envió nuevo acceso al cliente. Se brindó capacitación telefónica sobre el uso de la app.',
                'tipo_solucion' => 'resuelto_remoto',
                'canal' => 'email',
                'calificacion_cliente' => 5,
                'comentario_cliente' => 'Excelente atención, me resolvieron rápido.',
                'mensajes' => [
                    ['mensaje' => 'Le enviaremos nuevas credenciales a su correo.', 'tipo' => 'respuesta'],
                    ['mensaje' => 'Ya pude ingresar, muchas gracias!', 'tipo' => 'respuesta', 'es_cliente' => true],
                ],
            ],
            [
                'asunto' => 'Solicitud de mantenimiento preventivo',
                'descripcion' => 'Mi sistema cumplió 1 año. Quisiera programar el mantenimiento preventivo que está incluido en mi garantía.',
                'tipo' => 'mantenimiento',
                'categoria' => 'instalacion',
                'prioridad' => 'baja',
                'estado' => 'abierto',
                'canal' => 'web',
                'mensajes' => [
                    ['mensaje' => 'Gracias por contactarnos. Verificaremos su garantía y le ofreceremos fechas disponibles.', 'tipo' => 'respuesta'],
                ],
            ],
            [
                'asunto' => 'Sistema no genera lo esperado',
                'descripcion' => 'Según la app estoy generando 30% menos de lo que me indicaron en la cotización. Mi sistema es de 5kW y solo genera 15kWh diarios cuando debería generar más.',
                'tipo' => 'reclamo',
                'categoria' => 'produccion',
                'prioridad' => 'alta',
                'estado' => 'en_progreso',
                'canal' => 'telefono',
                'mensajes' => [
                    ['mensaje' => 'Entendemos su preocupación. Analizaremos los datos de monitoreo.', 'tipo' => 'respuesta'],
                    ['mensaje' => 'Revisión de datos: últimos 30 días promedio 15.2 kWh/día. Esperado según diseño: 21.7 kWh/día en verano.', 'tipo' => 'nota_interna'],
                    ['mensaje' => 'Detectamos que hay sombras parciales entre 10am-12pm. ¿Ha habido cambios en construcciones cercanas?', 'tipo' => 'respuesta'],
                ],
            ],
            [
                'asunto' => 'Factura de luz no bajó como esperaba',
                'descripcion' => 'Instalé el sistema hace 2 meses y mi factura de luz sigue siendo alta. ¿Es normal? Me dijeron que iba a bajar un 80%.',
                'tipo' => 'consulta',
                'categoria' => 'documentacion',
                'prioridad' => 'media',
                'estado' => 'cerrado',
                'solucion' => 'Se explicó al cliente que el ahorro real depende de su patrón de consumo. En su caso, consume más energía en horario nocturno cuando no hay generación solar. Se recomendó cambiar hábitos de consumo o considerar sistema con baterías.',
                'tipo_solucion' => 'resuelto_remoto',
                'canal' => 'email',
                'calificacion_cliente' => 4,
                'comentario_cliente' => 'Entendí la explicación, aunque esperaba más ahorro.',
            ],
        ];

        foreach ($tickets as $index => $data) {
            $cliente = $clientes->random();
            $codigo = 'TK-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $slaHoras = Ticket::SLA_POR_PRIORIDAD[$data['prioridad']] ?? 48;
            $fechaApertura = now()->subDays(rand(0, 15))->subHours(rand(0, 12));

            $mensajes = $data['mensajes'] ?? [];
            unset($data['mensajes']);

            $ticket = Ticket::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo' => $codigo,
                    'slug' => Str::slug($codigo . '-' . Str::random(5)),
                    'cliente_id' => $cliente->id,
                    'sla_horas' => $slaHoras,
                    'sla_vencimiento' => $fechaApertura->copy()->addHours($slaHoras),
                    'sla_cumplido' => in_array($data['estado'], ['resuelto', 'cerrado']) ? true : null,
                    'fecha_apertura' => $fechaApertura,
                    'fecha_primera_respuesta' => $fechaApertura->copy()->addHours(rand(1, 4)),
                    'fecha_resolucion' => $data['estado'] === 'resuelto' ? now()->subDays(rand(0, 3)) : null,
                    'fecha_cierre' => $data['estado'] === 'cerrado' ? now()->subDays(rand(0, 2)) : null,
                    'user_id' => $agente?->id,
                ])
            );

            // Crear mensajes
            foreach ($mensajes as $mensaje) {
                TicketMensaje::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => ($mensaje['es_cliente'] ?? false) ? null : $agente?->id,
                    'mensaje' => $mensaje['mensaje'],
                    'tipo' => $mensaje['tipo'],
                    'es_cliente' => $mensaje['es_cliente'] ?? false,
                ]);
            }
        }
    }
}
