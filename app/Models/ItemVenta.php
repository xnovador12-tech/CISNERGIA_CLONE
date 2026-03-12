<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemVenta extends Model
{
    protected $table = 'items_venta';

    protected $fillable = [
        'codigo',
        'nombre',
        'slug',
        'descripcion',
        'precio',
        'estado',
        'categoria_id',
        'unidad_medida_id',
        'tipo_afectacion_id',
        'sede_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(ItemVentaCategoria::class, 'categoria_id');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }

    public function tipoAfectacion()
    {
        return $this->belongsTo(TipoAfectacion::class, 'tipo_afectacion_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }
}
