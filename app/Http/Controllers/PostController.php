<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
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

    public function store(PostRequest $request, PostService $postService)
    {
        if ($request->exists('private')) {
            $request->request->remove('private');
            $request->request->set('status', Post::$private);
        }

        $post = $postService->create($request->all());

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
        $withPost = Post::whereId($post->id)
            ->with('user')
            ->withCount('likers')
            ->withCount('comments')
            ->firstOrFail();

        $comments = $post->comments()
            ->with('user')
            ->withCount('likers')
            ->latest()->paginate(12);

        return view('posts.show')
            ->with('post', $withPost)
            ->with('comments', $comments);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        auth()->user()->increment('experience', config('exp.post.destroy'));

        return redirect()->route('posts.index');
    }
}
