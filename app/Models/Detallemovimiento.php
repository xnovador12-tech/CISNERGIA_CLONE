<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallemovimiento extends Model
{
    use HasFactory;
    protected $table = 'detallemovimientos';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
