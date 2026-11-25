<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker)  use ($factory) {
    return [
        'state' => $faker->numberBetween($min = 0, $max = 3),
        'visibility' => $faker->numberBetween($min = 1, $max = 2),
        'verified' => 1,
        'verification_token' => $faker->citySuffix,
        'gender' => $faker->numberBetween($min = 0, $max = 2),
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'location' => $faker->state,
//        'location_coordinates' => $faker->latitude.', '. $faker->longitude,
        'description' => $faker->realText($maxNbChars = 100),
        'profession' => $faker->word,
        'profession_id' => $factory->create(App\Models\StaticProfession::class)->id,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'billing_address_id' => $faker->randomDigit,
        'email_activation_id' => $faker->word,
        'notification_message' => $faker->boolean($chanceOfGettingTrue = 50),
        'notification_sound' => $faker->numberBetween($min = 1, $max = 9),
        'profile_picture' => $faker->imageUrl($width = 640, $height = 480),
        'login_type' => $faker->numberBetween($min = 1, $max = 3),
        'gmail_token' => $faker->citySuffix,
        'facebook_token' => $faker->citySuffix,
        'url' => $faker->domainName,
        'approved' => $faker->boolean($chanceOfGettingTrue = 50),
    ];
});
