<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprobanteControlProceso extends Model
{
    protected $fillable = [
        'nombre',
        'en_ejecucion',
        'fecha_inicio',
        'fecha_fin',
    ];
}
