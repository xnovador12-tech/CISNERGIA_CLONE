<?php

namespace Database\Seeders;

use App\Models\CotizacionCrm;
use App\Models\DetalleCotizacionCrm;
use App\Models\Oportunidad;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CotizacionCrmSeeder extends Seeder
{
    public function run(): void
    {
        $vendedor = User::first();

        // Solo oportunidades que no estén en calificación ni perdidas
        $oportunidades = Oportunidad::whereNotIn('etapa', ['calificacion', 'perdida'])
            ->with('prospecto')
            ->get();

        if ($oportunidades->isEmpty()) {
            $this->command->warn('⚠️ No hay oportunidades activas para generar cotizaciones.');
            return;
        }

        // Cargar productos por tipo
        $paneles = Producto::where('codigo', 'like', 'PNL%')->get();
        $inversores = Producto::where('codigo', 'like', 'INV%')->get();
        $estructuras = Producto::where('codigo', 'like', 'EST%')->get();
        $cables = Producto::where('codigo', 'like', 'CBL%')->get();
        $baterias = Producto::where('codigo', 'like', 'BAT%')->get();

        $totalCreadas = 0;

        foreach ($oportunidades as $index => $oportunidad) {
            $esServicio = $oportunidad->tipo_oportunidad === 'servicio';
            $esMixto = $oportunidad->tipo_oportunidad === 'mixto';

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
                'codigo' => $codigo,
                'slug' => Str::slug($codigo . '-' . Str::random(5)),
                'version' => 1,
                'oportunidad_id' => $oportunidad->id,
                'prospecto_id' => $oportunidad->prospecto_id,
                'nombre_proyecto' => $oportunidad->nombre,
                'incluye_igv' => true,
                'fecha_emision' => now()->subDays(rand(1, 20)),
                'fecha_vigencia' => now()->addDays(rand(5, 25)),
                'estado' => $estado,
                'fecha_envio' => in_array($estado, ['enviada', 'aceptada']) ? now()->subDays(rand(1, 10)) : null,
                'user_id' => $vendedor?->id,
                'tiempo_ejecucion_dias' => $esServicio ? 2 : rand(3, 7),
                'garantia_servicio' => $esServicio ? '90 días en servicio realizado' : '2 años en mano de obra, 25 años en paneles',
                'condiciones_comerciales' => "- Precios incluyen IGV\n- Forma de pago: 50% adelanto, 50% contra entrega\n- Validez de la cotización: 30 días",
                'descuento_porcentaje' => rand(0, 8),
            ]);

            // Eliminar ítems previos (si se re-ejecuta)
            $cotizacion->detalles()->delete();

            $orden = 1;

            if ($esServicio) {
                // ========================================
                // COTIZACIÓN DE SERVICIO
                // ========================================
                $tipoServicio = $oportunidad->tipo_servicio ?? 'mantenimiento_preventivo';

                DetalleCotizacionCrm::create([
                    'cotizacion_id' => $cotizacion->id,
                    'categoria' => 'servicio',
                    'descripcion' => match ($tipoServicio) {
                        'instalacion' => 'Servicio de Instalación de Sistema Solar',
                        'mantenimiento_correctivo' => 'Mantenimiento Correctivo - Diagnóstico y Reparación',
                        default => 'Mantenimiento Preventivo - Limpieza y Revisión',
                    },
                    'cantidad' => 1,
                    'unidad' => 'glb',
                    'precio_unitario' => rand(800, 3500),
                    'descuento_porcentaje' => 0,
                    'orden' => $orden++,
                ]);

                DetalleCotizacionCrm::create([
                    'cotizacion_id' => $cotizacion->id,
                    'categoria' => 'servicio',
                    'descripcion' => 'Mano de obra técnica especializada',
                    'cantidad' => rand(1, 3),
                    'unidad' => 'dia',
                    'precio_unitario' => rand(250, 500),
                    'descuento_porcentaje' => 0,
                    'orden' => $orden++,
                ]);

                // A veces incluir materiales de reemplazo
                if (rand(0, 1)) {
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'servicio',
                        'descripcion' => 'Materiales de reemplazo y consumibles',
                        'cantidad' => 1,
                        'unidad' => 'glb',
                        'precio_unitario' => rand(150, 800),
                        'descuento_porcentaje' => 0,
                        'orden' => $orden++,
                    ]);
                }

            } else {
                // ========================================
                // COTIZACIÓN DE PRODUCTO (o MIXTO)
                // ========================================
                $cantPaneles = rand(6, 20);

                // 1. Panel solar
                if ($paneles->isNotEmpty()) {
                    $panel = $paneles->random();
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'producto',
                        'descripcion' => $panel->name,
                        'especificaciones' => $panel->descripcion,
                        'cantidad' => $cantPaneles,
                        'unidad' => 'und',
                        'precio_unitario' => $panel->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id' => $panel->id,
                        'orden' => $orden++,
                    ]);
                }

                // 2. Inversor
                if ($inversores->isNotEmpty()) {
                    $inversor = $inversores->random();
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'producto',
                        'descripcion' => $inversor->name,
                        'especificaciones' => $inversor->descripcion,
                        'cantidad' => 1,
                        'unidad' => 'und',
                        'precio_unitario' => $inversor->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id' => $inversor->id,
                        'orden' => $orden++,
                    ]);
                }

                // 3. Estructura
                if ($estructuras->isNotEmpty()) {
                    $estructura = $estructuras->random();
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'producto',
                        'descripcion' => $estructura->name,
                        'cantidad' => $cantPaneles,
                        'unidad' => 'und',
                        'precio_unitario' => $estructura->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id' => $estructura->id,
                        'orden' => $orden++,
                    ]);
                }

                // 4. Cable solar
                $cable = $cables->firstWhere('codigo', 'CBL-001');
                if ($cable) {
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'producto',
                        'descripcion' => $cable->name,
                        'cantidad' => rand(20, 50),
                        'unidad' => 'm',
                        'precio_unitario' => $cable->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id' => $cable->id,
                        'orden' => $orden++,
                    ]);
                }

                // 5. Tablero de protección
                $tablero = $cables->firstWhere('codigo', 'CBL-003');
                if ($tablero) {
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'producto',
                        'descripcion' => $tablero->name,
                        'cantidad' => 1,
                        'unidad' => 'und',
                        'precio_unitario' => $tablero->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id' => $tablero->id,
                        'orden' => $orden++,
                    ]);
                }

                // 6. Batería (si aplica)
                if (($oportunidad->incluye_baterias ?? false) && $baterias->isNotEmpty()) {
                    $bateria = $baterias->random();
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'producto',
                        'descripcion' => $bateria->name,
                        'especificaciones' => $bateria->descripcion,
                        'cantidad' => rand(1, 2),
                        'unidad' => 'und',
                        'precio_unitario' => $bateria->precio,
                        'descuento_porcentaje' => 0,
                        'producto_id' => $bateria->id,
                        'orden' => $orden++,
                    ]);
                }

                // 7. Mano de obra
                DetalleCotizacionCrm::create([
                    'cotizacion_id' => $cotizacion->id,
                    'categoria' => 'servicio',
                    'descripcion' => 'Instalación del sistema fotovoltaico completo',
                    'cantidad' => 1,
                    'unidad' => 'glb',
                    'precio_unitario' => $cantPaneles * rand(150, 250),
                    'descuento_porcentaje' => 0,
                    'orden' => $orden++,
                ]);

                // 8. Servicio: trámites
                DetalleCotizacionCrm::create([
                    'cotizacion_id' => $cotizacion->id,
                    'categoria' => 'servicio',
                    'descripcion' => 'Trámite ante distribuidora eléctrica',
                    'cantidad' => 1,
                    'unidad' => 'glb',
                    'precio_unitario' => 800,
                    'descuento_porcentaje' => 0,
                    'orden' => $orden++,
                ]);

                // 9. Si es mixto, agregar mantenimiento anual
                if ($esMixto) {
                    DetalleCotizacionCrm::create([
                        'cotizacion_id' => $cotizacion->id,
                        'categoria' => 'servicio',
                        'descripcion' => 'Plan de mantenimiento preventivo anual (2 limpiezas + revisión)',
                        'cantidad' => 1,
                        'unidad' => 'glb',
                        'precio_unitario' => rand(600, 1200),
                        'descuento_porcentaje' => 0,
                        'orden' => $orden++,
                    ]);
                }
            }

            // Recalcular totales desde los detalles
            $cotizacion->calcularTotales();

            $totalCreadas++;
            $itemCount = $cotizacion->detalles()->count();
            $this->command->info("  ✅ {$codigo} → {$oportunidad->nombre} ({$itemCount} ítems, Total: S/ {$cotizacion->total})");
        }

        $this->command->info("✅ {$totalCreadas} cotizaciones creadas con ítems y totales calculados.");
    }
}
