<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaticProfession;
use Faker\Generator as Faker;

$factory->define(StaticProfession::class, function (Faker $faker) {
    return [
        'croatian' => $faker->word,
        'german' => $faker->word,
        'english' => $faker->word,
        'spanish' => $faker->word,
        'french' => $faker->word,
        'italien' => $faker->word,
    ];
});
