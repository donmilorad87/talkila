<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\UserBlocked;
use Faker\Generator as Faker;

$factory->define(UserBlocked::class, function (Faker $faker) use ($factory)  {
    return [
        'state' => $faker->numberBetween($min = 1, $max = 100),
        'user_id' => $factory->create(App\Models\User::class)->id,
        'blocked_user_id' => $factory->create(App\Models\User::class)->id,
    ];
});
