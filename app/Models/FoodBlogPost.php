<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBlogPost extends Model
{
    protected $fillable = [
        'cafe_name',
        'location',
        'opening_hours',
        'description',
        'blogger_top_drink',
        'blogger_top_food',
        'score_affordability',
        'score_ambiance',
        'score_taste',
        'score_overall',
        'like_count',
    ];

    public function pictures()
    {
        return $this->hasMany(FoodBlogPostPicture::class, 'food_blog_post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function likedBy()
    {
        return $this->hasMany(LikedPost::class, 'post_id');
    }

    public function isLikedBy($userId)
    {
        return $this->likedBy()->where('user_id', $userId)->exists();
    }

    public function likes()
    {
        return $this->hasMany(LikedPost::class, 'post_id');
    }
}