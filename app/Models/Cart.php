<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'cupon_codigo',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Oportunidad CRM vinculada a este carrito.
     * Se crea automáticamente al agregar el primer producto.
     */
    public function oportunidad()
    {
        return $this->hasOne(Oportunidad::class);
    }

    // Métodos auxiliares
    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum('subtotal');
        $this->igv = $this->subtotal * 0.18;
        $this->total = $this->subtotal + $this->igv - $this->descuento;
        $this->save();
    }

    public function getTotalItems()
    {
        return $this->items->sum('cantidad');
    }
}
