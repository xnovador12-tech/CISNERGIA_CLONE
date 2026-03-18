<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correlativo extends Model
{
    protected $table = 'correlativos';

    protected $fillable = [
        'serie_comprobante_id',
        'numero',
    ];

    public function serieComprobante()
    {
        return $this->belongsTo(SerieComprobante::class, 'serie_comprobante_id');
    }
}
