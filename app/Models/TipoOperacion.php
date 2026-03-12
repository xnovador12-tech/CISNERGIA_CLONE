<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoOperacion extends Model
{
    protected $table = 'tipos_operaciones';

    protected $fillable = [
        'code',
        'descripcion',
    ];
}
