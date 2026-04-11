<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usercoupon extends Model
{
    protected $table = 'users_coupons';
    protected $fillable = [
        'user_id',
        'coupon_id'
    ];

    public function user()
    {
        return $this->belongsto(User::class);
    }

    public function cupons()
    {
        return $this->belongsToMany(Coupon::class);
    }
}
