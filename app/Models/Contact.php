<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'nombre',
        'apellido',
        'slug',
        'email',
        'telefono',
        'departamento',
        'tipo_proyecto',
        'consumo',
        'mensaje',
        'acepto_terminos',
        'mensaje_respuesta',
        'estado'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
