<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuentabanco extends Model
{
    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'banco_id',
        'numero_cuenta',
        'tipocuenta_id',
        'moneda_id',
        'sede_id',
        'titular',
        'saldo_inicial',
        'saldo_actual',
        'cci',
        'descripcion',
        'estado',
        'cuenta_principal',
        'fecha_apertura',
        'fecha_cierre',
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function tipocuenta()
    {
        return $this->belongsTo(Tipocuenta::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}
