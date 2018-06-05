<?php

namespace App\Http\Controllers\Post;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateComment extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $request->merge(['user_id' => auth()->id()]);

        $post->comments()->create($request->all());

        return redirect()->back()->with('success', 'Create successful');
    }
}
