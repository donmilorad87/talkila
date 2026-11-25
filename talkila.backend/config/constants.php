<?php

use Carbon\Carbon;

$date = Carbon::now();


return [
    //Transaction Status
    'CANCELLED' => 0,
    'COMPLETED' => 1,
    'PENDING' => 2,

    //Cancel Status
    'CHARGEABLE' => 0,
    'NON_CHARGEABLE' => 1,
    'REFUNDABLE' => 2,

    //Cancel APi Constant
    'CURRENT_DATE' => strtotime($date->toDateTimeString()),
    '24Hrs' => 86400,



];
