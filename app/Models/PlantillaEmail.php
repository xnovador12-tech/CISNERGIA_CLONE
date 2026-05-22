<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantillaEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plantillas_email';

    protected $fillable = [
        'nombre',
        'asunto',
        'contenido_html',
        'logo_path',
        'descripcion',
        'es_global',
        'user_id',
    ];

    protected $casts = [
        'es_global' => 'boolean',
    ];

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(
            EtiquetaPlantilla::class,
            'plantilla_email_etiqueta',
            'plantilla_email_id',
            'etiqueta_id'
        );
    }
}
