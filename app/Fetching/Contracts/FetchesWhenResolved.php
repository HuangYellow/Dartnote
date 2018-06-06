<?php

namespace App\Fetching\Contracts;

interface FetchesWhenResolved
{
    public static function fetchesResolved($value);
}