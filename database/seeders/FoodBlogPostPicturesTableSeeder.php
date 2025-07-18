<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodBlogPostPicture;

class FoodBlogPostPicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pictures = [
            // Post 1
            ['food_blog_post_id' => 1, 'picture_path' => 'images/post1_1.jpg'],
            ['food_blog_post_id' => 1, 'picture_path' => 'images/post1_2.jpg'],
            ['food_blog_post_id' => 1, 'picture_path' => 'images/post1_3.jpg'],
            // Post 2
            ['food_blog_post_id' => 2, 'picture_path' => 'images/post2_1.jpg'],
            ['food_blog_post_id' => 2, 'picture_path' => 'images/post2_2.jpg'],
            ['food_blog_post_id' => 2, 'picture_path' => 'images/post2_3.jpg'],
            // Post 3
            ['food_blog_post_id' => 3, 'picture_path' => 'images/post3_1.jpg'],
            ['food_blog_post_id' => 3, 'picture_path' => 'images/post3_2.jpg'],
            ['food_blog_post_id' => 3, 'picture_path' => 'images/post3_3.jpg'],
            // Post 4
            ['food_blog_post_id' => 4, 'picture_path' => 'images/post4_1.jpg'],
            ['food_blog_post_id' => 4, 'picture_path' => 'images/post4_2.jpg'],
            ['food_blog_post_id' => 4, 'picture_path' => 'images/post4_3.jpg'],
            // Post 5
            ['food_blog_post_id' => 5, 'picture_path' => 'images/post5_1.jpg'],
            ['food_blog_post_id' => 5, 'picture_path' => 'images/post5_2.jpg'],
            ['food_blog_post_id' => 5, 'picture_path' => 'images/post5_3.jpg'],
        ];

        foreach ($pictures as $picture) {
            FoodBlogPostPicture::create($picture);
        }
    }
}