<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobanteCompra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comprobantes_compras';

    protected $fillable = [
        'codigo',
        'slug',
        'user_id',
        'proveedor_id',
        'sede_id',
        'ordencompra_id',
        'tiposcomprobante_id',
        'numero_comprobante',
        'subtotal',
        'igv',
        'total',
        'moneda_id',
        'mediopago_id',
        'condicion_pago',
        'estado',
        'observaciones',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function ordencompra()
    {
        return $this->belongsTo(Ordencompra::class, 'ordencompra_id');
    }

    public function tipocomprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleComprobanteCompra::class, 'comprobante_compra_id');
    }
}
