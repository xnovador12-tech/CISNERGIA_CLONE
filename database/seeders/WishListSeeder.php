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
     */
    public function run(): void
    {
        $productos = Producto::where('estado', 'Activo')->get();

        if ($productos->isEmpty()) {
            return;
        }

        // Clientes que ya visitaron la tienda online y tienen cuenta
        $clientesEcommerce = [
            [
                'nombre' => 'Javier Rodríguez',
                'email' => 'javier.rodriguez.ecom@gmail.com',
                'prospecto_match' => 'Javier',  // Buscar prospecto por nombre
            ],
            [
                'nombre' => 'Lucía Fernández',
                'email' => 'lucia.fernandez.ecom@gmail.com',
                'prospecto_match' => 'Lucía',
            ],
            [
                'nombre' => 'Diego Quispe',
                'email' => 'diego.quispe.ecom@gmail.com',
                'prospecto_match' => 'Diego',
            ],
        ];

        foreach ($clientesEcommerce as $clienteData) {
            // 1. Crear Persona
            $persona = Persona::create([
                'name' => $clienteData['nombre'],
                'slug' => Str::slug($clienteData['nombre'] . '-ecom-' . rand(100, 999)),
                'avatar' => 'user.png',
                'tipo_persona' => 'Cliente',
                'sede_id' => 1,
            ]);

            // 2. Crear User (cuenta ecommerce del cliente)
            // withoutEvents evita que UserObserver cree un prospecto duplicado,
            // ya que el ProspectoSeeder ya creó estos prospectos y los vinculamos manualmente abajo
            $user = User::withoutEvents(function () use ($clienteData, $persona) {
                return User::create([
                    'email' => $clienteData['email'],
                    'password' => Hash::make('cliente123'),
                    'estado' => 'Activo',
                    'role_id' => 6, // Cliente
                    'persona_id' => $persona->id,
                ]);
            });

            // 3. Vincular al Prospecto correspondiente
            $prospecto = Prospecto::where('nombre', 'like', '%' . $clienteData['prospecto_match'] . '%')
                ->whereNull('registered_user_id')
                ->first();

            if ($prospecto) {
                $prospecto->registered_user_id = $user->id;
                $prospecto->origen = 'ecommerce';
                $prospecto->save();

            } else {
            }

            // 4. Crear Wish List (3-5 productos aleatorios por cliente)
            $cantidad = min($productos->count(), rand(3, 5));
            $productosWishlist = $productos->random($cantidad);

            foreach ($productosWishlist as $producto) {
                DB::table('wish_lists')->insert([
                    'deseo' => true,
                    'user_id' => $user->id,
                    'producto_id' => $producto->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 5)),
                ]);
            }

        }

    }
}
