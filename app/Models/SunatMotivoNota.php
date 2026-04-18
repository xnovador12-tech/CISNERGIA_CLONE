<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SunatMotivoNota extends Model
{
    use HasFactory;

    protected $table = 'sunat_motivos_nota';

    protected $fillable = [
        'codigo',
        'descripcion',
        'tiposcomprobante_id',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function tipocomprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    public function ventasReferencias()
    {
        return $this->hasMany(VentaReferencia::class, 'sunat_motivo_nota_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeParaTipoComprobante($query, string $codigo)
    {
        return $query->whereHas('tipocomprobante', fn($q) => $q->where('codigo', $codigo));
    }
}
