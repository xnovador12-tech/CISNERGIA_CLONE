<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    protected $table = 'tipos_comprobantes';

    protected $fillable = [
        'code',
        'descripcion',
    ];
}
