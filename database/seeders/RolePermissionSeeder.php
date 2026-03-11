<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Gerencia y Administrador reciben TODOS los permisos
        $todosLosPermisos = Permission::all();

        Role::where('name', 'Gerencia')->first()
            ?->syncPermissions($todosLosPermisos);

        Role::where('name', 'Administrador')->first()
            ?->syncPermissions($todosLosPermisos);

        // Técnico: solo puede ver tickets y mantenimientos que le asignen
        $permisosTecnico = Permission::whereIn('name', [
            'crm.tickets.index',
            'crm.tickets.edit',
            'crm.mantenimientos.index',
            'crm.mantenimientos.edit',
        ])->get();

        Role::where('name', 'Tecnico')->first()
            ?->syncPermissions($permisosTecnico);

        // El resto de roles quedan sin permisos hasta que
        // el cliente confirme el mapa de accesos (Fase B)
    }
}
