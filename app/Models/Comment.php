<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'comment_text',
        'status', // 0 = for review, 1 = accepted, 2 = blocked
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(FoodBlogPost::class, 'post_id');
    }

    protected static function booted()
    {
        static::addGlobalScope('notBlocked', function ($query) {
            $query->where('status', '!=', 2);
        });
    }
}