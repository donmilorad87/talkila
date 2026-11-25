<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookingsPayout;
use App\Models\Booking;
use App\Models\Payout;
use Faker\Generator as Faker;

$factory->define(BookingsPayout::class, function (Faker $faker) use ($factory) {
    return [
        'bookings_id' => $factory->create(Booking::class)->id,
        'payouts_id' => $factory->create(Payout::class)->id,
    ];
});
