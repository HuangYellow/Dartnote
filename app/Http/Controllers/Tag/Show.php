<?php

namespace App\Http\Controllers\Tag;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Show extends Controller
{
    public function __invoke($tag)
    {
        $posts = \App\Post::whereTag(base64_encode($tag))->paginate(12);

        return view('posts.index', compact('posts'));
    }
}
