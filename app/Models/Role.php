<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Str;

/**
 * Modelo Role extendido de Spatie.
 *
 * Agrega los campos propios del proyecto:
 *   - slug        → URL amigable generada automáticamente desde name
 *   - descripcion → descripción legible del rol
 *   - estado      → Activo / Inactivo
 *
 * Spatie usa 'name' y 'guard_name' internamente.
 * Nosotros usamos 'slug' para Route Model Binding en las rutas admin.
 */
class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'slug',
        'guard_name',
        'descripcion',
        'estado',
    ];

    /**
     * Las rutas admin de roles usan el slug: /admin-roles/administrador/edit
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Genera el slug automáticamente al crear o actualizar el nombre del rol.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Role $role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });

        static::updating(function (Role $role) {
            if ($role->isDirty('name') && !$role->isDirty('slug')) {
                $role->slug = Str::slug($role->name);
            }
        });
    }
}
