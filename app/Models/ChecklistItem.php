<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $table = 'checklist_items';

    protected $fillable = [
        'seccion',
        'descripcion',
        'orden',
        'estado',
    ];

    public function scopeActivo($query)
    {
        return $query->where('estado', 'Activo');
    }

    public function scopeSeccion($query, $seccion)
    {
        return $query->where('seccion', $seccion);
    }
}
