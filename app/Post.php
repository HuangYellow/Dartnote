<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements TaggableInterface
{
    use SoftDeletes, TaggableTrait;

    protected $table = 'posts';

    protected $guarded = [];

    protected $casts = [
        'options' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slugify()
    {
        $this->setSlugGenerator(function($name) {
            return base64_encode($name);
        });

        return $this;
    }
}
