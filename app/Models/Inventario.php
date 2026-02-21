<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'id_producto',
        'tipo_producto',
        'producto',
        'lote',
        'umedida',
        'cantidad',
        'precio',
        'sede_id',
        'almacen_id'
    ];

    public function producto_rel()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
