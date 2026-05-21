<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleCampania extends Model
{
    protected $table = 'sale_campania';

    protected $fillable = [
        'sale_id',
        'campania_id',
        'monto_aplicado',
        'descuento_aplicado',
        'productos_count',
    ];

    protected $casts = [
        'monto_aplicado' => 'decimal:2',
        'descuento_aplicado' => 'decimal:2',
        'productos_count' => 'integer',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function campania()
    {
        return $this->belongsTo(Campania::class, 'campania_id');
    }
}
