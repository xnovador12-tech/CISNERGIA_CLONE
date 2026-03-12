<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresoFinanciero extends Model
{
    protected $table = 'ingresos_financieros';

    protected $fillable = [
        'user_id',
        'cliente_id',
        'fecha_movimiento',
        'hora_movimiento',
        'cuenta_bancaria_id',
        'origen_tipo',
        'apertura_caja_id',
        'venta_id',
        'monto',
        'moneda_id',
        'nombre',
        'numero_operacion',
        'tipo_ingreso_id',
        'tipo_comprobante_id',
        'comprobante',
        'descripcion',
        'metodo_pago_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(Cuentabanco::class, 'cuenta_bancaria_id');
    }

    public function aperturaCaja()
    {
        return $this->belongsTo(AperturaCierreCaja::class, 'apertura_caja_id');
    }

    public function venta()
    {
        return $this->belongsTo(Sale::class, 'venta_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function tipoIngreso()
    {
        return $this->belongsTo(TipoIngreso::class, 'tipo_ingreso_id');
    }

    public function tipoComprobante()
    {
        return $this->belongsTo(TipoComprobante::class, 'tipo_comprobante_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(Mediopago::class, 'metodo_pago_id');
    }
}
