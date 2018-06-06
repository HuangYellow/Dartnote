<?php

namespace App\Fetching;

use App\Fetching\Contracts\FetchesWhenResolved;

class Tag implements FetchesWhenResolved
{
    public static function fetchesResolved($value)
    {
        $matches = [];

        if (! empty($value)) {
            preg_match_all("/(#\w+)/u", $value, $matches);
        }

        if (empty($matches)) {
            return;
        }

        $hashtagsArray = array_count_values($matches[0]);
        $hashtags = array_keys($hashtagsArray);

        return preg_replace('/#([\w-]+)/u', '$1', $hashtags);
    }

    public static function empty($tags)
    {
        return empty($tags);
    }
}