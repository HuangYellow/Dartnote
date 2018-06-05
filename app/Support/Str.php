<?php

namespace App\Support;

class Str
{
    public static function fetchTags($value)
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
}