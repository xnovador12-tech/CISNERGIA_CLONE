<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;
    protected $table = 'sedes';
    protected $fillable = [
        'name',
        'slug',
        'direccion',
        'referencia',
        'nro_contacto',
        'telefono',
        'email',
        'imagen',
        'departamento_id',
        'estado'
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
