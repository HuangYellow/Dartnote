<?php

namespace App\Services;

use App\Fetching\Tag;

class PostService
{
    public function create($attributes)
    {
        $post = auth()->user()->posts()->create($attributes);

        $tags = Tag::fetchesResolved($attributes['content']);

        Tag::empty($tags)?:$post->slugify()->tag($tags);

        auth()->user()->increment('experience', config('exp.post.create'));

        return $post;
    }
}
