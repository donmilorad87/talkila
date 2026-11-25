<?php

namespace App\Entity;

class CancellationReasons
{
    const CLIENT = [
        'found_a_cheaper_talk'   => 1,
        'no_longer_interested'   => 2,
        'something_has_come_up'  => 3,
        'dont_like_the_provider' => 4,
        'do_not_give_a_reason'   => 5,
        'talk_deleted'           => 6,
    ];

    const SUPPLIER = [
        'time_constraints'                     => 7,
        'do_not_want_to_talk_with_participant' => 8,
        'do_not_give_a_reason'                 => 9,
    ];

    const ACTIVE_TALK_CLIENT = [
        'end_it_early'                  => 10,
        'participant_no_longer_present' => 11,
        'participant_rude_or_insulting' => 12,
        'internet_connection_is_bad'    => 13,
        'do_not_give_a_reason'          => 14,
    ];

    const ACTIVE_TALK_SUPPLIER = [
        'end_it_early'                          => 15,
        'no_more_time'                          => 16,
        'internet_connection_is_bad'            => 17,
        'i_am_not_satisfied_with_the_talk'      => 18,
        'the_provider_is_no_longer_in_the_talk' => 19,
        'do_not_give_a_reason'                  => 20,
    ];
}