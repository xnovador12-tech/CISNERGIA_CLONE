<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class admin_UsuariosController extends Controller
{
    /**
     * Lista de usuarios del panel admin (excluye Clientes del ecommerce).
     */
    public function index()
    {
        $usuarios = User::with(['persona', 'roles'])
            ->whereDoesntHave('roles', fn($q) => $q->where('name', 'Cliente'))
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total'    => $usuarios->count(),
            'activos'  => $usuarios->where('estado', 'Activo')->count(),
            'inactivos'=> $usuarios->where('estado', 'Inactivo')->count(),
        ];

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.usuarios.index',
            compact('usuarios', 'stats'));
    }

    public function create()
    {
        // Todos los roles excepto Cliente (ecommerce)
        $roles = Role::where('name', '!=', 'Cliente')
            ->where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.usuarios.create',
            compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'surnames'   => ['nullable', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'celular'    => ['nullable', 'string', 'max:20'],
            'direccion'  => ['nullable', 'string', 'max:255'],
            'role_id'    => ['required', 'exists:roles,id'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'    => 'El nombre es obligatorio.',
            'email.required'   => 'El correo es obligatorio.',
            'email.unique'     => 'Este correo ya está en uso.',
            'role_id.required' => 'Debe seleccionar un rol.',
            'password.min'     => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',
        ]);

        $persona = Persona::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name . '-' . Str::random(5)),
            'surnames'    => $request->surnames,
            'celular'     => $request->celular,
            'direccion'   => $request->direccion,
            'tipo_persona'=> 'Empleado',
            'sede_id'     => 1,
        ]);

        $user = User::create([
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'estado'     => 'Activo',
            'persona_id' => $persona->id,
        ]);

        $role = Role::find($request->role_id);
        $user->assignRole($role->name);

        return redirect()->route('admin-usuarios.index')
            ->with('new_registration', 'ok');
    }

    public function show(User $admin_usuario)
    {
        $admin_usuario->load(['persona', 'roles.permissions']);

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.usuarios.show',
            compact('admin_usuario'));
    }

    public function edit(User $admin_usuario)
    {
        $roles = Role::where('name', '!=', 'Cliente')
            ->where('estado', 'Activo')
            ->orderBy('name')
            ->get();

        $rolActual = $admin_usuario->roles->first();

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.usuarios.edit',
            compact('admin_usuario', 'roles', 'rolActual'));
    }

    public function update(Request $request, User $admin_usuario)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'surnames'  => ['nullable', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255',
                            Rule::unique('users', 'email')->ignore($admin_usuario->id)],
            'celular'   => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'role_id'   => ['required', 'exists:roles,id'],
        ], [
            'name.required'    => 'El nombre es obligatorio.',
            'email.required'   => 'El correo es obligatorio.',
            'email.unique'     => 'Este correo ya está en uso.',
            'role_id.required' => 'Debe seleccionar un rol.',
        ]);

        // Actualizar persona
        $admin_usuario->persona->update([
            'name'      => $request->name,
            'surnames'  => $request->surnames,
            'celular'   => $request->celular,
            'direccion' => $request->direccion,
        ]);

        // Actualizar email
        $admin_usuario->update(['email' => $request->email]);

        // Cambiar contraseña solo si se envió
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $admin_usuario->update(['password' => Hash::make($request->password)]);
        }

        // Sincronizar rol
        $role = Role::find($request->role_id);
        $admin_usuario->syncRoles([$role->name]);

        return redirect()->route('admin-usuarios.index')
            ->with('update', 'ok');
    }

    public function destroy(User $admin_usuario)
    {
        // No permitir eliminar el usuario autenticado
        if ($admin_usuario->id === auth()->id()) {
            return redirect()->route('admin-usuarios.index')
                ->with('error', 'ok');
        }

        $admin_usuario->delete();

        return redirect()->route('admin-usuarios.index')
            ->with('delete', 'ok');
    }

    /**
     * Cambia el estado Activo ↔ Inactivo del usuario.
     * Ruta: PUT /admin-usuarios/estado/{admin_usuario}
     */
    public function estado(User $admin_usuario)
    {
        $admin_usuario->update([
            'estado' => $admin_usuario->estado === 'Activo' ? 'Inactivo' : 'Activo',
        ]);

        return redirect()->route('admin-usuarios.index')
            ->with('update', 'ok');
    }
}
