<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tipo;

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
            return;
        }

        if (!$almacen) {
            return;
        }

        $cantidadPorProducto = 20; // Stock de prueba inicial

        foreach ($productos as $producto) {
            $valor_tipo = Tipo::where('id', $producto->tipo_id)->first();
            // Verificar si ya existe inventario para evitar duplicados
            $existe = DB::table('inventarios')
                ->where('id_producto', $producto->id)
                ->where('almacen_id', $almacen->id)
                ->exists();

            if (!$existe) {
                DB::table('inventarios')->insert([
                    'id_producto'   => $producto->id,
                    'tipo_producto' => $valor_tipo->name,
                    'producto'      => $producto->name ?? $producto->nombre ?? 'Producto',
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

    }
}
