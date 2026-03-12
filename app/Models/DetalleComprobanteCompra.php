<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleComprobanteCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_comprobantes_compras';

    protected $fillable = [
        'comprobante_compra_id',
        'producto_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'igv',
        'total',
        'unidad_medida_id',
    ];

    public function comprobante()
    {
        return $this->belongsTo(ComprobanteCompra::class, 'comprobante_compra_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class, 'unidad_medida_id');
    }
}
