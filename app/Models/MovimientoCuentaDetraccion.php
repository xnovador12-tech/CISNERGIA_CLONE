<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCuentaDetraccion extends Model
{
    protected $table = 'movimientos_cuenta_detracciones';

    protected $fillable = [
        'tipo_movimiento',
        'monto',
        'comprobante_venta_detraccion_id',
        'ingreso_financiero_id',
        'descripcion',
    ];

    public function comprobanteVentaDetraccion()
    {
        return $this->belongsTo(ComprobanteVentaDetraccion::class, 'comprobante_venta_detraccion_id');
    }

    public function ingresoFinanciero()
    {
        return $this->belongsTo(IngresoFinanciero::class, 'ingreso_financiero_id');
    }
}
