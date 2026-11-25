<?php

use App\Models\Auth\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id'         => env('GOOGLE_CLIENT_ID'),
        'client_secret'     => env('GOOGLE_CLIENT_SECRET'),
        'redirect'          => env('GOOGLE_REDIRECT'),
        'calendar_redirect' => env('GOOGLE_CALENDAR_REDIRECT'),
        'recaptcha_sitekey' => env('GOOGLE_RECAPTCHA_SITE_KEY') ?? false
    ],

    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT'),
        'redirect_url_2'=> env('FACEBOOK_REDIRECT_URI2')
    ],

    'stripe' => [
        'model'   => App\User::class,
        'key'     => env('STRIPE_KEY'),
        'secret'  => env('STRIPE_SECRET'),
        'webhook' => [
            'secret'    => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'apple' => [
        "redirect"                    => env("APPLE_REDIRECT_URI"),
        "key_id"                      => env("APPLE_KEY_ID"),
        "team_id"                     => env("APPLE_TEAM_ID"),
        "auth_key"                    => env("APPLE_AUTH_KEY"),
        "client_id"                   => env("APPLE_CLIENT_ID"),
        "client_secret"               => env("APPLE_CLIENT_SECRET"),
        "client_secret_updated_at"    => env("APPLE_CLIENT_SECRET_UPDATED_AT"),
        "refresh_token_interval_days" => env("APPLE_REFRESH_TOKEN_INTERVAL_DAYS"),
    ],

    'linkedin' => [
        'client_id'     => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect'      => env('LINKEDIN_REDIRECT_URI'),
    ],
    'twitter' => [
        'client_id'     => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'client_id_oauth2'     => env('TWITTER_CLIENT_ID_OAUTH2'),
        'client_secret_oauth2' => env('TWITTER_CLIENT_SECRET_OAUTH2'),
        'redirect'      => env('TWITTER_REDIRECT_URI'),
    ],
    'instagram' => [
        'client_id'     => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect'      => env('INSTAGRAM_REDIRECT_URI'),
    ],

    // Twilio services (merged from twiliobackend)
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token'  => env('TWILIO_AUTH_TOKEN'),
        'api_sid'     => env('TWILIO_API_SID'),
        'api_secret'  => env('TWILIO_API_SECRET'),
    ],

    'firebase_notification' => [
        'access_key' => env('FIREBASE_ACCESS_KEY'),
    ],

    'ios_voip_notification' => [
        'apns_topic'    => env('APNS_TOPIC'),
        'apns_cert_name' => env('APNS_CERT_NAME'),
        'urls' => [
            'prod'    => env('IOS_PUSH_URL'),
            'sandbox' => env('IOS_PUSH_URL_SANDBOX'),
        ],
    ],
];
