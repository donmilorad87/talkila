<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SystemLogin;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SystemLogin::class, function (Faker $faker) use ($factory) {
    return [
        'login_type' => $faker->numberBetween($min = 1, $max = 15),
        'type' => $faker->numberBetween($min = 1, $max = 2),
        'user_id' => $factory->create(User::class)->id,
    ];
});
