<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'short_code' => $faker->numberBetween($min = 99, $max = 999),
        'shorter_code' => $faker->numberBetween($min = 10, $max = 99),
        'english' => $faker->word,
        'german' => $faker->word,
        'croatian' => $faker->word,
        'spanish' => $faker->word,
        'french' => $faker->word,
        'italian' => $faker->word,
        'dutch' => $faker->word,
        'polish' => $faker->word,
        'danish' => $faker->word,
        'hungarian' => $faker->word,
        'portuguese' => $faker->word,
        'russian' => $faker->word,
        'turkish' => $faker->word,
        'bulgarian' => $faker->word,
        'romanian' => $faker->word,
        'slovak' => $faker->word,
        'czech' => $faker->word,
    ];
});
