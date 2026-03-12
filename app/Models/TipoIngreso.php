<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIngreso extends Model
{
    protected $table = 'tipo_ingreso';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
