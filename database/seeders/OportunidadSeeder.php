<?php

namespace Database\Seeders;

use App\Models\Oportunidad;
use App\Models\Producto;
use App\Models\Prospecto;
use App\Models\User;
use Illuminate\Database\Seeder;

class OportunidadSeeder extends Seeder
{
    /**
     * Crea 6 oportunidades (una por etapa) con productos asociados.
     */
    public function run(): void
    {
        $vendedor = User::first();
        $prospectos = Prospecto::whereIn('estado', ['calificado', 'contactado'])->get();

        if ($prospectos->isEmpty()) {
            $this->command->warn('⚠️ No hay prospectos disponibles. Se omitió OportunidadSeeder.');
            return;
        }

        // Precargar productos por código para asociar al pivot
        $productos = Producto::whereIn('codigo', [
            'PNL-001', 'PNL-002', 'PNL-003', 'PNL-004',
            'INV-001', 'INV-002', 'INV-003', 'INV-004',
            'BAT-001', 'EST-001',
        ])->get()->keyBy('codigo');

        $oportunidades = [
            // ─── CALIFICACIÓN (producto) ───
            [
                'data' => [
                    'nombre' => 'Sistema Solar Residencial 5kW - La Molina',
                    'etapa' => 'calificacion',
                    'probabilidad' => 10,
                    'tipo_proyecto' => 'residencial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => false,
                    'descripcion' => 'Cliente interesado en sistema de 10 paneles para reducir factura eléctrica de S/350/mes.',
                    'fecha_cierre_estimada' => now()->addDays(45),
                ],
                // 10x Panel 550W ($650) + 1x Inversor Growatt 5kW ($3,200) = $9,700
                'items' => [
                    ['codigo' => 'PNL-001', 'cantidad' => 10, 'notas' => 'Paneles para techo de concreto'],
                    ['codigo' => 'INV-001', 'cantidad' => 1, 'notas' => 'Inversor Growatt 5kW'],
                ],
            ],

            // ─── EVALUACIÓN (producto) ───
            [
                'data' => [
                    'nombre' => 'Sistema Comercial 25kW - Restaurante San Isidro',
                    'etapa' => 'evaluacion',
                    'probabilidad' => 25,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'fecha_visita_programada' => now()->addDays(3),
                    'descripcion' => 'Restaurante con consumo alto. Techo metálico amplio disponible.',
                    'fecha_cierre_estimada' => now()->addDays(30),
                ],
                // 10x Panel 580W ($750) + 1x Inversor Huawei 25kW ($5,800) + 10x Estructura ($120) = $14,500
                'items' => [
                    ['codigo' => 'PNL-002', 'cantidad' => 10, 'notas' => 'TOPCon alta eficiencia'],
                    ['codigo' => 'INV-002', 'cantidad' => 1, 'notas' => ''],
                    ['codigo' => 'EST-001', 'cantidad' => 10, 'notas' => 'Estructura para techo metálico'],
                ],
            ],

            // ─── PROPUESTA TÉCNICA (servicio) ───
            [
                'data' => [
                    'nombre' => 'Mantenimiento Preventivo - Hotel Miraflores',
                    'etapa' => 'propuesta_tecnica',
                    'monto_estimado' => 3500,
                    'probabilidad' => 50,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'servicio',
                    'tipo_servicio' => 'mantenimiento_preventivo',
                    'descripcion_servicio' => 'Mantenimiento anual + limpieza de paneles para sistema de 15kW instalado hace 2 años.',
                    'requiere_visita_tecnica' => true,
                    'fecha_visita_programada' => now()->addDays(2),
                    'descripcion' => 'Hotel con sistema solar existente solicita mantenimiento preventivo.',
                    'fecha_cierre_estimada' => now()->addDays(10),
                ],
                'items' => [], // Servicio puro, sin productos
            ],

            // ─── NEGOCIACIÓN (mixto) ───
            [
                'data' => [
                    'nombre' => 'Ampliación + Mantenimiento - Fábrica Ate',
                    'etapa' => 'negociacion',
                    'probabilidad' => 80,
                    'tipo_proyecto' => 'industrial',
                    'tipo_oportunidad' => 'mixto',
                    'tipo_servicio' => 'ampliacion',
                    'descripcion_servicio' => 'Ampliar de 50kW a 100kW + contrato de mantenimiento anual.',
                    'requiere_visita_tecnica' => true,
                    'fecha_visita_programada' => now()->subDays(10),
                    'resultado_visita' => 'Nave industrial de 2000m². Techo metálico en buenas condiciones.',
                    'descripcion' => 'Fábrica textil quiere duplicar capacidad + contrato de servicio.',
                    'observaciones' => 'Pendiente aprobación del directorio.',
                    'fecha_cierre_estimada' => now()->addDays(15),
                ],
                // 8x Panel 545W ($720) + 1x Inversor SMA ($5,500) = $11,260 (+ servicio manual)
                'items' => [
                    ['codigo' => 'PNL-003', 'cantidad' => 8, 'notas' => 'Paneles bifaciales para nave industrial'],
                    ['codigo' => 'INV-003', 'cantidad' => 1, 'notas' => 'Inversor SMA Tripower'],
                ],
            ],

            // ─── GANADA (producto) ───
            [
                'data' => [
                    'nombre' => 'Sistema 3kW - Departamento Jesús María',
                    'etapa' => 'ganada',
                    'probabilidad' => 100,
                    'tipo_proyecto' => 'residencial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Departamento último piso. Techo compartido con autorización.',
                    'descripcion' => 'Sistema pequeño para departamento. Instalación completada.',
                    'fecha_cierre_estimada' => now()->subDays(10),
                    'fecha_cierre_real' => now()->subDays(8),
                ],
                // 6x Panel 500W ($580) + 1x Inversor Deye ($2,400) = $5,880
                'items' => [
                    ['codigo' => 'PNL-004', 'cantidad' => 6, 'notas' => ''],
                    ['codigo' => 'INV-004', 'cantidad' => 1, 'notas' => 'Microinversor híbrido'],
                ],
            ],

            // ─── PERDIDA (producto) ───
            [
                'data' => [
                    'nombre' => 'Sistema 10kW + Baterías - Colegio Lince',
                    'etapa' => 'perdida',
                    'probabilidad' => 0,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Techo amplio en buen estado. Sin problemas técnicos.',
                    'descripcion' => 'Colegio privado interesado en reducir costos. Eligieron competencia.',
                    'motivo_perdida' => 'Competencia',
                    'competidor_ganador' => 'SolarMax Perú',
                    'detalle_perdida' => 'Competidor ofreció 15% menos usando paneles de menor calidad.',
                    'fecha_cierre_estimada' => now()->subDays(20),
                    'fecha_cierre_real' => now()->subDays(18),
                ],
                // 10x Panel 550W ($650) + 1x Inversor Growatt ($3,200) + 1x Batería ($6,800) = $16,500
                'items' => [
                    ['codigo' => 'PNL-001', 'cantidad' => 10, 'notas' => ''],
                    ['codigo' => 'INV-001', 'cantidad' => 1, 'notas' => ''],
                    ['codigo' => 'BAT-001', 'cantidad' => 1, 'notas' => 'Batería de litio 10kWh'],
                ],
            ],
        ];

        foreach ($oportunidades as $index => $entry) {
            $prospecto = $prospectos[$index % $prospectos->count()];
            $data = $entry['data'];
            $items = $entry['items'];

            // Calcular monto desde productos (si no está definido manualmente)
            if (!isset($data['monto_estimado']) && !empty($items)) {
                $monto = 0;
                foreach ($items as $item) {
                    $prod = $productos->get($item['codigo']);
                    if ($prod) {
                        $monto += $prod->precio * $item['cantidad'];
                    }
                }
                $data['monto_estimado'] = $monto;
            }

            // Si es ganada, monto_final = monto_estimado (o con descuento)
            if ($data['etapa'] === 'ganada' && !isset($data['monto_final'])) {
                $data['monto_final'] = $data['monto_estimado'];
            }

            $data['prospecto_id'] = $prospecto->id;
            $data['user_id'] = $vendedor?->id;
            $data['fecha_creacion'] = now()->subDays(rand(5, 45));
            $data['codigo'] = Oportunidad::generarCodigo();
            $data['slug'] = Oportunidad::generarSlug($data['nombre'], $data['codigo']);

            $oportunidad = Oportunidad::create($data);

            // Asociar productos al pivot
            if (!empty($items)) {
                $syncData = [];
                foreach ($items as $item) {
                    $prod = $productos->get($item['codigo']);
                    if ($prod) {
                        $syncData[$prod->id] = [
                            'cantidad' => $item['cantidad'],
                            'notas' => $item['notas'],
                        ];
                    }
                }
                $oportunidad->productosInteres()->sync($syncData);
            }
        }
    }
}
