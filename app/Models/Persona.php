<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $fillable = [
        'slug',
        'name',
        'surnames',
        'email_pnatural',
        'avatar',
        'celular',
        'pais',
        'ciudad',
        'identificacion',
        'nro_identificacion',
        'direccion',
        'referencia',
        'descripcion',
        'tipo_persona',
        'sede_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
    
    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function proveedor()
    {
        return $this->hasOne(Proveedor::class);
    }
}
