<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaReferencia extends Model
{
    use HasFactory;

    protected $table = 'ventas_referencias';

    protected $fillable = [
        'sale_id',
        'venta_referenciada_id',
        'sunat_motivo_nota_id',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function ventaReferenciada()
    {
        return $this->belongsTo(Sale::class, 'venta_referenciada_id');
    }

    public function sunatMotivoNota()
    {
        return $this->belongsTo(SunatMotivoNota::class, 'sunat_motivo_nota_id');
    }

}
