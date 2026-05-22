<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EtiquetaPlantilla extends Model
{
    use HasFactory;

    protected $table = 'etiquetas_plantilla';

    protected $fillable = [
        'nombre',
        'color',
        'created_by',
    ];

    public function plantillas(): BelongsToMany
    {
        return $this->belongsToMany(
            PlantillaEmail::class,
            'plantilla_email_etiqueta',
            'etiqueta_id',
            'plantilla_email_id'
        );
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
