<?php

namespace Database\Seeders;

use App\Models\CotizacionCrm;
use App\Models\DetalleCotizacionCrm;
use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CotizacionCrmSeeder extends Seeder
{
    /**
     * Crea cotizaciones a partir de oportunidades activas y ganadas.
     *
     * Los ítems de cada cotización se leen DIRECTAMENTE de los productos
     * vinculados a la oportunidad (tabla pivot oportunidad_producto).
     * Esto garantiza consistencia en toda la cadena:
     *
     *   Oportunidad (productos) → Cotización (mismos productos + servicios)
     *       → Pedido (copia) → Venta (copia)
     *
     * Para oportunidades de tipo producto/mixto se agregan servicios estándar:
     *   - Instalación del sistema (mano de obra)
     *   - Trámite ante distribuidora eléctrica
     *
     * Dependencias: OportunidadSeeder (con productosInteres sincronizados)
     */
    public function run(): void
    {
        $vendedor = User::first();

        // Solo oportunidades que no estén en calificación ni perdidas
        $oportunidades = Oportunidad::whereNotIn('etapa', ['calificacion', 'perdida'])
            ->with(['prospecto', 'productosInteres'])
            ->get();

        if ($oportunidades->isEmpty()) {
            $this->command->warn('⚠️ No hay oportunidades activas para generar cotizaciones.');
            return;
        }

        $totalCreadas = 0;

        foreach ($oportunidades as $index => $oportunidad) {
            $esServicio = $oportunidad->tipo_oportunidad === 'servicio';
            $esMixto    = $oportunidad->tipo_oportunidad === 'mixto';

            // Estado de la cotización según etapa de la oportunidad
            $estado = match ($oportunidad->etapa) {
                'evaluacion'        => 'borrador',
                'propuesta_tecnica' => 'enviada',
                'negociacion'       => 'enviada',
                'ganada'            => 'aceptada',
                default             => 'borrador',
            };

            // Generar código secuencial
            $codigo = 'COT-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            $cotizacion = CotizacionCrm::create([
                'codigo'                  => $codigo,
                'slug'                    => Str::slug($codigo),
                'version'                 => 1,
                'oportunidad_id'          => $oportunidad->id,
                'prospecto_id'            => $oportunidad->prospecto_id,
                'nombre_proyecto'         => $oportunidad->nombre,
                'incluye_igv'             => true,
                'fecha_emision'           => now()->subDays(rand(1, 20)),
                'fecha_vigencia'          => now()->addDays(rand(5, 25)),
                'estado'                  => $estado,
                'fecha_envio'             => in_array($estado, ['enviada', 'aceptada']) ? now()->subDays(rand(1, 10)) : null,
                'user_id'                 => $vendedor?->id,
                'tiempo_ejecucion_dias'   => $esServicio ? 2 : rand(3, 7),
                'garantia_servicio'       => $esServicio
                    ? '90 días en servicio realizado'
                    : '2 años en mano de obra, 25 años en paneles',
                'condiciones_comerciales' => "- Precios incluyen IGV\n- Forma de pago: 50% adelanto, 50% contra entrega\n- Validez de la cotización: 30 días",
                'descuento_porcentaje'    => rand(0, 5),
            ]);

            // Eliminar ítems previos (si se re-ejecuta)
            $cotizacion->detalles()->delete();

            $orden = 1;

            if ($esServicio) {
                // ════════════════════════════════════════
                //  COTIZACIÓN DE SERVICIO PURO
                // ════════════════════════════════════════
                $tipoServicio = $oportunidad->tipo_servicio ?? 'mantenimiento_preventivo';

                DetalleCotizacionCrm::create([
                    'cotizacion_id'       => $cotizacion->id,
                    'categoria'           => 'servicio',
                    'descripcion'         => match ($tipoServicio) {
                        'instalacion'                => 'Servicio de Instalación de Sistema Solar',
                        'mantenimiento_correctivo'   => 'Mantenimiento Correctivo - Diagnóstico y Reparación',
                        'ampliacion'                 => 'Ampliación de Sistema Existente',
                        default                      => 'Mantenimiento Preventivo - Limpieza y Revisión',
                    },
                    'cantidad'            => 1,
                    'unidad'              => 'glb',
                    'precio_unitario'     => $oportunidad->monto_estimado
                        ? round($oportunidad->monto_estimado * 0.7, 2)
                        : rand(800, 3500),
                    'descuento_porcentaje' => 0,
                    'orden'               => $orden++,
                ]);

                DetalleCotizacionCrm::create([
                    'cotizacion_id'       => $cotizacion->id,
                    'categoria'           => 'servicio',
                    'descripcion'         => 'Mano de obra técnica especializada',
                    'cantidad'            => rand(1, 3),
                    'unidad'              => 'dia',
                    'precio_unitario'     => $oportunidad->monto_estimado
                        ? round($oportunidad->monto_estimado * 0.3 / rand(1, 3), 2)
                        : rand(250, 500),
                    'descuento_porcentaje' => 0,
                    'orden'               => $orden++,
                ]);

            } else {
                // ════════════════════════════════════════
                //  COTIZACIÓN DE PRODUCTO o MIXTO
                //  Lee productos desde la oportunidad
                // ════════════════════════════════════════
                $productosOportunidad = $oportunidad->productosInteres;

                if ($productosOportunidad->isEmpty()) {
                    $this->command->warn("  ⚠️ Oportunidad {$oportunidad->codigo} sin productos vinculados. Omitida.");
                    $cotizacion->delete();
                    continue;
                }

                $cantPaneles = 0;

                // Agregar cada producto de la oportunidad como ítem de cotización
                foreach ($productosOportunidad as $producto) {
                    $cantidad = $producto->pivot->cantidad;

                    DetalleCotizacionCrm::create([
                        'cotizacion_id'       => $cotizacion->id,
                        'categoria'           => 'producto',
                        'descripcion'         => $producto->name,
                        'especificaciones'    => $producto->descripcion,
                        'cantidad'            => $cantidad,
                        'unidad'              => 'und',
                        'precio_unitario'     => $producto->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id'         => $producto->id,
                        'orden'               => $orden++,
                    ]);

                    // Contar paneles para calcular costo de instalación
                    if (Str::startsWith($producto->codigo, 'PNL')) {
                        $cantPaneles += $cantidad;
                    }
                }

                // Servicio: Instalación (mano de obra proporcional a paneles)
                $costoInstalacion = max($cantPaneles, 1) * rand(150, 250);
                DetalleCotizacionCrm::create([
                    'cotizacion_id'       => $cotizacion->id,
                    'categoria'           => 'servicio',
                    'descripcion'         => 'Instalación del sistema fotovoltaico completo',
                    'cantidad'            => 1,
                    'unidad'              => 'glb',
                    'precio_unitario'     => $costoInstalacion,
                    'descuento_porcentaje' => 0,
                    'orden'               => $orden++,
                ]);

                // Servicio: Trámites ante distribuidora
                DetalleCotizacionCrm::create([
                    'cotizacion_id'       => $cotizacion->id,
                    'categoria'           => 'servicio',
                    'descripcion'         => 'Trámite ante distribuidora eléctrica',
                    'cantidad'            => 1,
                    'unidad'              => 'glb',
                    'precio_unitario'     => 800,
                    'descuento_porcentaje' => 0,
                    'orden'               => $orden++,
                ]);

                // Si es mixto, agregar mantenimiento anual
                if ($esMixto) {
                    DetalleCotizacionCrm::create([
                        'cotizacion_id'       => $cotizacion->id,
                        'categoria'           => 'servicio',
                        'descripcion'         => 'Plan de mantenimiento preventivo anual (2 limpiezas + revisión)',
                        'cantidad'            => 1,
                        'unidad'              => 'glb',
                        'precio_unitario'     => rand(600, 1200),
                        'descuento_porcentaje' => 0,
                        'orden'               => $orden++,
                    ]);
                }
            }

            // Recalcular totales desde los detalles
            $cotizacion->calcularTotales();

            $totalCreadas++;
            $itemCount = $cotizacion->detalles()->count();
            $this->command->info("  ✅ {$codigo} [{$estado}] → {$oportunidad->nombre} ({$itemCount} ítems, Total: S/ {$cotizacion->total})");
        }

        $this->command->info("✅ {$totalCreadas} cotizaciones creadas con ítems consistentes desde oportunidades.");
    }
}
