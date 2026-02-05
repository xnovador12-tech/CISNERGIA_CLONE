<?php

namespace Database\Seeders;

use App\Models\Garantia;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GarantiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::all();
        
        if ($clientes->isEmpty()) {
            return;
        }

        $garantias = [
            // Garantías de paneles solares
            [
                'tipo' => 'paneles',
                'marca' => 'JA Solar',
                'modelo' => 'JAM72S30-550/MR',
                'cantidad' => 10,
                'anos_garantia' => 25,
                'cubre_mano_obra' => false,
                'cubre_repuestos' => true,
                'cubre_transporte' => false,
                'condiciones' => 'Garantía de rendimiento: 90% en año 1, degradación máxima 0.5% anual hasta año 25.',
                'exclusiones' => 'Daños por granizo, vandalismo, instalación inadecuada o manipulación no autorizada.',
            ],
            [
                'tipo' => 'paneles',
                'marca' => 'LONGi',
                'modelo' => 'Hi-MO 5m LR5-72HBD-545M',
                'cantidad' => 50,
                'anos_garantia' => 25,
                'cubre_mano_obra' => false,
                'cubre_repuestos' => true,
                'cubre_transporte' => false,
                'condiciones' => 'Garantía de producto 12 años. Garantía de rendimiento 25 años (84.8% al año 25).',
                'exclusiones' => 'No cubre daños por eventos naturales extremos.',
            ],
            [
                'tipo' => 'paneles',
                'marca' => 'Trina Solar',
                'modelo' => 'TSM-DE19-550M',
                'cantidad' => 200,
                'anos_garantia' => 25,
                'cubre_mano_obra' => false,
                'cubre_repuestos' => true,
                'cubre_transporte' => true,
                'condiciones' => 'Garantía de producto 15 años. Rendimiento lineal garantizado.',
            ],
            
            // Garantías de inversores
            [
                'tipo' => 'inversor',
                'marca' => 'Growatt',
                'modelo' => 'MIN 5000TL-X',
                'cantidad' => 1,
                'anos_garantia' => 10,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => true,
                'cubre_transporte' => false,
                'condiciones' => 'Garantía extendida 10 años con registro en plataforma Growatt.',
                'exclusiones' => 'Daños por sobretensión de red eléctrica.',
            ],
            [
                'tipo' => 'inversor',
                'marca' => 'Huawei',
                'modelo' => 'SUN2000-25KTL-M3',
                'cantidad' => 1,
                'anos_garantia' => 10,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => true,
                'cubre_transporte' => true,
                'condiciones' => 'Garantía estándar 5 años + 5 años con FusionSolar registration.',
            ],
            [
                'tipo' => 'inversor',
                'marca' => 'Sungrow',
                'modelo' => 'SG110CX',
                'cantidad' => 1,
                'anos_garantia' => 10,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => true,
                'cubre_transporte' => true,
                'condiciones' => 'Garantía premium con soporte técnico 24/7.',
            ],
            
            // Garantías de baterías
            [
                'tipo' => 'baterias',
                'marca' => 'Pylontech',
                'modelo' => 'US5000',
                'cantidad' => 3,
                'anos_garantia' => 10,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => true,
                'cubre_transporte' => false,
                'condiciones' => 'Garantía de 10 años o 6000 ciclos de carga/descarga.',
                'exclusiones' => 'Uso en aplicaciones no residenciales sin autorización previa.',
            ],
            
            // Garantías de instalación
            [
                'tipo' => 'instalacion',
                'marca' => 'CISNERGIA',
                'modelo' => 'Instalación Sistema On-Grid 5kW',
                'cantidad' => 1,
                'anos_garantia' => 5,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => false,
                'cubre_transporte' => true,
                'condiciones' => 'Cubre defectos de instalación, cableado, conexiones y estructura de montaje.',
            ],
            [
                'tipo' => 'instalacion',
                'marca' => 'CISNERGIA',
                'modelo' => 'Instalación Sistema Híbrido 8kW',
                'cantidad' => 1,
                'anos_garantia' => 5,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => false,
                'cubre_transporte' => true,
                'condiciones' => 'Incluye configuración de sistema de baterías y monitoreo.',
            ],
            [
                'tipo' => 'instalacion',
                'marca' => 'CISNERGIA',
                'modelo' => 'Instalación Industrial 100kW',
                'cantidad' => 1,
                'anos_garantia' => 5,
                'cubre_mano_obra' => true,
                'cubre_repuestos' => false,
                'cubre_transporte' => true,
                'condiciones' => 'Incluye estructura metálica, canalización y tableros eléctricos.',
            ],
        ];

        foreach ($garantias as $index => $data) {
            $cliente = $clientes->random();
            $codigo = 'GAR-' . date('Y') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $fechaInicio = now()->subMonths(rand(1, 18));
            $fechaFin = $fechaInicio->copy()->addYears($data['anos_garantia']);
            
            // Generar número de serie realista
            $prefijo = match($data['tipo']) {
                'panel_solar' => 'PN',
                'inversor' => 'INV',
                'bateria' => 'BAT',
                'instalacion' => 'INST',
                default => 'EQ',
            };
            $numeroSerie = $prefijo . date('Ymd', strtotime($fechaInicio)) . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            Garantia::updateOrCreate(
                ['codigo' => $codigo],
                array_merge($data, [
                    'codigo' => $codigo,
                    'slug' => Str::slug($codigo . '-' . Str::random(5)),
                    'cliente_id' => $cliente->id,
                    'numero_serie' => $numeroSerie,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'estado' => $fechaFin > now() ? 'vigente' : 'vencida',
                    'veces_utilizada' => rand(0, 2),
                ])
            );
        }
    }
}
