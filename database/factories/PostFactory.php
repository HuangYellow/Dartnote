<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->lazy(),
        'content' => $faker->paragraph,
        'options' => [
            'url' => $faker->url,
            'title' => $faker->title,
            'description' => $faker->paragraph,
            'image' => $faker->imageUrl(),
        ]
    ];
});
