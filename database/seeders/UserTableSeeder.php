<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persona = new Persona();
        $persona->name = "Marcos Amasifuen";
        $persona->slug = Str::slug($persona->name);
        $persona->avatar = "user.png";
        $persona->celular = "0998765432";
        $persona->pais = "Ecuador";
        $persona->ciudad = "Quito";
        $persona->identificacion = "Cédula";
        $persona->nro_identificacion = "1712345678";
        $persona->direccion = "Av. Siempre Viva 123";
        $persona->referencia = "Frente al parque";
        $persona->descripcion = "Descripción de Marcos Amasifuen";
        $persona->save();

        $user = new User();
        $user->email = "marcos@cuanticagroup.com";
        $user->password = Hash::make("marcos123");
        $user->estado = "Activo";
        $user->role_id = "1";
        $user->persona_id = "1";
        $user->save();        


        $persona = new Persona();
        $persona->name = "leidenger";
        $persona->slug = Str::slug($persona->name);
        $persona->avatar = "user.png";
        $persona->celular = "0998765432";
        $persona->pais = "Peru";
        $persona->ciudad = "Lima";
        $persona->identificacion = "Dni";
        $persona->nro_identificacion = "48895679";
        $persona->direccion = "Av. Siempre Viva 123";
        $persona->referencia = "Frente al parque";
        $persona->descripcion = "Descripción de Leidenger";
        $persona->save();

        $user = new User();
        $user->email = "admin@leidenger.com";
        $user->password = Hash::make("admin");
        $user->estado = "Activo";
        $user->role_id = "2";
        $user->persona_id = "2";
        $user->save();

        $persona = new Persona();
        $persona->name = "leidenger";
        $persona->slug = Str::slug($persona->name);
        $persona->avatar = "user.png";
        $persona->celular = "0998765432";
        $persona->pais = "Peru";
        $persona->ciudad = "Lima";
        $persona->identificacion = "Dni";
        $persona->nro_identificacion = "48895679";
        $persona->direccion = "Av. Siempre Viva 123";
        $persona->referencia = "Frente al parque";
        $persona->descripcion = "Descripción de Leidenger";
        $persona->save();

        $user = new User();
        $user->email = "instructor@leidenger.com";
        $user->password = Hash::make("instructor");
        $user->estado = "Activo";
        $user->role_id = "3";
        $user->persona_id = "3";
        $user->save();

        $persona = new Persona();
        $persona->name = "Gilberto";
        $persona->slug = Str::slug($persona->name);
        $persona->avatar = "user.png";
        $persona->celular = "0998765432";
        $persona->pais = "Peru";
        $persona->ciudad = "Lima";
        $persona->identificacion = "Dni";
        $persona->nro_identificacion = "48895679";
        $persona->direccion = "Av. Siempre Viva 123";
        $persona->referencia = "Frente al parque";
        $persona->descripcion = "Descripción de Gilberto";
        $persona->save();

        $user = new User();
        $user->email = "cliente@leidenger.com";
        $user->password = Hash::make("cliente");
        $user->estado = "Activo";
        $user->role_id = "4";
        $user->persona_id = "4";
        $user->save();
    }
}
