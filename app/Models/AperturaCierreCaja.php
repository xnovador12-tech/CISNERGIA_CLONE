<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AperturaCierreCaja extends Model
{
    protected $table = 'apertura_cierres_caja';

    protected $fillable = [
        'codigo',
        'cuenta_bancaria_id',
        'user_id',
        'moneda_id',
        'fecha_apertura',
        'hora_apertura',
        'saldo_inicial',
        'efectivo_inicial',
        'total_ingresos',
        'total_egresos',
        'efectivo_final',
        'saldo_cierre',
        'fecha_cierre',
        'hora_cierre',
        'estado',
        'observacion',
    ];

    public function cuentaBancaria()
    {
        return $this->belongsTo(Cuentabanco::class, 'cuenta_bancaria_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoCaja::class, 'apertura_caja_id');
    }

    public function ingresos()
    {
        return $this->hasMany(MovimientoCaja::class, 'apertura_caja_id')->where('tipo', 'ingreso');
    }

    public function egresos()
    {
        return $this->hasMany(MovimientoCaja::class, 'apertura_caja_id')->where('tipo', 'egreso');
    }
}
