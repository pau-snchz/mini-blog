<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            $users = User::select('id', 'username', 'full_name', 'email', 'user_type', 'is_banned')->get();
            return response()->json($users);
        }

        return view('admin.users');
    }

    public function data()
    {
        return response()->json(
            User::withoutGlobalScope('notBanned')
                ->select('id', 'username', 'full_name', 'email', 'user_type', 'is_banned')
                ->get()
        );
    }

    public function updateType(Request $request, $id)
    {
        $request->validate([
            'user_type' => 'required|in:admin,subscriber',
        ]);
        $user = User::withoutGlobalScope('notBanned')->findOrFail($id);
        $user->user_type = $request->user_type;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function updateBan(Request $request, $id)
    {
        $request->validate([
            'is_banned' => 'required|in:0,1',
        ]);

        $user = User::withoutGlobalScope('notBanned')->findOrFail($id);
        $user->is_banned = $request->is_banned;
        $user->save();

        return response()->json(['success' => true]);
    }
}