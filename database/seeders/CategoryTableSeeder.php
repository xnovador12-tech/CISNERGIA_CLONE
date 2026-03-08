<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Kit Solares' => ['Kit Solares de Aislada', 'Kit Solares Conectados a Red', 'Kit Solares Hibridos', 'Kit Bombeo Agua Solar'],
            'Paneles Solares' => ['Paneles Solares 12V', 'Paneles Solares 24V', 'Paneles Solares 48V', 'Paneles Solares Voltaje Medio (60V - 600V)', 'Paneles Solares Voltaje Medio (1000V - 1500V)', 'Paneles Solares Portátiles','Paneles Solares Flexibles','Accesorios de Paneles Solares'],
            'Soportes Paneles Solares' => ['Soportes Cubierta Metálica', 'Soportes Pared o Fachada', 'Soportes Suelo', 'Soporte Elevado', 'Accesorios para Soporte'],
            'Baterías' => ['Baterías Plomo Acido Abierto', 'Baterías AGM', 'Baterías de GEL', 'Baterias Estacionarias','Baterías de Litio','Accesorios de Baterías'],
            'Inversores Solares' => ['Inversores 12V', 'Inversores 24V', 'Inversores 48V', 'Inversores Cargadores','Inversores Hibridos','Inversores Interconexion','Microinversor Solar','Convertidor de Corriente','Vatimetro','Accesorios de Inversores'],
            'Controladores de Carga' => ['Controladores de Carga PWM', 'Controladores de Carga MPPT', 'Accesorios'],
            'Cargador de Baterías' => ['Cargador de Baterías 12V', 'Cargador de Baterías 24V'],
            'Iluminación Solar' => ['Luminarias Solares'],
            'Accesorios Eléctricos' => ['Enchufes', 'Tomacorriente Schuko', 'Aisladores Eléctricos', 'Cajas de Paso', 'Base Galvanizada', 'Rejillas de Ventilación', 'Canalizaciones', 'Repartidores de Corriente', 'Material Eléctrico','Materiales para Pozo a Tierra','Terminales Eléctricos'],
            'Cables' => ['Cable Vulcanizado', 'Cable Unipolar', 'Cable Mellizo','Cable a Tierra','Cable Unifilar','Cable de Datos'],
            'Protecciones Eléctricas' => ['Termomagnéticos', 'Interruptores Diferenciales', 'Fusibles','Portafusibles','Protector de Sobretensiones','Transformadores Electricos'],
            'Tableros Eléctricos' => ['Tableros Adosables', 'Tableros Autosoportados', 'Kits de Material Eléctrico'],
            'Automatización y Control' => ['Conmutadores de Transferencia', 'Contactores', 'Relés Encapsulados','Temporrizador On Delay','Pulsadores Eléctricos']
        ];

        foreach ($categorias as $tipoName => $cats) {
            $tipo = Tipo::where('name', $tipoName)->first();
            if (!$tipo) continue;

            foreach ($cats as $catName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($catName)],
                    [
                        'name' => $catName,
                        'slug' => Str::slug($catName),
                        'estado' => 'Activo',
                        'tipo_id' => $tipo->id,
                    ]
                );
            }
        }

        $subcategorias = [
            "Baterías AGM" => ["Baterías AGM 6V", "Baterías AGM 12V"],
            "Baterías de GEL" => ["Baterías de GEL 6V", "Baterías de GEL 12V"],
            "Baterías de Litio" => ["Baterías de Litio 12V", "Baterías de Litio 24V", "Baterías de Litio 48V"],
            "Accesorios de Baterías" => ["Cables para Baterías", "Gabinetes de Piso"],
            "Inversores Cargadores" => ["Inversores Cargadores 12V", "Inversores Cargadores 24V", "Inversores Cargadores 48V"],
            "Inversores Hibridos" => ["Inversores Hibridos Monofasicos", "Inversores Hibridos Trifasicos"],
            "Inversores Interconexion" => ["Inversores Interconexion Monofasicos", "Inversores Interconexion Trifasicos"],
            "Convertidor de Corriente" => ["Convertidor de Corriente 12V a 24V", "Convertidor de Corriente 24V a 12V", "Convertidor de Corriente 24V a 24V","Convertidor de Corriente 24V a 48V", "Convertidor de Corriente 48V a 12V"],
            "Aisladores Eléctricos" => ["Aislador Portabarra"],
            "Cajas de Paso" => ["Caja Estanca de Paso"],
            "Canalizaciones" => ["Canaleta para Cable", "Bandeja para Cable"],
            "Repartidores de Corriente" => ["Busbar", "Bornera Repartidora", "Pletina de Cobre"],
            "Cables" => ["Cable Vulcanizado", "Cable Unipolar", "Cable Mellizo","Cable a Tierra","Cable Unifilar","Cable de Datos"],
            "Proteciones Eléctricas" => ["Termomagnéticos AC", "Termomagnéticos DC", "Llaves de Fuerza"],
            "Pulsadores Eléctricos" => ["Pulsadores de Emergencia", "Pulsadores NC"],
            ];
            
            foreach ($subcategorias as $tipoName => $subt) {
                $categ = Category::where('name', $tipoName)->first();
                if (!$categ) continue;

                foreach ($subt as $subName) {
                    Subcategory::updateOrCreate(
                        ['slug' => Str::slug($subName)],
                        [
                            'name' => $subName,
                            'slug' => Str::slug($subName),
                            'estado' => 'Activo',
                            'category_id' => $categ->id,
                        ]
                    );
                }
            }
    }
}
