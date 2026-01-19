<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordencompra extends Model
{
    use HasFactory;
    protected $table = 'ordenescompras';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
