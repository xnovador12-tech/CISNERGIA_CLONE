<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAfectacion extends Model
{
    protected $table = 'tipo_afectaciones';

    protected $fillable = [
        'code',
        'descripcion',
        'codigo_tributo',
        'tipo_tributo',
        'name_tributo',
        'porcentaje',
    ];
}
