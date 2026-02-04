<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detallecombo extends Model
{
    protected $table = 'detalle_combos';

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
