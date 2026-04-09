<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Modelo User con soporte de roles y permisos via Spatie.
 *
 * Cambios respecto a la versión anterior:
 *   - Se agrega el trait HasRoles de Spatie
 *   - Se elimina role_id del fillable (Spatie usa la pivot model_has_roles)
 *   - Se elimina la relación role() (ya no es necesaria con Spatie)
 *   - Se elimina getRouteKeyName() con 'slug' (users no tiene columna slug;
 *     las rutas de usuarios admin usan ID)
 *
 * Helpers disponibles gracias a HasRoles:
 *   $user->assignRole('Administrador')
 *   $user->hasRole('Ventas')
 *   $user->hasAnyRole(['Gerencia', 'Administrador'])
 *   $user->can('crm.prospectos.index')
 *   $user->hasPermissionTo('crm.cotizaciones.aprobar')
 *   $user->getRoleNames()  → colección de nombres de roles
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'email',
        'password',
        'estado',
        'persona_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relaciones ───────────────────────────────────────────────

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    /**
     * Prospecto CRM vinculado (solo para rol Cliente - registro ecommerce).
     */
    public function prospecto()
    {
        return $this->hasOne(Prospecto::class, 'registered_user_id');
    }

    // ─── Accessors ────────────────────────────────────────────────

    /**
     * Nombre completo del usuario obtenido desde su Persona.
     * Usado en vistas: {{ $user->name }}
     */
    public function getNameAttribute(): string
    {
        if ($this->persona) {
            $nombre = $this->persona->name;
            if ($this->persona->surnames) {
                $nombre .= ' ' . $this->persona->surnames;
            }
            return $nombre;
        }

        return $this->email;
    }

    /**
     * Primer rol asignado al usuario (el más común en este proyecto
     * ya que cada usuario tiene un solo rol).
     */
    public function getRolAttribute(): ?Role
    {
        return $this->roles->first();
    }

    /**
     * Indica si el usuario tiene acceso al panel de administración.
     * Los Clientes solo acceden al ecommerce.
     */
    public function esPersonalInterno(): bool
    {
        return ! $this->hasRole('Cliente');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }
}
