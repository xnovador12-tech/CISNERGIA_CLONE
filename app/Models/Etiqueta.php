<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;
    protected $table = 'tags';
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
}
