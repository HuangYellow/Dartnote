<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFollow\Traits\CanBeLiked;

class Post extends Model implements TaggableInterface
{
    use SoftDeletes, TaggableTrait, CanBeLiked, Status;

    protected $table = 'posts';

    protected $guarded = [];

    protected $casts = [
        'options' => 'json',
    ];

    protected $withCount = [
        'likers',
        'comments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function auth_like()
    {
        return $this->likers()->where('user_id', auth()->id());
    }

    public function slugify()
    {
        $this->setSlugGenerator(function($name) {
            return base64_encode($name);
        });

        return $this;
    }
}
