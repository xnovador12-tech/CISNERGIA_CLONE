<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likecomment extends Model
{
    use HasFactory;
    protected $table = 'likes_comments';
    protected $fillable = [
        'like',
        'user_id',
        'comment_id'
    ];
}
