<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Prospecto;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Se ejecuta después de crear un User.
     *
     * Solo actúa cuando el usuario tiene rol "Cliente" (registro e-commerce).
     * Crea un Prospecto vinculado automáticamente con origen 'ecommerce'.
     *
     * Usuarios con otros roles (Administrador, Ventas, etc.) se ignoran
     * porque no son clientes del e-commerce.
     *
     * IMPORTANTE: En el flujo de RegisterController, Spatie's assignRole()
     * NO dispara el evento 'updated' del modelo User (trabaja directamente
     * sobre la tabla pivote model_has_roles). Por eso, el RegisterController
     * debe llamar explícitamente a UserObserver::crearProspectoSiEsCliente($user)
     * después de assignRole(). Este Observer queda como red de seguridad para
     * otros flujos donde el rol se asigna ANTES del create() (poco común).
     */
    public function created(User $user): void
    {
        self::crearProspectoSiEsCliente($user);
    }

    /**
     * Hook 'updated' — red de seguridad por si en algún flujo se hace
     * $user->save() después de asignar el rol Cliente.
     */
    public function updated(User $user): void
    {
        self::crearProspectoSiEsCliente($user);
    }

    /**
     * Crea el Prospecto CRM si el usuario tiene rol Cliente y aún no tiene uno.
     *
     * Método PÚBLICO ESTÁTICO para que los controllers puedan llamarlo
     * explícitamente después de asignar el rol con Spatie (porque assignRole()
     * no dispara eventos de Eloquent).
     *
     * Es idempotente: si ya existe un Prospecto para este user, lo retorna sin
     * crear uno nuevo.
     */
    public static function crearProspectoSiEsCliente(User $user): ?Prospecto
    {
        // Verificar rol con Spatie
        if (! $user->hasRole('Cliente')) {
            return null;
        }

        // Evitar duplicados — si ya existe, retornarlo
        $existente = Prospecto::where('registered_user_id', $user->id)->first();
        if ($existente) {
            return $existente;
        }

        $persona = $user->persona;

        return Prospecto::create([
            'nombre'                => $persona?->name ?? 'Sin nombre',
            'apellidos'             => $persona?->surnames,
            'email'                 => $user->email ?? $persona?->email_pnatural,
            'celular'               => $persona?->celular,
            'direccion'             => $persona?->direccion,
            'tipo_persona'          => 'natural',
            'origen'                => 'ecommerce',
            'estado'                => 'nuevo',
            'registered_user_id'    => $user->id,
            'fecha_primer_contacto' => now(),
        ]);
    }
}
