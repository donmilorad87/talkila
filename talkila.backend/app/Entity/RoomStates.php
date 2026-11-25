<?php

namespace App\Entity;

class RoomStates
{
    const UNDEFINED           = 0;
    const ROOM_PENDING        = 1;
    const ROOM_DONE           = 2;
    const TEACHER_CANCELLED   = 3;
    const TEACHER_DONT_SHOW   = 4;
    const ROOM_IN_PROGRESS    = 5;
    const STUDENT_DONT_SHOW   = 6;
    const ALL_STUDENTS_HANGUP = 7;
    const NONE_SHOWED                       = 8;
    const ALL_CLIENTS_KICKED                = 9;
    const TEACHER_KICKED_LAST_PARTICIPANT   = 10;
    const USER_DELETED                      = 98;
    const REFUNDED                          = 99;
}
