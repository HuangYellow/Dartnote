<?php

namespace App;

use App\Eloquent\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use App\Foundations\Slugify;

class Post extends Model implements TaggableInterface
{
    use SoftDeletes, Slugify, CanBeLiked, HasStatus;

    protected $table = 'posts';

    protected $guarded = [];

    protected $casts = [
        'options' => 'json',
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
}
