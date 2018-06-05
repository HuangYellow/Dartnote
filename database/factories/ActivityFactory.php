<?php

use Faker\Generator as Faker;

$factory->define(\App\Activity::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->lazy(),
        'type' => $faker->randomElement(config('activity.type')),
        'reason' => $faker->randomElement(config('activity.reason')),
    ];
});
