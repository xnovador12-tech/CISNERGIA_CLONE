<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $table = 'sales';
    
    protected $fillable = [
        'codigo',
        'slug',
        'pedido_id',
        'cliente_id',
        'tiposcomprobante_id',
        'numero_comprobante',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'mediopago_id',
        'estado',
        'user_id',
        'observaciones'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tipocomprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    public function mediopago()
    {
        return $this->belongsTo(Mediopago::class, 'mediopago_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalles()
    {
        return $this->hasMany(Detailsale::class, 'sale_id');
    }
}
