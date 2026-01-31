<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'producto_id',
        'servicio_id',
        'tipo',
        'nombre',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'descuento' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relaciones
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    // Calcular subtotal
    public function calculateSubtotal()
    {
        $this->subtotal = ($this->precio_unitario * $this->cantidad) - $this->descuento;
        $this->save();
    }
}
