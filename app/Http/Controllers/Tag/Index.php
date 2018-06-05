<?php

namespace App\Http\Controllers\Tag;

use Cartalyst\Tags\IlluminateTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Index extends Controller
{
    public function __invoke()
    {
        $tags = IlluminateTag::all();

        return view('tags.index', compact('tags'));
    }
}
