<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EmbedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Embed\Embed as EmbedProvide;

class Embed extends Controller
{
    public function __invoke(EmbedRequest $request)
    {
        $parsed = EmbedProvide::create($request->get('url'));
        return response()->json([
                'title' => $parsed->title,
                'description' => $parsed->description,
                'url' => $parsed->url,
                'image' => $parsed->image,
        ]);
    }
}
