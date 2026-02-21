<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Prospecto;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Mostrar formulario de registro con distritos
     */
    public function showRegistrationForm()
    {
        $distritos = \App\Models\Distrito::orderBy('nombre')->get();
        return view('auth.register', compact('distritos'));
    }

    /**
     * Validación del formulario de registro
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'         => ['required', 'string', 'max:255'],
            'surnames'     => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'celular'      => ['required', 'string', 'max:20'],
            'direccion'    => ['nullable', 'string', 'max:255'],
            'distrito_id'  => ['nullable', 'exists:distritos,id'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'El nombre es obligatorio.',
            'surnames.required'  => 'Los apellidos son obligatorios.',
            'email.required'     => 'El correo electrónico es obligatorio.',
            'email.unique'       => 'Este correo ya está registrado.',
            'celular.required'   => 'El número de celular es obligatorio.',
            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);
    }

    /**
     * Crear usuario al registrarse.
     *
     * Flujo:
     * 1. Crear Persona con los datos del formulario
     * 2. Crear User con rol Cliente (ID 6)
     *    → El UserObserver (ya existente) crea el Prospecto automáticamente
     * 3. Actualizar el Prospecto con campos adicionales del formulario
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            // 1. Crear Persona
            $persona = Persona::create([
                'name'           => $data['name'],
                'slug'           => Str::slug($data['name'] . '-' . Str::random(5)),
                'surnames'       => $data['surnames'],
                'email_pnatural' => $data['email'],
                'celular'        => $data['celular'],
                'direccion'      => $data['direccion'] ?? null,
                'tipo_persona'   => 'Natural',
                'registrado_por' => 'ecommerce',
                'sede_id'        => 1, // Sede Central
            ]);

            // 2. Crear User → el UserObserver crea el Prospecto automáticamente
            $user = User::create([
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'estado'     => 'Activo',
                'role_id'    => 6, // Rol Cliente
                'persona_id' => $persona->id,
            ]);

            // 3. Complementar el Prospecto con datos extra del formulario
            $prospecto = Prospecto::where('registered_user_id', $user->id)->first();
            if ($prospecto) {
                $prospecto->update([
                    'distrito_id'   => $data['distrito_id'] ?? null,
                    'tipo_interes'  => 'producto',
                    'segmento'      => 'residencial',
                    'nivel_interes' => 'bajo',
                ]);
            }

            return $user;
        });
    }
}
