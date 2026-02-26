<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    
    protected static function booted(): void
    {
        static::creating(function ($pedido) {
            if (auth()->check()) {
                $pedido->created_by = auth()->id();
            }
        });

        static::updating(function ($pedido) {
            if (auth()->check()) {
                $pedido->updated_by = auth()->id();
            }
        });
    }

    protected $table = 'pedidos';
    
    protected $fillable = [
        'codigo',
        'slug',
        'cliente_id',
        'user_id',
        'subtotal',
        'incluye_igv',
        'descuento_porcentaje',
        'descuento_monto',
        'igv',
        'total',
        'estado',
        'tipo',
        'aprobacion_finanzas',
        'aprobacion_stock',
        'direccion_instalacion',
        'distrito_id',
        'fecha_entrega_estimada',
        'vigencia_dias',
        'almacen_id',
        'observaciones',
        'origen',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'fecha_entrega_estimada' => 'date',
        'subtotal' => 'decimal:2',
        'incluye_igv' => 'boolean',
        'descuento_porcentaje' => 'decimal:2',
        'descuento_monto' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'aprobacion_finanzas' => 'boolean',
        'aprobacion_stock' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }

    public function venta()
    {
        return $this->hasOne(Sale::class, 'pedido_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
