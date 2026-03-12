<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprobanteVentaDetraccion extends Model
{
    protected $table = 'comprobantes_ventas_detracciones';

    protected $fillable = [
        'comprobante_venta_id',
        'tipo_detraccion_id',
        'medio_pago_detraccion_id',
        'porcentaje',
        'monto_detraccion',
        'monto_neto',
        'numero_constancia',
        'fecha_pago',
        'estado',
        'comprobante_path',
    ];

    public function comprobanteVenta()
    {
        return $this->belongsTo(ComprobanteVenta::class, 'comprobante_venta_id');
    }

    public function tipoDetraccion()
    {
        return $this->belongsTo(TipoDetraccion::class, 'tipo_detraccion_id');
    }

    public function medioPagoDetraccion()
    {
        return $this->belongsTo(MedioPagoDetraccion::class, 'medio_pago_detraccion_id');
    }
}
