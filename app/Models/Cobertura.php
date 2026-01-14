<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobertura extends Model
{
    use HasFactory;
    protected $table = 'coberturas';
    protected $fillable = [
        'name',
        'slug',
        'precio',
        'estado',
        'registrado_por',
        'departamento_id',
        'provincia_id',
        'distrito_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function distrito()
    {
        return $this->belongsTo(Distrito::class);

    }
}