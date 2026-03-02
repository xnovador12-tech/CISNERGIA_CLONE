<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Prospecto;
use App\Models\Role;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Se ejecuta después de crear un User.
     *
     * Solo actúa cuando el usuario tiene rol "Cliente" (registro e-commerce).
     * Crea un Prospecto vinculado automáticamente con origen 'ecommerce'.
     *
     * Usuarios con otros roles (Administrador, Logística, etc.) se ignoran
     * porque no son clientes del e-commerce.
     */
    public function created(User $user): void
    {
        // Solo crear prospecto para usuarios con rol "Cliente"
        if (!$this->esRolCliente($user)) {
            return;
        }

        // Evitar duplicados: si ya tiene prospecto vinculado, no crear otro
        if (Prospecto::where('registered_user_id', $user->id)->exists()) {
            return;
        }

        // Obtener datos de la persona asociada al usuario
        $persona = $user->persona;

        Prospecto::create([
            'nombre'                => $persona?->name ?? 'Sin nombre',
            'apellidos'             => $persona?->surnames,
            'email'                 => $user->email ?? $persona?->email_pnatural,
            'celular'               => $persona?->celular,
            'direccion'             => $persona?->direccion,
            'tipo_persona'          => 'natural', // Por defecto natural para registro ecommerce
            'origen'                => 'ecommerce',
            'estado'                => 'nuevo',
            'registered_user_id'    => $user->id,
            'fecha_primer_contacto' => now(),
        ]);
    }

    /**
     * Verifica si el usuario tiene el rol "Cliente".
     * Usa el slug del rol para evitar depender del ID (que puede variar).
     */
    private function esRolCliente(User $user): bool
    {
        if (!$user->role_id) {
            return false;
        }

        $role = Role::find($user->role_id);

        return $role && $role->slug === 'cliente';
    }
}
