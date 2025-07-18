<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodBlogPost;
use App\Models\LikedPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikedBlogsController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type !== 'subscriber') {
            return redirect()->route('home')->with('error', 'Only subscribers can view liked blogs.');
        }

        $likedPosts = FoodBlogPost::whereHas('likedBy', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('pictures')->orderBy('created_at', 'desc')->get();

        return view('liked-blogs.index', compact('likedPosts'));
    }

    public function removeLike($id)
    {
        try {
            if (Auth::user()->user_type !== 'subscriber') {
                return response()->json(['error' => 'Only subscribers can unlike posts.'], 403);
            }

            $post = FoodBlogPost::findOrFail($id);
            $userId = Auth::id();

            $existingLike = LikedPost::where('user_id', $userId)->where('post_id', $id)->exists();

            if ($existingLike) {
                DB::table('liked_posts')
                    ->where('user_id', $userId)
                    ->where('post_id', $id)
                    ->delete();

                $post->decrement('like_count');

                return response()->json([
                    'success' => true,
                    'message' => 'Post removed from liked blogs!'
                ]);
            } else {
                return response()->json(['error' => 'Post not found in your liked blogs.'], 404);
            }

        } catch (\Exception $e) {
            \Log::error('Remove like error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'debug' => $e->getMessage()
            ], 500);
        }
    }
}