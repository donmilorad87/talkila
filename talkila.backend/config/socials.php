<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Social Network credentials.
    |--------------------------------------------------------------------------
    |
    | Here you may specify Social Network credentials and redirect URIs.
    |
    */

    'apple'    => [
        'client_id'     => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
    ],
    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT'),
    ],
    'google'   => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT'),
        'redirect_uri'  => env('GOOGLE_REDIRECT_URI'),
        'webhook_uri'   => env('GOOGLE_WEBHOOK_URI'),
    ],


];
