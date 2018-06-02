<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class Like extends Controller
{
    public function __invoke(Request $request)
    {
        $result = auth()->user()->toggleLike($request->get('id'), Post::class);

        return response()->json([
            'status' => empty($result['attached']) ? 'unlike' : 'like',
        ]);
    }
}
