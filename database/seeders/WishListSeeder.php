<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Prospecto;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WishListSeeder extends Seeder
{
    /**
     * Crea usuarios-cliente ecommerce de prueba, los vincula a prospectos
     * y genera wish_lists para simular actividad desde la tienda online.
     *
     * NOTA: Se usa User::withoutEvents() para que el UserObserver no cree
     * un Prospecto duplicado (el ProspectoSeeder ya los creó y los vinculamos
     * manualmente más abajo).
     */
    public function run(): void
    {
        $productos = Producto::where('estado', 'Activo')->get();

        if ($productos->isEmpty()) {
            return;
        }

        $clientesEcommerce = [
            ['nombre' => 'Javier Rodríguez', 'email' => 'javier.rodriguez.ecom@gmail.com', 'prospecto_match' => 'Javier'],
            ['nombre' => 'Lucía Fernández',   'email' => 'lucia.fernandez.ecom@gmail.com',  'prospecto_match' => 'Lucía'],
            ['nombre' => 'Diego Quispe',       'email' => 'diego.quispe.ecom@gmail.com',     'prospecto_match' => 'Diego'],
        ];

        foreach ($clientesEcommerce as $clienteData) {

            // 1. Crear Persona
            $persona = Persona::create([
                'name'         => $clienteData['nombre'],
                'slug'         => Str::slug($clienteData['nombre'] . '-ecom-' . rand(100, 999)),
                'avatar'       => 'user.png',
                'tipo_persona' => 'Cliente',
                'sede_id'      => 1,
            ]);

            // 2. Crear User con rol Cliente sin disparar el Observer
            // assignRole dentro de withoutEvents: no crea Prospecto duplicado
            $user = User::withoutEvents(function () use ($clienteData, $persona) {
                $u = User::create([
                    'email'      => $clienteData['email'],
                    'password'   => Hash::make('cliente123'),
                    'estado'     => 'Activo',
                    'persona_id' => $persona->id,
                ]);
                $u->assignRole('Cliente');
                return $u;
            });

            // 3. Vincular al Prospecto correspondiente (ya creado por ProspectoSeeder)
            $prospecto = Prospecto::where('nombre', 'like', '%' . $clienteData['prospecto_match'] . '%')
                ->whereNull('registered_user_id')
                ->first();

            if ($prospecto) {
                $prospecto->registered_user_id = $user->id;
                $prospecto->origen = 'ecommerce';
                $prospecto->save();
            }

            // 4. Crear Wish List (3-5 productos aleatorios)
            $cantidad = min($productos->count(), rand(3, 5));
            $productosWishlist = $productos->random($cantidad);

            foreach ($productosWishlist as $producto) {
                DB::table('wish_lists')->insert([
                    'deseo'       => true,
                    'user_id'     => $user->id,
                    'producto_id' => $producto->id,
                    'created_at'  => now()->subDays(rand(1, 30)),
                    'updated_at'  => now()->subDays(rand(0, 5)),
                ]);
            }
        }
    }
}
