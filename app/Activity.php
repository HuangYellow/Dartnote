<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $table = 'activities';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
