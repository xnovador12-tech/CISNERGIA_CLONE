<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedortipo extends Model
{
    protected $table = 'proveedor_tipo';

    public function proveedor()
{
    return $this->belongsTo(Proveedor::class, 'proveedor_id');
}

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }
}
