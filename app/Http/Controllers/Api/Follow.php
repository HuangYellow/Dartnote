<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class Follow extends Controller
{
    public function __invoke(Request $request)
    {
        if (auth()->id() == $request->get('id')) {
            return response()->json([
               'status' => 'denied',
            ]);
        }

        if (auth()->user()->isFollowing($request->get('id'))) {
            auth()->user()->unfollow($request->get('id'));

            return response()->json([
                'status' => 'unfollow',
            ]);
        }

        auth()->user()->follow($request->get('id'));

        return response()->json([
            'status' => 'follow',
        ]);
    }
}
