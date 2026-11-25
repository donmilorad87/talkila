<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            // PUSHER_HOST empty: Pusher Channels itself (local and production), reached through PUSHER_APP_CLUSTER.
            // PUSHER_HOST set: a self-hosted Pusher-protocol server such as Laravel Reverb.
            // The pusher library only falls back to the cluster when 'host' is absent (null would mean an empty host).
            'options' => array_filter([
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'host' => env('PUSHER_HOST') ?: null,
                'port' => env('PUSHER_PORT') ?: 443,
                'scheme' => env('PUSHER_SCHEME') ?: 'https',
                'encrypted' => true,
                'useTLS' => (env('PUSHER_SCHEME') ?: 'https') === 'https',
            ], fn ($value) => $value !== null),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
