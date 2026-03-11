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
     * NOTA: Con Spatie, el rol se asigna DESPUÉS de User::create() mediante
     * assignRole(). Por eso el Observer también escucha el evento 'updated'
     * para detectar cuando se asigna el rol 'Cliente' por primera vez.
     */
    public function created(User $user): void
    {
        // En el flujo de RegisterController, el rol se asigna después del create.
        // El observer 'updated' cubre ese caso.
        // Este hook queda por compatibilidad con flujos donde el rol se asigna antes.
        $this->crearProspectoSiEsCliente($user);
    }

    /**
     * Cuando se actualiza el usuario (por ejemplo, al asignar el rol con assignRole()),
     * verificamos si ahora tiene el rol Cliente y aún no tiene prospecto.
     */
    public function updated(User $user): void
    {
        $this->crearProspectoSiEsCliente($user);
    }

    /**
     * Crea el Prospecto CRM si el usuario tiene rol Cliente y aún no tiene uno.
     */
    private function crearProspectoSiEsCliente(User $user): void
    {
        // Verificar rol con Spatie
        if (! $user->hasRole('Cliente')) {
            return;
        }

        // Evitar duplicados
        if (Prospecto::where('registered_user_id', $user->id)->exists()) {
            return;
        }

        $persona = $user->persona;

        Prospecto::create([
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
