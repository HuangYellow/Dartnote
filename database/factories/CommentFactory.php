<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'commentable_type' => 'posts',
        'commentable_id' => 1,
        'user_id' => factory(\App\User::class)->lazy(),
        'description' => $faker->paragraph(),
    ];
});
