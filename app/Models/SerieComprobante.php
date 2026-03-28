<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SerieComprobante extends Model
{
    protected $table = 'series_comprobantes';

    protected $fillable = [
        'tiposcomprobante_id',
        'serie',
        'activo',
    ];

    public function tipoComprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    public function correlativo()
    {
        return $this->hasOne(Correlativo::class, 'serie_comprobante_id');
    }

    /**
     * Genera el siguiente número de comprobante y actualiza el correlativo.
     */
    public function generarNumero(): string
    {
        $correlativo = $this->correlativo ?? $this->correlativo()->create(['numero' => 0]);
        $correlativo->increment('numero');

        return $this->serie . '-' . str_pad($correlativo->numero, 8, '0', STR_PAD_LEFT);
    }
}
