<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class admin_PerfilController extends Controller
{
    /**
     * Muestra la pantalla de perfil del usuario autenticado.
     *
     * Esta ruta NO requiere permiso de Spatie — cualquier autenticado
     * puede gestionar SU propio perfil. También sirve como fallback
     * cuando un usuario sin permisos intenta acceder al dashboard
     * (ver bootstrap/app.php y LoginController::authenticated()).
     */
    public function index()
    {
        $user    = Auth::user()->load('persona');
        $roles   = $user->getRoleNames();       // Colección de nombres de rol
        $permisos = $user->getAllPermissions(); // Colección de permisos efectivos

        return view('ADMINISTRADOR.PRINCIPAL.configuraciones.perfil.index', compact('user', 'roles', 'permisos'));
    }

    /**
     * Actualiza los datos personales del usuario autenticado
     * (nombre, apellidos, celular, dirección, etc.)
     *
     * El email NO se actualiza desde aquí por seguridad — eso lo hace
     * Gerencia desde el módulo de Usuarios.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'surnames'   => ['nullable', 'string', 'max:100'],
            'celular'    => ['nullable', 'string', 'max:20'],
            'direccion'  => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max'      => 'El nombre no puede tener más de 100 caracteres.',
        ]);

        // Actualizar sobre la persona asociada (User tiene persona_id)
        if ($user->persona) {
            $user->persona->update($data);
        }

        return redirect()->route('admin-perfil.index')
            ->with('update', 'ok');
    }

    /**
     * Actualiza la contraseña del usuario autenticado.
     *
     * Valida:
     *   - contraseña actual correcta
     *   - nueva contraseña cumple política (mínimo 8 caracteres)
     *   - confirmación coincide
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password_actual' => ['required', 'string'],
            'password'        => ['required', 'confirmed', Password::min(8)],
        ], [
            'password_actual.required' => 'Debes ingresar tu contraseña actual.',
            'password.required'        => 'Debes ingresar una nueva contraseña.',
            'password.confirmed'       => 'La confirmación de contraseña no coincide.',
            'password.min'             => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        // Verificar contraseña actual
        if (! Hash::check($request->password_actual, $user->password)) {
            return back()
                ->withErrors(['password_actual' => 'La contraseña actual es incorrecta.'])
                ->with('password_error', 'ok');
        }

        // Actualizar
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin-perfil.index')
            ->with('password_update', 'ok');
    }
}
