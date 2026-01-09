<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'comentario',
        'tipo',
        'valoracion',
        'user_id',
        'course_id'
    ];

    public function likes()
    {
        return $this->hasMany(Likecomment::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
