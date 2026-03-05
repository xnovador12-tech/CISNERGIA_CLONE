<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoCuota extends Model
{
    use HasFactory;

    protected $table = 'pedido_cuotas';

    protected $fillable = [
        'pedido_id',
        'numero_cuota',
        'importe',
        'fecha_vencimiento'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
