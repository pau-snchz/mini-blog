<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodBlogPost;
use App\Models\FoodBlogPostPicture;
use App\Models\Comment;
use App\Models\LikedPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class BlogController extends Controller
{
    public function show($id)
    {
        $post = FoodBlogPost::with(['pictures', 'comments.user'])->findOrFail($id);
        return view('blog.show', compact('post'));
    }

    public function create()
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can create blog posts.');
        }

        return view('blog.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can create blog posts.');
        }

        try {
            $request->validate([
                'cafe_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'opening_hours' => 'required|string|max:255',
                'description' => 'required|string',
                'blogger_top_drink' => 'required|string|max:255',
                'blogger_top_food' => 'required|string|max:255',
                'score_affordability' => 'required|integer|min:1|max:10',
                'score_ambiance' => 'required|integer|min:1|max:10',
                'score_taste' => 'required|integer|min:1|max:10',
                'pictures' => 'nullable|array|max:5',
                'pictures.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $score_affordability = (int) $request->score_affordability;
            $score_ambiance = (int) $request->score_ambiance;
            $score_taste = (int) $request->score_taste;
            $score_overall = round(($score_affordability + $score_ambiance + $score_taste) / 3, 1);

            DB::beginTransaction();

            // Create the blog post
            $post = FoodBlogPost::create([
                'cafe_name' => $request->cafe_name,
                'location' => $request->location,
                'opening_hours' => $request->opening_hours,
                'description' => $request->description,
                'blogger_top_drink' => $request->blogger_top_drink,
                'blogger_top_food' => $request->blogger_top_food,
                'score_affordability' => $score_affordability,
                'score_ambiance' => $score_ambiance,
                'score_taste' => $score_taste,
                'score_overall' => $score_overall,
                'like_count' => 0,
            ]);

            // Handle picture uploads
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $picture) {
                    $filename = time() . '_' . uniqid() . '.' . $picture->getClientOriginalExtension();
                    $path = $picture->storeAs('blog_pictures', $filename, 'public');

                    FoodBlogPostPicture::create([
                        'food_blog_post_id' => $post->id,
                        'picture_path' => 'storage/' . $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('home')->with('success', 'Blog post created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Blog creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function edit($id)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can edit blog posts.');
        }

        $post = FoodBlogPost::with('pictures')->findOrFail($id);
        return view('blog.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can update blog posts.');
        }

        try {
            $request->validate([
                'cafe_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'opening_hours' => 'required|string|max:255',
                'description' => 'required|string',
                'blogger_top_drink' => 'required|string|max:255',
                'blogger_top_food' => 'required|string|max:255',
                'score_affordability' => 'required|integer|min:1|max:10',
                'score_ambiance' => 'required|integer|min:1|max:10',
                'score_taste' => 'required|integer|min:1|max:10',
                // score_overall will be calculated below
                'pictures' => 'nullable|array|max:5',
                'pictures.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_pictures' => 'nullable|array',
                'remove_pictures.*' => 'integer|exists:food_blog_post_pictures,id',
            ]);

            // Calculate the overall score as the average
            $score_affordability = (int) $request->score_affordability;
            $score_ambiance = (int) $request->score_ambiance;
            $score_taste = (int) $request->score_taste;
            $score_overall = round(($score_affordability + $score_ambiance + $score_taste) / 3, 1);

            $post = FoodBlogPost::findOrFail($id);

            DB::beginTransaction();

            // Update the blog post
            $post->update([
                'cafe_name' => $request->cafe_name,
                'location' => $request->location,
                'opening_hours' => $request->opening_hours,
                'description' => $request->description,
                'blogger_top_drink' => $request->blogger_top_drink,
                'blogger_top_food' => $request->blogger_top_food,
                'score_affordability' => $score_affordability,
                'score_ambiance' => $score_ambiance,
                'score_taste' => $score_taste,
                'score_overall' => $score_overall,
            ]);

            // Handle picture removal
            if ($request->has('remove_pictures')) {
                foreach ($request->remove_pictures as $pictureId) {
                    $picture = FoodBlogPostPicture::find($pictureId);
                    if ($picture && $picture->food_blog_post_id == $post->id) {
                        // Delete file from storage
                        $filePath = str_replace('storage/', '', $picture->picture_path);
                        Storage::disk('public')->delete($filePath);
                        // Delete database record
                        $picture->delete();
                    }
                }
            }

            // Handle new picture uploads
            if ($request->hasFile('pictures')) {
                foreach ($request->file('pictures') as $picture) {
                    $filename = time() . '_' . uniqid() . '.' . $picture->getClientOriginalExtension();
                    $path = $picture->storeAs('blog_pictures', $filename, 'public');

                    FoodBlogPostPicture::create([
                        'food_blog_post_id' => $post->id,
                        'picture_path' => 'storage/' . $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('home')->with('success', 'Blog post updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Blog update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function destroy($id)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect()->route('home')->with('error', 'Only administrators can delete blog posts.');
        }

        try {
            $post = FoodBlogPost::findOrFail($id);

            DB::beginTransaction();

            // Delete all associated pictures from storage and database
            $pictures = FoodBlogPostPicture::where('food_blog_post_id', $post->id)->get();
            foreach ($pictures as $picture) {
                $filePath = str_replace('storage/', '', $picture->picture_path);
                Storage::disk('public')->delete($filePath);
                $picture->delete();
            }

            // Delete all associated comments
            Comment::where('post_id', $post->id)->delete();

            // Delete all associated likes
            LikedPost::where('post_id', $post->id)->delete();

            // Finally delete the blog post
            $post->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Blog post deleted successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Blog deletion error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Something went wrong while deleting the blog post.');
        }
    }

    public function storeComment(Request $request, $id)
    {
        try {
            $request->validate([
                'comment_text' => 'required|string|max:1000',
            ]);

            if (!Auth::check()) {
                return response()->json(['error' => 'Please login to comment.'], 401);
            }

            if (Auth::user()->user_type !== 'subscriber') {
                return response()->json(['error' => 'Only subscribers can comment.'], 403);
            }

            $comment = Comment::create([
                'post_id' => $id,
                'user_id' => Auth::id(),
                'comment_text' => $request->comment_text,
            ]);

            $comment->load('user');

            $commentCount = Comment::where('post_id', $id)->count();

            $profilePic = $comment->user->profile_picture
                ? asset('storage/' . $comment->user->profile_picture)
                : asset('images/default-pic.jpg');

            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'comment_text' => $comment->comment_text,
                    'user_name' => $comment->user->full_name,
                    'profile_picture' => $profilePic,
                    'created_at' => $comment->created_at->format('M d, Y \a\t g:i A'),
                ],
                'comment_count' => $commentCount,
                'message' => 'Comment added successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Comment text is required and must be less than 1000 characters.',
                'validation_errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            \Log::error('Comment creation error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleLike($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['error' => 'Please login to like posts.'], 401);
            }

            if (Auth::user()->user_type !== 'subscriber') {
                return response()->json(['error' => 'Only subscribers can like posts.'], 403);
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
                $liked = false;
                $action = 'unliked';
            } else {
                LikedPost::create([
                    'user_id' => $userId,
                    'post_id' => $id,
                ]);
                $post->increment('like_count');
                $liked = true;
                $action = 'liked';
            }

            $freshPost = FoodBlogPost::find($id);

            return response()->json([
                'success' => true,
                'liked' => $liked,
                'like_count' => $freshPost->like_count,
                'action' => $action,
                'message' => "Post {$action} successfully!"
            ]);

        } catch (Exception $e) {
            \Log::error('Like toggle error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id && Auth::user()->user_type !== 'admin') {
            return redirect()->back()->with('error', 'You can only delete your own comments.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}