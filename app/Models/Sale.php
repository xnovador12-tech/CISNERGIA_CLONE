<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $table = 'sales';
    
    protected $fillable = [
        'codigo',
        'slug',
        'pedido_id',
        'cliente_id',
        'tiposcomprobante_id',
        'tipo_operacion_id',
        'tipo_detraccion_id',
        'serie_id',
        'serie',
        'correlativo',
        'numero_comprobante',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'monto_detraccion',
        'monto_neto',
        'mediopago_id',
        'condicion_pago',
        'estado',
        'user_id',
        'sede_id',
        'tipo_venta',
        'tipo_proyecto',
        'potencia_kw',
        'fecha_instalacion',
        'garantia_sistema_años',
        'requiere_financiamiento',
        'monto_financiado',
        'entidad_financiera',
        'consumo_mensual_kwh',
        'numero_proyecto',
        'observaciones',
        'anulado',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'monto_detraccion' => 'decimal:2',
        'monto_neto' => 'decimal:2',
        'potencia_kw' => 'decimal:2',
        'monto_financiado' => 'decimal:2',
        'consumo_mensual_kwh' => 'decimal:2',
        'fecha_instalacion' => 'date',
        'requiere_financiamiento' => 'boolean',
        'anulado' => 'boolean',
        'garantia_sistema_años' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ==================== RELACIONES ====================

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tipocomprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    public function mediopago()
    {
        return $this->belongsTo(Mediopago::class, 'mediopago_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    public function detalles()
    {
        return $this->hasMany(Detailsale::class, 'sale_id');
    }

    public function cuotas()
    {
        return $this->hasMany(SaleCuota::class, 'sale_id');
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(Cuentabanco::class, 'cuenta_bancaria_id');
    }

    public function pagos()
    {
        return $this->hasMany(MovimientoCaja::class, 'venta_id');
    }

    public function tipoOperacion()
    {
        return $this->belongsTo(TipoOperacion::class, 'tipo_operacion_id');
    }

    public function tipoDetraccion()
    {
        return $this->belongsTo(TipoDetraccion::class, 'tipo_detraccion_id');
    }

    public function serieComprobante()
    {
        return $this->belongsTo(Serie::class, 'serie_id');
    }

    public function ventaReferencia()
    {
        return $this->hasOne(VentaReferencia::class, 'sale_id');
    }

    public function referencias()
    {
        return $this->hasMany(VentaReferencia::class, 'venta_referenciada_id');
    }
}
