<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipocuenta extends Model
{
    use HasFactory;
    protected $table = 'tipocuentas';
    protected $fillable = [
            'name',
            'slug',
            'descripcion',
            'estado',
            'banco_id'
    ];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }
}
