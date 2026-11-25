<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DisposalEmail;
use Faker\Generator as Faker;

$factory->define(DisposalEmail::class, function (Faker $faker) {
    return [
        'email' => $faker->email(),
    ];
});
