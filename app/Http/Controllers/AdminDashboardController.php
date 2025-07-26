<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FoodBlogPost;
use App\Models\LikedPost;
use App\Models\Comment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function stats()
    {
        return response()->json([
            'users' => User::count(),
            'posts' => FoodBlogPost::count(),
            'comments' => Comment::count(),
            // 'blockedComments' => Comment::where('is_blocked', true)->count(),
        ]);
    }

    public function posts()
    {
        $posts = FoodBlogPost::withCount('likes')
            ->get(['id', 'cafe_name']);

        $posts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->cafe_name,
                'like_count' => $post->likes_count ?? 0,
            ];
        });

        return response()->json($posts);
    }
}