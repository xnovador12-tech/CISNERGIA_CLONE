<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVentaCategoria extends Model
{
    protected $table = 'items_venta_categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function items()
    {
        return $this->hasMany(ItemVenta::class, 'categoria_id');
    }
}
