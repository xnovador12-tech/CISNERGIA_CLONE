<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'tiposcomprobante_id',
        'serie',
        'correlativo',
    ];

    public function tipoComprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    /**
     * Genera el siguiente número de comprobante y actualiza el correlativo.
     */
    public function generarNumero(): string
    {
        $this->increment('correlativo');

        return $this->serie . '-' . str_pad($this->correlativo, 8, '0', STR_PAD_LEFT);
    }
}
