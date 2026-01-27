<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiposcomprobante extends Model
{
    use HasFactory;
    protected $table = 'tiposcomprobantes';
    protected $fillable = [
        'name',
        'slug',
        'codigo',
        'tipo',
        'estado'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}