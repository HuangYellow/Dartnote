<?php

namespace App\Foundations;

use Cartalyst\Tags\TaggableTrait;

trait Slugify
{
    use TaggableTrait;

    public function slugify()
    {
        $this->setSlugGenerator(function($name) {
            return base64_encode($name);
        });

        return $this;
    }
}