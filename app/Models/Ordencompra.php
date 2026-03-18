<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordencompra extends Model
{
    use HasFactory;
    protected $table = 'ordenescompras';
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function detallecompra()
    {
        return $this->hasMany(Detallecompra::class, 'ordencompra_id');
    }

    public function cuotas()
    {
        return $this->hasMany(OrdencompraCuota::class, 'ordencompra_id');
    }

    public function pagos()
    {
        return $this->hasMany(MovimientoCaja::class, 'ordencompra_id');
    }
}
