<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $fillable = [
        'titulo',
        'slug',
        'codigo',
        'fecha_inicio',
        'fecha_fin',
        'porcentaje',
        'estado'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relación con usuarios a través de users_coupons
    public function userCoupons()
    {
        return $this->hasMany(\App\Models\User::class, 'coupon_id');
    }
}
