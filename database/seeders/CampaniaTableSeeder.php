<?php

namespace Database\Seeders;

use App\Models\Campania;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CampaniaTableSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()->id ?? 1;
        $productos = Producto::pluck('id')->toArray();

        // Campaña 1: Activa - Descuento de verano
        $campania1 = Campania::create([
            'nombre' => 'Verano Solar 2026',
            'slug' => Str::slug('Verano Solar 2026'),
            'descripcion' => 'Aprovecha el verano con descuentos especiales en paneles solares y kits de energía renovable. Instalación incluida en productos seleccionados.',
            'tipo' => 'descuento',
            'descuento_porcentaje' => 15.00,
            'descuento_monto' => null,
            'condicion_minimo' => 500.00,
            'fecha_inicio' => Carbon::today()->subDays(5),
            'fecha_fin' => Carbon::today()->addDays(25),
            'estado' => 'activa',
            'aplica_todos_productos' => false,
            'creado_por' => $userId,
            'activado_por' => $userId,
            'activado_at' => Carbon::today()->subDays(5),
        ]);

        // Asociar productos (los primeros 3 disponibles)
        if (count($productos) >= 3) {
            $campania1->productos()->attach([
                $productos[0] => ['descuento_especifico' => null],
                $productos[1] => ['descuento_especifico' => 20.00],
                $productos[2] => ['descuento_especifico' => null],
            ]);
        } elseif (count($productos) > 0) {
            foreach (array_slice($productos, 0, 3) as $pid) {
                $campania1->productos()->attach($pid);
            }
        }

        // Campaña 2: Borrador - Flash Sale próximo
        $campania2 = Campania::create([
            'nombre' => 'Flash Sale - Día de la Energía',
            'slug' => Str::slug('Flash Sale Dia de la Energia'),
            'descripcion' => 'Venta relámpago por el Día Mundial de la Energía. 24 horas de ofertas imperdibles en inversores y baterías.',
            'tipo' => 'flash_sale',
            'descuento_porcentaje' => 25.00,
            'descuento_monto' => null,
            'condicion_minimo' => null,
            'fecha_inicio' => Carbon::today()->addDays(10),
            'fecha_fin' => Carbon::today()->addDays(11),
            'estado' => 'borrador',
            'aplica_todos_productos' => true,
            'creado_por' => $userId,
        ]);

        // Campaña 3: Activa - Envío gratis
        $campania3 = Campania::create([
            'nombre' => 'Envío Gratis en Marzo',
            'slug' => Str::slug('Envio Gratis Marzo'),
            'descripcion' => 'Durante todo marzo, envío gratis en compras mayores a S/ 300. Aplica para Lima Metropolitana y provincias seleccionadas.',
            'tipo' => 'envio_gratis',
            'descuento_porcentaje' => null,
            'descuento_monto' => null,
            'condicion_minimo' => 300.00,
            'fecha_inicio' => Carbon::today()->subDays(2),
            'fecha_fin' => Carbon::today()->addDays(30),
            'estado' => 'activa',
            'aplica_todos_productos' => true,
            'creado_por' => $userId,
            'activado_por' => $userId,
            'activado_at' => Carbon::today()->subDays(2),
        ]);

        $this->command->info('3 campañas creadas correctamente.');
    }
}
