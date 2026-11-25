<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) use ($factory) {
    return [
        'state' => $faker->boolean($chanceOfGettingTrue = 50),
        'booking_type' => $faker->boolean($chanceOfGettingTrue = 50),
        'anonym' => $faker->boolean($chanceOfGettingTrue = 50),
        'start_call' => date('Y-m-d H:i:s'),
        'end_call' => date('Y-m-d H:i:s'),
        'duration' => $faker->boolean($chanceOfGettingTrue = 50),
        'pin' => $faker->numberBetween($min = 10, $max = 99),
        'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
        'message' => $faker->text($maxNbChars = 150),
        'participant_user_id' => $factory->create(App\Models\User::class)->id,
        'currency' => $factory->create(App\Models\FinanceCurrency::class)->id,
        'cancellation_reason_id' => $factory->create(App\Models\CallsCancellationReason::class)->id,
    ];
});
