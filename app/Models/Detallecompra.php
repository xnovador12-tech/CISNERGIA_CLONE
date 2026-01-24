<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallecompra extends Model
{
    use HasFactory;
    protected $table = 'detallecompras';
    protected $fillable = array('*');

    public function ordenescompras()
    {
        return $this->belongsTo(Ordencompra::class, 'ordencompra_id');
    }
}
