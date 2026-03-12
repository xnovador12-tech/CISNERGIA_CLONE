<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $fillable = [
        'descripcion',
        'simbolo',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function cuentabancos()
    {
        return $this->hasMany(Cuentabanco::class);
    }
}
