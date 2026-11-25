<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProfilPayoutMethod;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(ProfilPayoutMethod::class, function (Faker $faker) use ($factory) {
    return [
        'method'    => $faker->numberBetween($min = 1, $max = 2),
        'value'     => $faker->text($maxNbChars = 40),
        'state'     => $faker->boolean($chanceOfGettingTrue = 50),
        'user_id'   => $factory->create(User::class)->id,
    ];
});
