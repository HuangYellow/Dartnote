<?php
namespace App;

trait HasStatus
{
    public static $private = 0;

    public static $public = 1;

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePrivate($query)
    {
        return $query->status(static::$private);
    }

    public function scopePublic($query)
    {
        return $query->status(static::$public);
    }
}