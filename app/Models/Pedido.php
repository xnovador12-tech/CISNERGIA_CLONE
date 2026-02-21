<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    
    protected $table = 'pedidos';
    
    protected $fillable = [
        'codigo',
        'slug',
        'cliente_id',
        'user_id',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'estado',
        'aprobacion_finanzas',
        'aprobacion_stock',
        'direccion_instalacion',
        'distrito_id',
        'fecha_entrega_estimada',
        'tecnico_asignado_id',
        'almacen_id',
        'observaciones',
        'origen'
    ];

    protected $casts = [
        'fecha_entrega_estimada' => 'date',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
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

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_asignado_id');
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
}
