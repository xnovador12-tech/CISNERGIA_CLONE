<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';

    protected $fillable = [
        'slug',
        'codigo',
        'name',
        'tipo_servicio',
        'descripcion',
        'estado',
        'registrado_por',
        'proveedor_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
