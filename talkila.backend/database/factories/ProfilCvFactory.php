<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProfilCv;
use App\Models\User;
use App\Models\StaticProfession;
use Faker\Generator as Faker;

$factory->define(ProfilCv::class, function (Faker $faker) use ($factory) {
    return [
        'type' => $faker->boolean($chanceOfGettingTrue = 50),
        'start_date' => date('Y-m-d'),
        'end_date' => date('Y-m-d', strtotime("+30 days")),
        'company_name' => $faker->company,
        'profession' => $faker->text($maxNbChars = 30),
        'user_id' => $factory->create(User::class)->id,
        'profession_id' => $factory->create(StaticProfession::class)->id,
    ];
});
