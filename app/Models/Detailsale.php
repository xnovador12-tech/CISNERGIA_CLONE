<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailsale extends Model
{
    use HasFactory;
    protected $table = 'detail_sales';
    protected $fillable = [
        'course_id',
        'courses',
        'cantidad',
        'precio',
        'precio_descuento',
        'descuento',
        'sale_id'
    ];
}
