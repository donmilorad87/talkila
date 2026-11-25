<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PayPal Details
    |--------------------------------------------------------------------------
    |
    | Here you may specify PayPal details.
    |
    */

    'client_id'    => env('PAYPAL_CLIENT_ID'),
    'secret'       => env('PAYPAL_SECRET'),
    'environment'  => env('PAYPAL_ENVIRONMENT'),
    'rest_version' => env('PAYPAL_REST_VERSION'),
];
