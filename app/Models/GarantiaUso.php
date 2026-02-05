<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarantiaUso extends Model
{
    use HasFactory;

    protected $table = 'garantia_usos';

    protected $fillable = [
        'garantia_id',
        'ticket_id',
        'fecha_uso',
        'motivo',
        'descripcion_problema',
        'solucion_aplicada',
        'costo_cubierto',
        'tecnico_responsable',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_uso' => 'date',
        'costo_cubierto' => 'decimal:2',
    ];

    // ==================== RELACIONES ====================

    public function garantia()
    {
        return $this->belongsTo(Garantia::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
