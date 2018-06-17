<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)
            ->withCount('likers')
            ->withCount('comments')
            ->with('user')
            ->with('auth_like')
            ->latest()->paginate(12);

        return view('users.show', compact('user', 'posts'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('users.show', $user->nickname);
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(12);

        return view('users.followers', compact('followers'));
    }
}
