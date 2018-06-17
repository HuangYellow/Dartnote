<?php

namespace App;

use App\Foundations\Slugify;
use Cartalyst\Tags\TaggableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFollow\Traits\CanBeLiked;

class Comment extends Model implements TaggableInterface
{
    use SoftDeletes, HasStatus, Slugify, CanBeLiked;

    protected $table = 'comments';

    protected $guarded = [];

    protected $casts = [
        'options' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function auth_like()
    {
        return $this->likers()->where('user_id', auth()->id());
    }
}
