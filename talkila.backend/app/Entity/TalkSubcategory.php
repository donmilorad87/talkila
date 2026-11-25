<?php

namespace App\Entity;

class TalkSubcategory
{
    // Language
    const LANGUAGE = [
        'GERMAN'     => 1,
        'CROATIAN'   => 2,
        'ENGLISH'    => 3,
        'SPANISH'    => 4,
        'FRENCH'     => 5,
        'ITALIAN'    => 6,
        'PORTUGUESE' => 7,
        'DUTCH'      => 8,
        'RUSSIAN'    => 9,
        'UKRAINIAN'  => 10,
        'TURKISH'    => 11,
        'DANISH'     => 12,
        'SWEDISH'    => 13,
        'FINNISH'    => 14,
        'NORWEGIAN'  => 15,
        'ARABIAN'    => 16,
        'POLISH'     => 17,
        'OTHER'      => 18,
    ];

    const TUTORING = [
        'MATHEMATICS'             => 19,
        'BIOLOGY'                 => 20,
        'PHYSICS'                 => 21,
        'CHEMISTRY'               => 22,
        'BUSINESS_ADMINISTRATION' => 23,
        'ACCOUNTING'              => 24,
        'ELECTRICAL_ENGINEERING'  => 25,
        'GEOGRAPHY'               => 26,
        'HISTORY'                 => 27,
        'MUSIC'                   => 28,
        'ECONOMICS'               => 29,
        'STATISTICS'              => 30,
        'OTHER'                   => 31,
    ];

    const MUSIC = [
        'ACCORDION'        => 32,
        'WIND_INSTRUMENTS' => 33,
        'VIOLIN'           => 34,
        'SINGING'          => 35,
        'GUITAR'           => 36,
        'HARP'             => 37,
        'KEYBOARD'         => 38,
        'PIANO'            => 39,
        'ORGAN'            => 40,
        'PERCUSSION'       => 41,
        'SAXOPHONE'        => 42,
        'SYNTHESIZER'      => 44,
        'OTHER'            => 45,
    ];

    const ASTROLOGY = [
        'HOROSCOPES' => 46,
        'OTHER'      => 47,
    ];

    const INFLUENCER = [
        'STREAMER' => 48,
        'OTHER'    => 49,
    ];

    const SPORTS = [
        'YOGA'              => 50,
        'PILATES'           => 51,
        'WORKOUT'           => 52,
        'BACK'              => 53,
        'PERSONAL_TRAINING' => 54,
        'OTHER'             => 55,
    ];

    const RELIGION = [
        'CHRISTIANITY' => 56,
        'JUDAISM'      => 57,
        'ISLAM'        => 58,
        'HINDUISM'     => 59,
        'BUDDHISM'     => 60,
        'OTHER'        => 61,
    ];

    const EXPERTS = [
        'LAWYER'            => 62,
        'TAX_CONSULTANT'    => 63,
        'FINANCIAL_ADVISOR' => 64,
        'INSURANCE'         => 65,
        'OTHER'             => 66,
    ];

    const LISTENERS = [
        'PASTORAL_CARE' => 67,
        'OTHER'         => 68,
    ];

    const HEALTH = [
        'NUTRITIONAL_COUNSELING' => 69,
        'VEGAN'                  => 70,
        'VEGETARIANISM'          => 71,
        'OTHER'                  => 72,
    ];

    const FLIRT = [
        'GENERAL' => 73,
        'NLP'     => 74,
        'PICK_UP' => 75,
        'OTHER'   => 76,
    ];

    const PERSONALITY = [
        'PERSONALITY_DEVELOPMENT' => 77,
        'ANXIETY'                 => 78,
        'MARRIAGE_COUNSELING'     => 79,
        'SEX_COUNSELING'          => 80,
        'DEPRESSIONS'             => 81,
        'OTHER'                   => 82,
    ];

    const FUN = [
        'OTHER' => 83,
    ];

    const OTHER = [
        'OTHER' => 84,
    ];
}
