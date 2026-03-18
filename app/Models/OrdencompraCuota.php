<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdencompraCuota extends Model
{
    protected $table = 'ordencompra_cuotas';

    protected $fillable = [
        'ordencompra_id',
        'numero_cuota',
        'importe',
        'fecha_vencimiento',
    ];

    public function ordenCompra()
    {
        return $this->belongsTo(Ordencompra::class, 'ordencompra_id');
    }
}
