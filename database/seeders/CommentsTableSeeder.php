<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'post_id' => 1,
                'user_id' => 2,
                'comment_text' => 'This is a great post! I really enjoyed reading it.',
                'status' => 0, // for review
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 1,
                'user_id' => 2,
                'comment_text' => 'I disagree with some points, but overall good writeup.',
                'status' => 1, // accepted
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2,
                'user_id' => 2,
                'comment_text' => 'Spammy comment here.',
                'status' => 2, // blocked
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 2,
                'user_id' => 2,
                'comment_text' => 'Thanks for sharing this place!',
                'status' => 1, // accepted
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'post_id' => 3,
                'user_id' => 2,
                'comment_text' => 'Looking forward to going here!',
                'status' => 0, // for review
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}