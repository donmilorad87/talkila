<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Language;
use Faker\Generator as Faker;

$factory->define(Language::class, function (Faker $faker) {
    return [
        'code' => $faker->numberBetween($min = 99, $max = 999),
        'croatian' => $faker->text($maxNbChars = 15),
        'english' => $faker->text($maxNbChars = 15),
        'german' => $faker->text($maxNbChars = 15),
    ];
});
