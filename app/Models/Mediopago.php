<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediopago extends Model
{
    use HasFactory;
    protected $table = 'mediopagos';
    protected $fillable = [
            'name',
            'slug',
            'estado'
    ];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
