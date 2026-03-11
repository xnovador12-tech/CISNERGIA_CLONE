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
     * Lista de roles con conteo de usuarios y permisos.
     * Usa Route Model Binding por slug (Role::getRouteKeyName = 'slug').
     */
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('id')->get();

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

        // Asignar permisos seleccionados
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin-roles.index')
            ->with('new_registration', 'ok');
    }

    public function edit(Role $admin_role)
    {
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
        $request->validate([
            'name'        => ['required', 'string', 'max:100',
                              Rule::unique('roles', 'name')->ignore($admin_role->id)],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'estado'      => ['required', Rule::in(['Activo', 'Inactivo'])],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique'   => 'Ya existe un rol con ese nombre.',
        ]);

        $admin_role->update([
            'name'        => $request->name,
            'descripcion' => $request->descripcion,
            'estado'      => $request->estado,
        ]);

        // Sincronizar permisos (reemplaza los anteriores)
        $admin_role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin-roles.index')
            ->with('update', 'ok');
    }

    public function destroy(Role $admin_role)
    {
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
