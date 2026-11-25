<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\UserVisited;
use Faker\Generator as Faker;

$factory->define(UserVisited::class, function (Faker $faker) use($factory) {
    return [
        'user_id' => $factory->create(User::class)->id,
        'visited_user_id' => $factory->create(User::class)->id,
    ];
});
