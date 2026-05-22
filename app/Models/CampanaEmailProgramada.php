<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampanaEmailProgramada extends Model
{
    use HasFactory;

    protected $table = 'campanas_email_programadas';

    public const ESTADO_PENDIENTE = 'pendiente';
    public const ESTADO_PROCESANDO = 'procesando';
    public const ESTADO_ENVIADO = 'enviado';
    public const ESTADO_FALLIDO = 'fallido';
    public const ESTADO_PARCIAL = 'parcial';

    protected $fillable = [
        'asunto',
        'destinatarios',
        'contenido_html',
        'logo_path',
        'adjuntos',
        'enviar_el',
        'estado',
        'enviados_count',
        'fallidos_count',
        'detalle_error',
        'procesado_en',
        'user_id',
    ];

    protected $casts = [
        'destinatarios' => 'array',
        'adjuntos' => 'array',
        'enviar_el' => 'datetime',
        'procesado_en' => 'datetime',
    ];

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE)
            ->where('enviar_el', '<=', now());
    }
}
