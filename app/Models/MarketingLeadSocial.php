<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketingLeadSocial extends Model
{
    use HasFactory;

    protected $table = 'marketing_leads_sociales';

    public const PLATAFORMAS = [
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
    ];

    protected $fillable = [
        'plataforma',
        'social_id',
        'nombre_social',
        'prospecto_id',
        'puntaje_interes',
        'comentario_origen',
        'created_by',
    ];

    public function prospecto(): BelongsTo
    {
        return $this->belongsTo(Prospecto::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
