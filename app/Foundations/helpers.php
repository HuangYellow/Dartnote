<?php

if (! function_exists('gavatar')) {
    function gavatar($email, $size = null, $rating = null)
    {
        return \Gravatar::src($email, $size, $rating);
    }
}