<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Exceptions\Handler;
use App\Models\User;
use App\ModelsApi\Availability;
use App\ModelsApi\Booking;
use App\ModelsApi\Talk;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Availability",
 *     description="Everything about Availabilities",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/teacher-availability/{id}",
 *      operationId="getTeacherAvailability",
 *      tags={"Availability"},
 *      summary="Method getTeacherAvailability of AvailabilityApiController",
 *      description="Method getTeacherAvailability of AvailabilityApiController",
 *
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      @OA\Response(response=500, description="Server error"),
 *      @OA\Response(response=503, description="Service unavailable"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Post(
 *      path="/v1/talk-availability/{id}",
 *      operationId="getTalkAvailability",
 *      tags={"Availability"},
 *      summary="Method getTalkAvailability of AvailabilityApiController",
 *      description="Method getTalkAvailability of AvailabilityApiController",
 *
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      @OA\Response(response=500, description="Server error"),
 *      @OA\Response(response=503, description="Service unavailable"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */
class AvailabilityApiController
{
    /**
     * @param  Request  $request
     * @param           $talkId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeacherAvailability(Request $request, $talkId)
    {
        // TODO Unit test

        try {
            Log::notice("\n\n" . '::AvailabilityApiController::getTeacherAvailability::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::AvailabilityApiController::getTeacherAvailability::$talkId');
            Log::notice($talkId);

            $talk                   = Talk::query()->select(['id', 'teacher_user_id', 'duration', 'talk_type', 'max_participiants', 'call_type'])->find($talkId)->toArray();
            $teacherId              = $talk['teacher_user_id'];
            $supplier               = User::find($teacherId);
            $todayDate              = date('Y-m-d');
            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';
            $calendars              = $supplier->getSupplierCalendars();
            $supplier_event_times   = [];

            foreach ($calendars as $calendar) {
                $calendar_events = $calendar->events->toArray();

                if (empty($calendar_events)) {
                    continue;
                }

                foreach ($calendar_events as $event) {
                    $supplier_event_start = convertToUserTimezone($event['start_time'])->toDateTimeString();
                    $supplier_event_end   = convertToUserTimezone($event['end_time'])->toDateTimeString();
                    $intervals            = CarbonInterval::minutes(15)->toPeriod($supplier_event_start, $supplier_event_end);

                    foreach ($intervals as $interval) {
                        $supplier_event_times[] = Carbon::parse($interval)->toDateTimeString();
                    }
                }
            }

            asort($supplier_event_times);

            $supplier_event_times = array_values($supplier_event_times);

            Log::notice("\n\n" . '::AvailabilityApiController::getTeacherAvailability::$supplier_event_times');
            Log::notice(json_encode($supplier_event_times));

            if ($request->user()) {
                $userId = $request->user()->id;
            } else {
                $userId = -99;
            }

            $aBookings = Booking::query()
                ->select(['talk_id', 'start_call', 'end_call', 'teacher_user_id'])
                ->selectRaw('COUNT(talk_id) AS same_bookings')
                ->where(function ($q) use ($todayDate) {
                    $q->where('start_date', '>=', $todayDate);
                    $q->orWhere('end_date', '>=', $todayDate);
                })
                ->where(function ($q) use ($teacherId, $userId) {
                    $q->where('teacher_user_id', $teacherId);
                    $q->orWhere('participant_user_id', $userId);
                })
                ->where('state', Booking::STATE['paid'])
                ->groupBy('start_call', 'end_call', 'talk_id', 'teacher_user_id')
                ->orderBy('start_call')
                ->get()->toArray();

            $takenSlots = [];
            foreach ($aBookings as $aBooking) {
                /* Talk Type Change */
                // if($talk['talk_type'] == 2 && $aBooking['teacher_user_id'] == $teacherId && $aBooking['talk_id'] == $talk['id']) {
                if ($talk['call_type'] == CallTypes::GROUP && $aBooking['teacher_user_id'] == $teacherId && $aBooking['talk_id'] == $talk['id']) {
                    if ($talk['max_participiants'] > $aBooking['same_bookings']) {
                        continue;
                    }
                }

                $aBooking['start_call'] = date('Y-m-d H:i:00', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($aBooking['start_call'])));
                $aBooking['end_call']   = date('Y-m-d H:i:00', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($aBooking['end_call'])));

                $startCall = date('Y-m-d H:i:00', strtotime('-15 minutes', strtotime($aBooking['start_call'])));
                $endCall   = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($aBooking['end_call'])));

                while ($startCall < $endCall) {
                    $takenSlots[$startCall] = true;

                    $startCall = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($startCall)));
                }
            }

            $availabilities = \App\Models\Availability::query()->select('weekday', 'start_time', 'end_time')
                ->where('state', Availability::STATE['valid'])
                ->where('user_id', $teacherId)
                ->orderBy('weekday')
                ->get()
                ->toArray();

            $currentDayDate     = date('N');
            $currentTimeMinutes = date('i');
            $calculateMinutes   = $currentTimeMinutes % 15;
            $finalMinutes       = date('i') - $calculateMinutes;

            $noBookInNextNHoursFrom = date('Y-m-d 00:00:00');
            $userTime               = date('Y-m-d H:' . $finalMinutes . ':00', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes'));
            $noBookInNextNHoursTo   = date('Y-m-d H:i:00', strtotime('+' . \App\Models\Booking::DELAY_PERIOD . ' minutes', strtotime($userTime)));

            while ($noBookInNextNHoursFrom <= $noBookInNextNHoursTo) {
                $takenSlots[$noBookInNextNHoursFrom] = true;

                $noBookInNextNHoursFrom = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($noBookInNextNHoursFrom)));
            }
            $takenSlots[$noBookInNextNHoursFrom] = true;


            $freeSlots = [];
            foreach ($availabilities as $availability) {
                $availabilityWeekDay = $availability['weekday'];

                // Check for a case when weekday in db + timezone of user is not same because of case 23:00 + 2h = next day 01:00
                $addTmpDay                        = 0;
                $availabilityWeekDayAfterUserTime = date('Y-m-d', strtotime('+' . ($availability['weekday'] - $currentDayDate) . ' days'));
                $availabilityWeekDayAfterUserTime = date('N', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($availabilityWeekDayAfterUserTime . " " . $availability['start_time'])));
                if ($availabilityWeekDay + 1 == $availabilityWeekDayAfterUserTime || (($availabilityWeekDay + 1 == 8) && $availabilityWeekDayAfterUserTime == 1)) {
                    $addTmpDay = 1;
                }

                if ((int)$currentDayDate > $availabilityWeekDay + $addTmpDay) {
                    $dayResult = $availabilityWeekDay - $currentDayDate + 7;
                } else {
                    $dayResult = $availabilityWeekDay - $currentDayDate;
                }

                for ($i = 0; $i < Booking::MAX_DAYS_IN_ADVANCE; $i = $i + 7) {
                    $availabilityDate = date('Y-m-d', strtotime('+' . ($dayResult + $i) . ' days'));

                    $startAvailabilityTime = date('Y-m-d H:i:00', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($availabilityDate . " " . $availability['start_time'])));
                    $endAvailabilityTime   = date('Y-m-d H:i:00', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($availabilityDate . " " . $availability['end_time'])));

                    if ($startAvailabilityTime > $endAvailabilityTime) {
                        $endAvailabilityTime = date('Y-m-d H:i:00', strtotime('+1 day', strtotime($endAvailabilityTime)));
                    }

                    $endBookingTime = date('Y-m-d H:i:00', strtotime('+' . ($talk['duration']) . ' minutes', strtotime($startAvailabilityTime)));

                    while ($startAvailabilityTime <= $endAvailabilityTime) {
                        if ($endBookingTime > $endAvailabilityTime) {
                            $startAvailabilityTime = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($startAvailabilityTime)));
                            $endBookingTime        = date('Y-m-d H:i:00', strtotime('+' . ($talk['duration']) . ' minutes', strtotime($startAvailabilityTime)));
                            continue;
                        }
                        $tmpStartCounter         = $startAvailabilityTime;
                        $tmpNoFreeTimeForBooking = false;
                        while ($tmpStartCounter < $endBookingTime) {
                            if (isset($takenSlots[$tmpStartCounter])) {
                                $tmpStartCounter         = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($tmpStartCounter)));
                                $tmpNoFreeTimeForBooking = true;
                            }
                            $tmpStartCounter = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($tmpStartCounter)));
                        }

                        if (! isset($takenSlots[$startAvailabilityTime]) && $tmpNoFreeTimeForBooking === false) {
//                            $slotDateTime = date('Y-m-d H:i:00',  strtotime($requestTimezoneSign.$requestTimezoneHour.' hours '. $requestTimezoneSign.$requestTimezoneMinutes .' minutes', strtotime($startAvailabilityTime)));

                            if (! in_array($startAvailabilityTime, $supplier_event_times)) {
                                $freeSlots[substr($startAvailabilityTime, 0, 10)][] = $startAvailabilityTime;
                            }
                            // $freeSlots[substr($startAvailabilityTime, 0, 10)][] = $startAvailabilityTime;
                        }

                        $startAvailabilityTime = date('Y-m-d H:i:00', strtotime('+15 minutes', strtotime($startAvailabilityTime)));
                        $endBookingTime        = date('Y-m-d H:i:00', strtotime('+' . ($talk['duration']) . ' minutes', strtotime($startAvailabilityTime)));
                    }
                }
            }
            ksort($freeSlots);

            // return $supplier_event_times;

            if (empty($freeSlots)) {
                $response = response()->json([
                    'message' => __('NO_FREE_SLOTS'),
                    'success' => true,
                ], 200);
            } else {
                $response = response()->json([
                    'data'    => $freeSlots,
                    'message' => __('SUCCESSFULLY_RETRIEVED_AVAILABILITIES'),
                    'success' => true,
                ], 200);
            }


            Log::notice("\n\n" . '::AvailabilityApiController::getTeacherAvailability::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2100, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2100,
                'success' => false,
            ], 500);
        }
    }

    public function getSupplierAvailability(Request $request, $talkId)
    {
        Log::notice("\n\n" . '::AvailabilityApiController::getSupplierAvailability::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::AvailabilityApiController::getSupplierAvailability::$talkId');
        Log::notice($talkId);

        try {
            $talkApi        = new AvailabilityApiController();
            $availabilities = $talkApi->getTeacherAvailability($request, $talkId)->getData(true);

            if (! isset($availabilities['data'])) {
                return response()->success($availabilities['message']);
            }

            $availabilities = $availabilities['data'];

            $calendars = $request->user()->getClientCalendars();

            $events = [];

            foreach ($calendars as $calendar) {
                // $calendar_response = (new CalendarController())->events($request, $request->user(), $calendar);
                $calendar_response = $calendar->events->toArray();
                // $events = $calendar->events;

                if (empty($calendar_response)) {
                    continue;
                }

                // $calendar_items = $calendar_response['items'];

                $response_events = array_map(function ($event) use ($calendar) {
                    return [
                        'calendar'   => $calendar['name'],
                        'start_time' => convertToUserTimezone($event['start_time'])->toDateTimeString(),
                        'end_time'   => convertToUserTimezone($event['end_time'])->toDateTimeString(),
                        'name'       => $event['name'] ?? 'No title',
                    ];
                }, $calendar_response);

                $events = array_merge($events, $response_events);
            }

            usort($events, [$this, 'sortEvents']);

            $supplier_slots = [];

            foreach ($availabilities as $date => $availability) {
                $availability_data         = [];
                $overlapping_temp          = [];
                $slot_counter              = 0;
                $group_id                  = 0;
                $previous_overlap          = false;
                $availability_data['date'] = $date;
                $items                     = [];

                foreach ($availability as $slot) {
                    $has_overlap = false;

                    foreach ($events as $event) {
                        $event_name  = $event['name'];
                        $event_start = $event['start_time'];
                        $event_end   = $event['end_time'];
                        $calendar    = $event['calendar'];

                        if ($slot >= $event_start && $slot < $event_end) {
                            if (! isset($overlapping_temp['id']) || $overlapping_temp['id'] != $group_id) {
                                $overlapping_temp['id'] = $group_id;
                            }

                            $event_model = [
                                'name'  => $event_name,
                                'start' => $event_start,
                                'end'   => $event_end,
                            ];

                            if (! empty($items) && isset($items[$group_id])) {
                                $index = $this->itemAlreadySet($items[$group_id], $calendar);

                                if (! is_null($index)) {
                                    $temp_array = $items[$group_id][$index]['events'];

                                    $exists = false;

                                    foreach ($temp_array as $item) {
                                        if ($item === $event_model) {
                                            $exists = true;
                                        }
                                    }

                                    if (! $exists) {
                                        $items[$group_id][$index]['events'][] = $event_model;
                                    }
                                } else {
                                    $items[$group_id][] = [
                                        'calendar' => $calendar,
                                        'events'   => [
                                            $event_model,
                                        ],
                                    ];
                                }
                            } else {
                                $items[$group_id] = [
                                    [
                                        'calendar' => $calendar,
                                        'events'   => [
                                            $event_model,
                                        ],
                                    ],
                                ];
                            }

                            $has_overlap = true;
                        }
                    } // Events loop

                    // Adding time slot...
                    $availability_data['time_slots'][$slot_counter] = [
                        'time' => $slot,
                    ];

                    // Has overlaps...
                    if (! empty($overlapping_temp)) {
                        $overlapping_temp['items']                                  = $items[$group_id];
                        $availability_data['overlapping_events'][$group_id]         = $overlapping_temp;
                        $availability_data['time_slots'][$slot_counter]['event_id'] = $group_id;
                        $overlapping_temp                                           = [];
                    }

                    // Has no overlaps...
                    if ($previous_overlap && ! $has_overlap) {
                        $group_id++;
                    }

                    $previous_overlap = $has_overlap;
                    $slot_counter++;
                } // Slot loop

                asort($availability_data);

                $supplier_slots[] = $availability_data;
            }  // Date loop

            if (empty($supplier_slots)) {
                return response()->success(__('NO_SUPPLIER_AVAILABILITIES'));
            }

            return response()->success([
                'message' => __('SUPPLIER_AVAILABILITIES'),
                'data'    => [
                    'availabilities' => $supplier_slots,
                ],
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2101, self::class, __FUNCTION__);

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function sortEvents($current_event, $next_event)
    {
        if ($current_event['start_time'] > $next_event['end_time']) {
            return true;
        }
    }

    public function itemAlreadySet($items, $calendar)
    {
        $index = null;

        foreach ($items as $key => $item) {
            if (isset($item['calendar']) && $item['calendar'] == $calendar) {
                $index = $key;
            }
        }

        return $index;
    }

    /**
     * @param  Request  $request
     * @param           $talkId
     * @param  null     $date
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTalkAvailability(Request $request, $talkId, $date = null)
    {
        try {
            Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$talkId');
            Log::notice($talkId);

            Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$date');
            Log::notice($date);

            if (! empty($date)) {
                $requestedDayDate = $date;
            } else {
                if (empty($request->input('requested_date'))) {
                    $response = response()->json([
                        'errors'  => [
                            'requested_date' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'Date']),
                        ],
                        'message' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'Date']),
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$response');
                    Log::notice($response);

                    return $response;
                }

                $requestedDayDate = $request->input('requested_date');
            }

            $requestedDay = date('N', strtotime($requestedDayDate));
            $talk         = Talk::query()->select('id', 'duration', 'teacher_user_id')->find($talkId)->toArray();
            $bookings     = Booking::query()->selectRaw("TO_CHAR(start_call, 'YYYY-MM-DD') as date_period")
                ->selectRaw("TO_CHAR(start_call, 'HH24:MI:SS') as start_time_call")
                ->selectRaw("TO_CHAR(end_call, 'HH24:MI:SS') as end_time_call")
                ->where('state', Booking::STATE['paid'])
                ->whereDate('start_call', $requestedDayDate);

            $originalBooking = clone $bookings;
            $studentBookings = $originalBooking->where('participant_user_id', $request->user()->id)->get()->toArray();
            $talkBooking     = $bookings->where('talk_id', $talkId)->get()->toArray();

            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';


            $removeFromTalk    = [];
            $removeFromStudent = [];

            foreach ($talkBooking as $booking) {
                $booking_start_time = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking['start_time_call'])));
                $booking_end_time   = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking['end_time_call'])));

                $start_hours = date('H:i', strtotime('-' . $talk['duration'] . ' minutes', strtotime($booking_start_time)));
                $end_hours   = date('H:i', strtotime('+15 minutes', strtotime($booking_end_time)));

                while (strtotime($start_hours) <= strtotime($end_hours)) {
                    $removeFromTalk[] = date('H:i', strtotime($start_hours));
                    $start_hours      = date('H:i', strtotime('+15 minutes', strtotime($start_hours)));
                }
            }

            foreach ($studentBookings as $booking) {
                $booking_start_time = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking['start_time_call'])));
                $booking_end_time   = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking['end_time_call'])));

                $start_hours = date('H:i', strtotime('-' . $talk['duration'] . ' minutes', strtotime($booking_start_time)));
                $end_hours   = date('H:i', strtotime('+15 minutes', strtotime($booking_end_time)));

                while (strtotime($start_hours) <= strtotime($end_hours)) {
                    $removeFromStudent[] = date('H:i', strtotime($start_hours));
                    $start_hours         = date('H:i', strtotime('+15 minutes', strtotime($start_hours)));
                }
            }

            $availabilityTimeConstant = Availability::TIME;

            $availableTimeAfterBooking = array_diff($availabilityTimeConstant, $removeFromTalk);
            $availableTime             = array_diff($availableTimeAfterBooking, $removeFromStudent);

            $availability = \App\Models\Availability::query()->select('weekday', 'start_time', 'end_time')
                ->where('state', Availability::STATE['valid'])
                ->where('weekday', $requestedDay)
                ->where('user_id', $talk['teacher_user_id'])
                ->get()
                ->toArray();

            if (empty($availability)) {
                $response = response()->json([
                    // 'message' => 'Requested teacher dont have assigned availability time.',
                    'message' => __('NO_SUPPLIER_AVAILABILITIES'),
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$response');
                Log::notice($response);

                return $response;
            }

            $available_time = [];
            foreach ($availability as $available) {
                $available_start_time = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($available['start_time'])));
                $available_end_time   = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($available['end_time'])));

                $start_hours = date('H:i', strtotime($available_start_time));
                $end_hours   = date('H:i', strtotime('-' . $talk['duration'] . ' minutes', strtotime($available_end_time)));

                while (strtotime($start_hours) <= strtotime($end_hours)) {
                    $available_time[] = date('H:i', strtotime($start_hours));
                    $start_hours      = date('H:i', strtotime('+15 minutes', strtotime($start_hours)));
                }
            }

            $teacherAvailableTime = array_intersect($availableTime, $available_time);

            $teacherAvailability = [];
            foreach (array_values($teacherAvailableTime) as $availabilityTime) {
                $teacherAvailability[] = $requestedDayDate . ' ' . $availabilityTime . ':00';
            }

            if (empty($teacherAvailability)) {
                $response = response()->json([
                    // 'message' => 'Logged in user dont have teacher availability',
                    'message' => __('NO_AVAILABILITIES'),
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $teacherAvailability,
                // 'message' => 'Available time of teacher for requested day.',
                'message' => __('SUPPLIER_AVAILABILITIES'),
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::AvailabilityApiController::getTalkAvailability::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2102, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2102,
                'success' => false,
            ], 500);
        }
    }
}
