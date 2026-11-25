<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CallsCancellationReason;
use Faker\Generator as Faker;

$factory->define(CallsCancellationReason::class, function (Faker $faker) {
    return [
        'croatian' => $faker->text($maxNbChars = 25),
        'english' => $faker->text($maxNbChars = 25),
        'german' => $faker->text($maxNbChars = 25),
        'state' => $faker->randomDigit,
    ];
});
