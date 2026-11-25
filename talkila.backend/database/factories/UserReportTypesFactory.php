<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserReportType;
use Faker\Generator as Faker;

$factory->define(UserReportType::class, function (Faker $faker) {
    return [
        'name' => $faker->name($gender = null),
        'croatian' => $faker->text($maxNbChars = 25),
        'english' => $faker->text($maxNbChars = 25),
        'german' => $faker->text($maxNbChars = 25),
    ];
});
