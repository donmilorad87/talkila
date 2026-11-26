<?php

/*
 * App-specific settings that application code used to read with env() directly.
 * In production `php artisan config:cache` runs on every deploy, and after that env() returns null everywhere
 * except in config/ files, so application code must read these through config('talkila.…').
 */
return [
    'payment_gateway'              => env('PAYMENT_GATEWAY'),
    'number_of_char_for_show_more' => env('NUMBER_OF_CHAR_FOR_SHOW_MORE', 200),
    'postpone_time'                => env('POSTPONE_TIME'),
    'account_verification'         => env('ACCOUNT_VERIFICATION', '/account-verification'),
    'app_url_string'               => env('APP_URL_STRING'),
    'sendgrid_api_key'             => env('SENDGRID_API_KEY'),
    'webhook_client_secret'        => env('WEBHOOK_CLIENT_SECRET'),
    'stripe_api_base_url'          => env('STRIPE_API_BASE_URL', 'https://api.stripe.com/v1/'),

    'adyen' => [
        'merchant_account' => env('YOUR_MERCHANT_ACCOUNT'),
        'x_api_key'        => env('YOUR_X_API_KEY'),
    ],

    'paypal' => [
        'endpoints'   => env('PAYPAL_ENDPOINTS'),
        'connect_jtc' => env('PAYPAL_CONNECT_JTC'),
        'sbn_code'    => env('SBN_CODE'),
    ],
];
