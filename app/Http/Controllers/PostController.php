<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function index()
    {
        $posts = Post::latest()->paginate(12);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $attributes = $request->all();

        $post = auth()->user()->posts()->create($attributes);
        auth()->user()->increment('experience', config('exp.post.create'));

        $matches = [];
        if (! empty($attributes['content'])) {
            preg_match_all("/(#\w+)/u", $attributes['content'], $matches);
        }

        if (! empty($matches)) {
            $hashtagsArray = array_count_values($matches[0]);
            $hashtags = array_keys($hashtagsArray);
            $tags = preg_replace('/#([\w-]+)/u', '$1', $hashtags);
            $post->slugify()->tag($tags);
        }

        return redirect()->route('posts.show', $post->id);
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());

        return redirect()->route('posts.show', $post->id);
    }

    public function show(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->paginate(12);

        return view('posts.show', compact('post', 'comments'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        auth()->user()->increment('experience', config('exp.post.destroy'));

        return redirect()->route('posts.index');
    }
}
