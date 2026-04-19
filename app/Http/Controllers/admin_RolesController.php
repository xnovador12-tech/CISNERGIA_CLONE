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
        $permisosAgrupados = Permission::orderBy('modulo')->orderBy('label')
            ->get()
            ->groupBy('modulo');

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.roles.create',
            compact('permisosAgrupados'));
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

        $permisosAgrupados = Permission::orderBy('modulo')->orderBy('label')
            ->get()
            ->groupBy('modulo');

        // IDs de permisos que ya tiene este rol
        $permisosAsignados = $admin_role->permissions->pluck('id')->toArray();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.roles.edit',
            compact('admin_role', 'permisosAgrupados', 'permisosAsignados'));
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
}
