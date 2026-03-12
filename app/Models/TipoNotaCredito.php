<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNotaCredito extends Model
{
    protected $table = 'tipo_nota_credito';

    protected $fillable = [
        'code',
        'descripcion',
    ];
}
