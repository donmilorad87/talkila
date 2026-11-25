<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LanguagesProfil;
use App\Models\User;
use App\Models\Language;
use Faker\Generator as Faker;

$factory->define(LanguagesProfil::class, function (Faker $faker) use ($factory) {
    return [
        'level' => $faker->numberBetween($min = 0, $max = 9),
        'user_id' => $factory->create(User::class)->id,
        'language_id' => $factory->create(Language::class)->id,
    ];
});
