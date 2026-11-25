<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\UserReported;
use Faker\Generator as Faker;

$factory->define(UserReported::class, function (Faker $faker) use($factory) {
    return [
        'description' => $faker->text($maxNbChars = 250),
        'type_id' => $faker->numberBetween($min = 1, $max = 9),
        'state' => $faker->boolean($chanceOfGettingTrue = 50),
        'user_id' => $factory->create(User::class)->id,
        'reporter_user_id' => $factory->create(User::class)->id,
    ];
});
