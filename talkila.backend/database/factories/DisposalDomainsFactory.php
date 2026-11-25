<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DisposalDomain;
use Faker\Generator as Faker;

$factory->define(DisposalDomain::class, function (Faker $faker) {
    return [
        'domain' => $faker->domainName,
    ];
});
