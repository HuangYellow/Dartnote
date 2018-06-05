<?php

namespace App;

use App\Foundations\Slugify;
use Cartalyst\Tags\TaggableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model implements TaggableInterface
{
    use SoftDeletes, Status, Slugify;

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
}
