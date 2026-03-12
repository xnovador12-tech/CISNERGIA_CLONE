<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleComprobanteVenta extends Model
{
    protected $table = 'detalle_comprobantes_ventas';

    protected $fillable = [
        'comprobante_venta_id',
        'item_id',
        'tipo_afectacion_id',
        'unidad_medida_id',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal',
        'igv',
        'total',
    ];

    public function comprobanteVenta()
    {
        return $this->belongsTo(ComprobanteVenta::class, 'comprobante_venta_id');
    }

    public function item()
    {
        return $this->belongsTo(ItemVenta::class, 'item_id');
    }

    public function tipoAfectacion()
    {
        return $this->belongsTo(TipoAfectacion::class, 'tipo_afectacion_id');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }
}
