<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BillingAddress;
use Faker\Generator as Faker;

$factory->define(BillingAddress::class, function (Faker $faker) use ($factory) {
    return [
        'street' => $faker->streetName,
        'zipcode' => $faker->postcode,
        'city' => $faker->city,
        'company_name' => $faker->company,
        'tax_number' => $faker->ean13,
        'email' => $faker->safeEmail,
        'tel_number' => $faker->e164PhoneNumber,
        'countries_id' => $factory->create(App\Models\Country::class)->id,
    ];
});
