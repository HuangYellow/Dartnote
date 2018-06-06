<?php

namespace App\Presenters;

use App\Post;

class PostPresenter
{
    public function status($status)
    {
        return $status == Post::$private ? 'Private' : 'Public';
    }
}
