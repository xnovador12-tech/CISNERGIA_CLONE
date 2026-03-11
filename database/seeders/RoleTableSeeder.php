<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Gerencia',       'descripcion' => 'Acceso de alto nivel, visibilidad total'],
            ['name' => 'Administrador',  'descripcion' => 'Control total del sistema'],
            ['name' => 'Ventas',         'descripcion' => 'CRM: prospectos, oportunidades, cotizaciones'],
            ['name' => 'Finanzas',       'descripcion' => 'Cobros, ventas, reportes económicos'],
            ['name' => 'Compras',        'descripcion' => 'Órdenes de compra y proveedores'],
            ['name' => 'Almacen',        'descripcion' => 'Inventario, ingresos y salidas'],
            ['name' => 'Operaciones',    'descripcion' => 'Supervisión de tickets, mantenimientos y asignaciones'],
            ['name' => 'Tecnico',        'descripcion' => 'Personal de campo: recibe tickets y mantenimientos'],
            ['name' => 'Cliente',        'descripcion' => 'Solo ecommerce'],
        ];

        foreach ($roles as $data) {
            Role::create([
                'name'        => $data['name'],
                'guard_name'  => 'web',
                'descripcion' => $data['descripcion'],
                'estado'      => 'Activo',
                // slug se genera automáticamente en el boot() del modelo
            ]);
        }
    }
}
