<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDetraccion extends Model
{
    protected $table = 'tipo_detraccion';

    protected $fillable = [
        'code',
        'descripcion',
        'porcentaje',
        'total',
    ];
}
