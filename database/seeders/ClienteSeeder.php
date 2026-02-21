<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Persona;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Cliente 1: Juan Perez (Persona Natural)
        $persona1 = Persona::create([
            'name' => 'Juan',
            'slug' => 'juan-perez-martinez',
            'surnames' => 'Perez Martinez',
            'email_pnatural' => 'juan.perez@email.com',
            'celular' => '987654321',
            'identificacion' => 'DNI',
            'nro_identificacion' => '12345678',
            'direccion' => 'Av. Los Olivos 123, San Isidro',
            'tipo_persona' => 'natural',
            'sede_id' => 1,
        ]);

        $user1 = User::create([
            'persona_id' => $persona1->id,
            'email' => 'juan.perez@email.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        Cliente::create(['user_id' => $user1->id]);

        // Cliente 2: Empresa Solar SAC (Persona Jurídica)
        $persona2 = Persona::create([
            'name' => 'Empresa Solar SAC',
            'slug' => 'empresa-solar-sac',
            'email_pnatural' => 'contacto@empresasolar.com',
            'celular' => '014567890',
            'identificacion' => 'RUC',
            'nro_identificacion' => '20123456789',
            'direccion' => 'Jr. Comercio 456, Miraflores',
            'tipo_persona' => 'juridica',
            'sede_id' => 1,
        ]);

        $user2 = User::create([
            'persona_id' => $persona2->id,
            'email' => 'contacto@empresasolar.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        Cliente::create(['user_id' => $user2->id]);

        // Cliente 3: Maria Rodriguez (Persona Natural)
        $persona3 = Persona::create([
            'name' => 'Maria',
            'slug' => 'maria-rodriguez-lopez',
            'surnames' => 'Rodriguez Lopez',
            'email_pnatural' => 'maria.rodriguez@email.com',
            'celular' => '912345678',
            'identificacion' => 'DNI',
            'nro_identificacion' => '87654321',
            'direccion' => 'Calle Las Flores 789, Surco',
            'tipo_persona' => 'natural',
            'sede_id' => 1,
        ]);

        $user3 = User::create([
            'persona_id' => $persona3->id,
            'email' => 'maria.rodriguez@email.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        Cliente::create(['user_id' => $user3->id]);

        // Cliente 4: Constructora Lima EIRL
        $persona4 = Persona::create([
            'name' => 'Constructora Lima EIRL',
            'slug' => 'constructora-lima-eirl',
            'email_pnatural' => 'ventas@constructoralima.com',
            'celular' => '016789012',
            'identificacion' => 'RUC',
            'nro_identificacion' => '20987654321',
            'direccion' => 'Av. Industrial 321, Ate',
            'tipo_persona' => 'juridica',
            'sede_id' => 1,
        ]);

        $user4 = User::create([
            'persona_id' => $persona4->id,
            'email' => 'ventas@constructoralima.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        Cliente::create(['user_id' => $user4->id]);

        // Cliente 5: Carlos Gomez (Persona Natural)
        $persona5 = Persona::create([
            'name' => 'Carlos',
            'slug' => 'carlos-gomez-diaz',
            'surnames' => 'Gomez Diaz',
            'email_pnatural' => 'carlos.gomez@email.com',
            'celular' => '923456789',
            'identificacion' => 'DNI',
            'nro_identificacion' => '45678912',
            'direccion' => 'Urb. Los Pinos 555, La Molina',
            'tipo_persona' => 'natural',
            'sede_id' => 1,
        ]);

        $user5 = User::create([
            'persona_id' => $persona5->id,
            'email' => 'carlos.gomez@email.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        Cliente::create(['user_id' => $user5->id]);

        $this->command->info('✅ 5 Clientes creados exitosamente');
    }
}
