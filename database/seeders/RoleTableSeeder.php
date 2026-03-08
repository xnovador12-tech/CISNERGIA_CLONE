<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Role();
        $role->name = "Cuantica"; //Usuario Cuantica
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();

        $role = new Role();
        $role->name = "Administrador"; //Administrador general
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();

        $role = new Role();
        $role->name = "Logistica"; //Instructores
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();

        $role = new Role();
        $role->name = "Almacen"; //Clientes
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();

        $role = new Role();
        $role->name = "Tesoreria"; //Clientes
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();

        // $role = new Role();
        // $role->name = "Reparto"; //Clientes
        // $role->slug = Str::slug($role->name);
        // $role->estado = "Activo";
        // $role->nivel = "PRINCIPAL";
        // $role->save();

        $role = new Role();
        $role->name = "Tecnico"; // Técnico de campo
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();

        $role = new Role();
        $role->name = "Cliente"; //Clientes
        $role->slug = Str::slug($role->name);
        $role->estado = "Activo";
        $role->nivel = "PRINCIPAL";
        $role->save();
        
    }
}
