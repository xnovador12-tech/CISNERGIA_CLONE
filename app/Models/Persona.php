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
        'avatar',
        'celular',
        'pais',
        'ciudad',
        'identificacion',
        'nro_identificacion',
        'direccion',
        'referencia',
        'descripcion'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function consultore()
    {
        return $this->hasOne(Consultore::class);
    }
}
