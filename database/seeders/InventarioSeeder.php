<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    /**
     * Crea stock inicial en inventario para todos los productos existentes.
     * Vinculado al Almacén Central (primer almacén) y la primera sede.
     */
    public function run(): void
    {
        $productos = DB::table('productos')->get();
        $almacen   = DB::table('almacenes')->first();
        $sede      = DB::table('sedes')->first();

        if ($productos->isEmpty()) {
            $this->command->error('❌ No hay productos. Ejecuta primero ProductoSeeder.');
            return;
        }

        if (!$almacen) {
            $this->command->error('❌ No hay almacenes. Ejecuta primero AlmacenTableSeeder.');
            return;
        }

        $cantidadPorProducto = 20; // Stock de prueba inicial

        foreach ($productos as $producto) {
            // Verificar si ya existe inventario para evitar duplicados
            $existe = DB::table('inventarios')
                ->where('id_producto', $producto->id)
                ->where('almacen_id', $almacen->id)
                ->exists();

            if (!$existe) {
                DB::table('inventarios')->insert([
                    'id_producto'   => $producto->id,
                    'tipo_producto' => 'Producto terminado',
                    'producto'      => $producto->name ?? $producto->nombre ?? 'Producto',
                    'lote'          => 'LOTE-INICIAL-' . date('Y'),
                    'umedida'       => 'UND',
                    'cantidad'      => $cantidadPorProducto,
                    'precio'        => $producto->precio ?? 0,
                    'almacen_id'    => $almacen->id,
                    'sede_id'       => $sede->id ?? null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        $this->command->info("✅ Stock inicial creado: {$cantidadPorProducto} unidades por producto en almacén '{$almacen->name}'.");
    }
}
