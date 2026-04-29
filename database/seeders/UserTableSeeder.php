<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['nombre' => 'Gerencia Cisnergia',      'email' => 'gerencia@cisnergiamarketplace.com',     'rol' => 'Gerencia'],
            ['nombre' => 'Administrador Cisnergia',  'email' => 'administrador@cisnergiamarketplace.com', 'rol' => 'Administrador'],
            ['nombre' => 'Vendedor Cisnergia',       'email' => 'ventas@cisnergiamarketplace.com',        'rol' => 'Ventas'],
            ['nombre' => 'Finanzas Cisnergia',       'email' => 'finanzas@cisnergiamarketplace.com',      'rol' => 'Finanzas'],
            ['nombre' => 'Compras Cisnergia',        'email' => 'compras@cisnergiamarketplace.com',       'rol' => 'Compras'],
            ['nombre' => 'Almacen Cisnergia',        'email' => 'almacen@cisnergiamarketplace.com',       'rol' => 'Almacen'],
            ['nombre' => 'Operaciones Cisnergia',    'email' => 'operaciones@cisnergiamarketplace.com',   'rol' => 'Operaciones'],
            ['nombre' => 'Tecnico Cisnergia',        'email' => 'tecnico@cisnergiamarketplace.com',       'rol' => 'Tecnico'],
            ['nombre' => 'Cliente Demo',             'email' => 'cliente@cisnergiamarketplace.com',       'rol' => 'Cliente'],
        ];

        foreach ($usuarios as $data) {
            $persona = Persona::create([
                'name'        => $data['nombre'],
                'slug'        => Str::slug($data['nombre']) . '-' . Str::random(5),
                'avatar'      => 'user.png',
                'celular'     => '999999999',
                'pais'        => 'Peru',
                'ciudad'      => 'Ica',
                'direccion'   => 'Av. Principal 123',
                'tipo_persona'=> 'Empleado',
                'sede_id'     => 1,
            ]);

            $user = User::create([
                'email'      => $data['email'],
                'password'   => Hash::make('Cisnergi@123'),
                'estado'     => 'Activo',
                'persona_id' => $persona->id,
            ]);

            $user->assignRole($data['rol']);
        }
    }
}
