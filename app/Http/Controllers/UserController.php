<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(12);

        return view('users.show', compact('user', 'posts'));
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(12);

        return view('users.followers', compact('followers'));
    }
}
