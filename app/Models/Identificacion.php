<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identificacion extends Model
{
    protected $table = 'identificacions';

    protected $fillable = [
        'name',
        'slug',
        'abreviatura',
        'codigo',
        'estado'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
