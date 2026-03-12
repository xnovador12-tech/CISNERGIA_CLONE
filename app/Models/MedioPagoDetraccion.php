<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedioPagoDetraccion extends Model
{
    protected $table = 'medios_pagos_detraccion';

    protected $fillable = [
        'codigo',
        'descripcion',
    ];
}
