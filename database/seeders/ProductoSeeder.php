<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Tipo;
use App\Models\Category;
use App\Models\Marca;
use App\Models\Medida;
use App\Models\Sede;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $sede = Sede::first();
        $medidaUnd = Medida::first();

        if (!$sede || !$medidaUnd) {
            $this->command->warn('⚠️ Se requiere al menos 1 Sede y 1 Medida para crear productos.');
            return;
        }

        $productos = [
            // ===== PANELES SOLARES =====
            [
                'codigo' => 'PNL-001',
                'name' => 'Panel Solar 550W Monocristalino',
                'tipo' => 'Panel Solar',
                'categoria' => 'Monocristalino PERC',
                'marca' => 'JA Solar',
                'precio' => 650.00,
                'costo' => 480.00,
                'descripcion' => 'Panel solar monocristalino PERC 550W, alta eficiencia.',
            ],
            [
                'codigo' => 'PNL-002',
                'name' => 'Panel Solar 580W TOPCon',
                'tipo' => 'Panel Solar',
                'categoria' => 'Monocristalino TOPCon',
                'marca' => 'Jinko Solar',
                'precio' => 750.00,
                'costo' => 560.00,
                'descripcion' => 'Panel solar TOPCon N-Type 580W, tecnología de última generación.',
            ],
            [
                'codigo' => 'PNL-003',
                'name' => 'Panel Solar 545W Bifacial',
                'tipo' => 'Panel Solar',
                'categoria' => 'Bifacial',
                'marca' => 'Trina Solar',
                'precio' => 720.00,
                'costo' => 530.00,
                'descripcion' => 'Panel bifacial 545W, genera energía por ambas caras.',
            ],
            [
                'codigo' => 'PNL-004',
                'name' => 'Panel Solar 500W Monocristalino',
                'tipo' => 'Panel Solar',
                'categoria' => 'Monocristalino PERC',
                'marca' => 'LONGi',
                'precio' => 580.00,
                'costo' => 420.00,
                'descripcion' => 'Panel monocristalino PERC 500W, excelente relación calidad-precio.',
            ],

            // ===== INVERSORES =====
            [
                'codigo' => 'INV-001',
                'name' => 'Inversor On-Grid 5kW',
                'tipo' => 'Inversor',
                'categoria' => 'On-Grid (String)',
                'marca' => 'Growatt',
                'precio' => 3200.00,
                'costo' => 2400.00,
                'descripcion' => 'Inversor string on-grid 5kW, monofásico, WiFi incluido.',
            ],
            [
                'codigo' => 'INV-002',
                'name' => 'Inversor On-Grid 10kW',
                'tipo' => 'Inversor',
                'categoria' => 'On-Grid (String)',
                'marca' => 'Growatt',
                'precio' => 5800.00,
                'costo' => 4300.00,
                'descripcion' => 'Inversor string on-grid 10kW, trifásico, monitoreo remoto.',
            ],
            [
                'codigo' => 'INV-003',
                'name' => 'Inversor Híbrido 5kW',
                'tipo' => 'Inversor',
                'categoria' => 'Híbrido',
                'marca' => 'Deye',
                'precio' => 5500.00,
                'costo' => 4100.00,
                'descripcion' => 'Inversor híbrido 5kW, compatible con baterías de litio.',
            ],
            [
                'codigo' => 'INV-004',
                'name' => 'Inversor On-Grid 3kW',
                'tipo' => 'Inversor',
                'categoria' => 'On-Grid (String)',
                'marca' => 'Sungrow',
                'precio' => 2400.00,
                'costo' => 1800.00,
                'descripcion' => 'Inversor on-grid 3kW monofásico, ideal para uso residencial.',
            ],

            // ===== BATERÍAS =====
            [
                'codigo' => 'BAT-001',
                'name' => 'Batería Litio LFP 5.12kWh',
                'tipo' => 'Batería',
                'categoria' => 'Litio LFP',
                'marca' => 'Pylontech',
                'precio' => 6800.00,
                'costo' => 5200.00,
                'descripcion' => 'Batería de litio fosfato de hierro 5.12kWh, 6000 ciclos.',
            ],
            [
                'codigo' => 'BAT-002',
                'name' => 'Batería Litio LFP 10.24kWh',
                'tipo' => 'Batería',
                'categoria' => 'Litio LFP',
                'marca' => 'BYD',
                'precio' => 12500.00,
                'costo' => 9800.00,
                'descripcion' => 'Batería de litio BYD 10.24kWh, escalable hasta 4 módulos.',
            ],

            // ===== ESTRUCTURA =====
            [
                'codigo' => 'EST-001',
                'name' => 'Estructura Techo Inclinado (por panel)',
                'tipo' => 'Estructura',
                'categoria' => 'Techo Inclinado',
                'marca' => 'Genérico',
                'precio' => 120.00,
                'costo' => 75.00,
                'descripcion' => 'Estructura de aluminio para techo inclinado, incluye rieles y grapas.',
            ],
            [
                'codigo' => 'EST-002',
                'name' => 'Estructura Techo Plano (por panel)',
                'tipo' => 'Estructura',
                'categoria' => 'Techo Plano',
                'marca' => 'Genérico',
                'precio' => 180.00,
                'costo' => 110.00,
                'descripcion' => 'Estructura triangular para techo plano con inclinación de 15°.',
            ],

            // ===== CABLES Y CONECTORES =====
            [
                'codigo' => 'CBL-001',
                'name' => 'Cable Solar 6mm² (metro)',
                'tipo' => 'Cable y Conector',
                'categoria' => 'Cable Solar',
                'marca' => 'Genérico',
                'precio' => 8.50,
                'costo' => 5.00,
                'descripcion' => 'Cable solar fotovoltaico 6mm², resistente a UV, doble aislamiento.',
            ],
            [
                'codigo' => 'CBL-002',
                'name' => 'Par Conectores MC4',
                'tipo' => 'Cable y Conector',
                'categoria' => 'Conector MC4',
                'marca' => 'Genérico',
                'precio' => 12.00,
                'costo' => 6.50,
                'descripcion' => 'Par de conectores MC4 macho/hembra, IP67.',
            ],
            [
                'codigo' => 'CBL-003',
                'name' => 'Tablero de Protección DC',
                'tipo' => 'Cable y Conector',
                'categoria' => 'Protección Eléctrica',
                'marca' => 'Genérico',
                'precio' => 350.00,
                'costo' => 220.00,
                'descripcion' => 'Tablero de protección DC con fusibles y descargador de sobretensión.',
            ],
        ];

        foreach ($productos as $data) {
            $tipo = Tipo::where('name', $data['tipo'])->first();
            $categoria = Category::where('name', $data['categoria'])->first();
            $marca = Marca::where('name', $data['marca'])->first();

            if (!$tipo || !$categoria || !$marca) {
                $this->command->warn("⚠️ Saltando producto {$data['codigo']}: falta tipo, categoría o marca.");
                continue;
            }

            Producto::updateOrCreate(
                ['codigo' => $data['codigo']],
                [
                    'codigo' => $data['codigo'],
                    'slug' => Str::slug($data['name'] . '-' . $data['codigo']),
                    'name' => $data['name'],
                    'precio' => $data['precio'],
                    'costo' => $data['costo'],
                    'descripcion' => $data['descripcion'],
                    'estado' => 'Activo',
                    'tipo_id' => $tipo->id,
                    'categorie_id' => $categoria->id,
                    'marca_id' => $marca->id,
                    'medida_id' => $medidaUnd->id,
                    'sede_id' => $sede->id,
                ]
            );
        }

        $this->command->info('✅ ' . count($productos) . ' productos creados.');
    }
}
