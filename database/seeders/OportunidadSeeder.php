<?php

namespace Database\Seeders;

use App\Models\Oportunidad;
use App\Models\Prospecto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OportunidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendedor = User::first();
        $prospectos = Prospecto::whereIn('estado', ['calificado', 'contactado'])->get();

        $oportunidades = [
            // Oportunidades en diferentes etapas
            [
                'nombre' => 'Sistema Solar Residencial 5kW - La Molina',
                'etapa' => 'negociacion',
                'monto_estimado' => 22500,
                'probabilidad' => 75,
                'tipo_proyecto' => 'residencial',
                'potencia_kw' => 5.0,
                'cantidad_paneles' => 10,
                'tipo_panel' => 'monocristalino',
                'marca_panel' => 'JA Solar',
                'tipo_inversor' => 'string',
                'marca_inversor' => 'Growatt',
                'incluye_baterias' => false,
                'produccion_mensual_kwh' => 650,
                'produccion_anual_kwh' => 7800,
                'ahorro_mensual_soles' => 325,
                'ahorro_anual_soles' => 3900,
                'retorno_inversion_anos' => 5.8,
                'fecha_cierre_estimada' => now()->addDays(15),
            ],
            [
                'nombre' => 'Sistema Comercial 25kW - Restaurante San Isidro',
                'etapa' => 'propuesta_tecnica',
                'monto_estimado' => 82000,
                'probabilidad' => 50,
                'tipo_proyecto' => 'comercial',
                'potencia_kw' => 25.0,
                'cantidad_paneles' => 50,
                'tipo_panel' => 'monocristalino_bifacial',
                'marca_panel' => 'LONGi',
                'tipo_inversor' => 'string',
                'marca_inversor' => 'Huawei',
                'incluye_baterias' => false,
                'produccion_mensual_kwh' => 3250,
                'produccion_anual_kwh' => 39000,
                'ahorro_mensual_soles' => 1625,
                'ahorro_anual_soles' => 19500,
                'retorno_inversion_anos' => 4.2,
                'fecha_cierre_estimada' => now()->addDays(30),
            ],
            [
                'nombre' => 'Sistema Industrial 100kW - Textiles del Norte',
                'etapa' => 'contrato',
                'monto_estimado' => 320000,
                'probabilidad' => 90,
                'tipo_proyecto' => 'industrial',
                'potencia_kw' => 100.0,
                'cantidad_paneles' => 200,
                'tipo_panel' => 'monocristalino_bifacial',
                'marca_panel' => 'Trina Solar',
                'tipo_inversor' => 'central',
                'marca_inversor' => 'Sungrow',
                'incluye_baterias' => false,
                'produccion_mensual_kwh' => 13000,
                'produccion_anual_kwh' => 156000,
                'ahorro_mensual_soles' => 8200,
                'ahorro_anual_soles' => 98400,
                'retorno_inversion_anos' => 3.3,
                'fecha_cierre_estimada' => now()->addDays(7),
                'notas_tecnicas' => 'Techo metálico en buenas condiciones. Requiere refuerzo estructural en sección norte.',
            ],
            [
                'nombre' => 'Sistema Híbrido 8kW con Baterías - Surco',
                'etapa' => 'analisis_sitio',
                'monto_estimado' => 45000,
                'probabilidad' => 25,
                'tipo_proyecto' => 'residencial',
                'potencia_kw' => 8.0,
                'cantidad_paneles' => 16,
                'tipo_panel' => 'monocristalino',
                'marca_panel' => 'Canadian Solar',
                'tipo_inversor' => 'hibrido',
                'marca_inversor' => 'Deye',
                'incluye_baterias' => true,
                'capacidad_baterias_kwh' => 15.0,
                'produccion_mensual_kwh' => 1040,
                'produccion_anual_kwh' => 12480,
                'ahorro_mensual_soles' => 520,
                'ahorro_anual_soles' => 6240,
                'retorno_inversion_anos' => 7.2,
                'fecha_cierre_estimada' => now()->addDays(45),
                'notas_tecnicas' => 'Cliente desea autonomía de 8 horas. Verificar orientación del techo.',
            ],
            [
                'nombre' => 'Bombeo Solar 15HP - Fundo Cañete',
                'etapa' => 'calificacion',
                'monto_estimado' => 65000,
                'probabilidad' => 10,
                'tipo_proyecto' => 'bombeo_solar',
                'potencia_kw' => 15.0,
                'cantidad_paneles' => 30,
                'tipo_panel' => 'monocristalino',
                'marca_panel' => 'Risen',
                'tipo_inversor' => 'variador',
                'marca_inversor' => 'ABB',
                'incluye_baterias' => false,
                'produccion_mensual_kwh' => 1950,
                'ahorro_mensual_soles' => 1200,
                'ahorro_anual_soles' => 14400,
                'retorno_inversion_anos' => 4.5,
                'fecha_cierre_estimada' => now()->addDays(60),
                'notas_tecnicas' => 'Pozo profundo 80m. Requiere bomba sumergible 15HP. Caudal requerido: 20 l/s.',
            ],
            [
                'nombre' => 'Sistema Clínica Dental 10kW - Magdalena',
                'etapa' => 'propuesta_tecnica',
                'monto_estimado' => 42000,
                'probabilidad' => 50,
                'tipo_proyecto' => 'comercial',
                'potencia_kw' => 10.0,
                'cantidad_paneles' => 20,
                'tipo_panel' => 'monocristalino',
                'marca_panel' => 'JA Solar',
                'tipo_inversor' => 'string',
                'marca_inversor' => 'Fronius',
                'incluye_baterias' => false,
                'produccion_mensual_kwh' => 1300,
                'produccion_anual_kwh' => 15600,
                'ahorro_mensual_soles' => 780,
                'ahorro_anual_soles' => 9360,
                'retorno_inversion_anos' => 4.5,
                'fecha_cierre_estimada' => now()->addDays(25),
            ],
            // Oportunidades ganadas
            [
                'nombre' => 'Sistema Residencial 3kW - San Borja',
                'etapa' => 'ganada',
                'monto_estimado' => 15000,
                'monto_final' => 14500,
                'probabilidad' => 100,
                'tipo_proyecto' => 'residencial',
                'potencia_kw' => 3.0,
                'cantidad_paneles' => 6,
                'tipo_panel' => 'monocristalino',
                'marca_panel' => 'JA Solar',
                'tipo_inversor' => 'microinversor',
                'marca_inversor' => 'Hoymiles',
                'incluye_baterias' => false,
                'produccion_mensual_kwh' => 390,
                'produccion_anual_kwh' => 4680,
                'ahorro_mensual_soles' => 195,
                'ahorro_anual_soles' => 2340,
                'retorno_inversion_anos' => 6.2,
                'fecha_cierre_estimada' => now()->subDays(30),
                'fecha_cierre_real' => now()->subDays(25),
            ],
            // Oportunidades perdidas
            [
                'nombre' => 'Sistema Comercial 15kW - Miraflores',
                'etapa' => 'perdida',
                'monto_estimado' => 55000,
                'probabilidad' => 0,
                'tipo_proyecto' => 'comercial',
                'potencia_kw' => 15.0,
                'cantidad_paneles' => 30,
                'motivo_perdida' => 'precio',
                'detalle_perdida' => 'El cliente consiguió una oferta 20% más barata con otro proveedor',
                'competidor_ganador' => 'EnelX',
                'fecha_cierre_estimada' => now()->subDays(15),
                'fecha_cierre_real' => now()->subDays(10),
            ],
        ];

        foreach ($oportunidades as $index => $data) {
            $prospecto = $prospectos->random();
            $codigo = 'OPO-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            
            // Calcular valor ponderado
            $valorPonderado = ($data['monto_estimado'] * $data['probabilidad']) / 100;
            
            Oportunidad::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo' => $codigo,
                    'slug' => Str::slug($data['nombre'] . '-' . $codigo),
                    'prospecto_id' => $prospecto->id,
                    'user_id' => $vendedor?->id,
                    'valor_ponderado' => $valorPonderado,
                    'fecha_creacion' => now()->subDays(rand(5, 45)),
                ])
            );
        }
    }
}
