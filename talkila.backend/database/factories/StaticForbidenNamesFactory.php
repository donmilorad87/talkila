<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaticForbiddenName;
use Faker\Generator as Faker;

$factory->define(StaticForbiddenName::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName($gender = null),
    ];
});
