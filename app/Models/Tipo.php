<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    protected $table = 'tipos';
    protected $fillable = [
            'name',
            'slug',
            'estado'
    ];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    // public function proveedores()
    // {
    //     return $this->hasMany(Proveedor::class);
    // }

    public function proveedors()
    {
        return $this->belongsToMany(Proveedor::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    public function areaalmacenes()
    {
        return $this->belongsToMany(Areaalmacen::class);
    }
}
