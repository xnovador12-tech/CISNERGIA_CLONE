<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    protected $table = 'movimientos_caja';

    protected $fillable = [
        'tipo',
        'monto',
        'apertura_caja_id',
        'user_id',
        'fecha_movimiento',
        'hora_movimiento',
        'venta_id',
        'ordencompra_id',
        'cliente_id',
        'proveedor_id',
        'metodo_pago_id',
        'cuenta_bancaria_id',
        'numero_operacion',
        'descripcion',
    ];

    public function aperturaCaja()
    {
        return $this->belongsTo(AperturaCierreCaja::class, 'apertura_caja_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venta()
    {
        return $this->belongsTo(Sale::class, 'venta_id');
    }

    public function ordenCompra()
    {
        return $this->belongsTo(Ordencompra::class, 'ordencompra_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(Mediopago::class, 'metodo_pago_id');
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(Cuentabanco::class, 'cuenta_bancaria_id');
    }
}
