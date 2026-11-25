<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payout;
use App\Models\FinanceCurrency;
use Faker\Generator as Faker;

$factory->define(Payout::class, function (Faker $faker) use ($factory) {
    return [
        'payout_date' => date('Y-m-d H:i:s'),
        'price' => $faker->numberBetween($min = 1, $max = 99),
        'invoice_number' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'sales_tax' => $faker->numberBetween($min = 1, $max = 99),
        'reference' => $faker->text($maxNbChars = 40),
        'transferred_date' => date('Y-m-d H:i:s', strtotime("+1 days")),
        'finance_currencies_id' => $factory->create(FinanceCurrency::class)->id,
    ];
});
