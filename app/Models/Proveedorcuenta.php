<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedorcuenta extends Model
{
    protected $table = 'proveedor_cuentas';

    public function proveedor()
{
    return $this->belongsTo(Proveedor::class, 'proveedor_id');
}
}
