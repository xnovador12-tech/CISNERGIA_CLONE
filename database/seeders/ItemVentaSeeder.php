<?php

namespace Database\Seeders;

use App\Models\ItemVenta;
use App\Models\ItemVentaCategoria;
use App\Models\TipoAfectacion;
use App\Models\UnidadMedida;
use App\Models\Sede;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catServicios = ItemVentaCategoria::firstOrCreate(['nombre' => 'Servicios Generales'], ['descripcion' => 'Servicios de consultoría e instalación']);
        $catProductos = ItemVentaCategoria::firstOrCreate(['nombre' => 'Productos Ferretería'], ['descripcion' => 'Accesorios y materiales']);

        $afectacionGravado = TipoAfectacion::where('code', '10')->first();
        $unidadServicio = UnidadMedida::where('codigo_sunat' , 'ZZ')->first();
        $unidadProducto = UnidadMedida::where('codigo_sunat' , 'NIU')->first();
        
        $sede = Sede::first();

        if ($sede && $afectacionGravado && $unidadServicio && $unidadProducto) {
            $items = [
                [
                    'codigo' => 'SERV-001',
                    'nombre' => 'Instalación de Paneles Solares',
                    'slug' => Str::slug('Instalación de Paneles Solares'),
                    'descripcion' => 'Servicio completo de instalación',
                    'precio' => 1500.00,
                    'categoria_id' => $catServicios->id,
                    'unidad_medida_id' => $unidadServicio->id,
                    'tipo_afectacion_id' => $afectacionGravado->id,
                    'sede_id' => $sede->id,
                ],
                [
                    'codigo' => 'PROD-001',
                    'nombre' => 'Cable Eléctrico 12AWG (100m)',
                    'slug' => Str::slug('Cable Eléctrico 12AWG 100m'),
                    'descripcion' => 'Rollo de cable de cobre',
                    'precio' => 250.00,
                    'categoria_id' => $catProductos->id,
                    'unidad_medida_id' => $unidadProducto->id,
                    'tipo_afectacion_id' => $afectacionGravado->id,
                    'sede_id' => $sede->id,
                ],
            ];

            foreach ($items as $item) {
                ItemVenta::updateOrCreate(['codigo' => $item['codigo'], 'sede_id' => $item['sede_id']], $item);
            }
        }
    }
}
