<?php

namespace App\Services;

use App\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class CommentService
{
    public function create(Model $model, $attributes, $column = 'description')
    {
        if (! method_exists($model, 'comments')) {
            throw new MethodNotFoundException('The relations method does not exist.', get_class($model), 'comments');
        }

        $comment = $model->comments()->create($attributes);

        $tags = Str::fetchTags($attributes[$column]);

        empty($tags) ?: $comment->slugify()->tag($tags);

        return $comment;
    }
}
