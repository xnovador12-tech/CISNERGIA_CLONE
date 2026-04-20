<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class admin_RolesController extends Controller
{
    /**
     * Roles considerados del sistema — no pueden eliminarse ni renombrarse.
     *
     * - Gerencia y Administrador: protegidos para garantizar que siempre
     *   haya acceso administrativo al panel.
     * - Cliente: rol técnico del ecommerce, no debe ser visible ni
     *   administrable desde el panel. No aparece en el listado y no se
     *   puede editar ni eliminar por URL directa.
     */
    private const ROLES_SISTEMA = ['Gerencia', 'Administrador', 'Cliente'];

    /**
     * Roles que se ocultan del listado admin-roles (no aparecen en la UI).
     * El rol "Cliente" se oculta porque es técnico del ecommerce y no
     * tiene sentido que los empleados lo vean o intenten editarlo.
     */
    private const ROLES_OCULTOS = ['Cliente'];

    /**
     * Lista de roles con conteo de usuarios y permisos.
     * Usa Route Model Binding por slug (Role::getRouteKeyName = 'slug').
     *
     * EXCLUYE roles ocultos (ej: "Cliente") que no deben verse en la UI.
     */
    public function index()
    {
        $roles = Role::withCount('users')
            ->whereNotIn('name', self::ROLES_OCULTOS)
            ->orderBy('id')
            ->get();

        $stats = [
            'total'   => $roles->count(),
            'activos' => $roles->where('estado', 'Activo')->count(),
        ];

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.roles.index',
            compact('roles', 'stats'));
    }

    public function create()
    {
        // Permisos agrupados por módulo para los checkboxes
        $permisosAgrupados = $this->permisosAgrupadosPorArea();
        $iconosModulo = $this->iconosModulo();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.roles.create',
            compact('permisosAgrupados', 'iconosModulo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:roles,name'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'estado'      => ['required', Rule::in(['Activo', 'Inactivo'])],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique'   => 'Ya existe un rol con ese nombre.',
        ]);

        $role = Role::create([
            'name'        => $request->name,
            'guard_name'  => 'web',
            'descripcion' => $request->descripcion,
            'estado'      => $request->estado,
            // slug generado automáticamente por el modelo (boot)
        ]);

        // Asignar permisos seleccionados.
        // IMPORTANTE: el form envía IDs (ej: ["1","2","3"]), pero syncPermissions()
        // de Spatie espera NOMBRES o INSTANCIAS de Permission. Si pasamos IDs
        // directamente, Spatie los interpreta como nombres y lanza
        // PermissionDoesNotExist. Por eso primero convertimos los IDs a modelos.
        if ($request->filled('permissions')) {
            $permisos = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permisos);
        }

        return redirect()->route('admin-roles.index')
            ->with('new_registration', 'ok');
    }

    public function edit(Role $admin_role)
    {
        // Los roles ocultos (ej: Cliente) no pueden editarse desde la UI,
        // ni siquiera ingresando la URL directa /admin-roles/cliente/edit.
        // Esto previene que alguien le asigne por error permisos admin a
        // todos los clientes del ecommerce.
        if (in_array($admin_role->name, self::ROLES_OCULTOS)) {
            return redirect()->route('admin-roles.index')
                ->with('error_msg', 'El rol "' . $admin_role->name . '" es del sistema y no puede editarse.');
        }

        $permisosAgrupados = $this->permisosAgrupadosPorArea();
        $iconosModulo = $this->iconosModulo();

        // IDs de permisos que ya tiene este rol
        $permisosAsignados = $admin_role->permissions->pluck('id')->toArray();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.roles.edit',
            compact('admin_role', 'permisosAgrupados', 'permisosAsignados', 'iconosModulo'));
    }

    public function update(Request $request, Role $admin_role)
    {
        // Bloquear updates a roles ocultos (defensa ante envío POST directo).
        if (in_array($admin_role->name, self::ROLES_OCULTOS)) {
            return redirect()->route('admin-roles.index')
                ->with('error_msg', 'El rol "' . $admin_role->name . '" es del sistema y no puede modificarse.');
        }

        $request->validate([
            'name'        => ['required', 'string', 'max:100',
                              Rule::unique('roles', 'name')->ignore($admin_role->id)],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'estado'      => ['required', Rule::in(['Activo', 'Inactivo'])],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique'   => 'Ya existe un rol con ese nombre.',
        ]);

        // PROTECCIÓN 1: no permitir renombrar los roles del sistema.
        // Si cambiaran el name, los hasRole('Gerencia') / hasRole('Administrador')
        // en el código dejarían de funcionar.
        if (in_array($admin_role->name, self::ROLES_SISTEMA) && $request->name !== $admin_role->name) {
            return back()
                ->withInput()
                ->with('error_msg', 'No se puede renombrar el rol del sistema "' . $admin_role->name . '".');
        }

        // PROTECCIÓN 2: evitar el auto-bloqueo.
        // Si el usuario actual tiene este rol y está a punto de quitarle el
        // permiso de editar roles, bloquear la acción — se quedaría sin
        // poder entrar a esta pantalla después.
        $permisosSeleccionados = $request->permissions ?? [];
        $tieneEsteRol = auth()->user()->hasRole($admin_role->name);
        $permisoEditRoles = Permission::where('name', 'configuraciones.roles.edit')->first();

        if ($tieneEsteRol && $permisoEditRoles && !in_array($permisoEditRoles->id, $permisosSeleccionados)) {
            return back()
                ->withInput()
                ->with('error_msg', 'No puedes quitarte a ti mismo el permiso "Editar Roles" — te quedarías bloqueado. Pide a otro usuario con rol de Gerencia que te lo reasigne si es necesario.');
        }

        $admin_role->update([
            'name'        => $request->name,
            'descripcion' => $request->descripcion,
            'estado'      => $request->estado,
        ]);

        // Sincronizar permisos (reemplaza los anteriores).
        // IMPORTANTE: el form envía IDs (ej: ["1","2","3"]), pero syncPermissions()
        // de Spatie espera NOMBRES o INSTANCIAS de Permission. Si pasamos IDs
        // directamente, Spatie los interpreta como nombres y lanza
        // PermissionDoesNotExist. Por eso primero convertimos los IDs a modelos.
        $permisos = !empty($permisosSeleccionados)
            ? Permission::whereIn('id', $permisosSeleccionados)->get()
            : [];
        $admin_role->syncPermissions($permisos);

        return redirect()->route('admin-roles.index')
            ->with('update', 'ok');
    }

    public function destroy(Role $admin_role)
    {
        // PROTECCIÓN 1: no permitir eliminar roles del sistema
        if (in_array($admin_role->name, self::ROLES_SISTEMA)) {
            return redirect()->route('admin-roles.index')
                ->with('error_msg', 'No se puede eliminar el rol del sistema "' . $admin_role->name . '".');
        }

        // No permitir eliminar roles con usuarios asignados
        if ($admin_role->users()->count() > 0) {
            return redirect()->route('admin-roles.index')
                ->with('error', 'ok');
        }

        $admin_role->delete();

        return redirect()->route('admin-roles.index')
            ->with('delete', 'ok');
    }

    /**
     * Retorna los permisos agrupados por módulo, respetando un ORDEN LÓGICO
     * por áreas operativas de la empresa:
     *
     *   1. Dashboard y Reportes (general)
     *   2. CRM (7 submódulos: Prospectos, Oportunidades, Cotizaciones, Actividades,
     *      Clientes, Tickets, Mantenimientos)
     *   3. Ventas (Pedidos, Ventas)
     *   4. Compras (Órdenes)
     *   5. Almacén (Ingresos, Salidas, Inventario)
     *   6. Finanzas (Cobros, Pagos, Caja Chica, Comprobantes, Notas, Cuentas)
     *   7. Operaciones (Asignaciones, Calidad, Trazabilidad, Campañas)
     *   8. Configuraciones - Acceso (Roles, Usuarios)
     *   9. Configuraciones - Catálogo (Tipos, Modelos, Categorías, Marcas, Productos,
     *      Proveedores, Servicios, Kits, Coberturas, Descuentos, Cupones, Etiquetas)
     *
     * Esto es más intuitivo para Gerencia que el orden alfabético por defecto
     * (que mezclaba Almacén → CRM → Config → Dashboard → Finanzas...).
     *
     * Si mañana se agregan permisos con un módulo nuevo que NO está en la lista,
     * se muestran al final sin romper nada (orderBy('label') como fallback).
     */
    private function permisosAgrupadosPorArea()
    {
        // Orden lógico de módulos — los que no estén aquí se muestran al final.
        $ordenModulos = [
            // General
            'Dashboard',
            'Reportes',

            // CRM
            'CRM - Prospectos',
            'CRM - Oportunidades',
            'CRM - Cotizaciones',
            'CRM - Actividades',
            'CRM - Clientes',
            'CRM - Tickets',
            'CRM - Mantenimientos',

            // Ventas
            'Ventas - Pedidos',
            'Ventas - Ventas',

            // Compras
            'Compras - Órdenes Compra',
            'Compras - Órdenes Serv.',

            // Almacén
            'Almacén - Ingresos',
            'Almacén - Salidas',
            'Almacén - Inventario',

            // Finanzas
            'Finanzas - Cobros',
            'Finanzas - Pagos',
            'Finanzas - Caja Chica',
            'Finanzas - Comprobantes',
            'Finanzas - Notas',
            'Finanzas - Cuentas',

            // Operaciones
            'Operaciones - Asignac.',
            'Operaciones - Calidad',
            'Operaciones - Trazab.',
            'Operaciones - Campañas',

            // Configuraciones - Acceso
            'Config - Roles',
            'Config - Usuarios',

            // Configuraciones - Catálogo
            'Config - Tipos',
            'Config - Modelos',
            'Config - Categorías',
            'Config - Marcas',
            'Config - Productos',
            'Config - Proveedores',
            'Config - Servicios',
            'Config - Kits',
            'Config - Coberturas',
            'Config - Descuentos',
            'Config - Cupones',
            'Config - Etiquetas',
        ];

        // Obtener todos los permisos agrupados por módulo, orden interno por label
        $permisos = Permission::orderBy('label')->get()->groupBy('modulo');

        // Reordenar según el array $ordenModulos, dejando al final los no listados
        $ordenados = collect();
        foreach ($ordenModulos as $modulo) {
            if ($permisos->has($modulo)) {
                $ordenados->put($modulo, $permisos->get($modulo));
            }
        }
        // Agregar módulos que existan en BD pero no estén en el orden manual
        foreach ($permisos as $modulo => $perms) {
            if (!$ordenados->has($modulo)) {
                $ordenados->put($modulo, $perms);
            }
        }

        return $ordenados;
    }

    /**
     * Retorna el mapeo módulo → icono Bootstrap Icons para la UI de permisos.
     *
     * Se centraliza acá para que las vistas create y edit usen la misma fuente
     * (antes estaba duplicado en cada blade, con riesgo de desincronización).
     *
     * Si se agrega un permiso con módulo nuevo no listado aquí, la vista cae
     * al icono de fallback 'bi-circle' (no rompe nada).
     */
    private function iconosModulo(): array
    {
        return [
            // General
            'Dashboard'                 => 'bi-speedometer2',
            'Reportes'                  => 'bi-bar-chart',

            // CRM
            'CRM - Prospectos'          => 'bi-person-plus',
            'CRM - Oportunidades'       => 'bi-graph-up-arrow',
            'CRM - Cotizaciones'        => 'bi-file-earmark-text',
            'CRM - Actividades'         => 'bi-calendar-check',
            'CRM - Clientes'            => 'bi-people',
            'CRM - Tickets'             => 'bi-ticket-perforated',
            'CRM - Mantenimientos'      => 'bi-tools',

            // Ventas
            'Ventas - Pedidos'          => 'bi-cart3',
            'Ventas - Ventas'           => 'bi-bag-check',

            // Compras
            'Compras - Órdenes Compra'  => 'bi-truck',
            'Compras - Órdenes Serv.'   => 'bi-clipboard-check',

            // Almacén
            'Almacén - Ingresos'        => 'bi-box-arrow-in-down',
            'Almacén - Salidas'         => 'bi-box-arrow-up',
            'Almacén - Inventario'      => 'bi-box-seam',

            // Finanzas
            'Finanzas - Cobros'         => 'bi-cash-coin',
            'Finanzas - Pagos'          => 'bi-credit-card',
            'Finanzas - Caja Chica'     => 'bi-wallet2',
            'Finanzas - Comprobantes'   => 'bi-receipt',
            'Finanzas - Notas'          => 'bi-journal-text',
            'Finanzas - Cuentas'        => 'bi-bank',

            // Operaciones
            'Operaciones - Asignac.'    => 'bi-person-check',
            'Operaciones - Calidad'     => 'bi-patch-check',
            'Operaciones - Trazab.'     => 'bi-diagram-3',
            'Operaciones - Campañas'    => 'bi-megaphone',

            // Configuraciones - Acceso
            'Config - Roles'            => 'bi-shield-lock',
            'Config - Usuarios'         => 'bi-person-gear',

            // Configuraciones - Catálogo
            'Config - Tipos'            => 'bi-tags',
            'Config - Modelos'          => 'bi-diagram-2',
            'Config - Categorías'       => 'bi-folder',
            'Config - Marcas'           => 'bi-bookmark-star',
            'Config - Productos'        => 'bi-box',
            'Config - Proveedores'      => 'bi-building',
            'Config - Servicios'        => 'bi-wrench-adjustable',
            'Config - Kits'             => 'bi-boxes',
            'Config - Coberturas'       => 'bi-geo-alt',
            'Config - Descuentos'       => 'bi-percent',
            'Config - Cupones'          => 'bi-ticket',
            'Config - Etiquetas'        => 'bi-tag',
        ];
    }
}
