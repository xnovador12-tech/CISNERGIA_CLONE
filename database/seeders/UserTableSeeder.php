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
            ['nombre' => 'Gerencia Cisnergia',      'email' => 'gerencia@cisnergia.com',     'rol' => 'Gerencia'],
            ['nombre' => 'Administrador Cisnergia',  'email' => 'administrador@cisnergia.com', 'rol' => 'Administrador'],
            ['nombre' => 'Vendedor Cisnergia',       'email' => 'ventas@cisnergia.com',        'rol' => 'Ventas'],
            ['nombre' => 'Finanzas Cisnergia',       'email' => 'finanzas@cisnergia.com',      'rol' => 'Finanzas'],
            ['nombre' => 'Compras Cisnergia',        'email' => 'compras@cisnergia.com',       'rol' => 'Compras'],
            ['nombre' => 'Almacen Cisnergia',        'email' => 'almacen@cisnergia.com',       'rol' => 'Almacen'],
            ['nombre' => 'Operaciones Cisnergia',    'email' => 'operaciones@cisnergia.com',   'rol' => 'Operaciones'],
            ['nombre' => 'Tecnico Cisnergia',        'email' => 'tecnico@cisnergia.com',       'rol' => 'Tecnico'],
            ['nombre' => 'Cliente Demo',             'email' => 'cliente@cisnergia.com',       'rol' => 'Cliente'],
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
                'password'   => Hash::make('password'),
                'estado'     => 'Activo',
                'persona_id' => $persona->id,
            ]);

            $user->assignRole($data['rol']);
        }
    }
}
