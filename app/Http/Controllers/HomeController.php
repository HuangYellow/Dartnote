<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::whereIn('user_id', auth()->user()->followings->pluck('id')->toArray())
            ->with('user')
            ->withCount('comments')
            ->withCount('likers')
            ->with('auth_like')
            ->latest()->paginate(12);

        return view('home', compact('posts'));
    }
}
