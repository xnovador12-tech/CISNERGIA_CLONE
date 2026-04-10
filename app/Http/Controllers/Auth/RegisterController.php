<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Prospecto;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Después del registro el cliente va al ecommerce.
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Mostrar formulario de registro con distritos.
     */
    public function showRegistrationForm()
    {
        $distritos = \App\Models\Distrito::orderBy('nombre')->get();
        return view('auth.register', compact('distritos'));
    }

    /**
     * Validación del formulario de registro público (ecommerce).
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'        => ['required', 'string', 'max:255'],
            'surnames'    => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'celular'     => ['required', 'string', 'max:20'],
            'direccion'   => ['nullable', 'string', 'max:255'],
            'distrito_id' => ['nullable', 'exists:distritos,id'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
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
     * Crear usuario al registrarse desde el ecommerce.
     *
     * Flujo:
     *   1. Crear Persona con los datos del formulario
     *   2. Crear User y asignar rol 'Cliente' con Spatie (assignRole)
     *   3. Llamar EXPLÍCITAMENTE a UserObserver::crearProspectoSiEsCliente()
     *      → Spatie's assignRole() NO dispara el evento 'updated' del modelo,
     *        por eso no podemos depender solo del Observer; lo invocamos a mano.
     *   4. Complementar el Prospecto recién creado con datos adicionales del formulario
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
                'sede_id'        => 1,
            ]);

            // 2. Crear User
            $user = User::create([
                'email'      => $data['email'],
                'password'   => Hash::make($data['password']),
                'estado'     => 'Activo',
                'persona_id' => $persona->id,
            ]);

            // 3. Asignar rol Cliente con Spatie
            $user->assignRole('Cliente');

            // 4. Crear el Prospecto explícitamente.
            // No podemos depender del UserObserver::updated() porque assignRole()
            // de Spatie trabaja directo sobre la tabla pivote model_has_roles
            // y NO dispara eventos de Eloquent en el modelo User.
            // El método es idempotente: si ya existe, lo retorna sin duplicar.
            $prospecto = UserObserver::crearProspectoSiEsCliente($user);

            // 5. Complementar el Prospecto con datos adicionales del formulario
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
