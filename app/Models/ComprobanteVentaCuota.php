<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprobanteVentaCuota extends Model
{
    protected $table = 'comprobantes_ventas_cuotas';

    protected $fillable = [
        'comprobante_venta_id',
        'numero_cuota',
        'monto',
        'fecha_vencimiento',
        'fecha_pago',
        'estado',
    ];

    public function comprobanteVenta()
    {
        return $this->belongsTo(ComprobanteVenta::class, 'comprobante_venta_id');
    }
}
