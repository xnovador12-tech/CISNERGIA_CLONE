<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleCuota extends Model
{
    use HasFactory;

    protected $table = 'sale_cuotas';

    protected $fillable = [
        'sale_id',
        'numero_cuota',
        'importe',
        'fecha_vencimiento',
        'fecha_pago',
        'estado',
    ];

    protected $casts = [
        'importe' => 'decimal:2',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
