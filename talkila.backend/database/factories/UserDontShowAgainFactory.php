<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserDontShowAgain;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(UserDontShowAgain::class, function (Faker $faker) use ($factory) {
    return [
        'user_id' => $factory->create(User::class)->id,
        'dont_show_again_user_id' => $factory->create(User::class)->id,
    ];
});
