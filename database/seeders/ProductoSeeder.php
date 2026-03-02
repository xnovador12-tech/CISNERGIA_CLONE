<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Tipo;
use App\Models\Category;
use App\Models\Marca;
use App\Models\Medida;
use App\Models\Modelo;
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
            return;
        }

        // IMPORTANTE: 'tipo' y 'categoria' deben coincidir EXACTAMENTE
        // con los nombres en TipoTableSeeder y CategoryTableSeeder
        $productos = [
            // ===== PANELES SOLARES =====
            [
                'codigo' => 'PNL-001',
                'name' => 'Panel Solar 550W Monocristalino',
                'tipo' => 'Paneles Solares',
                'categoria' => 'Paneles Solares Voltaje Medio (1000V - 1500V)',
                'marca' => 'JA Solar',
                'modelo' => 'JAM72S30-550/MR',
                'precio' => 650.00,
                'costo' => 480.00,
                'descripcion' => 'Panel solar monocristalino PERC 550W, alta eficiencia.',
            ],
            [
                'codigo' => 'PNL-002',
                'name' => 'Panel Solar 580W TOPCon',
                'tipo' => 'Paneles Solares',
                'categoria' => 'Paneles Solares Voltaje Medio (1000V - 1500V)',
                'marca' => 'Jinko Solar',
                'modelo' => 'Tiger Neo N-Type 580',
                'precio' => 750.00,
                'costo' => 560.00,
                'descripcion' => 'Panel solar TOPCon N-Type 580W, tecnología de última generación.',
            ],
            [
                'codigo' => 'PNL-003',
                'name' => 'Panel Solar 545W Bifacial',
                'tipo' => 'Paneles Solares',
                'categoria' => 'Paneles Solares Voltaje Medio (1000V - 1500V)',
                'marca' => 'Trina Solar',
                'modelo' => 'Vertex S+ DEG21C.20',
                'precio' => 720.00,
                'costo' => 530.00,
                'descripcion' => 'Panel bifacial 545W, genera energía por ambas caras.',
            ],
            [
                'codigo' => 'PNL-004',
                'name' => 'Panel Solar 500W Monocristalino',
                'tipo' => 'Paneles Solares',
                'categoria' => 'Paneles Solares Voltaje Medio (60V - 600V)',
                'marca' => 'LONGi',
                'modelo' => 'Hi-MO 5m LR5-72HPH-500M',
                'precio' => 580.00,
                'costo' => 420.00,
                'descripcion' => 'Panel monocristalino PERC 500W, excelente relación calidad-precio.',
            ],

            // ===== INVERSORES =====
            [
                'codigo' => 'INV-001',
                'name' => 'Inversor On-Grid 5kW',
                'tipo' => 'Inversores Solares',
                'categoria' => 'Inversores Interconexion',
                'marca' => 'Growatt',
                'modelo' => 'MIN 5000TL-X',
                'precio' => 3200.00,
                'costo' => 2400.00,
                'descripcion' => 'Inversor string on-grid 5kW, monofásico, WiFi incluido.',
            ],
            [
                'codigo' => 'INV-002',
                'name' => 'Inversor On-Grid 10kW',
                'tipo' => 'Inversores Solares',
                'categoria' => 'Inversores Interconexion',
                'marca' => 'Growatt',
                'modelo' => 'MIN 10000TL-X',
                'precio' => 5800.00,
                'costo' => 4300.00,
                'descripcion' => 'Inversor string on-grid 10kW, trifásico, monitoreo remoto.',
            ],
            [
                'codigo' => 'INV-003',
                'name' => 'Inversor Híbrido 5kW',
                'tipo' => 'Inversores Solares',
                'categoria' => 'Inversores Hibridos',
                'marca' => 'Deye',
                'modelo' => 'SUN-5K-SG03LP1-EU',
                'precio' => 5500.00,
                'costo' => 4100.00,
                'descripcion' => 'Inversor híbrido 5kW, compatible con baterías de litio.',
            ],
            [
                'codigo' => 'INV-004',
                'name' => 'Inversor On-Grid 3kW',
                'tipo' => 'Inversores Solares',
                'categoria' => 'Inversores Interconexion',
                'marca' => 'Sungrow',
                'modelo' => 'SG3.0RS-L',
                'precio' => 2400.00,
                'costo' => 1800.00,
                'descripcion' => 'Inversor on-grid 3kW monofásico, ideal para uso residencial.',
            ],

            // ===== BATERÍAS =====
            [
                'codigo' => 'BAT-001',
                'name' => 'Batería Litio LFP 5.12kWh',
                'tipo' => 'Baterías',
                'categoria' => 'Baterías de Litio',
                'marca' => 'Pylontech',
                'modelo' => 'US5000',
                'precio' => 6800.00,
                'costo' => 5200.00,
                'descripcion' => 'Batería de litio fosfato de hierro 5.12kWh, 6000 ciclos.',
            ],
            [
                'codigo' => 'BAT-002',
                'name' => 'Batería Litio LFP 10.24kWh',
                'tipo' => 'Baterías',
                'categoria' => 'Baterías de Litio',
                'marca' => 'BYD',
                'modelo' => 'Battery-Box Premium HVS 10.2',
                'precio' => 12500.00,
                'costo' => 9800.00,
                'descripcion' => 'Batería de litio BYD 10.24kWh, escalable hasta 4 módulos.',
            ],

            // ===== SOPORTES =====
            [
                'codigo' => 'EST-001',
                'name' => 'Estructura Techo Inclinado (por panel)',
                'tipo' => 'Soportes Paneles Solares',
                'categoria' => 'Soportes Cubierta Metálica',
                'marca' => 'Genérico',
                'modelo' => 'Rail AL-6005 T5',
                'precio' => 120.00,
                'costo' => 75.00,
                'descripcion' => 'Estructura de aluminio para techo inclinado, incluye rieles y grapas.',
            ],
            [
                'codigo' => 'EST-002',
                'name' => 'Estructura Techo Plano (por panel)',
                'tipo' => 'Soportes Paneles Solares',
                'categoria' => 'Soportes Suelo',
                'marca' => 'Genérico',
                'modelo' => 'Triangle Mount 15°',
                'precio' => 180.00,
                'costo' => 110.00,
                'descripcion' => 'Estructura triangular para techo plano con inclinación de 15°.',
            ],

            // ===== CABLES Y ACCESORIOS =====
            [
                'codigo' => 'CBL-001',
                'name' => 'Cable Solar 6mm² (metro)',
                'tipo' => 'Cables',
                'categoria' => 'Cable Unipolar',
                'marca' => 'Genérico',
                'modelo' => 'PV1-F 6mm²',
                'precio' => 8.50,
                'costo' => 5.00,
                'descripcion' => 'Cable solar fotovoltaico 6mm², resistente a UV, doble aislamiento.',
            ],
            [
                'codigo' => 'CBL-002',
                'name' => 'Par Conectores MC4',
                'tipo' => 'Accesorios Eléctricos',
                'categoria' => 'Material Eléctrico',
                'marca' => 'Genérico',
                'modelo' => 'MC4-IP67',
                'precio' => 12.00,
                'costo' => 6.50,
                'descripcion' => 'Par de conectores MC4 macho/hembra, IP67.',
            ],
            [
                'codigo' => 'CBL-003',
                'name' => 'Tablero de Protección DC',
                'tipo' => 'Protecciones Eléctricas',
                'categoria' => 'Protector de Sobretensiones',
                'marca' => 'Genérico',
                'modelo' => 'DC Combiner Box 2-in',
                'precio' => 350.00,
                'costo' => 220.00,
                'descripcion' => 'Tablero de protección DC con fusibles y descargador de sobretensión.',
            ],
        ];

        foreach ($productos as $data) {
            $tipo = Tipo::where('name', $data['tipo'])->first();
            $categoria = Category::where('name', $data['categoria'])->first();
            $marca = Marca::where('name', $data['marca'])->first();
            $modelo = Modelo::where('nombre', $data['modelo'])->first();

            if (!$tipo || !$categoria || !$marca || !$modelo) {
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
                    'modelo_id' => $modelo->id,
                    'medida_id' => $medidaUnd->id,
                    'sede_id' => $sede->id,
                ]
            );
        }

    }
}
