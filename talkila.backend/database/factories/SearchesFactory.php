<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Search;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Search::class, function (Faker $faker) use ($factory) {
    return [
        'term' => $faker->text($maxNbChars = 40),
        'user_id' => $factory->create(User::class)->id,
    ];
});
