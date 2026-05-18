<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Asignación inicial de permisos a roles.
     *
     * POLÍTICA:
     *   Cada rol arranca con un conjunto base de permisos según la
     *   operación típica de Cisnergia. El cliente (Gerencia) puede
     *   ajustar cada rol desde la UI /admin-roles/{slug}/edit.
     *
     *   - Gerencia y Administrador  → TODOS los permisos (incluye dashboard)
     *   - Ventas                    → CRM completo + Pedidos/Ventas + consultas
     *   - Finanzas                  → Finanzas completo + Pedidos/Ventas (aprobar) + reportes
     *   - Compras                   → Órdenes de compra/servicio + proveedores + consultas
     *   - Almacen                   → Ingresos/Salidas/Inventario + aprobar-stock
     *   - Operaciones               → Operaciones completo + tickets/mantenimientos
     *   - Tecnico                   → Solo tickets y mantenimientos
     *   - Cliente                   → Ninguno (solo ecommerce, no accede al admin)
     *
     * IMPORTANTE - Acceso al dashboard:
     *   Solo Gerencia y Administrador tienen 'dashboard.index'. Los demás
     *   roles NO ven el dashboard (es una vista directiva/gerencial con
     *   métricas globales de negocio). Al iniciar sesión, los roles sin
     *   este permiso son redirigidos a /admin-perfil por LoginController
     *   y acceden a sus módulos directamente desde el sidebar.
     *
     *   Si el cliente quiere que otro rol vea el dashboard, solo debe
     *   asignarle 'dashboard.index' desde la UI de roles.
     *
     * IDEMPOTENTE: syncPermissions reemplaza los permisos existentes, así que
     * se puede correr múltiples veces sin duplicar.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ═══════════════════════════════════════════════════════════════
        // GERENCIA y ADMINISTRADOR: todos los permisos
        // ═══════════════════════════════════════════════════════════════
        $todosLosPermisos = Permission::all();

        Role::where('name', 'Gerencia')->first()
            ?->syncPermissions($todosLosPermisos);

        Role::where('name', 'Administrador')->first()
            ?->syncPermissions($todosLosPermisos);

        // ═══════════════════════════════════════════════════════════════
        // VENTAS: CRM completo + Pedidos/Ventas + consultas básicas
        // ═══════════════════════════════════════════════════════════════
        $permisosVentas = [
            'perfil.edit',

            // CRM completo
            'crm.prospectos.index', 'crm.prospectos.create', 'crm.prospectos.edit', 'crm.prospectos.delete',
            'crm.oportunidades.index', 'crm.oportunidades.create', 'crm.oportunidades.edit', 'crm.oportunidades.delete',
            'crm.cotizaciones.index', 'crm.cotizaciones.create', 'crm.cotizaciones.edit', 'crm.cotizaciones.delete', 'crm.cotizaciones.aprobar',
            'crm.actividades.index', 'crm.actividades.create', 'crm.actividades.edit', 'crm.actividades.delete',
            'crm.clientes.index', 'crm.clientes.create', 'crm.clientes.edit',
            'crm.tickets.index', 'crm.tickets.create', 'crm.tickets.edit',
            'crm.mantenimientos.index', 'crm.mantenimientos.edit',

            // Ventas - Pedidos y Ventas (sin eliminar)
            'ventas.pedidos.index', 'ventas.pedidos.create', 'ventas.pedidos.edit',
            'ventas.ventas.index', 'ventas.ventas.create', 'ventas.ventas.enviar-email',

            // Consultas de catálogo (necesarias para cotizar)
            'configuraciones.productos.index',
            'configuraciones.proveedores.index',
            'configuraciones.coberturas.index',
            'configuraciones.servicios.index',
            'configuraciones.kits.index',
            'configuraciones.descuentos.index',
            'configuraciones.cupones.index',
        ];
        $this->asignar('Ventas', $permisosVentas);

        // ═══════════════════════════════════════════════════════════════
        // FINANZAS: Cobros/Pagos/CajaChica + aprobar pedidos + reportes
        // ═══════════════════════════════════════════════════════════════
        $permisosFinanzas = [
            'perfil.edit',
            'reportes.index',

            // Ventas - supervisión y aprobación
            'ventas.pedidos.index', 'ventas.pedidos.aprobar-finanzas', 'ventas.pedidos.generar-comprobante',
            'ventas.ventas.index', 'ventas.ventas.edit', 'ventas.ventas.enviar-email',

            // Finanzas completo
            'finanzas.cuentasbancarias.index', 'finanzas.cuentasbancarias.create',
            'finanzas.cobros.index', 'finanzas.cobros.registrar',
            'finanzas.pagos.index', 'finanzas.pagos.registrar',
            'finanzas.caja-chica.index', 'finanzas.caja-chica.create', 'finanzas.caja-chica.cerrar',
            'finanzas.comprobantes.index',
            'finanzas.notas-ventas.index', 'finanzas.notas-ventas.create', 'finanzas.notas-ventas.anular',

            // Consultas CRM (para reconciliar cobros con clientes)
            'crm.clientes.index',
            'crm.cotizaciones.index',
        ];
        $this->asignar('Finanzas', $permisosFinanzas);

        // ═══════════════════════════════════════════════════════════════
        // COMPRAS: Órdenes de compra y servicio + proveedores
        // ═══════════════════════════════════════════════════════════════
        $permisosCompras = [
            'perfil.edit',

            // Compras completo
            'compras.ordencompras.index', 'compras.ordencompras.create', 'compras.ordencompras.edit', 'compras.ordencompras.delete',
            'compras.ordenservicios.index', 'compras.ordenservicios.create', 'compras.ordenservicios.edit', 'compras.ordenservicios.delete',

            // Proveedores (gestión completa)
            'configuraciones.proveedores.index', 'configuraciones.proveedores.create', 'configuraciones.proveedores.edit',

            // Consulta productos (para órdenes de compra)
            'configuraciones.productos.index',

            // Pagos a proveedores (consulta)
            'finanzas.pagos.index',
        ];
        $this->asignar('Compras', $permisosCompras);

        // ═══════════════════════════════════════════════════════════════
        // ALMACEN: Ingresos/Salidas/Inventario + aprobar stock
        // ═══════════════════════════════════════════════════════════════
        $permisosAlmacen = [
            'perfil.edit',

            // Almacén completo
            'almacen.ingresos.index', 'almacen.ingresos.create', 'almacen.ingresos.edit', 'almacen.ingresos.delete',
            'almacen.salidas.index', 'almacen.salidas.create', 'almacen.salidas.edit', 'almacen.salidas.delete',
            'almacen.inventario.index', 'almacen.inventario.edit',

            // Pedidos - supervisión y aprobación de stock
            'ventas.pedidos.index', 'ventas.pedidos.aprobar-stock',

            // Consulta productos y órdenes de compra
            'configuraciones.productos.index',
            'compras.ordencompras.index',
        ];
        $this->asignar('Almacen', $permisosAlmacen);

        // ═══════════════════════════════════════════════════════════════
        // OPERACIONES: Asignaciones/Calidad/Trazabilidad/Campañas + tickets
        // ═══════════════════════════════════════════════════════════════
        $permisosOperaciones = [
            'perfil.edit',

            // Operaciones completo
            'operaciones.asignaciones.index', 'operaciones.asignaciones.asignar',
            'operaciones.calidad.index', 'operaciones.calidad.aprobar', 'operaciones.calidad.rechazar',
            'operaciones.trazabilidad.index',
            'operaciones.campanias.index', 'operaciones.campanias.create', 'operaciones.campanias.edit', 'operaciones.campanias.delete', 'operaciones.campanias.gestionar',

            // Supervisión pedidos
            'ventas.pedidos.index',

            // CRM - Tickets y Mantenimientos (Operaciones supervisa técnicos)
            'crm.tickets.index', 'crm.tickets.edit', 'crm.tickets.resolver',
            'crm.tickets.ver-todos',   // Operaciones supervisa todos los tickets
            'crm.mantenimientos.index', 'crm.mantenimientos.edit',
            'crm.mantenimientos.ver-todos',   // Operaciones supervisa todos los mantenimientos
            'crm.clientes.index',
        ];
        $this->asignar('Operaciones', $permisosOperaciones);

        // ═══════════════════════════════════════════════════════════════
        // TECNICO: Solo tickets y mantenimientos (personal de campo)
        // ═══════════════════════════════════════════════════════════════
        $permisosTecnico = [
            'perfil.edit',

            'crm.tickets.index', 'crm.tickets.edit',
            'crm.mantenimientos.index', 'crm.mantenimientos.edit',
        ];
        $this->asignar('Tecnico', $permisosTecnico);

        // ═══════════════════════════════════════════════════════════════
        // CLIENTE: Ninguno (solo ecommerce, no accede al admin)
        // ═══════════════════════════════════════════════════════════════
        Role::where('name', 'Cliente')->first()?->syncPermissions([]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Permisos asignados a los 9 roles según su operación base.');
        $this->command->info('   Gerencia y Administrador: ' . $todosLosPermisos->count() . ' permisos (todos)');
        $this->command->info('   Ventas: ' . count($permisosVentas) . ' permisos');
        $this->command->info('   Finanzas: ' . count($permisosFinanzas) . ' permisos');
        $this->command->info('   Compras: ' . count($permisosCompras) . ' permisos');
        $this->command->info('   Almacen: ' . count($permisosAlmacen) . ' permisos');
        $this->command->info('   Operaciones: ' . count($permisosOperaciones) . ' permisos');
        $this->command->info('   Tecnico: ' . count($permisosTecnico) . ' permisos');
        $this->command->info('   Cliente: 0 permisos (solo ecommerce)');
    }

    /**
     * Helper para asignar permisos a un rol por nombre.
     * Solo asigna los permisos que existen en BD (ignora silenciosamente
     * los que no, por si el PermissionSeeder cambió).
     */
    private function asignar(string $nombreRol, array $nombresPermisos): void
    {
        $role = Role::where('name', $nombreRol)->first();
        if (! $role) {
            $this->command->warn("⚠ Rol '{$nombreRol}' no existe — se omite asignación.");
            return;
        }

        $permisos = Permission::whereIn('name', $nombresPermisos)->get();
        $role->syncPermissions($permisos);
    }
}
