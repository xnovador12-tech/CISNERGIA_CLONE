<?php

namespace Database\Seeders;

use App\Models\CotizacionCrm;
use App\Models\Oportunidad;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CotizacionCrmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendedor = User::first();
        $oportunidades = Oportunidad::whereNotIn('etapa', ['calificacion', 'perdida'])->get();

        foreach ($oportunidades as $index => $oportunidad) {
            $codigo = 'COT-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            
            // Precios base según potencia
            $precioPorKw = $oportunidad->tipo_proyecto === 'on_grid' ? 3500 : 4500;
            $precioEquipos = $oportunidad->potencia_kw * $precioPorKw * 0.6;
            $precioInstalacion = $oportunidad->potencia_kw * $precioPorKw * 0.25;
            $precioTramites = 800;
            $precioEstructura = $oportunidad->potencia_kw * 150;
            
            $subtotal = $precioEquipos + $precioInstalacion + $precioTramites + $precioEstructura;
            
            // Descuento según monto
            $descuentoPorcentaje = $subtotal > 100000 ? 8 : ($subtotal > 50000 ? 5 : 3);
            $descuentoMonto = ($subtotal * $descuentoPorcentaje) / 100;
            $subtotalConDescuento = $subtotal - $descuentoMonto;
            $igv = $subtotalConDescuento * 0.18;
            $total = $subtotalConDescuento + $igv;

            // Estado según etapa de oportunidad
            $estado = match($oportunidad->etapa) {
                'analisis_sitio' => 'borrador',
                'propuesta_tecnica' => 'enviada',
                'negociacion' => 'vista',
                'contrato' => 'aceptada',
                'ganada' => 'aceptada',
                default => 'borrador',
            };

            CotizacionCrm::updateOrCreate(
                ['codigo' => $codigo],
                [
                    'codigo' => $codigo,
                    'slug' => Str::slug($codigo . '-' . Str::random(5)),
                    'version' => 1,
                    'oportunidad_id' => $oportunidad->id,
                    'prospecto_id' => $oportunidad->prospecto_id,
                    'nombre_proyecto' => $oportunidad->nombre,
                    'potencia_kw' => $oportunidad->potencia_kw,
                    'cantidad_paneles' => $oportunidad->cantidad_paneles,
                    'modelo_panel' => 'JAM72S30-550/MR',
                    'marca_panel' => $oportunidad->marca_panel ?? 'JA Solar',
                    'potencia_panel_w' => 550,
                    'modelo_inversor' => $oportunidad->potencia_kw > 10 ? 'SUN-' . (int)$oportunidad->potencia_kw . 'K-SG04LP3' : 'MIN ' . (int)$oportunidad->potencia_kw . '000TL-X',
                    'marca_inversor' => $oportunidad->marca_inversor ?? 'Growatt',
                    'potencia_inversor_kw' => $oportunidad->potencia_kw,
                    'incluye_baterias' => $oportunidad->incluye_baterias,
                    'capacidad_baterias_kwh' => $oportunidad->capacidad_baterias_kwh,
                    'produccion_diaria_kwh' => $oportunidad->produccion_mensual_kwh / 30,
                    'produccion_mensual_kwh' => $oportunidad->produccion_mensual_kwh,
                    'produccion_anual_kwh' => $oportunidad->produccion_anual_kwh ?? $oportunidad->produccion_mensual_kwh * 12,
                    'ahorro_mensual_soles' => $oportunidad->ahorro_mensual_soles,
                    'ahorro_anual_soles' => $oportunidad->ahorro_anual_soles,
                    'ahorro_25_anos_soles' => $oportunidad->ahorro_anual_soles * 25,
                    'retorno_inversion_anos' => $oportunidad->retorno_inversion_anos,
                    'reduccion_co2_toneladas' => ($oportunidad->produccion_anual_kwh ?? $oportunidad->produccion_mensual_kwh * 12) * 0.0005,
                    'precio_equipos' => $precioEquipos,
                    'precio_instalacion' => $precioInstalacion,
                    'precio_tramites' => $precioTramites,
                    'precio_estructura' => $precioEstructura,
                    'precio_otros' => 0,
                    'subtotal' => $subtotal,
                    'descuento_porcentaje' => $descuentoPorcentaje,
                    'descuento_monto' => $descuentoMonto,
                    'igv' => $igv,
                    'total' => $total,
                    'garantia_paneles_anos' => 25,
                    'garantia_inversor_anos' => 10,
                    'garantia_instalacion_anos' => 5,
                    'garantia_baterias_anos' => $oportunidad->incluye_baterias ? 10 : null,
                    'tiempo_instalacion_dias' => $oportunidad->potencia_kw > 50 ? 15 : ($oportunidad->potencia_kw > 10 ? 7 : 3),
                    'fecha_emision' => now()->subDays(rand(1, 20)),
                    'fecha_vigencia' => now()->addDays(rand(5, 15)),
                    'estado' => $estado,
                    'fecha_envio' => in_array($estado, ['enviada', 'vista', 'aceptada']) ? now()->subDays(rand(1, 10)) : null,
                    'fecha_vista' => in_array($estado, ['vista', 'aceptada']) ? now()->subDays(rand(1, 5)) : null,
                    'user_id' => $vendedor?->id,
                    'condiciones_comerciales' => "- Precios incluyen IGV\n- Forma de pago: 50% adelanto, 50% contra entrega\n- Garantía de instalación: 5 años\n- Mantenimiento preventivo gratuito primer año",
                ]
            );
        }
    }
}
