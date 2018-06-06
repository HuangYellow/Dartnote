<?php

namespace App\Services;

use App\Fetching\Tag;
use Illuminate\Database\Eloquent\Model;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class CommentService
{
    public function create(Model $model, $attributes)
    {
        $this->resolvedRelations($model);

        $comment = $model->comments()->create($attributes);

        $tags = Tag::fetchesResolved($attributes['description']);

        Tag::empty($tags) ?: $comment->slugify()->tag($tags);

        return $comment;
    }

    /**
     * @param Model $model
     */
    private function resolvedRelations(Model $model)
    {
        if (! method_exists($model, 'comments')) {
            throw new MethodNotFoundException('The relations method does not exist.', get_class($model), 'comments');
        }
    }
}
