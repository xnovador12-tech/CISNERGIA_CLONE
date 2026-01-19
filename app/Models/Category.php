<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'tipo_id',
        'estado'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }
}
