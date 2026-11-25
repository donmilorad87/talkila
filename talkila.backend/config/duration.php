<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Talkila ringing/room duration
    |--------------------------------------------------------------------------
    |
    | Determines the duration of the ringing/room active state depending on the talk length.
    |
    */

    // Value in seconds that determines for how long will the users phone ring.
    'ringing' => env('RINGING_TIME_FOR_CALL', 60),

    // Value in minutes that determine for how long the room will remain active until supplier joins.
    'room' => [
        'short' => env('PICKUP_TIME_FOR_CALL_UNDER_15', 5),
        'long'  => env('PICKUP_TIME_FOR_CALL_OVER_15', 10),
    ],
];
