<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $fillable = [
        'tipo_comprobante_id',
        'name',
        'correlativo',
    ];

    public function tipoComprobante()
    {
        return $this->belongsTo(TipoComprobante::class, 'tipo_comprobante_id');
    }
}
