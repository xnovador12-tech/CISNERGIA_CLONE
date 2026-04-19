<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
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
     * Acciones especiales: aprobar, resolver, registrar, enviar-email, anular, etc.
     *
     * El campo 'name' de Spatie es el que se usa en:
     *   $user->can('crm.prospectos.index')
     *   $user->hasPermissionTo('crm.cotizaciones.aprobar')
     *   middleware('permission:crm.prospectos.edit')
     *
     * El campo 'label' es para mostrar en la UI del panel de roles.
     * El campo 'modulo' agrupa los permisos en los checkboxes de edición de roles.
     *
     * IDEMPOTENTE: el seeder limpia la tabla antes de insertar para poder
     * re-ejecutarse sin conflictos. Las asignaciones a roles se regeneran en
     * RolePermissionSeeder (que debe correrse DESPUÉS de este).
     */
    public function run(): void
    {
        // Limpiar caché de Spatie y vaciar tabla para idempotencia
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::query()->delete();

        $permisos = [

            // ─── DASHBOARD Y GENERALES ────────────────────────────────────
            ['modulo' => 'Dashboard',                'name' => 'dashboard.index',                     'label' => 'Ver Dashboard'],
            ['modulo' => 'Dashboard',                'name' => 'configuraciones.index',               'label' => 'Ver Configuraciones Generales'],
            ['modulo' => 'Dashboard',                'name' => 'reportes.index',                      'label' => 'Ver Reportes'],
            ['modulo' => 'Dashboard',                'name' => 'informacion.edit',                    'label' => 'Editar Información de la Empresa'],
            ['modulo' => 'Dashboard',                'name' => 'perfil.edit',                         'label' => 'Editar Perfil Propio'],

            // ─── CONFIGURACIONES - ACCESO AL SISTEMA ──────────────────────
            ['modulo' => 'Config - Roles',           'name' => 'configuraciones.roles.index',         'label' => 'Ver Roles'],
            ['modulo' => 'Config - Roles',           'name' => 'configuraciones.roles.create',        'label' => 'Crear Roles'],
            ['modulo' => 'Config - Roles',           'name' => 'configuraciones.roles.edit',          'label' => 'Editar Roles'],
            ['modulo' => 'Config - Roles',           'name' => 'configuraciones.roles.delete',        'label' => 'Eliminar Roles'],

            ['modulo' => 'Config - Usuarios',        'name' => 'configuraciones.usuarios.index',      'label' => 'Ver Usuarios'],
            ['modulo' => 'Config - Usuarios',        'name' => 'configuraciones.usuarios.create',     'label' => 'Crear Usuarios'],
            ['modulo' => 'Config - Usuarios',        'name' => 'configuraciones.usuarios.edit',       'label' => 'Editar Usuarios'],
            ['modulo' => 'Config - Usuarios',        'name' => 'configuraciones.usuarios.delete',     'label' => 'Eliminar Usuarios'],

            // ─── CONFIGURACIONES - CATÁLOGO MAESTRO ───────────────────────
            ['modulo' => 'Config - Tipos',           'name' => 'configuraciones.tipos.index',         'label' => 'Ver Tipos'],
            ['modulo' => 'Config - Tipos',           'name' => 'configuraciones.tipos.create',        'label' => 'Crear Tipos'],
            ['modulo' => 'Config - Tipos',           'name' => 'configuraciones.tipos.edit',          'label' => 'Editar Tipos'],
            ['modulo' => 'Config - Tipos',           'name' => 'configuraciones.tipos.delete',        'label' => 'Eliminar Tipos'],

            ['modulo' => 'Config - Modelos',         'name' => 'configuraciones.modelos.index',       'label' => 'Ver Modelos'],
            ['modulo' => 'Config - Modelos',         'name' => 'configuraciones.modelos.create',      'label' => 'Crear Modelos'],
            ['modulo' => 'Config - Modelos',         'name' => 'configuraciones.modelos.edit',        'label' => 'Editar Modelos'],
            ['modulo' => 'Config - Modelos',         'name' => 'configuraciones.modelos.delete',      'label' => 'Eliminar Modelos'],

            ['modulo' => 'Config - Categorías',      'name' => 'configuraciones.categorias.index',    'label' => 'Ver Categorías'],
            ['modulo' => 'Config - Categorías',      'name' => 'configuraciones.categorias.create',   'label' => 'Crear Categorías'],
            ['modulo' => 'Config - Categorías',      'name' => 'configuraciones.categorias.edit',     'label' => 'Editar Categorías'],
            ['modulo' => 'Config - Categorías',      'name' => 'configuraciones.categorias.delete',   'label' => 'Eliminar Categorías'],

            ['modulo' => 'Config - Marcas',          'name' => 'configuraciones.marcas.index',        'label' => 'Ver Marcas'],
            ['modulo' => 'Config - Marcas',          'name' => 'configuraciones.marcas.create',       'label' => 'Crear Marcas'],
            ['modulo' => 'Config - Marcas',          'name' => 'configuraciones.marcas.edit',         'label' => 'Editar Marcas'],
            ['modulo' => 'Config - Marcas',          'name' => 'configuraciones.marcas.delete',       'label' => 'Eliminar Marcas'],

            ['modulo' => 'Config - Etiquetas',       'name' => 'configuraciones.etiquetas.index',     'label' => 'Ver Etiquetas'],
            ['modulo' => 'Config - Etiquetas',       'name' => 'configuraciones.etiquetas.create',    'label' => 'Crear Etiquetas'],
            ['modulo' => 'Config - Etiquetas',       'name' => 'configuraciones.etiquetas.edit',      'label' => 'Editar Etiquetas'],
            ['modulo' => 'Config - Etiquetas',       'name' => 'configuraciones.etiquetas.delete',    'label' => 'Eliminar Etiquetas'],

            ['modulo' => 'Config - Productos',       'name' => 'configuraciones.productos.index',     'label' => 'Ver Productos'],
            ['modulo' => 'Config - Productos',       'name' => 'configuraciones.productos.create',    'label' => 'Crear Productos'],
            ['modulo' => 'Config - Productos',       'name' => 'configuraciones.productos.edit',      'label' => 'Editar Productos'],
            ['modulo' => 'Config - Productos',       'name' => 'configuraciones.productos.delete',    'label' => 'Eliminar Productos'],

            ['modulo' => 'Config - Kits',            'name' => 'configuraciones.kits.index',          'label' => 'Ver Kits'],
            ['modulo' => 'Config - Kits',            'name' => 'configuraciones.kits.create',         'label' => 'Crear Kits'],
            ['modulo' => 'Config - Kits',            'name' => 'configuraciones.kits.edit',           'label' => 'Editar Kits'],
            ['modulo' => 'Config - Kits',            'name' => 'configuraciones.kits.delete',         'label' => 'Eliminar Kits'],

            ['modulo' => 'Config - Proveedores',     'name' => 'configuraciones.proveedores.index',   'label' => 'Ver Proveedores'],
            ['modulo' => 'Config - Proveedores',     'name' => 'configuraciones.proveedores.create',  'label' => 'Crear Proveedores'],
            ['modulo' => 'Config - Proveedores',     'name' => 'configuraciones.proveedores.edit',    'label' => 'Editar Proveedores'],
            ['modulo' => 'Config - Proveedores',     'name' => 'configuraciones.proveedores.delete',  'label' => 'Eliminar Proveedores'],

            ['modulo' => 'Config - Descuentos',      'name' => 'configuraciones.descuentos.index',    'label' => 'Ver Descuentos'],
            ['modulo' => 'Config - Descuentos',      'name' => 'configuraciones.descuentos.create',   'label' => 'Crear Descuentos'],
            ['modulo' => 'Config - Descuentos',      'name' => 'configuraciones.descuentos.edit',     'label' => 'Editar Descuentos'],
            ['modulo' => 'Config - Descuentos',      'name' => 'configuraciones.descuentos.delete',   'label' => 'Eliminar Descuentos'],

            ['modulo' => 'Config - Cupones',         'name' => 'configuraciones.cupones.index',       'label' => 'Ver Cupones'],
            ['modulo' => 'Config - Cupones',         'name' => 'configuraciones.cupones.create',      'label' => 'Crear Cupones'],
            ['modulo' => 'Config - Cupones',         'name' => 'configuraciones.cupones.edit',        'label' => 'Editar Cupones'],
            ['modulo' => 'Config - Cupones',         'name' => 'configuraciones.cupones.delete',      'label' => 'Eliminar Cupones'],

            ['modulo' => 'Config - Coberturas',      'name' => 'configuraciones.coberturas.index',    'label' => 'Ver Coberturas'],
            ['modulo' => 'Config - Coberturas',      'name' => 'configuraciones.coberturas.create',   'label' => 'Crear Coberturas'],
            ['modulo' => 'Config - Coberturas',      'name' => 'configuraciones.coberturas.edit',     'label' => 'Editar Coberturas'],
            ['modulo' => 'Config - Coberturas',      'name' => 'configuraciones.coberturas.delete',   'label' => 'Eliminar Coberturas'],

            ['modulo' => 'Config - Servicios',       'name' => 'configuraciones.servicios.index',     'label' => 'Ver Servicios (catálogo)'],
            ['modulo' => 'Config - Servicios',       'name' => 'configuraciones.servicios.create',    'label' => 'Crear Servicios'],
            ['modulo' => 'Config - Servicios',       'name' => 'configuraciones.servicios.edit',      'label' => 'Editar Servicios'],
            ['modulo' => 'Config - Servicios',       'name' => 'configuraciones.servicios.delete',    'label' => 'Eliminar Servicios'],

            // ─── CRM - PROSPECTOS ─────────────────────────────────────────
            ['modulo' => 'CRM - Prospectos',         'name' => 'crm.prospectos.index',                'label' => 'Ver Prospectos'],
            ['modulo' => 'CRM - Prospectos',         'name' => 'crm.prospectos.create',               'label' => 'Crear Prospectos'],
            ['modulo' => 'CRM - Prospectos',         'name' => 'crm.prospectos.edit',                 'label' => 'Editar Prospectos'],
            ['modulo' => 'CRM - Prospectos',         'name' => 'crm.prospectos.delete',               'label' => 'Eliminar Prospectos'],

            // ─── CRM - OPORTUNIDADES ──────────────────────────────────────
            ['modulo' => 'CRM - Oportunidades',      'name' => 'crm.oportunidades.index',             'label' => 'Ver Oportunidades'],
            ['modulo' => 'CRM - Oportunidades',      'name' => 'crm.oportunidades.create',            'label' => 'Crear Oportunidades'],
            ['modulo' => 'CRM - Oportunidades',      'name' => 'crm.oportunidades.edit',              'label' => 'Editar Oportunidades'],
            ['modulo' => 'CRM - Oportunidades',      'name' => 'crm.oportunidades.delete',            'label' => 'Eliminar Oportunidades'],

            // ─── CRM - COTIZACIONES ───────────────────────────────────────
            ['modulo' => 'CRM - Cotizaciones',       'name' => 'crm.cotizaciones.index',              'label' => 'Ver Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',       'name' => 'crm.cotizaciones.create',             'label' => 'Crear Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',       'name' => 'crm.cotizaciones.edit',               'label' => 'Editar Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',       'name' => 'crm.cotizaciones.delete',             'label' => 'Eliminar Cotizaciones'],
            ['modulo' => 'CRM - Cotizaciones',       'name' => 'crm.cotizaciones.aprobar',            'label' => 'Aprobar Cotizaciones'],

            // ─── CRM - ACTIVIDADES ────────────────────────────────────────
            ['modulo' => 'CRM - Actividades',        'name' => 'crm.actividades.index',               'label' => 'Ver Actividades'],
            ['modulo' => 'CRM - Actividades',        'name' => 'crm.actividades.create',              'label' => 'Crear Actividades'],
            ['modulo' => 'CRM - Actividades',        'name' => 'crm.actividades.edit',                'label' => 'Editar Actividades'],
            ['modulo' => 'CRM - Actividades',        'name' => 'crm.actividades.delete',              'label' => 'Eliminar Actividades'],

            // ─── CRM - CLIENTES ───────────────────────────────────────────
            ['modulo' => 'CRM - Clientes',           'name' => 'crm.clientes.index',                  'label' => 'Ver Clientes'],
            ['modulo' => 'CRM - Clientes',           'name' => 'crm.clientes.create',                 'label' => 'Crear Clientes'],
            ['modulo' => 'CRM - Clientes',           'name' => 'crm.clientes.edit',                   'label' => 'Editar Clientes'],
            ['modulo' => 'CRM - Clientes',           'name' => 'crm.clientes.delete',                 'label' => 'Eliminar Clientes'],

            // ─── CRM - TICKETS ────────────────────────────────────────────
            ['modulo' => 'CRM - Tickets',            'name' => 'crm.tickets.index',                   'label' => 'Ver Tickets'],
            ['modulo' => 'CRM - Tickets',            'name' => 'crm.tickets.create',                  'label' => 'Crear Tickets'],
            ['modulo' => 'CRM - Tickets',            'name' => 'crm.tickets.edit',                    'label' => 'Editar Tickets'],
            ['modulo' => 'CRM - Tickets',            'name' => 'crm.tickets.delete',                  'label' => 'Eliminar Tickets'],
            ['modulo' => 'CRM - Tickets',            'name' => 'crm.tickets.resolver',                'label' => 'Resolver Tickets'],
            ['modulo' => 'CRM - Tickets',            'name' => 'crm.tickets.ver-todos',               'label' => 'Ver Todos los Tickets (supervisión)'],

            // ─── CRM - MANTENIMIENTOS ─────────────────────────────────────
            ['modulo' => 'CRM - Mantenimientos',     'name' => 'crm.mantenimientos.index',            'label' => 'Ver Mantenimientos'],
            ['modulo' => 'CRM - Mantenimientos',     'name' => 'crm.mantenimientos.edit',             'label' => 'Editar Mantenimientos'],
            ['modulo' => 'CRM - Mantenimientos',     'name' => 'crm.mantenimientos.delete',           'label' => 'Eliminar Mantenimientos'],
            ['modulo' => 'CRM - Mantenimientos',     'name' => 'crm.mantenimientos.ver-todos',        'label' => 'Ver Todos los Mantenimientos (supervisión)'],

            // ─── VENTAS - PEDIDOS ─────────────────────────────────────────
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.index',                'label' => 'Ver Pedidos'],
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.create',               'label' => 'Crear Pedidos'],
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.edit',                 'label' => 'Editar Pedidos'],
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.delete',               'label' => 'Eliminar Pedidos'],
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.aprobar-finanzas',     'label' => 'Aprobar Pedidos (Finanzas)'],
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.aprobar-stock',        'label' => 'Aprobar Pedidos (Stock)'],
            ['modulo' => 'Ventas - Pedidos',         'name' => 'ventas.pedidos.generar-comprobante',  'label' => 'Generar Comprobante de Pedido'],

            // ─── VENTAS - VENTAS ──────────────────────────────────────────
            ['modulo' => 'Ventas - Ventas',          'name' => 'ventas.ventas.index',                 'label' => 'Ver Ventas'],
            ['modulo' => 'Ventas - Ventas',          'name' => 'ventas.ventas.create',                'label' => 'Crear Ventas'],
            ['modulo' => 'Ventas - Ventas',          'name' => 'ventas.ventas.edit',                  'label' => 'Editar Ventas'],
            ['modulo' => 'Ventas - Ventas',          'name' => 'ventas.ventas.delete',                'label' => 'Eliminar Ventas'],
            ['modulo' => 'Ventas - Ventas',          'name' => 'ventas.ventas.enviar-email',          'label' => 'Enviar Comprobante por Email'],

            // ─── COMPRAS - ÓRDENES DE COMPRA (BIENES) ─────────────────────
            ['modulo' => 'Compras - Órdenes Compra', 'name' => 'compras.ordencompras.index',          'label' => 'Ver Órdenes de Compra'],
            ['modulo' => 'Compras - Órdenes Compra', 'name' => 'compras.ordencompras.create',         'label' => 'Crear Órdenes de Compra'],
            ['modulo' => 'Compras - Órdenes Compra', 'name' => 'compras.ordencompras.edit',           'label' => 'Editar Órdenes de Compra'],
            ['modulo' => 'Compras - Órdenes Compra', 'name' => 'compras.ordencompras.delete',         'label' => 'Eliminar Órdenes de Compra'],

            // ─── COMPRAS - ÓRDENES DE SERVICIO ────────────────────────────
            ['modulo' => 'Compras - Órdenes Serv.',  'name' => 'compras.ordenservicios.index',        'label' => 'Ver Órdenes de Servicio'],
            ['modulo' => 'Compras - Órdenes Serv.',  'name' => 'compras.ordenservicios.create',       'label' => 'Crear Órdenes de Servicio'],
            ['modulo' => 'Compras - Órdenes Serv.',  'name' => 'compras.ordenservicios.edit',         'label' => 'Editar Órdenes de Servicio'],
            ['modulo' => 'Compras - Órdenes Serv.',  'name' => 'compras.ordenservicios.delete',       'label' => 'Eliminar Órdenes de Servicio'],

            // ─── ALMACÉN - INGRESOS ───────────────────────────────────────
            ['modulo' => 'Almacén - Ingresos',       'name' => 'almacen.ingresos.index',              'label' => 'Ver Ingresos a Almacén'],
            ['modulo' => 'Almacén - Ingresos',       'name' => 'almacen.ingresos.create',             'label' => 'Registrar Ingreso a Almacén'],
            ['modulo' => 'Almacén - Ingresos',       'name' => 'almacen.ingresos.edit',               'label' => 'Editar Ingreso a Almacén'],
            ['modulo' => 'Almacén - Ingresos',       'name' => 'almacen.ingresos.delete',             'label' => 'Eliminar Ingreso a Almacén'],

            // ─── ALMACÉN - SALIDAS ────────────────────────────────────────
            ['modulo' => 'Almacén - Salidas',        'name' => 'almacen.salidas.index',               'label' => 'Ver Salidas de Almacén'],
            ['modulo' => 'Almacén - Salidas',        'name' => 'almacen.salidas.create',              'label' => 'Registrar Salida de Almacén'],
            ['modulo' => 'Almacén - Salidas',        'name' => 'almacen.salidas.edit',                'label' => 'Editar Salida de Almacén'],
            ['modulo' => 'Almacén - Salidas',        'name' => 'almacen.salidas.delete',              'label' => 'Eliminar Salida de Almacén'],

            // ─── ALMACÉN - INVENTARIO ─────────────────────────────────────
            ['modulo' => 'Almacén - Inventario',     'name' => 'almacen.inventario.index',            'label' => 'Ver Inventario'],
            ['modulo' => 'Almacén - Inventario',     'name' => 'almacen.inventario.edit',             'label' => 'Ajustar Inventario'],

            // ─── FINANZAS - CUENTAS BANCARIAS ─────────────────────────────
            ['modulo' => 'Finanzas - Cuentas',       'name' => 'finanzas.cuentasbancarias.index',     'label' => 'Ver Cuentas Bancarias'],
            ['modulo' => 'Finanzas - Cuentas',       'name' => 'finanzas.cuentasbancarias.create',    'label' => 'Crear Cuentas Bancarias'],

            // ─── FINANZAS - COBROS ────────────────────────────────────────
            ['modulo' => 'Finanzas - Cobros',        'name' => 'finanzas.cobros.index',               'label' => 'Ver Cobros'],
            ['modulo' => 'Finanzas - Cobros',        'name' => 'finanzas.cobros.registrar',           'label' => 'Registrar Cobro'],

            // ─── FINANZAS - PAGOS ─────────────────────────────────────────
            ['modulo' => 'Finanzas - Pagos',         'name' => 'finanzas.pagos.index',                'label' => 'Ver Pagos a Proveedores'],
            ['modulo' => 'Finanzas - Pagos',         'name' => 'finanzas.pagos.registrar',            'label' => 'Registrar Pago a Proveedor'],

            // ─── FINANZAS - CAJA CHICA ────────────────────────────────────
            ['modulo' => 'Finanzas - Caja Chica',    'name' => 'finanzas.caja-chica.index',           'label' => 'Ver Caja Chica'],
            ['modulo' => 'Finanzas - Caja Chica',    'name' => 'finanzas.caja-chica.create',          'label' => 'Abrir Caja Chica'],
            ['modulo' => 'Finanzas - Caja Chica',    'name' => 'finanzas.caja-chica.cerrar',          'label' => 'Cerrar Caja Chica'],

            // ─── FINANZAS - COMPROBANTES ──────────────────────────────────
            ['modulo' => 'Finanzas - Comprobantes',  'name' => 'finanzas.comprobantes.index',         'label' => 'Ver Comprobantes Electrónicos'],

            // ─── FINANZAS - NOTAS DE VENTA ────────────────────────────────
            ['modulo' => 'Finanzas - Notas',         'name' => 'finanzas.notas-ventas.index',         'label' => 'Ver Notas de Crédito/Débito'],
            ['modulo' => 'Finanzas - Notas',         'name' => 'finanzas.notas-ventas.create',        'label' => 'Crear Notas de Crédito/Débito'],
            ['modulo' => 'Finanzas - Notas',         'name' => 'finanzas.notas-ventas.anular',        'label' => 'Anular Notas de Crédito/Débito'],

            // ─── OPERACIONES - ASIGNACIONES ───────────────────────────────
            ['modulo' => 'Operaciones - Asignac.',   'name' => 'operaciones.asignaciones.index',      'label' => 'Ver Tablero de Asignaciones'],
            ['modulo' => 'Operaciones - Asignac.',   'name' => 'operaciones.asignaciones.asignar',    'label' => 'Asignar Pedido a Técnico'],

            // ─── OPERACIONES - CONTROL DE CALIDAD ─────────────────────────
            ['modulo' => 'Operaciones - Calidad',    'name' => 'operaciones.calidad.index',           'label' => 'Ver Control de Calidad'],
            ['modulo' => 'Operaciones - Calidad',    'name' => 'operaciones.calidad.aprobar',         'label' => 'Aprobar Control de Calidad'],
            ['modulo' => 'Operaciones - Calidad',    'name' => 'operaciones.calidad.rechazar',        'label' => 'Rechazar Control de Calidad'],

            // ─── OPERACIONES - TRAZABILIDAD ───────────────────────────────
            ['modulo' => 'Operaciones - Trazab.',    'name' => 'operaciones.trazabilidad.index',      'label' => 'Ver Trazabilidad'],

            // ─── OPERACIONES - CAMPAÑAS ───────────────────────────────────
            ['modulo' => 'Operaciones - Campañas',   'name' => 'operaciones.campanias.index',         'label' => 'Ver Campañas'],
            ['modulo' => 'Operaciones - Campañas',   'name' => 'operaciones.campanias.create',        'label' => 'Crear Campañas'],
            ['modulo' => 'Operaciones - Campañas',   'name' => 'operaciones.campanias.edit',          'label' => 'Editar Campañas'],
            ['modulo' => 'Operaciones - Campañas',   'name' => 'operaciones.campanias.delete',        'label' => 'Eliminar Campañas'],
            ['modulo' => 'Operaciones - Campañas',   'name' => 'operaciones.campanias.gestionar',     'label' => 'Gestionar Campañas (activar/pausar/finalizar)'],

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

        // Limpiar caché de Spatie para que los nuevos permisos sean reconocidos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ ' . count($permisos) . ' permisos creados correctamente.');
    }
}
