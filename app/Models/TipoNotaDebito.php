<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNotaDebito extends Model
{
    protected $table = 'tipo_nota_debito';

    protected $fillable = [
        'code',
        'descripcion',
    ];
}
