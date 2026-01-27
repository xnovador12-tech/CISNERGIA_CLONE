<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacenes';
    protected $fillable = [
        'name',
        'slug',
        'fecha',
        'registrado_por',
        'clasificacion',
        'estado',
        'sede_id'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }   
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function tipos()
    {
        return $this->belongsToMany(Tipo::class);
    }

    public function motivos()
    {
        return $this->belongsToMany(Motivo::class);
    }
}

