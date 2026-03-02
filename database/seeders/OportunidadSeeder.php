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
     * Crea 10 oportunidades con asignación EXPLÍCITA de prospectos.
     *
     * Distribución:
     *   - 4 en pipeline activo (calificacion, evaluacion, propuesta_tecnica, negociacion)
     *   - 5 ganadas (se convertirán en clientes vía ClienteSeeder)
     *   - 1 perdida
     *
     * Prospectos se buscan por email para garantizar consistencia.
     */
    public function run(): void
    {
        $vendedor  = User::first();
        $vendedor2 = User::skip(1)->first() ?? $vendedor;

        // ── Buscar prospectos por email (determinístico) ──
        $prospectoMap = Prospecto::whereIn('email', [
            'carlos.mendoza@gmail.com',       // pipeline: calificacion
            'patricia.vega@clinicasonrisas.com', // pipeline: evaluacion
            'gparedes@gmail.com',              // pipeline: propuesta_tecnica (servicio)
            'dquispe@minimarketdondiego.com',  // pipeline: negociacion (ecommerce)
            'maria.torres@hotmail.com',        // GANADA → Cliente 1 (natural, residencial)
            'lgarcia@elbuensabor.com.pe',      // GANADA → Cliente 2 (jurídica, comercial)
            'fcastillo@textilesdelnorte.com.pe', // GANADA → Cliente 3 (jurídica, industrial)
            'rhuaman@agricolahuaman.com',      // GANADA → Cliente 4 (jurídica, agrícola)
            'lucia.fc89@hotmail.com',          // GANADA → Cliente 5 (natural, ecommerce)
            'pedro.diaz@outlook.com',          // PERDIDA
        ])->get()->keyBy('email');

        if ($prospectoMap->count() < 10) {
            return;
        }

        // ── Productos precargados ──
        $productos = Producto::whereIn('codigo', [
            'PNL-001', 'PNL-002', 'PNL-003', 'PNL-004',
            'INV-001', 'INV-002', 'INV-003', 'INV-004',
            'BAT-001', 'EST-001',
        ])->get()->keyBy('codigo');

        // ══════════════════════════════════════════════════════════════
        //  DEFINICIÓN DE OPORTUNIDADES
        // ══════════════════════════════════════════════════════════════

        $oportunidades = [

            // ─────────────────────────────────────────
            //  PIPELINE ACTIVO (4)
            // ─────────────────────────────────────────

            // 1. CALIFICACIÓN
            [
                'prospecto_email' => 'carlos.mendoza@gmail.com',
                'vendedor' => $vendedor,
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
                'items' => [
                    ['codigo' => 'PNL-001', 'cantidad' => 10, 'notas' => 'Paneles para techo de concreto'],
                    ['codigo' => 'INV-001', 'cantidad' => 1, 'notas' => 'Inversor Growatt 5kW'],
                ],
            ],

            // 2. EVALUACIÓN
            [
                'prospecto_email' => 'patricia.vega@clinicasonrisas.com',
                'vendedor' => $vendedor,
                'data' => [
                    'nombre' => 'Sistema 8kW - Clínica Dental Magdalena',
                    'etapa' => 'evaluacion',
                    'probabilidad' => 25,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'fecha_visita_programada' => now()->addDays(3),
                    'descripcion' => 'Clínica dental con consumo alto por equipos. Techo disponible en segundo piso.',
                    'fecha_cierre_estimada' => now()->addDays(30),
                ],
                'items' => [
                    ['codigo' => 'PNL-002', 'cantidad' => 14, 'notas' => 'TOPCon alta eficiencia'],
                    ['codigo' => 'INV-002', 'cantidad' => 1, 'notas' => ''],
                    ['codigo' => 'EST-001', 'cantidad' => 14, 'notas' => 'Estructura para techo de concreto'],
                ],
            ],

            // 3. PROPUESTA TÉCNICA (servicio)
            [
                'prospecto_email' => 'gparedes@gmail.com',
                'vendedor' => $vendedor,
                'data' => [
                    'nombre' => 'Mantenimiento Preventivo - Sistema 3kW San Miguel',
                    'etapa' => 'propuesta_tecnica',
                    'monto_estimado' => 1800,
                    'probabilidad' => 50,
                    'tipo_proyecto' => 'residencial',
                    'tipo_oportunidad' => 'servicio',
                    'tipo_servicio' => 'mantenimiento_preventivo',
                    'descripcion_servicio' => 'Mantenimiento preventivo + limpieza de paneles para sistema de 3kW instalado hace 1 año.',
                    'requiere_visita_tecnica' => true,
                    'fecha_visita_programada' => now()->addDays(2),
                    'descripcion' => 'Cliente con sistema solar existente solicita mantenimiento preventivo anual.',
                    'fecha_cierre_estimada' => now()->addDays(10),
                ],
                'items' => [],
            ],

            // 4. NEGOCIACIÓN
            [
                'prospecto_email' => 'dquispe@minimarketdondiego.com',
                'vendedor' => $vendedor2,
                'data' => [
                    'nombre' => 'Sistema 10kW - Minimarket Don Diego Comas',
                    'etapa' => 'negociacion',
                    'probabilidad' => 80,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'fecha_visita_programada' => now()->subDays(5),
                    'resultado_visita' => 'Local comercial con techo metálico amplio. Buena orientación norte.',
                    'descripcion' => 'Minimarket busca reducir costos energéticos. Contactado vía e-commerce.',
                    'observaciones' => 'Pendiente aprobación de financiamiento.',
                    'fecha_cierre_estimada' => now()->addDays(12),
                ],
                'items' => [
                    ['codigo' => 'PNL-001', 'cantidad' => 18, 'notas' => ''],
                    ['codigo' => 'INV-002', 'cantidad' => 1, 'notas' => 'Inversor Huawei 10kW'],
                    ['codigo' => 'EST-001', 'cantidad' => 18, 'notas' => 'Estructura para techo metálico'],
                ],
            ],

            // ─────────────────────────────────────────
            //  GANADAS (5) → Se convertirán en CLIENTES
            // ─────────────────────────────────────────

            // 5. GANADA → Cliente: María Elena Torres (natural, residencial, directo)
            [
                'prospecto_email' => 'maria.torres@hotmail.com',
                'vendedor' => $vendedor,
                'data' => [
                    'nombre' => 'Sistema Solar Residencial 3kW - San Borja',
                    'etapa' => 'ganada',
                    'probabilidad' => 100,
                    'tipo_proyecto' => 'residencial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Casa de 2 pisos. Techo de concreto en buen estado con buena orientación.',
                    'descripcion' => 'Sistema pequeño para casa unifamiliar. Referida por cliente existente. Instalación completada.',
                    'fecha_cierre_estimada' => now()->subDays(25),
                    'fecha_cierre_real' => now()->subDays(20),
                ],
                'items' => [
                    ['codigo' => 'PNL-004', 'cantidad' => 6, 'notas' => ''],
                    ['codigo' => 'INV-004', 'cantidad' => 1, 'notas' => 'Microinversor híbrido'],
                ],
            ],

            // 6. GANADA → Cliente: Luis Alberto García / Restaurante El Buen Sabor (jurídica, comercial, directo)
            [
                'prospecto_email' => 'lgarcia@elbuensabor.com.pe',
                'vendedor' => $vendedor,
                'data' => [
                    'nombre' => 'Sistema Comercial 25kW - Restaurante El Buen Sabor',
                    'etapa' => 'ganada',
                    'probabilidad' => 100,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Restaurante con techo metálico amplio. Consumo promedio S/2,800/mes.',
                    'descripcion' => 'Restaurante de alta demanda energética. Proyecto rentable con ROI estimado de 3 años.',
                    'fecha_cierre_estimada' => now()->subDays(40),
                    'fecha_cierre_real' => now()->subDays(35),
                ],
                'items' => [
                    ['codigo' => 'PNL-002', 'cantidad' => 44, 'notas' => 'TOPCon alta eficiencia'],
                    ['codigo' => 'INV-002', 'cantidad' => 1, 'notas' => 'Inversor Huawei 25kW'],
                    ['codigo' => 'EST-001', 'cantidad' => 44, 'notas' => 'Estructura para techo metálico'],
                ],
            ],

            // 7. GANADA → Cliente: Fernando Castillo / Textiles del Norte (jurídica, industrial, directo)
            [
                'prospecto_email' => 'fcastillo@textilesdelnorte.com.pe',
                'vendedor' => $vendedor2,
                'data' => [
                    'nombre' => 'Sistema Industrial 100kW - Textiles del Norte Ate',
                    'etapa' => 'ganada',
                    'probabilidad' => 100,
                    'tipo_proyecto' => 'industrial',
                    'tipo_oportunidad' => 'mixto',
                    'tipo_servicio' => 'instalacion',
                    'descripcion_servicio' => 'Instalación completa + contrato de mantenimiento anual incluido.',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Nave industrial de 2000m². Techo metálico en buenas condiciones. Sin sombras.',
                    'descripcion' => 'Fábrica textil con alto consumo. Proyecto grande con contrato de mantenimiento.',
                    'fecha_cierre_estimada' => now()->subDays(50),
                    'fecha_cierre_real' => now()->subDays(45),
                ],
                'items' => [
                    ['codigo' => 'PNL-003', 'cantidad' => 180, 'notas' => 'Paneles bifaciales para nave industrial'],
                    ['codigo' => 'INV-003', 'cantidad' => 4, 'notas' => 'Inversor SMA Tripower x4'],
                    ['codigo' => 'BAT-001', 'cantidad' => 2, 'notas' => 'Baterías de respaldo'],
                ],
            ],

            // 8. GANADA → Cliente: Ricardo Huamán / Agrícola Huamán (jurídica, agrícola, directo)
            [
                'prospecto_email' => 'rhuaman@agricolahuaman.com',
                'vendedor' => $vendedor2,
                'data' => [
                    'nombre' => 'Sistema Bombeo Solar 15kW - Fundo Cañete',
                    'etapa' => 'ganada',
                    'probabilidad' => 100,
                    'tipo_proyecto' => 'agricola',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Fundo de 50 hectáreas. Pozo de 80m de profundidad. Sin acceso a red eléctrica.',
                    'descripcion' => 'Sistema de bombeo solar para riego de cultivos. Zona sin acceso a red eléctrica.',
                    'fecha_cierre_estimada' => now()->subDays(15),
                    'fecha_cierre_real' => now()->subDays(10),
                ],
                'items' => [
                    ['codigo' => 'PNL-001', 'cantidad' => 28, 'notas' => 'Paneles para estructura en terreno'],
                    ['codigo' => 'INV-003', 'cantidad' => 1, 'notas' => 'Inversor SMA para bomba'],
                ],
            ],

            // 9. GANADA → Cliente: Lucía Fernández (natural, residencial, ecommerce)
            [
                'prospecto_email' => 'lucia.fc89@hotmail.com',
                'vendedor' => $vendedor, // asignado post-compra
                'data' => [
                    'nombre' => 'Kit Solar Residencial 2kW - Los Olivos',
                    'etapa' => 'ganada',
                    'probabilidad' => 100,
                    'tipo_proyecto' => 'residencial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => false,
                    'descripcion' => 'Compra directa desde e-commerce. Kit solar básico residencial. Envío e instalación incluida.',
                    'fecha_cierre_estimada' => now()->subDays(8),
                    'fecha_cierre_real' => now()->subDays(5),
                ],
                'items' => [
                    ['codigo' => 'PNL-004', 'cantidad' => 4, 'notas' => 'Kit básico e-commerce'],
                    ['codigo' => 'INV-004', 'cantidad' => 1, 'notas' => ''],
                ],
            ],

            // ─────────────────────────────────────────
            //  PERDIDA (1)
            // ─────────────────────────────────────────

            // 10. PERDIDA
            [
                'prospecto_email' => 'pedro.diaz@outlook.com',
                'vendedor' => $vendedor,
                'data' => [
                    'nombre' => 'Sistema 10kW + Baterías - Colegio Miraflores',
                    'etapa' => 'perdida',
                    'probabilidad' => 0,
                    'tipo_proyecto' => 'comercial',
                    'tipo_oportunidad' => 'producto',
                    'requiere_visita_tecnica' => true,
                    'resultado_visita' => 'Techo amplio en buen estado. Sin problemas técnicos.',
                    'descripcion' => 'Colegio privado interesado en reducir costos. Eligieron a la competencia.',
                    'motivo_perdida' => 'Competencia',
                    'competidor_ganador' => 'SolarMax Perú',
                    'detalle_perdida' => 'Competidor ofreció 15% menos usando paneles de menor calidad.',
                    'fecha_cierre_estimada' => now()->subDays(20),
                    'fecha_cierre_real' => now()->subDays(18),
                ],
                'items' => [
                    ['codigo' => 'PNL-001', 'cantidad' => 18, 'notas' => ''],
                    ['codigo' => 'INV-001', 'cantidad' => 1, 'notas' => ''],
                    ['codigo' => 'BAT-001', 'cantidad' => 1, 'notas' => 'Batería de litio 10kWh'],
                ],
            ],
        ];

        // ══════════════════════════════════════════════════════════════
        //  CREACIÓN
        // ══════════════════════════════════════════════════════════════

        foreach ($oportunidades as $entry) {
            $prospecto = $prospectoMap->get($entry['prospecto_email']);
            $data  = $entry['data'];
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

            // Si es ganada, monto_final = monto_estimado
            if ($data['etapa'] === 'ganada' && !isset($data['monto_final'])) {
                $data['monto_final'] = $data['monto_estimado'];
            }

            $data['prospecto_id']  = $prospecto->id;
            $data['user_id']       = $entry['vendedor']?->id;
            $data['fecha_creacion'] = now()->subDays(rand(5, 60));
            $data['codigo']        = Oportunidad::generarCodigo();
            $data['slug']          = Oportunidad::generarSlug($data['nombre'], $data['codigo']);

            $oportunidad = Oportunidad::create($data);

            // Asociar productos al pivot
            if (!empty($items)) {
                $syncData = [];
                foreach ($items as $item) {
                    $prod = $productos->get($item['codigo']);
                    if ($prod) {
                        $syncData[$prod->id] = [
                            'cantidad' => $item['cantidad'],
                            'notas'    => $item['notas'],
                        ];
                    }
                }
                $oportunidad->productosInteres()->sync($syncData);
            }

            // Actualizar estado del prospecto para mantener consistencia
            // Si tiene oportunidad, mínimo debe ser calificado
            // Si la oportunidad fue ganada, debe ser convertido
            // Nunca modificar un prospecto descartado
            if ($prospecto->estado !== 'descartado') {
                $nuevoEstado = match ($data['etapa']) {
                    'ganada'  => 'convertido',
                    default   => 'calificado',
                };
                // Solo avanzar estado, nunca retroceder
                $jerarquia = ['nuevo' => 1, 'contactado' => 2, 'calificado' => 3, 'convertido' => 4];
                if (($jerarquia[$nuevoEstado] ?? 0) > ($jerarquia[$prospecto->estado] ?? 0)) {
                    $prospecto->update(['estado' => $nuevoEstado]);
                }
            }

            $emoji = match ($data['etapa']) {
                'ganada'  => '✅',
                'perdida' => '❌',
                default   => '📋',
            };
        }

        $ganadas = collect($oportunidades)->where('data.etapa', 'ganada')->count();
    }
}
