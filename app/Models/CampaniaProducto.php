<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaniaProducto extends Pivot
{
    protected $table = 'campania_productos';

    protected $fillable = [
        'campania_id',
        'producto_id',
        'descuento_especifico',
    ];

    protected $casts = [
        'descuento_especifico' => 'decimal:2',
    ];

    public function campania()
    {
        return $this->belongsTo(Campania::class, 'campania_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
