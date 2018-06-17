<?php

if (! function_exists('gravatar')) {
    function gravatar($email, $size = null, $rating = null)
    {
        return \Gravatar::src($email, $size, $rating);
    }
}