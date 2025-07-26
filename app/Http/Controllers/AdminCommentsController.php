<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentsController extends Controller
{
    /**
     * Show the admin comments moderation page.
     */
    public function index()
    {
        return view('admin.comments');
    }

    /**
     * Return comments for moderation, including user info.
     */
    public function comments()
    {
        $comments = Comment::withoutGlobalScope('notBlocked')
            ->with(['user:id,full_name'])
            ->get(['id', 'comment_text', 'user_id', 'status']);

        $data = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'comment_text' => $comment->comment_text,
                'user_id' => $comment->user_id,
                'user' => $comment->user ? [
                    'id' => $comment->user->id,
                    'full_name' => $comment->user->full_name,
                ] : null,
                'status' => $comment->status,
            ];
        });

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2',
        ]);

        $comment = Comment::withoutGlobalScope('notBlocked')->findOrFail($id);
        $comment->status = $request->input('status');
        $comment->save();

        return response()->json(['success' => true, 'status' => $comment->status]);
    }
}