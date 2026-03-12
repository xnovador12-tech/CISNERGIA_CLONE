<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteVenta extends Model
{
    use SoftDeletes;

    protected $table = 'comprobantes_ventas';

    protected $fillable = [
        'user_id',
        'cliente_id',
        'sede_id',
        'pedido_id',
        'tipo_comprobante_id',
        'tipo_operacion_id',
        'serie_id',
        'moneda_id',
        'metodo_pago_id',
        'cuenta_bancaria_id',
        'numero_comprobante',
        'fecha_emision',
        'fecha_vencimiento',
        'subtotal',
        'igv',
        'descuento_global',
        'total',
        'tipo_pago',
        'numero_cuotas',
        'estado',
        'ingreso_financiero_id',
        'observaciones',
        'estado_sunat',
        'mensaje_sunat',
        'nombre_xml_sunat',
        'venta_referencia_id',
        'tipo_nota_credito_id',
        'tipo_nota_debito_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function tipoComprobante()
    {
        return $this->belongsTo(TipoComprobante::class);
    }

    public function tipoOperacion()
    {
        return $this->belongsTo(TipoOperacion::class);
    }

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(Mediopago::class, 'metodo_pago_id');
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(Cuentabanco::class, 'cuenta_bancaria_id');
    }

    public function ingresoFinanciero()
    {
        return $this->belongsTo(IngresoFinanciero::class);
    }

    public function ventaReferencia()
    {
        return $this->belongsTo(ComprobanteVenta::class, 'venta_referencia_id');
    }

    public function tipoNotaCredito()
    {
        return $this->belongsTo(TipoNotaCredito::class);
    }

    public function tipoNotaDebito()
    {
        return $this->belongsTo(TipoNotaDebito::class);
    }
}
