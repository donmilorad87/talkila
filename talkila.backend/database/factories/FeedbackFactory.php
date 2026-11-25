<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Feedback;
use App\Models\User;
use App\Models\Booking;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) use ($factory) {
    return [
        'stars_content' => $faker->numberBetween($min = 1, $max = 10),
        'stars_voice_quality' => $faker->numberBetween($min = 1, $max = 10),
        'description' => $faker->text($maxNbChars = 250),
        'state' => $faker->numberBetween($min = 0, $max = 2),
        'participiant_id' => $factory->create(User::class)->id,
        'booking_id' => $factory->create(Booking::class)->id,
    ];
});
