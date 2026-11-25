<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaticBlockedUser;
use Faker\Generator as Faker;

$factory->define(StaticBlockedUser::class, function (Faker $faker) {
    return [
        'email' => $faker->email(),
    ];
});
