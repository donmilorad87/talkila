<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserFollowed;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(UserFollowed::class, function (Faker $faker) use ($factory) {
    return [
        'state' => $faker->numberBetween($min = 1, $max = 100),
        'user_id' => $factory->create(User::class)->id,
        'follower_user_id' => $factory->create(User::class)->id,
    ];
});
