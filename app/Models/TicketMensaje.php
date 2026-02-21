<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMensaje extends Model
{
    use HasFactory;

    protected $table = 'ticket_mensajes';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'mensaje',
        'tipo',
        'es_cliente',
        'adjunto',
    ];

    protected $casts = [
        'es_cliente' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ==================== SCOPES ====================

    public function scopeRespuestas($query)
    {
        return $query->where('tipo', 'respuesta');
    }

    public function scopeNotasInternas($query)
    {
        return $query->where('tipo', 'nota_interna');
    }

    public function scopeDelCliente($query)
    {
        return $query->where('es_cliente', true);
    }
}
