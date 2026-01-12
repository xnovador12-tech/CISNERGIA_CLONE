<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';
    protected $fillable = [
        'titulo',
        'slug',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'course_id',
        'category_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }
}
