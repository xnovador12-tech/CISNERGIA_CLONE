<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'slug',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function provincias(): HasMany
    {
        return $this->hasMany(Provincia::class);
    }

    public function distritos(): HasMany
    {
        return $this->hasMany(Distrito::class);
    }
}
