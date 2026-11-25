<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaticMetric;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(StaticMetric::class, function (Faker $faker) use($factory) {
    return [
        'follower' => $faker->numberBetween($min = 1, $max = 500),
        'reviews' => $faker->numberBetween($min = 1, $max = 500),
        'calls' => $faker->numberBetween($min = 1, $max = 50),
        'revenue' => $faker->numberBetween($min = 1, $max = 500),
        'bad_reports' => $faker->numberBetween($min = 1, $max = 300),
        'send_emails' => $faker->numberBetween($min = 1, $max = 300),
        'searches_per_day' => $faker->numberBetween($min = 1, $max = 300),
        'visited_user_profils_per_day' => $faker->boolean($chanceOfGettingTrue = 50),
        'dont_show_again' => $faker->numberBetween($min = 1, $max = 30),
        'visited' => $faker->numberBetween($min = 1, $max = 30),
        'user_id' => $factory->create(User::class)->id,
    ];
});
