<?php

use App\Entity\CallTypes;
use App\Entity\TalkTypes;
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

    'filter' => [
        'type'         => [
            'field'  => 'call_type',
            'values' => [
                /* Talk Type Change */
                // 'private'   => [
                //     [
                //         'value' => Talk::TALK_TYPE['face_to_face'],
                //         'operator' => '='
                //     ]
                // ],
                'private' => [
                    [
                        'value'    => CallTypes::ONE_TO_ONE,
                        'operator' => '=',
                    ],
                ],
                /* Talk Type Change */
                // 'group'     => [
                //     [
                //         'value' => Talk::TALK_TYPE['group'],
                //         'operator' => '='
                //     ]
                // ]
                'group' => [
                    [
                        'value'    => CallTypes::GROUP,
                        'operator' => '=',
                    ],
                ],
            ],
        ],
        'priceRange'   => [
            'field'  => 'talks.price',
            'values' => [
                '1_10'    => [
                    [
                        'value'    => 1,
                        'operator' => '>=',
                    ],
                    [
                        'value'    => 10,
                        'operator' => '<=',
                    ],
                ],
                '10_50'   => [
                    [
                        'value'    => 10,
                        'operator' => '>=',
                    ],
                    [
                        'value'    => 50,
                        'operator' => '<=',
                    ],
                ],
                'over50'  => [
                    [
                        'value'    => 50,
                        'operator' => '>=',
                    ],
                ],
                'over100' => [
                    [
                        'value'    => 100,
                        'operator' => '>=',
                    ],
                ],
            ],
        ],
        'duration'     => [
            'field'  => 'duration',
            'values' => [],
        ],
        'availability' => [
            'field'  => 'weekday',
            'values' => [
                'monday'    => [
                    [
                        'value'    => 1,
                        'operator' => '=',
                    ],
                ],
                'tuesday'   => [
                    [
                        'value'    => 2,
                        'operator' => '=',
                    ],
                ],
                'wednesday' => [
                    [
                        'value'    => 3,
                        'operator' => '=',
                    ],
                ],
                'thursday'  => [
                    [
                        'value'    => 4,
                        'operator' => '=',
                    ],
                ],
                'friday'    => [
                    [
                        'value'    => 5,
                        'operator' => '=',
                    ],
                ],
                'saturday'  => [
                    [
                        'value'    => 6,
                        'operator' => '=',
                    ],
                ],
                'sunday'    => [
                    [
                        'value'    => 7,
                        'operator' => '=',
                    ],
                ],
            ],
        ],
        'anonTalks'    => [
            'field'  => 'anonym_call',
            'values' => [],
        ],
        'talks'        => [
            'field'  => 'talk_type',
            'values' => [
                /* Call Type Change */
                // 'voice'   => [
                //     [
                //         'value' => Talk::CALL_TYPE['voice_call'],
                //         'operator' => '='
                //     ]
                // ],
                'voice' => [
                    [
                        'value'    => TalkTypes::VOICE_CALL,
                        'operator' => '=',
                    ],
                ],
                /* Call Type Change */
                // 'video'     => [
                //     [
                //         'value' => Talk::CALL_TYPE['video_call'],
                //         'operator' => '='
                //     ]
                // ]
                'video' => [
                    [
                        'value'    => TalkTypes::VIDEO_CALL,
                        'operator' => '=',
                    ],
                ],
            ],
        ],
        'language_id'  => [
            'field'  => 'languages_id',
            'values' => [],
        ],
    ],
];
