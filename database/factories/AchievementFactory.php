<?php

use Faker\Generator as Faker;

$factory->define(App\Achievement::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'experience' => $faker->randomNumber(),
    ];
});
