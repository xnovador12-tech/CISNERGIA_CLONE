<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = [
        'codigo',
        'slug',
        'name',
        'marca_id',
        'imagen',
        'descripcion',
        'tipo_material',
        'vida_util',
        'depreciacion',
        'costo',
        'estado',
        'precio',
        'precio_descuento',
        'peso',
        'tipo_id',
        'medida_id',
        'tipo_adquisicion',
        'tipo_afectacion',
        'categoria_id'
    ];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'etiqueta_producto', 'producto_id', 'tag_id');
    }

    public function producto_proveedor()
{
    return $this->belongsToMany(Proveedor::class); // agrega tabla/pivots si difiere del naming estándar
}
}
