<?php

namespace App\Http\Controllers\Post;

use App\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateComment extends Controller
{
    /**
     * @var CommentService
     */
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function __invoke(Request $request, Post $post)
    {
        $this->commentService->create($post, $request->merge(['user_id' => auth()->id()])->all());

        auth()->user()->increment('experience', config('exp.comment.create'));
        auth()->user()->increment('coins', config('coin.comment.create'));

        return redirect()->back()->with('success', 'Create successful');
    }
}
