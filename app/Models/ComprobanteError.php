<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprobanteError extends Model
{
    protected $fillable = [
        'comprobante',
        'fecha',
        'mensaje',
    ];
    protected $table = 'comprobante_errores';
}
