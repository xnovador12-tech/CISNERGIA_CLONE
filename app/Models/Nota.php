<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [
        'codigo',
        'slug',
        'sale_id',
        'tiposcomprobante_id',
        'numero_comprobante',
        'motivo_codigo',
        'motivo_descripcion',
        'subtotal',
        'igv',
        'total',
        'observaciones',
        'estado',
        'user_id',
        'sede_id',
        'fecha_emision',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'igv' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_emision' => 'date',
    ];

    // ==================== CONSTANTES SUNAT ====================

    const MOTIVOS_NC = [
        '01' => 'Anulación de la operación',
        '02' => 'Anulación por error en el RUC',
        '03' => 'Corrección por error en la descripción',
        '04' => 'Descuento global',
        '05' => 'Descuento por ítem',
        '06' => 'Devolución total',
        '07' => 'Devolución por ítem',
        '09' => 'Disminución en el valor',
        '10' => 'Otros conceptos',
    ];

    const MOTIVOS_ND = [
        '01' => 'Intereses por mora',
        '02' => 'Aumento en el valor',
        '03' => 'Penalidades / otros conceptos',
    ];

    // ==================== ROUTE MODEL BINDING ====================

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ==================== RELACIONES ====================

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function tipocomprobante()
    {
        return $this->belongsTo(Tiposcomprobante::class, 'tiposcomprobante_id');
    }

    public function detalles()
    {
        return $this->hasMany(NotaDetalle::class, 'nota_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    // ==================== HELPERS ====================

    public function esNotaCredito(): bool
    {
        return $this->tipocomprobante && $this->tipocomprobante->codigo === '07';
    }

    public function esNotaDebito(): bool
    {
        return $this->tipocomprobante && $this->tipocomprobante->codigo === '08';
    }
}
