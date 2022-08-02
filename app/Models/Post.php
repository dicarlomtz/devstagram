<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user = null)
    {
        return $user ? $this->likes->contains('user_id', $user->id) : false; 
    }   
}
