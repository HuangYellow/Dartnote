<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $posts = Post::latest()->paginate(12);

        return view('users.show', compact('user', 'posts'));
    }
}
