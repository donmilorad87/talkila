<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Page names
    |--------------------------------------------------------------------------
    |
    | Here you may specify project page names.
    |
    */

    'prices' => [
        '1_10'    => [
            'from' => 1,
            'to'   => 10,
        ],
        '10_50'   => [
            'from' => 10,
            'to'   => 50,
        ],
        'over50'  => [
            'from' => 50,
            'to'   => INF,
        ],
        'over100' => [
            'from' => 100,
            'to'   => INF,
        ],
    ],

    'days' => [
        'monday'    => 1,
        'tuesday'   => 2,
        'wednesday' => 3,
        'thursday'  => 4,
        'friday'    => 5,
        'saturday'  => 6,
        'sunday'    => 7,
    ],

    'talks' => [
        'voice'     => 1,
        'video'     => 2,
    ],
];
