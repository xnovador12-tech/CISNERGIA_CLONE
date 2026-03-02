<?php

namespace Database\Seeders;

use App\Models\Mantenimiento;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MantenimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tecnico = User::first();
        $clientes = Cliente::all();
        
        if ($clientes->isEmpty()) {
            return;
        }

        $mantenimientos = [
            // Mantenimientos completados
            [
                'tipo' => 'preventivo',
                'titulo' => 'Mantenimiento preventivo anual - Sistema 5kW',
                'descripcion' => 'Mantenimiento preventivo programado para sistema residencial de 5kW.',
                'potencia_sistema_kw' => 5.0,
                'cantidad_paneles' => 10,
                'marca_inversor' => 'Growatt',
                'modelo_inversor' => 'MIN 5000TL-X',
                'estado' => 'completado',
                'es_gratuito' => true,
                'checklist' => [
                    'limpieza_paneles' => ['completado' => true, 'observacion' => 'Paneles limpios, sin suciedad acumulada'],
                    'inspeccion_visual' => ['completado' => true, 'observacion' => 'Sin daños visibles'],
                    'conexiones_paneles' => ['completado' => true, 'observacion' => 'Todas las conexiones ajustadas'],
                    'medicion_voltaje' => ['completado' => true, 'observacion' => 'Voc: 49.2V, Isc: 11.2A - Dentro de parámetros'],
                    'funcionamiento_inversor' => ['completado' => true, 'observacion' => 'Funcionando correctamente'],
                    'display_errores' => ['completado' => true, 'observacion' => 'Sin errores en histórico'],
                    'anclajes' => ['completado' => true, 'observacion' => 'Anclajes firmes'],
                ],
                'resultados' => [
                    'limpieza_paneles' => ['completado' => true],
                    'inspeccion_visual' => ['completado' => true],
                    'conexiones_paneles' => ['completado' => true],
                    'medicion_voltaje' => ['completado' => true],
                    'funcionamiento_inversor' => ['completado' => true],
                ],
                'produccion_actual_kwh' => 620,
                'produccion_esperada_kwh' => 650,
                'eficiencia_porcentaje' => 95.4,
            ],
            [
                'tipo' => 'correctivo',
                'titulo' => 'Reparación de conexión suelta - Sistema 10kW',
                'descripcion' => 'Cliente reporta bajo rendimiento. Revisar conexiones y cableado.',
                'potencia_sistema_kw' => 10.0,
                'cantidad_paneles' => 20,
                'marca_inversor' => 'Fronius',
                'modelo_inversor' => 'Primo 10.0-1',
                'estado' => 'completado',
                'es_gratuito' => false,
                'costo_mano_obra' => 150,
                'costo_materiales' => 45,
                'costo_transporte' => 50,
                'costo_total' => 245,
                'estado_pago' => 'pagado',
                'hallazgos' => 'Se encontró conector MC4 suelto en string 2. Causaba pérdida de 3 paneles.',
                'recomendaciones' => 'Revisar periódicamente las conexiones. Considerar protectores UV para conectores.',
                'produccion_actual_kwh' => 1250,
                'produccion_esperada_kwh' => 1300,
                'eficiencia_porcentaje' => 96.2,
            ],
            [
                'tipo' => 'preventivo',
                'titulo' => 'Mantenimiento semestral - Sistema Industrial 100kW',
                'descripcion' => 'Mantenimiento preventivo para planta industrial con contrato de mantenimiento.',
                'potencia_sistema_kw' => 100.0,
                'cantidad_paneles' => 200,
                'marca_inversor' => 'Sungrow',
                'modelo_inversor' => 'SG110CX',
                'estado' => 'completado',
                'es_gratuito' => false,
                'costo_mano_obra' => 800,
                'costo_materiales' => 200,
                'costo_transporte' => 150,
                'costo_total' => 1150,
                'estado_pago' => 'pagado',
                'duracion_estimada_horas' => 8,
                'duracion_real_horas' => 7,
                'produccion_actual_kwh' => 12500,
                'produccion_esperada_kwh' => 13000,
                'eficiencia_porcentaje' => 96.2,
                'hallazgos' => 'Algunos paneles presentan microfisuras por impacto de aves. Requiere monitoreo.',
                'recomendaciones' => 'Instalar protección anti-aves en estructura. Programar termografía en 3 meses.',
            ],
            
            // Mantenimientos programados
            [
                'tipo' => 'preventivo',
                'titulo' => 'Mantenimiento preventivo - Sistema 8kW Híbrido',
                'descripcion' => 'Incluye revisión de sistema de baterías.',
                'potencia_sistema_kw' => 8.0,
                'cantidad_paneles' => 16,
                'marca_inversor' => 'Deye',
                'modelo_inversor' => 'SUN-8K-SG04LP3',
                'estado' => 'programado',
                'es_gratuito' => true,
                'duracion_estimada_horas' => 3,
                'dias_futuro' => 5,
            ],
            [
                'tipo' => 'preventivo',
                'titulo' => 'Mantenimiento anual - Sistema comercial 25kW',
                'descripcion' => 'Mantenimiento incluido en garantía de instalación.',
                'potencia_sistema_kw' => 25.0,
                'cantidad_paneles' => 50,
                'marca_inversor' => 'Huawei',
                'modelo_inversor' => 'SUN2000-25KTL-M3',
                'estado' => 'confirmado',
                'es_gratuito' => true,
                'duracion_estimada_horas' => 4,
                'dias_futuro' => 10,
            ],
            [
                'tipo' => 'correctivo',
                'titulo' => 'Revisión de inversor con falla intermitente',
                'descripcion' => 'Inversor se desconecta de la red en horas pico. Posible problema de configuración.',
                'potencia_sistema_kw' => 15.0,
                'cantidad_paneles' => 30,
                'marca_inversor' => 'Growatt',
                'modelo_inversor' => 'MOD 15KTL3-X',
                'estado' => 'programado',
                'es_gratuito' => false,
                'costo_mano_obra' => 200,
                'costo_transporte' => 50,
                'duracion_estimada_horas' => 2,
                'dias_futuro' => 2,
            ],
            
            // Mantenimiento en progreso
            [
                'tipo' => 'preventivo',
                'titulo' => 'Limpieza profunda de paneles - Sistema 12kW',
                'descripcion' => 'Limpieza especial debido a acumulación de polvo por obra cercana.',
                'potencia_sistema_kw' => 12.0,
                'cantidad_paneles' => 24,
                'marca_inversor' => 'Fronius',
                'modelo_inversor' => 'Symo 12.5-3-M',
                'estado' => 'en_progreso',
                'es_gratuito' => false,
                'costo_mano_obra' => 180,
                'costo_materiales' => 30,
                'costo_transporte' => 40,
                'duracion_estimada_horas' => 3,
            ],
        ];

        foreach ($mantenimientos as $index => $data) {
            $cliente = $clientes->random();
            $codigo = 'MANT-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            
            $fechaProgramada = match($data['estado']) {
                'completado' => now()->subDays(rand(5, 30)),
                'en_progreso' => now(),
                default => now()->addDays($data['dias_futuro'] ?? rand(3, 15)),
            };
            
            unset($data['dias_futuro']);
            
            Mantenimiento::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo' => $codigo,
                    'slug' => Str::slug($codigo . '-' . Str::random(5)),
                    'cliente_id' => $cliente->id,
                    'fecha_programada' => $fechaProgramada,
                    'hora_programada' => '09:00',
                    'fecha_realizada' => $data['estado'] === 'completado' ? $fechaProgramada : null,
                    'direccion' => $cliente->direccion ?? 'Dirección por confirmar',
                    'tecnico_id' => $tecnico?->id,
                    'fecha_proximo_mantenimiento' => $data['estado'] === 'completado' ? $fechaProgramada->copy()->addMonths(6) : null,
                ])
            );
        }
    }
}
