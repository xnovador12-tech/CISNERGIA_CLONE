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
            $this->command->warn('No hay productos activos para crear wishlists.');
            return;
        }

        // Clientes que ya visitaron la tienda online y tienen cuenta
        $clientesEcommerce = [
            [
                'nombre' => 'Carlos Mendoza',
                'email' => 'carlos.mendoza.ecom@gmail.com',
                'prospecto_match' => 'Carlos',  // Buscar prospecto por nombre
            ],
            [
                'nombre' => 'Patricia Vega',
                'email' => 'patricia.vega.ecom@gmail.com',
                'prospecto_match' => 'Patricia',
            ],
            [
                'nombre' => 'Fernando Castillo',
                'email' => 'fernando.castillo.ecom@gmail.com',
                'prospecto_match' => 'Fernando',
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
            $user = User::create([
                'email' => $clienteData['email'],
                'password' => Hash::make('cliente123'),
                'estado' => 'Activo',
                'role_id' => 2,
                'persona_id' => $persona->id,
            ]);

            // 3. Vincular al Prospecto correspondiente
            $prospecto = Prospecto::where('nombre', 'like', '%' . $clienteData['prospecto_match'] . '%')
                ->whereNull('registered_user_id')
                ->first();

            if ($prospecto) {
                $prospecto->registered_user_id = $user->id;
                $prospecto->origen = 'ecommerce';
                $prospecto->save();

                $this->command->info("  → Prospecto '{$prospecto->nombre_completo}' vinculado a cuenta ecommerce #{$user->id} (origen → ecommerce)");
            } else {
                $this->command->warn("  → No se encontró prospecto para '{$clienteData['prospecto_match']}'");
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

            $this->command->info("  → Wishlist: {$cantidad} productos para '{$clienteData['nombre']}'");
        }

        $this->command->info("Total wish_lists: " . DB::table('wish_lists')->count());
    }
}
