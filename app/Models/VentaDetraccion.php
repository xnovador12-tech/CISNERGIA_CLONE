<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetraccion extends Model
{
    use HasFactory;

    protected $table = 'venta_detraccion';

    protected $fillable = [
        'sale_id',
        'tipo_detraccion_id',
        'medio_pago_detraccion_id',
        'porcentaje',
        'monto_detraccion',
        'numero_constancia',
        'fecha_pago',
        'estado',
        'user_id',
        'cuenta_bancaria_id',
    ];

    protected $casts = [
        'porcentaje' => 'decimal:2',
        'monto_detraccion' => 'decimal:2',
        'fecha_pago' => 'date',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function tipoDetraccion()
    {
        return $this->belongsTo(TipoDetraccion::class, 'tipo_detraccion_id');
    }

    public function medioPago()
    {
        return $this->belongsTo(Mediopago::class, 'medio_pago_detraccion_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cuentaBancaria()
    {
        return $this->belongsTo(Cuentabanco::class, 'cuenta_bancaria_id');
    }
}
