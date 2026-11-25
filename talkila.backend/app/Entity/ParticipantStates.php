<?php

namespace App\Entity;

class ParticipantStates
{
    // const INACTIVE = 0;
    // const JOINED = 1;
    // const REJOINED = 2;
    // const HANGUP = 3;
    // const KICKED = 4;
    // const DIDNT_SHOW = 5;
    // const TIME_ENDED = 6;

    const INACTIVE = 0;
    const JOINED = 1;
    const REJOINED = 2;
    const HANGUP = 3;
    const OTHER_PERSON_HANGUP = 4;
    const KICKED = 5;
    const DIDNT_SHOW = 6;
    const OTHER_PERSON_DIDNT_SHOW = 7;
    const TIME_ENDED = 8;
    const DECLINED = 9;
}
