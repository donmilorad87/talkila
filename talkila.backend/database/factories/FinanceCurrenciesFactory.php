<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FinanceCurrency;
use Faker\Generator as Faker;

$factory->define(FinanceCurrency::class, function (Faker $faker) {
    return [
        'iso_code' => $faker->isbn10,
        'short_code' => $faker->postcode,
        'name' => $faker->text($maxNbChars = 150),
        'value' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'symbol' => $faker->countryCode,
    ];
});
