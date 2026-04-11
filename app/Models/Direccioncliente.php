<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccioncliente extends Model
{
    protected $table = 'direcciones_clientes';
    protected $fillable = [
        'cliente_id',
        'referencia',
        'direccion',
        'distrito_id',
        'provincia_id',
        'departamento_id',
    ];

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
}
