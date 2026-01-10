<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $fillable = [];

    public function cuentabancos()
    {
        return $this->hasMany(Cuentabanco::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
