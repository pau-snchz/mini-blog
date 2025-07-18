<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBlogPostPicture extends Model
{
    protected $fillable = [
        'food_blog_post_id',
        'picture_path',
    ];

    public function post()
    {
        return $this->belongsTo(FoodBlogPost::class, 'food_blog_post_id');
    }
}