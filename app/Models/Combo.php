<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    protected $table = 'combos';
    protected $fillable = [
        'codigo',
        'slug',
        'descripcion',
        'estado',
        'precio_total',
        'cantidad_total',
        'descripcion'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function detallecombo()
    {
        return $this->hasMany(Detallecombo::class, 'combo_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'combo_etiqueta', 'combo_id', 'tag_id');
    }
}
