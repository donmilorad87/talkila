<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Availability;
use Faker\Generator as Faker;

$factory->define(Availability::class, function (Faker $faker) use ($factory) {
    return [
        'weekday' => $faker->boolean($chanceOfGettingTrue = 50),
        'state' => $faker->boolean($chanceOfGettingTrue = 50),
        'start_time' => $faker->time($format = '08:i:s', $max = 'now'),
        'end_time' => $faker->time($format = '10:i:s', $max = 'now'),
        'user_id' => $factory->create(App\Models\User::class)->id,
    ];
});
