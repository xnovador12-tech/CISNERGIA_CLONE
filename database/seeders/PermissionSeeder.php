<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Catálogo completo de permisos del sistema Cisnergia.
     *
     * Convención de nombres (slug técnico):
     *   modulo.submodulo.accion
     *
     * Acciones estándar: index, create, edit, delete
     * Acciones especiales: aprobar (cotizaciones), resolver (tickets)
     *
     * El campo 'name' de Spatie es el que se usa en:
     *   $user->can('crm.prospectos.index')
     *   $user->hasPermissionTo('crm.cotizaciones.aprobar')
     *
     * El campo 'label' es para mostrar en la UI del panel.
     * El campo 'modulo' agrupa los permisos en la pantalla de edición de roles.
     */
    public function run(): void
    {
        $permisos = [

            // ─── DASHBOARD ───────────────────────────────────────────────
            ['modulo' => 'Dashboard',           'name' => 'dashboard.index',                    'label' => 'Ver Dashboard'],

            // ─── CRM - PROSPECTOS ─────────────────────────────────────────
            ['modulo' => 'CRM - Prospectos',    'name' => 'crm.prospectos.index',               'label' => 'Ver Prospectos'],
            ['modulo' => 'CRM - Prospectos',    'name' => 'crm.prospectos.create',              'label' => 'Crear Prospectos'],
            ['modulo' => 'CRM - Prospectos',    'name' => 'crm.prospectos.edit',                'label' => 'Editar Prospectos'],
            ['modulo' => 'CRM - Prospectos',    'name' => 'crm.prospectos.delete',              'label' => 'Eliminar Prospectos'],

            // ─── CRM - OPORTUNIDADES ──────────────────────────────────────
            ['modulo' => 'CRM - Oportunidades', 'name' => 'crm.oportunidades.index',            'label' => 'Ver Oportunidades'],
            ['modulo' => 'CRM - Oportunidades', 'name' => 'crm.oportunidades.create',           'label' => 'Crear Oportunidades'],
            ['modulo' => 'CRM - Oportunidades', 'name' => 'crm.oportunidades.edit',             'label' => 'Editar Oportunidades'],
            ['modulo' => 'CRM - Oportunidades', 'name' => 'crm.oportunidades.delete',           'label' => 'Eliminar Oportunidades'],

            // ─── CRM - COTIZACIONES ───────────────────────────────────────
            ['modulo' => 'CRM - Cotizaciones',  'name' => 'crm.cotizaciones.index',             'label' => 'Ver Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',  'name' => 'crm.cotizaciones.create',            'label' => 'Crear Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',  'name' => 'crm.cotizaciones.edit',              'label' => 'Editar Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',  'name' => 'crm.cotizaciones.delete',            'label' => 'Eliminar Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',  'name' => 'crm.cotizaciones.aprobar',           'label' => 'Aprobar Cotizaciones'],

            // ─── CRM - ACTIVIDADES ────────────────────────────────────────
            ['modulo' => 'CRM - Actividades',   'name' => 'crm.actividades.index',              'label' => 'Ver Actividades'],
            ['modulo' => 'CRM - Actividades',   'name' => 'crm.actividades.create',             'label' => 'Crear Actividades'],
            ['modulo' => 'CRM - Actividades',   'name' => 'crm.actividades.edit',               'label' => 'Editar Actividades'],
            ['modulo' => 'CRM - Actividades',   'name' => 'crm.actividades.delete',             'label' => 'Eliminar Actividades'],

            // ─── CRM - CLIENTES ───────────────────────────────────────────
            ['modulo' => 'CRM - Clientes',      'name' => 'crm.clientes.index',                 'label' => 'Ver Clientes'],
            ['modulo' => 'CRM - Clientes',      'name' => 'crm.clientes.create',                'label' => 'Crear Clientes'],
            ['modulo' => 'CRM - Clientes',      'name' => 'crm.clientes.edit',                  'label' => 'Editar Clientes'],
            ['modulo' => 'CRM - Clientes',      'name' => 'crm.clientes.delete',                'label' => 'Eliminar Clientes'],

            // ─── CRM - TICKETS ────────────────────────────────────────────
            ['modulo' => 'CRM - Tickets',       'name' => 'crm.tickets.index',                  'label' => 'Ver Tickets'],
            ['modulo' => 'CRM - Tickets',       'name' => 'crm.tickets.create',                 'label' => 'Crear Tickets'],
            ['modulo' => 'CRM - Tickets',       'name' => 'crm.tickets.edit',                   'label' => 'Editar Tickets'],
            ['modulo' => 'CRM - Tickets',       'name' => 'crm.tickets.delete',                 'label' => 'Eliminar Tickets'],
            ['modulo' => 'CRM - Tickets',       'name' => 'crm.tickets.resolver',               'label' => 'Resolver Tickets'],

            // ─── CRM - MANTENIMIENTOS ─────────────────────────────────────
            ['modulo' => 'CRM - Mantenimientos','name' => 'crm.mantenimientos.index',           'label' => 'Ver Mantenimientos'],
            ['modulo' => 'CRM - Mantenimientos','name' => 'crm.mantenimientos.create',          'label' => 'Crear Mantenimientos'],
            ['modulo' => 'CRM - Mantenimientos','name' => 'crm.mantenimientos.edit',            'label' => 'Editar Mantenimientos'],
            ['modulo' => 'CRM - Mantenimientos','name' => 'crm.mantenimientos.delete',          'label' => 'Eliminar Mantenimientos'],

            // ─── VENTAS - PEDIDOS ─────────────────────────────────────────
            ['modulo' => 'Ventas - Pedidos',    'name' => 'ventas.pedidos.index',               'label' => 'Ver Pedidos'],
            ['modulo' => 'Ventas - Pedidos',    'name' => 'ventas.pedidos.create',              'label' => 'Crear Pedidos'],
            ['modulo' => 'Ventas - Pedidos',    'name' => 'ventas.pedidos.edit',                'label' => 'Editar Pedidos'],
            ['modulo' => 'Ventas - Pedidos',    'name' => 'ventas.pedidos.delete',              'label' => 'Eliminar Pedidos'],

            // ─── VENTAS - VENTAS ──────────────────────────────────────────
            ['modulo' => 'Ventas - Ventas',     'name' => 'ventas.ventas.index',                'label' => 'Ver Ventas'],
            ['modulo' => 'Ventas - Ventas',     'name' => 'ventas.ventas.create',               'label' => 'Crear Ventas'],
            ['modulo' => 'Ventas - Ventas',     'name' => 'ventas.ventas.edit',                 'label' => 'Editar Ventas'],
            ['modulo' => 'Ventas - Ventas',     'name' => 'ventas.ventas.delete',               'label' => 'Eliminar Ventas'],

            // ─── COMPRAS ──────────────────────────────────────────────────
            ['modulo' => 'Compras',             'name' => 'compras.index',                      'label' => 'Ver Compras'],
            ['modulo' => 'Compras',             'name' => 'compras.create',                     'label' => 'Crear Órdenes de Compra'],
            ['modulo' => 'Compras',             'name' => 'compras.edit',                       'label' => 'Editar Compras'],
            ['modulo' => 'Compras',             'name' => 'compras.delete',                     'label' => 'Eliminar Compras'],

            // ─── ALMACÉN ──────────────────────────────────────────────────
            ['modulo' => 'Almacén',             'name' => 'almacen.index',                      'label' => 'Ver Almacén'],
            ['modulo' => 'Almacén',             'name' => 'almacen.create',                     'label' => 'Registrar Ingresos/Salidas'],
            ['modulo' => 'Almacén',             'name' => 'almacen.edit',                       'label' => 'Editar Registros de Almacén'],
            ['modulo' => 'Almacén',             'name' => 'almacen.delete',                     'label' => 'Eliminar Registros de Almacén'],

            // ─── OPERACIONES ──────────────────────────────────────────────
            ['modulo' => 'Operaciones',         'name' => 'operaciones.index',                  'label' => 'Ver Operaciones'],
            ['modulo' => 'Operaciones',         'name' => 'operaciones.create',                 'label' => 'Crear Asignaciones'],
            ['modulo' => 'Operaciones',         'name' => 'operaciones.edit',                   'label' => 'Editar Operaciones'],
            ['modulo' => 'Operaciones',         'name' => 'operaciones.delete',                 'label' => 'Eliminar Operaciones'],

            // ─── REPORTES ─────────────────────────────────────────────────
            ['modulo' => 'Reportes',            'name' => 'reportes.index',                     'label' => 'Ver Reportes'],

            // ─── CONFIGURACIONES ──────────────────────────────────────────
            ['modulo' => 'Config - Tipos',      'name' => 'configuraciones.tipos.index',        'label' => 'Ver Tipos'],
            ['modulo' => 'Config - Tipos',      'name' => 'configuraciones.tipos.create',       'label' => 'Crear Tipos'],
            ['modulo' => 'Config - Tipos',      'name' => 'configuraciones.tipos.edit',         'label' => 'Editar Tipos'],
            ['modulo' => 'Config - Tipos',      'name' => 'configuraciones.tipos.delete',       'label' => 'Eliminar Tipos'],

            ['modulo' => 'Config - Categorías', 'name' => 'configuraciones.categorias.index',   'label' => 'Ver Categorías'],
            ['modulo' => 'Config - Categorías', 'name' => 'configuraciones.categorias.create',  'label' => 'Crear Categorías'],
            ['modulo' => 'Config - Categorías', 'name' => 'configuraciones.categorias.edit',    'label' => 'Editar Categorías'],
            ['modulo' => 'Config - Categorías', 'name' => 'configuraciones.categorias.delete',  'label' => 'Eliminar Categorías'],

            ['modulo' => 'Config - Marcas',     'name' => 'configuraciones.marcas.index',       'label' => 'Ver Marcas'],
            ['modulo' => 'Config - Marcas',     'name' => 'configuraciones.marcas.create',      'label' => 'Crear Marcas'],
            ['modulo' => 'Config - Marcas',     'name' => 'configuraciones.marcas.edit',        'label' => 'Editar Marcas'],
            ['modulo' => 'Config - Marcas',     'name' => 'configuraciones.marcas.delete',      'label' => 'Eliminar Marcas'],

            ['modulo' => 'Config - Productos',  'name' => 'configuraciones.productos.index',    'label' => 'Ver Productos'],
            ['modulo' => 'Config - Productos',  'name' => 'configuraciones.productos.create',   'label' => 'Crear Productos'],
            ['modulo' => 'Config - Productos',  'name' => 'configuraciones.productos.edit',     'label' => 'Editar Productos'],
            ['modulo' => 'Config - Productos',  'name' => 'configuraciones.productos.delete',   'label' => 'Eliminar Productos'],

            ['modulo' => 'Config - Proveedores','name' => 'configuraciones.proveedores.index',  'label' => 'Ver Proveedores'],
            ['modulo' => 'Config - Proveedores','name' => 'configuraciones.proveedores.create', 'label' => 'Crear Proveedores'],
            ['modulo' => 'Config - Proveedores','name' => 'configuraciones.proveedores.edit',   'label' => 'Editar Proveedores'],
            ['modulo' => 'Config - Proveedores','name' => 'configuraciones.proveedores.delete', 'label' => 'Eliminar Proveedores'],

            ['modulo' => 'Config - Usuarios',   'name' => 'configuraciones.usuarios.index',     'label' => 'Ver Usuarios'],
            ['modulo' => 'Config - Usuarios',   'name' => 'configuraciones.usuarios.create',    'label' => 'Crear Usuarios'],
            ['modulo' => 'Config - Usuarios',   'name' => 'configuraciones.usuarios.edit',      'label' => 'Editar Usuarios'],
            ['modulo' => 'Config - Usuarios',   'name' => 'configuraciones.usuarios.delete',    'label' => 'Eliminar Usuarios'],

            ['modulo' => 'Config - Roles',      'name' => 'configuraciones.roles.index',        'label' => 'Ver Roles'],
            ['modulo' => 'Config - Roles',      'name' => 'configuraciones.roles.create',       'label' => 'Crear Roles'],
            ['modulo' => 'Config - Roles',      'name' => 'configuraciones.roles.edit',         'label' => 'Editar Roles'],
            ['modulo' => 'Config - Roles',      'name' => 'configuraciones.roles.delete',       'label' => 'Eliminar Roles'],
        ];

        foreach ($permisos as $permiso) {
            Permission::create([
                'name'       => $permiso['name'],
                'slug'       => $permiso['name'],   // slug = name (ya usa notación dot)
                'guard_name' => 'web',
                'label'      => $permiso['label'],
                'modulo'     => $permiso['modulo'],
            ]);
        }

        $this->command->info('✅ ' . count($permisos) . ' permisos creados correctamente.');
    }
}
