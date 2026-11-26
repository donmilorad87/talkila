<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Entity\ParticipantStates;
use App\Entity\PaymentMethodTypes;
use App\Entity\RoomStates;
use App\Entity\StateTypes;
use App\Entity\TalkTypes;
use App\Entity\UserTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\Admin\BookingResource;
use App\Jobs\NotifyClientTalkCanceled;
use App\Jobs\NotifyTeacherTalkBooked;
use App\Jobs\NotifyTeacherTalkCanceled;
use App\Jobs\NotifyTeacherTalkPostpond;
use App\Mail\BookingCancellation;
use App\Mail\BookingCancellationClient;
use App\Mail\BookingCancellationSupplier;
use App\Mail\BookingConfirmationClient;
use App\Mail\BookingConfirmationSupplier;
use App\Mail\BookingMessage;
use App\Mail\BookingPostponedClient;
use App\Mail\BookingPostponedSupplier;
use App\Models\BillingAddress;
use App\Models\BookingsBookedSlots;
use App\Models\Country;
use App\Models\Feedback;
use App\Models\Notifications;
use App\Models\SocketParticipant;
use App\Models\SocketRoom;
use App\Models\StaticProfession;
use App\Models\WalletHistory;
use App\ModelsApi\Availability;
use App\ModelsApi\Booking;
use App\ModelsApi\CallsCancellationReason;
use App\ModelsApi\FinanceCurrency;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\Talk;
use App\ModelsApi\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Bookings",
 *     description="Everything about Bookings",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/bookings",
 *      operationId="index",
 *      tags={"Bookings"},
 *      summary="Get list of Bookings",
 *      description="Returns list of Bookings",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of Bookings
 */

/**
 * @OA\Post(
 *      path="/v1/bookings",
 *      operationId="store",
 *      tags={"Bookings"},
 *      summary="Get requested fields from form and create new Booking",
 *      description="Get requested fields from form and create new Booking",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreBookingRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Booking")
 *       ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * @OA\Get(
 *      path="/v1/bookings/{id}",
 *      operationId="show",
 *      tags={"Bookings"},
 *      summary="Get Booking information",
 *      description="Returns Booking data",
 *      @OA\Parameter(
 *          name="id",
 *          description="Booking id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:bookings", "read:bookings"}
 *         }
 *     },
 * )
 */

/**
 * @OA\Put(
 *      path="/v1/bookings/{id}",
 *      operationId="update",
 *      tags={"Bookings"},
 *      summary="Get Booking update information",
 *      description="Get requested fields from form and update requested Booking",
 *      @OA\Parameter(
 *          name="id",
 *          description="Booking id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateBookingRequest")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:bookings", "read:bookings"}
 *         }
 *     },
 * )
 */

/**
 * @OA\Delete(
 *      path="/v1/bookings/{id}",
 *      operationId="destroy",
 *      tags={"Bookings"},
 *      summary="Delete Booking",
 *      description="Take requested Booking and delete it from system",
 *      @OA\Parameter(
 *          name="id",
 *          description="Booking id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:bookings", "read:bookings"}
 *         }
 *     },
 * )
 */

/**
 * @OA\Delete(
 *      path="/v1/bookings/destroy",
 *      operationId="massDestroy",
 *      tags={"Bookings"},
 *      summary="Delete Bookings",
 *      description="Take requested Bookings and delete it from system",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:bookings", "read:bookings"}
 *         }
 *     },
 * )
 */


/**
 * @OA\Post(
 *      path="/v1/api/v1/future-bookings/{id}",
 *      operationId="getFutureBookings",
 *      tags={"Bookings"},
 *      summary="Get Future bookings for requested user for next two month",
 *      description="Get Future bookings for requested user for next two month",
 *      @OA\Parameter(
 *          name="id",
 *          description="Id of requested user",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:future-bookings", "read:future-bookings"}
 *         }
 *     },
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/user-bookings",
 *      operationId="getLoggedUserBookings",
 *      tags={"Bookings"},
 *      summary="Method getLoggedUserBookings of BookingsApiController",
 *      description="Method getLoggedUserBookings of BookingsApiController",
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
 * @OA\Get(
 *      path="/v1/user-bookings-data/{date}",
 *      operationId="getBookings",
 *      tags={"Bookings"},
 *      summary="Method getBookings of BookingsApiController",
 *      description="Method getBookings of BookingsApiController",
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
 * @OA\Get(
 *      path="/v1/booking-data/{id}",
 *      operationId="getBookingData",
 *      tags={"Bookings"},
 *      summary="Method getBookingData of BookingsApiController",
 *      description="Method getBookingData of BookingsApiController",
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
 *      path="/v1/cancel-booking/{id}",
 *      operationId="cancelBooking",
 *      tags={"Bookings"},
 *      summary="Method cancelBooking of BookingsApiController",
 *      description="Method cancelBooking of BookingsApiController",
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
/**
 * @OA\Post(
 *      path="/v1/postpone-booking/{id}",
 *      operationId="postponeBooking",
 *      tags={"Bookings"},
 *      summary="Method postponeBooking of BookingsApiController",
 *      description="Method postponeBooking of BookingsApiController",
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
/**
 * @OA\Post(
 *      path="/v1/set-booking-notification",
 *      operationId="setBookingNotification",
 *      tags={"Bookings"},
 *      summary="Method setBookingNotification of BookingsApiController",
 *      description="Method setBookingNotification of BookingsApiController",
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
/**
 * @OA\Post(
 *      path="/v1/set-booking-message",
 *      operationId="setBookingMessage",
 *      tags={"Bookings"},
 *      summary="Method setBookingMessage of BookingsApiController",
 *      description="Method setBookingMessage of BookingsApiController",
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
/**
 * @OA\Post(
 *      path="/v1/teacher-available-extensions",
 *      operationId="getAvailableExtensions",
 *      tags={"Bookings"},
 *      summary="Method getAvailableExtensions of BookingsApiController",
 *      description="Method getAvailableExtensions of BookingsApiController",
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

/**
 * @OA\Get(
 *      path="/v1/call-extension/{id}/{time}",
 *      operationId="makeCallExtension",
 *      tags={"Bookings"},
 *      summary="Method makeCallExtension of BookingsApiController",
 *      description="Method makeCallExtension of BookingsApiController",
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
class BookingsApiController extends Controller
{
    const JURE          = 228;
    const ALLOWED_USERS = [
        229,
        230,
        231,
        232,
        233,
        234,
        235,
        236,
        237,
        265,
        266,
    ];

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            Log::notice("\n\n" . '::BookingsApiController::index::$request');
            Log::notice($request->all());

            $userBookings = Talk::query()
                ->withGroup()
                ->where('teacher_user_id', $request->user()->id)
                ->pluck('id')
                ->toArray();

            $bookings = Booking::query()->whereIn('talk_id', $userBookings)
                ->where('state', Booking::STATE['paid'])
                ->select(['id', 'state', 'booking_type', 'anonym', 'start_call', 'end_call', 'duration', 'price', 'message', 'created_at', 'currency', 'vat_id'])
                ->get()->toArray();

            if (empty($bookings)) {
                $response = response()->json([
                    'message' => 'There is no bookings data',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::BookingsApiController::index::$request');
                Log::notice($request->all());

                return $response;
            }

            $response = response()->json([
                'data'    => $bookings,
                'message' => 'List of all bookings',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::BookingsApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2300, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2300,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  StoreBookingRequest  $request
     * @param                       $socketBooking
     */
    public function store(Request $request, $socketBooking = false)
    {
        DB::beginTransaction();
        try {
            Log::notice("\n\n" . '::BookingApiController::store::$request');
            Log::notice($request->all());
            $newBookingData = $request->all();

            if (!empty($newBookingData['start_call_time'])) {
                $startCallRequest = $request->input('start_call') . ' ' . $request->input('start_call_time') . ':00';
            } else {
                $startCallRequest = $request->input('start_call');
            }

            $timezone               = $request->input('timezone_offset') * -1 ?: ($request->user()->timezone != '' ? $request->user()->timezone : $request->header('Time-Zone-Offset-UTC'));
            $requestTimezoneHour    = abs((int)(($timezone) / 60));
            $requestTimezoneMinutes = abs((int)(($timezone) % 60));
            $requestTimezoneSign    = $timezone < 0 ? '+' : '-';
            $talkId                 = $request->input('talk_id');

            $date                         = date('Y-m-d H:i:00', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime(str_replace('/', '-', $startCallRequest))));
            $newBookingData['start_call'] = $startCall = $date;

            $anonym    = $request->input('anonym');
            $bookingId = $request->input('booking_id');

            if ($request->has('fake_user_id')) {
                $users = \App\Models\User::query()->find($request->input('fake_user_id'));

                if (!$users instanceof Collection) {
                    $users = [$users];
                }
            } else {
                $users = [$request->user()];
            }

            foreach ($users as $user) {
                $participantUserId = $user->id;

                if (empty($talkId)) {
                    $response = response()->json([
                        'errors'  => [
                            'talk_id' => 'Talk id is required for field.',
                        ],
                        'message' => 'Talk id is required for booking store.',
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::BookingsApiController::store::$response');
                    Log::notice($response);

                    return $response;
                }

                // Disable Partner Users to book any other talk other than the ones Jure created.
                if (Talk::find($talkId)->supplier->id != self::JURE && in_array($request->user()->id, self::ALLOWED_USERS)) {
                    return response()->error([
                        'message' => __('TEST_ACCOUNT_BOOKING_ERROR'),
                        'errors'  => [
                            'booking_restriction' => [
                                __('TEST_ACCOUNT_BOOKING_ERROR'),
                            ],
                        ],
                    ]);
                }

                $talk = Talk::query()->select(['id', 'anonym_call', 'call_type', 'talk_type', 'headline', 'description', 'duration', 'price', 'max_participiants', 'teacher_user_id', 'finance_currencies_id', 'start_time_call', 'end_time_call'])
                    ->whereKey($talkId)
                    ->where('state', Talk::STATE['valid'])
                    ->first();

                if (!empty($request->input('duration'))) {
                    $duration = $request->input('duration');
                } else {
                    $duration = $talk['duration'];
                }

                if (!isset($talk['anonym_call'])) {
                    $response = response()->json([
                        'message' => 'No Talk Found for talk_id: ' . $talkId,
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::BookingsApiController::store::$response');
                    Log::notice($response);

                    return $response;
                } else {
                    $talk = $talk->toArray();
                }

                if ($talk['teacher_user_id'] == $participantUserId) {
                    $response = response()->json([
                        'message' => 'Cannot book yourself talk.',
                        'success' => true,
                    ], 200);

                    Log::notice("\n\n" . '::BookingsApiController::store::$response');
                    Log::notice($response);

                    return $response;
                }
                /* Call Type Change */
                // if ($talk['talk_type'] == Talk::TALK_TYPE['group']) {
                if ($talk['call_type'] == CallTypes::GROUP) {
                    if ($request->has('admin_panel')) {
                        $endCallTime                = date('Y-m-d H:i:00', strtotime('+' . $duration . ' minutes', strtotime($startCall)));
                        $newBookingData['end_call'] = $endCallTime;
                    } else {
                        $endCallTime                = $talk['end_time_call'];
                        $startCallDate              = date('Y-m-d', strtotime($startCall));
                        $newBookingData['end_call'] = $startCallDate . ' ' . $endCallTime;
                    }
                } else {
                    $startCallTime = $startCall;
                    $endCallTime   = date('Y-m-d H:i:00', strtotime('+' . $duration . ' minutes', strtotime($startCallTime)));

                    $newBookingData['end_call'] = $endCallTime;
                }

                if ($request->has('socket_room_booking') && !empty($request->input('socket_room_booking'))) {
                    $delayMinutes = 0;
                } else {
                    $delayMinutes = 15;
                }

                $newBookingData['start_date'] = date('Y-m-d', strtotime($newBookingData['start_call']));
                $newBookingData['end_date']   = date('Y-m-d', strtotime($newBookingData['end_call']));
                $newBookingData['start_time'] = date('H:i:s', strtotime($newBookingData['start_call']));
                $newBookingData['end_time']   = date('H:i:s', strtotime($newBookingData['end_call']));

                $startCallTimeCheck = date('Y-m-d H:i:00', strtotime('-' . $delayMinutes . ' minutes', strtotime($newBookingData['start_call'])));
                $endCallTimeCheck   = date('Y-m-d H:i:00', strtotime('+' . $delayMinutes . ' minutes', strtotime($newBookingData['end_call'])));

                $isBookingBooked = Booking::query()
                    ->where('teacher_user_id', $talk['teacher_user_id'])
                    ->where('state', Booking::STATE['paid'])
                    ->where(function ($q) use ($startCallTimeCheck, $endCallTimeCheck) {
                        $q->where(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                            $q2->where('start_call', '>', $startCallTimeCheck)->where('start_call', '<', $endCallTimeCheck);
                        });

                        $q->orWhere(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                            $q2->where('end_call', '>', $startCallTimeCheck)->where('end_call', '<=', $endCallTimeCheck);
                        });

                        $q->orWhere('start_call', $startCallTimeCheck)->orWhere('end_call', $endCallTimeCheck);

                        $q->orWhere(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                            $q2->whereRaw("'{$startCallTimeCheck}' > start_call")->whereRaw("'{$startCallTimeCheck}' < end_call");
                        });
                    });

                if (!empty($bookingId)) {
                    $isBookingBooked->where('id', '!=', $bookingId);
                }

                // Check for available slots if talks is for group talk

                $copiedBookingBooked = clone $isBookingBooked;
                $isBookingBooked     = $isBookingBooked->exists();
                $bookedTalksCount    = 0;

                /* Call Type Change */
                // if ($talk['talk_type'] == Talk::TALK_TYPE['group']) {
                if ($talk['call_type'] == CallTypes::GROUP) {
                    $bookedTalksCount    = Booking::query()->where('talk_id', $talk)->whereDate('start_date', $newBookingData['start_date'])->get()->count();
                    $copiedBookingBooked = $copiedBookingBooked->where('participant_user_id', $participantUserId)->exists();

                    if ($copiedBookingBooked) {
                        $response = response()->json([
                            'message' => 'Already exist booking of requested user for this talk.',
                            'success' => false,
                        ], 200);

                        Log::notice("\n\n" . '::BookingsApiController::store::$response');
                        Log::notice($response);

                        return $response;
                    }
                }

                /* Call Type Change */
                // if (($talk['talk_type'] == Talk::TALK_TYPE['group'] && $bookedTalksCount >= $talk['max_participiants']) || ($talk['talk_type'] == Talk::TALK_TYPE['face_to_face'] && $isBookingBooked)) {
                if (($talk['call_type'] == CallTypes::GROUP && $bookedTalksCount >= $talk['max_participiants']) || ($talk['call_type'] == CallTypes::ONE_TO_ONE && $isBookingBooked && !$request->input('admin_panel'))) {
                    $response = response()->json([
                        'message' => 'No free time for booking',
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::BookingsApiController::store::$response');
                    Log::notice($response);

                    return $response;
                }

                if ($anonym == 1 && $talk['anonym_call'] != Talk::ANONYM_CALL['allowed']) {
                    $response = response()->json([
                        'message' => 'Anonymous call is not allowed for talk_id: ' . $talkId,
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::BookingsApiController::store::$response');
                    Log::notice($response);

                    return $response;
                }
                $courseTeacher = User::query()->find($talk['teacher_user_id']);

                if ($socketBooking) {
                    $teacherWaletBallance = $user->wallet_balance + $talk['price'];
                    $user->update(['wallet_balance' => $teacherWaletBallance]);
                }

                if ($request->has('admin_panel')) {
                    $client = User::find($participantUserId);
                    $vat_id = $client->vat_id;
                }

                if ($request->has('booking_id')) {
                    $vat_id = Booking::find($newBookingData['booking_id'])->vat_id;
                }

                $this->updateDefaultPaymentMethod($request);

                if ($talk['call_type'] == CallTypes::GROUP) {
                    $this->setTalkTokens((int)$participantUserId, (int)$talk['teacher_user_id']);
                }

                $billing   = $request->user()->billing;
                $vat_id    = $vat_id ?? $billing->countries_id;
                $vat_value = Country::find($vat_id ?? $billing->countries_id)->vat_value;

                $newBookingData['state']                       = Booking::STATE['paid'];
                $newBookingData['participant_user_id']         = $participantUserId;
                $newBookingData['teacher_user_id']             = $talk['teacher_user_id'];
                $newBookingData['currency']                    = $talk['finance_currencies_id'];
                $newBookingData['price']                       = $talk['price'];
                $newBookingData['duration']                    = $duration;
                $newBookingData['supplier_billing_address_id'] = $courseTeacher->billing_address_id;
                $newBookingData['client_billing_address_id']   = $billing->id;
                $newBookingData['vat_id']                      = $vat_id;
                $newBookingData['vat']                         = $vat_value;

                $newBooking = Booking::create($newBookingData);
                $partner    = $newBooking->supplier->partner;

                if ($partner) {
                    $dashboard = $partner->dashboard();

                    /**
                     * Regular Bookings:
                     * 1. Update 'total_bookings'
                     * 2. Update 'total_revenue'
                     */
                    if (!$bookingId) {
                        $dashboard->update([
                            'total_bookings' => DB::raw('total_bookings + 1'),
                            'total_revenue'  => DB::raw("total_revenue + $newBooking->price"),
                        ]);
                    }

                    /**
                     * Extend:
                     * 1. Update 'total_revenue'
                     */
                    if ($newBooking->parent_id && $newBooking->booking_parent->state === Booking::STATE['paid']) {
                        $dashboard->update([
                            'total_revenue' => DB::raw("total_revenue + $newBooking->price"),
                        ]);
                    }
                }

                try {
                    $calendar_account = $this->getCalendarAccount($newBooking->client, $newBooking->supplier);

                    if (isset($calendar_account)) {
                        $this->createCalendarEvent($request, $calendar_account, $bookingId, $newBooking);
                    }
                } catch (\Exception $exception) {
                    Log::notice("Error while creating Calendar Event");
                    Log::notice("{$exception->getFile()} {$exception->getMessage()} {$exception->getLine()}",);
                }

                $notificationData = [
                    'user_id'    => $newBooking->participant_user_id,
                    'type'       => $talk['headline'],
                    'param_type' => 'name_of_talk',
                    'param_id'   => $newBooking->id,
                    'talkName'   => $talk['headline'],
                    'value'      => Notifications::VALUE['new_booking'],
                ];
                $notification     = NotificationsApiController::sendNotification($request, $notificationData);

                Log::notice("\n\n" . '::BookingsApiController::store::$notification');
                Log::notice($notification);

                if ($bookingId > 0) {
                    $requestedBooking = Booking::query()->where('id', $bookingId)->first();

                    if ($request->has('socket_room_booking') && !empty($request->input('socket_room_booking'))) {
                        $delayPeriod = 0;
                    } else {
                        $delayPeriod = Booking::CHANGE_PERIOD;
                    }


                    $aValidation = $this->validateBookingAction($user, $requestedBooking, $delayPeriod);

                    if (!$aValidation['success']) {
                        DB::rollBack();
                        $response = response()->json([
                            'message' => $aValidation['message'],
                            'success' => $aValidation['success'],
                        ], 200);

                        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                        Log::notice($response);

                        return $response;
                    }

                    if ($requestedBooking->state != Booking::STATE['paid']) {
                        DB::rollBack();
                        $response = response()->json([
                            'message' => __('BOOKING_ALREADY_POSTPONED'), //'Booking already cancelled',
                            'success' => false,
                        ], 200);

                        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                        Log::notice($response);

                        return $response;
                    }

                    if ($participantUserId == $requestedBooking->participant_user_id || $participantUserId == $requestedBooking->teacher_user_id) {
                        Booking::query()->find($newBooking->id)->update(['parent_id' => $bookingId]);

                        // TODO, on cancel create new column in DB to we store reschedule_id of new booking
                        // TODO Also add new cancel Reason that we will pass to we know reason is reschedule

                        $cancelBookingResponse = $this->postponeBooking($request, $bookingId)->getData(true);

                        if ($cancelBookingResponse['success'] == false) {
                            DB::rollBack();

                            return response()->json([
                                'message' => $cancelBookingResponse['message'],
                                'success' => false,
                            ], 200);
                        }

                        $originBooking = Booking::query()->find($bookingId);
                        $teacherData   = User::query()->find($originBooking['teacher_user_id']);
                        $clientData    = User::query()->find($originBooking['participant_user_id']);

                        $talkType = $talk['talk_type'] == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk';

                        Mail::to($teacherData->email)->queue(
                            new BookingPostponedSupplier(
                                $teacherData->last_language,
                                $teacherData->email,
                                $teacherData->username,
                                $talk['headline'],
                                // date('d.m.Y', strtotime($newBooking->start_date)),
                                convertToUserTimezone($newBooking->start_date, 'd.m.Y'),
                                // date('H:i', strtotime($newBooking->start_time)),
                                convertToUserTimezone($newBooking->start_time, 'H:i'),
                                // date('H:i', strtotime($newBooking->end_time)),
                                convertToUserTimezone($newBooking->end_time, 'H:i'),
                                $newBooking->duration,
                                $talk['price'],
                                $talkType,
                                $newBooking->id,
                                convertToUserTimezone($originBooking->start_date, 'd.m.Y'),
                                convertToUserTimezone($originBooking->start_time, 'H:i'),
                                convertToUserTimezone($originBooking->end_time, 'H:i'),
                                $newBooking->anonym,
                                $originBooking->duration
                            )
                        );
                        Mail::to($clientData->email)->queue(
                            new BookingPostponedClient(
                                $clientData->last_language,
                                $clientData->email,
                                $teacherData->email,
                                $teacherData->username,
                                $talk['headline'],
                                convertToUserTimezone($newBooking->start_date, 'd.m.Y'),
                                convertToUserTimezone($newBooking->start_time, 'H:i'),
                                convertToUserTimezone($newBooking->end_time, 'H:i'),
                                $newBooking->duration,
                                $talk['id'],
                                $talk['price'],
                                $talkType,
                                $newBooking->id,
                                convertToUserTimezone($originBooking->start_date, 'd.m.Y'),
                                convertToUserTimezone($originBooking->start_time, 'H:i'),
                                convertToUserTimezone($originBooking->end_time, 'H:i'),
                                $newBooking->duration
                            )
                        );

                        StaticMetric::query()->where('user_id', $teacherData->id)->increment('received_emails');
                        StaticMetric::query()->where('user_id', $clientData->id)->increment('received_emails');

                        // Create socket room if not exist
                        $socketRoomOld = SocketRoom::query()
                            ->where('talk_id', $talk['id'])
                            ->where('state', RoomStates::ROOM_PENDING)
                            ->where('talk_start_time', date('Y-m-d H:i:00', strtotime('-1 minutes', strtotime($originBooking->start_call))))
                            ->where('talk_end_time', $originBooking->end_call)
                            ->first();

                        $socketCancelWorkflow = $this->removeParticipants($socketRoomOld->id)->getData(true);

                        BookingsController::createBookingProtocolEvent($newBooking->id, Booking::STATE['postponed_to']);

                        $wallethistory             = new WalletHistory();
                        $responseFromWalletHistory = $wallethistory->addFundsInWallet($user, $newBooking->price, WalletHistory::TYPE['CREDIT'], $bookingId, null, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['POSTPONE']);

                        if ($responseFromWalletHistory['success'] == false) {
                            return response()->json([
                                'message' => $responseFromWalletHistory['message'],
                                'success' => false,
                            ], 200);
                        }

                        $responseFromWalletHistory = $wallethistory->removeFundsFromWallet($request->user(), $newBooking->id, $newBooking->price);

                        if ($responseFromWalletHistory['success'] == false) {
                            DB::rollBack();

                            return response()->json([
                                'message' => $responseFromWalletHistory['message'],
                                'success' => false,
                            ], 200);
                        }

                        if ($socketCancelWorkflow['success'] == false) {
                            DB::rollBack();

                            return response()->json([
                                'message' => $socketCancelWorkflow['message'],
                                'success' => false,
                            ], 200);
                        }

                        NotifyTeacherTalkPostpond::dispatch(
                            $teacherData->id,
                            $originBooking->id,
                            $talk['headline'],
                            Carbon::parse($originBooking->start_date)->format('d.m.Y'),
                            convertToUserTimezone($originBooking->start_time, 'H:i'),
                            Carbon::parse($newBooking->start_date)->format('d.m.Y'),
                            convertToUserTimezone($newBooking->start_time, 'H:i'),
                        );
                    } else {
                        DB::rollBack();

                        return response()->json([
                            'message' => ' Cannot postpone this booking, you are not participant.',
                            'success' => false,
                        ], 200);
                    }
                }

                // Booking create socket room
                $teacherData = \App\Models\User::query()->find($newBooking->teacher_user_id);
                $clientData  = \App\Models\User::query()->find($newBooking->participant_user_id);

                // Create socket room if not exist
                $socketRoom = SocketRoom::query()
                    ->where('talk_id', $talk['id'])
                    ->where('state', RoomStates::ROOM_PENDING)
                    ->where('talk_start_time', date('Y-m-d H:i:00', strtotime('-1 minutes', strtotime($newBooking->start_call))))
                    ->where('talk_end_time', $newBooking->end_call)
                    ->first();

                if (empty($socketRoom)) {
                    if ($talk['call_type'] == CallTypes::ONE_TO_ONE) {
                        $room_name = 'tkp_room_' . $talk['id'] . '_' . $newBooking->id . '_' . date('Y-m-d');
                    } else {
                        $room_name = 'tkg_room_' . $talk['id'] . '_' . $newBooking->id . '_' . date('Y-m-d');
                    }

                    $socketRoomRequest              = [];
                    $socketRoomRequest['talk_id']   = $talk['id'];
                    $socketRoomRequest['room_name'] = $room_name;
                    $socketRoomRequest['duration']  = $duration;
                    /* Call Type Change */
                    // $socketRoomRequest['call_type']         = $talk['talk_type'];
                    $socketRoomRequest['call_type']       = $talk['call_type'];
                    $socketRoomRequest['talk_type']       = $request->input('admin_panel') ? $request->input('talk_type') : $talk['talk_type'];
                    $socketRoomRequest['talk_start_time'] = date('Y-m-d H:i:00', strtotime('-1 minutes', strtotime($newBooking->start_call)));
                    $socketRoomRequest['talk_end_time']   = $newBooking->end_call;
                    $socketRoomRequest['state']           = RoomStates::ROOM_PENDING;
                    $socketRoomRequest['booking_id']      = $newBooking->id;

                    $socketRoom = SocketRoom::create($socketRoomRequest);

                    //Populate Socket Room with Teacher
                    $socketParticipantRequest                        = [];
                    $socketParticipantRequest['socket_room_id']      = $socketRoom->id;
                    $socketParticipantRequest['booking_id']          = $newBooking->id;
                    $socketParticipantRequest['user_id']             = $teacherData->id;
                    $socketParticipantRequest['name_of_user']        = $teacherData->name;
                    $socketParticipantRequest['user_image']          = $teacherData->profile_picture;
                    $socketParticipantRequest['firebase_id']         = (($teacherData->device_type == 'ios') ? $teacherData->voip_token : $teacherData->firebase_id);
                    $socketParticipantRequest['twilio_access_token'] = null;
                    $socketParticipantRequest['is_active']           = ParticipantStates::INACTIVE;
                    $socketParticipantRequest['is_anonym']           = false;
                    $socketParticipantRequest['user_type']           = UserTypes::PROVIDER;
                    $socketParticipantRequest['room_end']            = $newBooking->end_call;

                    SocketParticipant::create($socketParticipantRequest);
                }

                //Populate Socket Room with participant
                $socketParticipantTwoRequest                        = [];
                $socketParticipantTwoRequest['socket_room_id']      = $socketRoom->id;
                $socketParticipantTwoRequest['booking_id']          = $newBooking->id;
                $socketParticipantTwoRequest['user_id']             = $clientData->id;
                $socketParticipantTwoRequest['name_of_user']        = $talk['anonym_call'] ? 'Anonym' : $clientData->name;
                $socketParticipantTwoRequest['user_image']          = $talk['anonym_call'] ? config('app.default_image') : $clientData->profile_picture;
                $socketParticipantTwoRequest['firebase_id']         = (($clientData->device_type == 'ios') ? $clientData->voip_token : $clientData->firebase_id);
                $socketParticipantTwoRequest['twilio_access_token'] = null;
                $socketParticipantTwoRequest['is_active']           = ParticipantStates::INACTIVE;
                $socketParticipantTwoRequest['is_anonym']           = $anonym == 1;
                $socketParticipantTwoRequest['user_type']           = UserTypes::CLIENT;
                $socketParticipantTwoRequest['room_end']            = $socketRoom->talk_end_time;
                SocketParticipant::create($socketParticipantTwoRequest);

                StaticMetric::query()->where('user_id', $newBooking->teacher_user_id)->increment('received_emails');
                StaticMetric::query()->where('user_id', $newBooking->participant_user_id)->increment('received_emails');

                $currency = FinanceCurrency::query()->select('iso_code')
                    ->where('id', $newBooking->currency)
                    ->first()
                    ->toArray();

                // Increment bookings in static metrics
                StaticMetric::query()->where('user_id', $newBooking->teacher_user_id)->increment('received_bookings');
                StaticMetric::query()->where('user_id', $participantUserId)->increment('my_bookings');

                // Increment booked hours in static metrics
                StaticMetric::query()->where('user_id', $newBooking->teacher_user_id)->increment('received_booked_hours', $newBooking->duration);
                StaticMetric::query()->where('user_id', $newBooking->participant_user_id)->increment('my_booked_hours', $newBooking->duration);

                NotifyTeacherTalkBooked::dispatch($newBooking->id, $newBooking->talk->headline, Carbon::parse($newBooking->start_date)->format('d.m.Y'), convertToUserTimezone($newBooking->start_time, 'H:i'));

                // Payment proceed
                if (empty($bookingId)) {
                    $checkDidSuccessfulPaymentHappened = false;

                    if ($user->wallet_balance - $newBooking->price < 0) {
                        $payment            = new PaymentController();
                        $responseFromCharge = $payment->chargeCustomer($request, WalletHistory::SOURCE['BOOKING'], ($newBooking->price - $user->wallet_balance), $newBooking->id);
                        Log::notice('$responseFromCharge');
                        Log::notice($responseFromCharge);

                        if ($responseFromCharge['success'] == false && !empty($responseFromCharge['data']['redirect'])) {
                            BookingsController::createBookingProtocolEvent($newBooking->id, Booking::STATE['waiting']);
                            $newBooking->state = Booking::STATE['waiting'];
                            $newBooking->save();

                            $this->sendBookingMails($teacherData, $clientData, $talk, $newBooking);

                            DB::commit();

                            return response()->json([
                                'message' => $responseFromCharge['message'],
                                'data'    => [
                                    'redirect' => $responseFromCharge['data']['redirect'],
                                ],
                                'success' => true,
                            ], 200);
                        } else {
                            if ($responseFromCharge['success'] == false) {
                                $responseFromCancel = $payment->cancelPayment($request, $responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $bookingId);
                                DB::rollBack();

                                return response()->json([
                                    'message' => $responseFromCharge['message'],
                                    'success' => false,
                                ], 200);
                            }
                        }

                        $user                              = User::query()->where('id', $user->id)->first();
                        $checkDidSuccessfulPaymentHappened = true;
                    }

                    if ($user->wallet_balance - $newBooking->price >= 0) {
                        $wallethistory             = new WalletHistory();
                        $responseFromWalletHistory = $wallethistory->removeFundsFromWallet($user, $newBooking->id, $newBooking->price);

                        if ($responseFromWalletHistory['success'] == false) {
                            DB::rollBack();

                            return response()->json([
                                'message' => $responseFromWalletHistory['message'],
                                'success' => false,
                            ], 200);
                        }

                        BookingsController::createBookingProtocolEvent($newBooking->id, Booking::STATE['paid']);

                        $this->sendBookingMails($teacherData, $clientData, $talk, $newBooking);
                    } else {
                        if ($checkDidSuccessfulPaymentHappened) {
                            BookingsController::createBookingProtocolEvent($newBooking->id, Booking::STATE['not_enough_coins']);
                            $newBooking->state = Booking::STATE['not_enough_coins'];
                            $newBooking->save();

                            DB::commit();
                        } else {
                            DB::rollBack();
                        }

                        $response = response()->json([
                            'message' => 'Not enough coins in wallet',
                            'success' => false,
                        ], 200);

                        Log::notice("\n\n" . '::BookingsApiController::store::$response');
                        Log::notice($response);

                        return $response;
                    }
                }

//            StaticMetric::query()->where('user_id1', $newBooking->teacher_user_id)->get();

                if (isset($responseFromCharge['success']) && $responseFromCharge['success'] == true) {
                    $responseFromCapture = $payment->capturePayment($responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $bookingId);

                    if ($responseFromCapture['success'] == false) {
                        $responseFromCancel = $payment->cancelPayment($request, $responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $bookingId);
                        DB::rollBack();

                        return response()->json([
                            'message' => $responseFromCapture['message'],
                            'success' => false,
                        ], 200);
                    }
                }

                DB::commit();

                $response = response()->json([
                    'data'    => [
                        'booking_id'       => $newBooking->id,
                        'booking_price'    => (int)$newBooking->price,
                        'booking_currency' => $currency['iso_code'],
                    ],
                    'message' => 'Booking successfully created',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::BookingsApiController::store::$response');
                Log::notice($response);
            }

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR------------)::');
            Log::notice($exception);
            if (isset($responseFromCharge['success'])/* && $responseFromCharge['success'] == true*/) {
                $responseFromCancel = $payment->cancelPayment($request, $responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $bookingId);
            }

            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2301, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2301,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Booking  $booking
     *
     * @return BookingResource|\Illuminate\Http\JsonResponse
     */
    public function show(Booking $booking)
    {
        Log::notice("\n\n" . '::BookingsApiController::show::$booking');
        Log::notice($booking);

        try {
            return new BookingResource($booking->load(['participant_user', 'finance_currencies', 'cancellation_reason']));
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2302, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2302,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  UpdateBookingRequest  $request
     * @param  Booking               $booking
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            Log::notice("\n\n" . '::BookingsApiController::update::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::BookingsApiController::update::$booking');
            Log::notice($booking);

            DB::beginTransaction();

            $booking->update($request->all());

            DB::commit();

            $response = response()->json([
                'booking' => $booking,
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::BookingsApiController::update::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2303, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2303,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Booking  $booking
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy(Booking $booking)
    {
        try {
            abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            DB::beginTransaction();

            $booking->delete();

            DB::commit();

            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2304, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2304,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoggedUserBookings(Request $request)
    {
        try {
            Log::notice("\n\n" . '::BookingsApiController::getLoggedUserBookings::$request');
            Log::notice($request->all());

            if ($request->user()) {
                $userId = $request->user()->id;
            } else {
                if ($request->has('logged_user_id')) {
                    $userId = $request->input('logged_user_id');
                } else {
                    $userId = -99;
                }
            }

            $requestedDate = $request->input('requested_date');
            //            $user                   = User::where('id', '=', $userId)->first();
            $requestTimezoneHour    = abs((int)(($request->user()->timezone) / 60));
            $requestTimezoneMinutes = abs((int)(($request->user()->timezone) % 60));
            $requestTimezoneSign    = $request->user()->timezone < 0 ? '-' : '+';

            if (is_null($userId)) {
                return response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 500);
            }

            $firstDate       = null;
            $firstActiveDate = null;
            $todayDate       = date('Y-m-d', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime(date('Y-m-d'))));

            $bookings = Booking::query()
                ->where(function ($query) use ($userId) {
                    /* @var $query \Illuminate\Database\Eloquent\Builder */

                    $query->where('participant_user_id', $userId);
                    $query->orWhere('teacher_user_id', $userId);
                })
                ->whereNotIn('state', [Booking::STATE['waiting'], Booking::STATE['not_enough_coins']])
                ->get();

            foreach ($bookings as $key => $booking) {
                if (!is_null($booking->parent_id) && Booking::find($booking->parent_id)->state != 19) {
                    $bookings->forget($key);
                }
            }

            $oBookings = Booking::query()
                ->whereIn('id', $bookings->pluck('id'))
                ->selectRaw("TO_CHAR(start_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours', 'YYYY-MM-DD') as date_period, count(*) as count, bool_or(state = '" . Booking::STATE['paid'] . "') as has_paid")
                ->groupByRaw("date_period")
                ->orderBy('date_period')
                ->get()
                ->mapWithKeys(function ($item) use (&$firstDate, &$firstActiveDate, $todayDate) {
                    if (strtotime($todayDate) <= strtotime($item['date_period']) && $item['has_paid'] && $firstActiveDate == null) {
                        $firstActiveDate = $item['date_period'];
                    }

                    if ($firstDate == null) {
                        if (strtotime($todayDate) <= strtotime($item['date_period'])) {
                            $firstDate = $item['date_period'];
                        }
                    }

                    return [$item['date_period'] => $item['count']];
                });

            $data['has_active_booking_in_future']       = $request->user()->hasActiveBookings();
            $data['first_upcoming_booking'][$todayDate] = [];

            if (count($oBookings) == 0) {
                if (isset($requestedDate)) {
                    unset($data['first_upcoming_booking'][$todayDate]);
                    $data['first_upcoming_booking'][$requestedDate] = [];
                }

                $response = response()->json([
                    'data'    => $data,
                    'message' => 'There is no user bookings data',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::BookingsApiController::getLoggedUserBookings::$response');
                Log::notice($response);

                return $response;
            }

            if (isset($requestedDate)) {
                $tmpResponse = $this->getBookings($request, $requestedDate)->getData(true);
                if ($tmpResponse['success']) {
                    unset($data['first_upcoming_booking'][$todayDate]);
                    $data['first_upcoming_booking'][$requestedDate] = $tmpResponse['data'] ?? [];
                } else {
                    return response()->json([
                        'message' => 'Error on retrieving date Booking data',
                        'success' => false,
                    ], 500);
                }
            } else {
                if (isset($firstDate)) {
                    if (!empty($firstActiveDate)) {
                        $firstDate = $firstActiveDate;
                    }
                    $tmpResponse = $this->getBookings($request, $firstDate)->getData(true);

                    if ($tmpResponse['success']) {
                        unset($data['first_upcoming_booking'][$todayDate]);
                        $data['first_upcoming_booking'][$firstDate] = $tmpResponse['data'];
                    } else {
                        return response()->json([
                            'message' => 'Error on retrieving date Booking data',
                            'success' => false,
                        ], 500);
                    }
                }
            }

            $data['bookings'] = $oBookings;

            $response = response()->json([
                'success' => true,
                'data'    => $data,
            ]);

            Log::notice("\n\n" . '::BookingsApiController::getLoggedUserBookings::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2305, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2305,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $requestedDayDate
     * @param  null     $bookingId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBookings(Request $request, $requestedDayDate, $bookingId = null)
    {
        try {
            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request->all());

            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC') ?? $request->user()->timezone) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC') ?? $request->user()->timezone) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';

            $todayDateTime          = date('Y-m-d H:i:s');
            $sCurrentTimePlusChange = date('Y-m-d H:i:s', strtotime('+' . Booking::CHANGE_PERIOD . ' hours'));
            $loggedUser             = $request->user();

            $teacher = User::query()
                ->withTrashed()
                ->select('users.id AS teacher_id', 'username AS teacher_username', 'name AS teacher_name')
                ->selectRaw("CASE WHEN users.id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture");

            $talks      = Talk::query()
                ->withTrashed()
                ->withGroup()
                ->select(['id AS talk_id', 'headline', 'call_type', 'talk_type', 'max_participiants', 'description', 'state', 'talk_categories_id', 'talk_subcategories_id']);
            $validTalks = Talk::STATE['valid'];

            // Get current user Language preference.
            $language = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', session()->get('language') ?: 'en')];

            $oBookings = Booking::query()
                ->select([
                    "bookings.id",
                    "bookings.id AS booking_id",
                    "bookings.anonym",
                    "bookings.state AS booking_status",
                    "socket_rooms.state AS room_status",
                    "calls_cancellation_reasons.{$language} AS cancellation_reason",
                    "bookings.duration",
                    "bookings.participant_user_id",
                    'talk_categories.' . $language . ' as category',
                    'talk_subcategories.' . $language . ' as subcategory',
                    'billing_addresses.pays_vat',
                    'bookings.vat_id',
                    'bookings.vat as vat_value',
                ])
                ->selectRaw("start_call AS database_start_time")
                ->selectRaw("start_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS start_call")
                ->selectRaw("end_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS end_call")
                ->selectRaw("wallet_ledgers.created_at + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS paid_at")
                ->selectRaw("CASE WHEN '$todayDateTime' < start_call THEN 1 ELSE 0 END AS upcoming_lesson")
                ->selectRaw("notification_before_meeting AS notification_before_meeting")
                ->selectRaw("CASE WHEN talk_data.state = $validTalks THEN 1 ELSE 0 END AS book_again")
                ->selectRaw("teacher_data.teacher_id, teacher_data.profile_picture, teacher_data.teacher_username, teacher_data.teacher_name")
                ->selectRaw("CASE WHEN '$sCurrentTimePlusChange' > start_call THEN 0 ELSE 1 END AS cancellation_refundable")
                ->selectRaw("CASE WHEN bookings.cancel_type = 1 THEN bookings.created_at ELSE NULL END + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS cancellation_date")
                ->selectRaw("wallet_ledgers.created_at + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS paid_at")
                ->selectRaw(
                    "
                        CASE WHEN wallet_ledgers.card_details = '\"Paid By PayPal\"' THEN " . PaymentMethodTypes::PAYPAL . "
                        WHEN wallet_ledgers.card_details != '\"Paid By PayPal\"' THEN " . PaymentMethodTypes::STRIPE . "
                        WHEN wallet_ledgers.card_details IS NULL THEN " . PaymentMethodTypes::WALLET . "
                        END as payment_type
                    "
                )
                ->selectRaw("bookings.price as gross_price")
                ->selectRaw("CASE WHEN billing_addresses.pays_vat = true THEN CAST(ROUND((price / (1 + bookings.vat / 100))::NUMERIC, 2) AS TEXT) ELSE null END as net_price")
                ->selectRaw("CASE WHEN billing_addresses.pays_vat = true THEN CAST(ROUND((price - (price / (1 + bookings.vat / 100)))::NUMERIC, 2) AS TEXT) ELSE null END as tax")
                ->selectRaw("talk_data.*")
                ->where(function ($query) {
                    $query->where('bookings.state', '!=', Booking::STATE['waiting']);
                    $query->orWhere('bookings.state', '!=', Booking::STATE['not_enough_coins']);
                })
                ->joinSub($teacher, 'teacher_data', function ($join) {
                    $join->on('bookings.teacher_user_id', '=', 'teacher_data.teacher_id');
                })
                ->joinSub($talks, 'talk_data', function ($join) {
                    $join->on('bookings.talk_id', '=', 'talk_data.talk_id');
                })
                ->join('talk_categories', 'talk_categories_id', '=', 'talk_categories.id')
                ->join('talk_subcategories', 'talk_subcategories_id', '=', 'talk_subcategories.id')
                ->join('billing_addresses', 'bookings.supplier_billing_address_id', '=', 'billing_addresses.id')
                ->join('socket_rooms', 'bookings.id', '=', 'socket_rooms.booking_id')
                ->leftJoin('calls_cancellation_reasons', 'bookings.cancellation_reason_id', '=', 'calls_cancellation_reasons.id')
                ->leftJoin('wallet_ledgers', 'bookings.id', '=', 'wallet_ledgers.booking_id')
                ->with('booking_protocol:id,booking_id,state,created_at')
                ->orderBy('start_call');

            if (!empty($bookingId)) {
                $oBookings->where('bookings.id', $bookingId);

                $requestedBooking = clone $oBookings;
                $bookingCheck     = $requestedBooking->first();

                if ($bookingCheck->teacher_id == $loggedUser->id || $bookingCheck->participant_user_id == $loggedUser->id) {
                } else {
                    $response = response()->json([
                        'message' => __('UNAUTHORIZED_ACCESS'), //'There is no user bookings data',
                        'success' => true,
                    ], 200);

                    Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                    Log::notice($response);

                    return $response;
                }
            } else {
                $userId = $request->user()->id;
                $oBookings->where(function ($query) use ($userId) {
                    $query->where('participant_user_id', $userId);
                    $query->orWhere('teacher_user_id', $userId);
                });
                $oBookings->whereRaw("TO_CHAR(start_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . "', 'YYYY-MM-DD') = '$requestedDayDate'");
            }
            //            $oBookings->groupBy(['talk_id'/*, 'start_call'*/]);

            $bookingsData = $oBookings->get();

            foreach ($bookingsData as $booking) {
                if ($booking->booking_status == 19) {
                    $postponed_booking             = Booking::where('parent_id', $booking->id)
                        ->selectRaw("start_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS start_call")
                        ->selectRaw("end_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS end_call")
                        ->first();
                    $booking->postponed_start_call = $postponed_booking->start_call;
                    $booking->postponed_end_call   = $postponed_booking->end_call;
                }
                $extends = Booking::query()
                    ->where('parent_id', $booking->id)
                    ->select(['bookings.id', 'parent_id', 'duration', 'billing_addresses.pays_vat', 'bookings.vat_id', 'bookings.vat as vat_value'])
                    ->selectRaw("start_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS start_call")
                    ->selectRaw("end_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS end_call")
                    ->selectRaw("wallet_ledgers.created_at + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' AS paid_at")
                    ->selectRaw(
                        "
                        CASE WHEN wallet_ledgers.card_details = '\"Paid By PayPal\"' THEN " . PaymentMethodTypes::PAYPAL . "
                        WHEN wallet_ledgers.card_details != '\"Paid By PayPal\"' THEN " . PaymentMethodTypes::STRIPE . "
                        WHEN wallet_ledgers.card_details IS NULL THEN " . PaymentMethodTypes::WALLET . "
                        END as payment_type
                    "
                    )
                    ->selectRaw("bookings.price as gross_price")
                    ->selectRaw("CASE WHEN billing_addresses.pays_vat = true THEN CAST(ROUND((price / (1 + bookings.vat / 100))::NUMERIC, 2) AS TEXT) ELSE null END as net_price")
                    ->selectRaw("CASE WHEN billing_addresses.pays_vat = true THEN CAST(ROUND((price - (price / (1 + bookings.vat / 100)))::NUMERIC, 2) AS TEXT) ELSE null END as tax")
                    ->join('billing_addresses', 'bookings.supplier_billing_address_id', '=', 'billing_addresses.id')
                    ->leftJoin('wallet_ledgers', 'bookings.id', '=', 'wallet_ledgers.booking_id')
                    ->groupBy('bookings.id', 'parent_id', 'duration', 'billing_addresses.pays_vat', 'bookings.vat_id', 'bookings.vat', 'bookings.price', 'bookings.supplier_billing_address_id', 'billing_addresses.id', 'wallet_ledgers.created_at', 'wallet_ledgers.card_details', 'wallet_ledgers.booking_id', 'bookings.start_call', 'bookings.end_call')
                    ->get();

                if ($extends->isNotEmpty()) {
                    foreach ($extends as $key => $extend) {
                        if (Booking::find($extend->parent_id)->state == 19) {
                            $extends->forget($key);
                        }
                    }

                    $booking->extends = $extends->toArray();
                }

                $feedback = Feedback::query()
                    ->where('feedback.booking_id', $booking->id)
                    ->where('feedback.user_id', $booking->participant_user_id)
                    ->join('socket_participants', 'feedback.user_id', '=', 'socket_participants.user_id')
                    ->select(['socket_participants.name_of_user as name', 'feedback.description', 'feedback.stars_content', 'feedback.stars_voice_quality'])
                    ->selectRaw("feedback.created_at + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours' as created_at")
                    ->first();

                if ($feedback) {
                    $booking->review = $feedback->toArray();
                }
            }

            $bookingsDataArray = [];

            foreach ($bookingsData as $booking) {
                $bookingsDataArray[$booking->id] = $booking->toArray();

                foreach ($booking->toArray()['booking_protocol'] as $booking_protocol) {
                    $bookingsDataArray[$booking->id]['booking_protocol_data'][] =
                        [
                            'state'   => $booking_protocol['state'],
                            'date'    => date('d.m.Y H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking_protocol['created_at']))),
                            'message' => __('BOOKING_PROTOCOL_' . $booking_protocol['state']),
                        ];
                }

                $bookingParticipants = Booking::query()->select('anonym', 'participant_user_id')->where('talk_id', $booking->talk_id)->where('start_call', $booking->database_start_time)->get()->toArray();

                foreach ($bookingParticipants as $participantBooking) {
                    $participant = User::withTrashed()->find($participantBooking['participant_user_id']);

                    if ($participantBooking['anonym']) {
                        $profile_picture = config('app.default_image');
                        $profile_name    = 'Anonymous';
                    } else {
                        if (empty($participant->profile_picture)) {
                            $profile_picture = config('app.default_image');
                        } else {
                            $profile_picture = $participant->profile_picture;
                        }
                        $profile_name = $participant->name;
                    }
                    $bookingsDataArray[$booking->id]['booking_participants'][] = [
                        'profile_id'      => $participant->id,
                        'profile_name'    => $profile_name,
                        'profile_picture' => $profile_picture,
                    ];
                }
            }

            if (count($bookingsDataArray) == 0) {
                $response = response()->json([
                    'message' => __('BOOKING_NO_DATA'), //'There is no user bookings data',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            }
            $response = response()->json([
                'data'    => array_values($bookingsDataArray),
                'success' => true,
            ], 200);

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2306, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2306,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $bookingId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getBookingData(Request $request, $bookingId)
    {
        try {
            $tmpResponse = $this->getBookings($request, null, $bookingId)->getData(true);


            Log::notice("\n\n" . '::BookingsApiController::getBookingData::$tmpResponse');
            Log::notice($tmpResponse);

            return $tmpResponse;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2307, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2307,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param  null     $nBookingId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableExtensions(Request $request)
    {
        try {
            $nBookingId = $request->input('booking_id', null);
            Log::notice("\n\n" . '::BookingsApiController::getAvailableExtensions::$nBookingId');
            Log::notice($nBookingId);

            if (empty($nBookingId)) {
                $user    = $request->user();
                $user_id = $user->id;

                $feedback_time = date('Y-m-d H:i:s');
                $booking       = Booking::query()
                    ->where(function ($query) use ($user_id) {
                        $query->where('participant_user_id', $user_id);
                        $query->orWhere('teacher_user_id', $user_id);
                    })
                    ->where(function ($query) use ($feedback_time) {
                        $query->where('start_call', '<=', $feedback_time);
                        $query->where('end_call', '>=', $feedback_time);
                    })
                    ->orderBy('end_call', 'DESC')
                    ->first();

                if (!empty($booking->id)) {
                    $nBookingId = $booking->id;
                } else {
                    return response()->json([
                        'message' => __('BOOKING_NO_AVAILABLE_BOOKING_FOR_EXTENSION'), //'There is no available booking for time extension',
                        'success' => true,
                    ], 200);
                }
            }

            $return = [
                'extension_of_15'  => $this->makeCallExtension($request, $nBookingId, 15)->getData(true),
                'extension_of_30'  => $this->makeCallExtension($request, $nBookingId, 30)->getData(true),
                'extension_of_45'  => $this->makeCallExtension($request, $nBookingId, 45)->getData(true),
                'extension_of_60'  => $this->makeCallExtension($request, $nBookingId, 60)->getData(true),
                'extension_of_75'  => $this->makeCallExtension($request, $nBookingId, 75)->getData(true),
                'extension_of_90'  => $this->makeCallExtension($request, $nBookingId, 90)->getData(true),
                'extension_of_105' => $this->makeCallExtension($request, $nBookingId, 105)->getData(true),
                'extension_of_120' => $this->makeCallExtension($request, $nBookingId, 120)->getData(true),
            ];
            if (
                $return['extension_of_15']['success'] ||
                $return['extension_of_30']['success'] ||
                $return['extension_of_45']['success'] ||
                $return['extension_of_75']['success'] ||
                $return['extension_of_90']['success'] ||
                $return['extension_of_105']['success'] ||
                $return['extension_of_120']['success']
            ) {
                $message  = __('BOOKING_AVAILABLE_EXTENSION'); //'Available extensions for this call',
                $response = response()->json([
                    'data'    => $return,
                    'message' => $message,
                    'success' => true,
                ], 200);
            } else {
                $message  = __('BOOKING_DONT_HAVE_AVAILABLE_EXTENSION'); //'Dont have available extensions for this call',
                $response = response()->json([
                    'message' => $message,
                    'success' => true,
                ]);
                // $this->emitExtensionCancelledEvent($request);
            }

            Log::notice("\n\n" . '::BookingsApiController::getAvailableExtensions::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2308, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2308,
                'success' => false,
            ], 500);
        }
    }

    public function bookExtension(Request $request)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $user    = $request->user();
            $user_id = $user->id;

            $feedback_time = date('Y-m-d H:i:s');
            $booking       = Booking::query()
                ->where(function ($query) use ($user_id) {
                    $query->where('participant_user_id', $user_id);
                    $query->orWhere('teacher_user_id', $user_id);
                })
                ->where(function ($query) use ($feedback_time) {
                    $query->where('start_call', '<=', $feedback_time);
                    $query->where('end_call', '>=', $feedback_time);
                })
                ->join('billing_addresses', 'bookings.supplier_billing_address_id', '=', 'billing_addresses.id')
                ->join('countries', 'bookings.vat_id', '=', 'countries.id')
                ->select(['bookings.*', 'billing_addresses.pays_vat', 'countries.vat_value'])
                ->orderBy('id', 'DESC')
                ->first();


            if (!empty($booking->id)) {
                $nBookingId = $booking->id;
            } else {
                $this->emitExtensionCancelledEvent($request);

                return response()->json([
                    'message' => __('BOOKING_NO_AVAILABLE_BOOKING_FOR_EXTENSION'), //'There is no available booking for time extension',
                    'success' => true,
                ], 200);
            }

            $response = $this->makeCallExtension($request, $nBookingId, $request->input('extension_time'), true)->getData(true);

            // TODO: Extend mail including VAT info

            Log::notice($response);

            return response()->json([
                'message' => $response['message'] ?? 'Error: ' . Handler::TYPE_EXCEPTION_2309,
                'data'    => [
                    'redirect' => $response['data']['redirect'] ?? null,
                ],
                'success' => $response['success'],
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2309, self::class, __FUNCTION__);

            $this->emitExtensionCancelledEvent($request);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2309,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param $nBookingId
     * @param $nRequestedExtension
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function makeCallExtension($request, $nBookingId, $nRequestedExtension, $createExtension = false)
    {
        Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$nBookingId');
        Log::notice($nBookingId);

        Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$nRequestedExtension');
        Log::notice($nRequestedExtension);

        DB::beginTransaction();
        try {
            // Add 15 minutes on requested time to make pause between next call
            $nOriginalExtension  = $nRequestedExtension;
            $nRequestedExtension = $nRequestedExtension + 15;

            // $oBooking = Booking::query()->where('id', $nBookingId)->first();
            $oBookings = Booking::query()
                ->where('id', $nBookingId)
                ->orWhere('parent_id', $nBookingId)
                ->orderBy('id', 'desc')
                ->get();

            // First - Latest
            // Last  - Parent
            $oBooking = $oBookings->first();

            $sRequestedExtensionTimeFull = date('Y-m-d H:i:00', strtotime($oBooking->end_call . '+' . $nRequestedExtension . ' minutes'));

            $sRequestedOriginalTime     = date('H:i', strtotime($oBooking->end_call . '+' . $nOriginalExtension . ' minutes'));
            $sRequestedOriginalTimeFull = date('Y-m-d H:i:00', strtotime($oBooking->end_call . '+' . $nOriginalExtension . ' minutes'));

            $aTeacherTalks = Talk::query()->where('teacher_user_id', $oBooking->teacher_user_id)->pluck('id')->toArray();

            $iNextBooking = Booking::query()->whereIn('talk_id', $aTeacherTalks)
                ->where('state', Booking::STATE['paid'])
                ->where('id', '!=', $nBookingId)
                ->whereDate('start_call', date('Y-m-d', strtotime($oBooking->end_call)))
                ->where('start_call', '<=', $sRequestedExtensionTimeFull)
                ->where('start_call', '>', $oBooking->end_call)
                ->exists();

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$iNextBooking');
            Log::notice($iNextBooking ? 'Exists' : 'Not Exists');

            $iStudentBooking = Booking::query()->where('id', '!=', $oBooking->id)
                ->where('state', Booking::STATE['paid'])
                ->whereDate('start_call', date('Y-m-d', strtotime($oBooking->end_call)))
                ->where('start_call', '<=', $sRequestedExtensionTimeFull)
                ->where('start_call', '>', $oBooking->end_call)
                ->where(function ($query) use ($oBooking) {
                    $query->where('participant_user_id', $oBooking->participant_user_id);
                    $query->orWhere('teacher_user_id', $oBooking->participant_user_id);
                })
                ->exists();

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$iStudentBooking');
            Log::notice($iStudentBooking ? 'Exists' : 'Not Exists');

            $TeacherBooking = Booking::query()->where('id', '!=', $oBooking->id)
                ->where('state', Booking::STATE['paid'])
                ->whereDate('start_call', date('Y-m-d', strtotime($oBooking->end_call)))
                ->where('start_call', '<=', $sRequestedExtensionTimeFull)
                ->where('start_call', '>', $oBooking->end_call)
                ->where(function ($query) use ($oBooking) {
                    $query->where('participant_user_id', $oBooking->teacher_user_id);
                    $query->orWhere('teacher_user_id', $oBooking->teacher_user_id);
                })
                ->exists();

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$TeacherBooking');
            Log::notice($TeacherBooking ? 'Exists' : 'Not Exists');

            $iAvailability = \App\Models\Availability::query()->whereRaw("end_time > '$sRequestedOriginalTime' AND start_time < '$sRequestedOriginalTime'")
                ->where('state', Availability::STATE['valid'])
                ->where('user_id', $oBooking->teacher_user_id)
                ->where('weekday', date('N', strtotime($sRequestedOriginalTimeFull)))
                ->exists();

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$iAvailability');
            Log::notice($iAvailability ? 'Exists' : 'Not Exists');

            $extensionPrice = round(($oBooking->price / $oBooking->duration) * $nOriginalExtension, 2, PHP_ROUND_HALF_UP);

            // $iAvailability = true;

            if (!$iNextBooking && !$iStudentBooking && !$TeacherBooking && $iAvailability) {
                if ($createExtension) {
                    $responseFromExtension = $this->createExtensionInDb($request, $oBookings, $extensionPrice, $nOriginalExtension, $sRequestedOriginalTimeFull, $nOriginalExtension);

                    return response()->json([
                        'message' => $responseFromExtension['message'],
                        'data'    => [
                            'redirect' => $responseFromExtension['data']['redirect'] ?? null,
                        ],
                        'success' => $responseFromExtension['success'],
                    ], 200);
                } else {
                    return response()->json([
                        'price'   => $extensionPrice,
                        'success' => true,
                    ], 200);
                }
            } else {
                return response()->json([
                    'price'   => $extensionPrice,
                    'success' => false,
                ], 200);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2310, self::class, __FUNCTION__);

            $this->emitExtensionCancelledEvent($request);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2310,
                'success' => false,
            ], 500);
        }
    }


    public function createExtensionInDb($request, $oBookings, $extensionPrice, $nOriginalExtension, $sRequestedOriginalTimeFull)
    {
        $user                        = $request->user();
        $oBooking                    = $oBookings->first();
        $parentBooking               = $oBookings->last();
        $newBookingData              = $oBooking->toArray();
        $newBookingData['parent_id'] = $parentBooking->id;
        $newBookingData['price']     = round($extensionPrice, 2, PHP_ROUND_HALF_UP);
        $newBookingData['duration']  = $nOriginalExtension;

        $oBookingSlots = BookingsBookedSlots::query()
            ->where('talk_id', $newBookingData['talk_id'])
            ->where('participant_user_id', $newBookingData['participant_user_id'])
            ->where('slot_datetime', $newBookingData['end_call'])
            ->first();

        $new_slot = Carbon::parse($newBookingData['end_call'])->addMinutes(15)->toDateTimeString();

        $oNextBookingSlot = BookingsBookedSlots::query()
            ->where('talk_id', $newBookingData['talk_id'])
            ->where('participant_user_id', $newBookingData['participant_user_id'])
            ->where('slot_datetime', $new_slot)
            ->first();

        if ($oBookingSlots) {
            $oBookingSlots->delete();
        }
        if ($oNextBookingSlot) {
            $oNextBookingSlot->delete();
        }

        $newBookingData['start_call'] = $newBookingData['end_call'];
        $newBookingData['end_call']   = $sRequestedOriginalTimeFull;

        $newBookingData['start_date'] = date('Y-m-d', strtotime($newBookingData['start_call']));
        $newBookingData['end_date']   = date('Y-m-d', strtotime($newBookingData['end_call']));
        $newBookingData['start_time'] = date('H:i:s', strtotime($newBookingData['start_call']));
        $newBookingData['end_time']   = date('H:i:s', strtotime($newBookingData['end_call']));

        $newBooking = Booking::create($newBookingData);

        $partner = $newBooking->supplier->partner;

        if ($partner) {
            $dashboard = $partner->dashboard();
            $dashboard->update([
                'total_revenue' => DB::raw("total_revenue + $newBooking->price"),
            ]);
        }

        if ($user->wallet_balance - $newBooking->price < 0) {
            $payment            = new PaymentController();
            $responseFromCharge = $payment->chargeCustomer($request, WalletHistory::SOURCE['EXTENSION'], ($newBooking->price - $user->wallet_balance), $newBooking->id);
            Log::notice('$responseFromCharge');
            Log::notice($responseFromCharge);

            if ($responseFromCharge['success'] == false && !empty($responseFromCharge['data']['redirect'])) {
                BookingsController::createBookingProtocolEvent($newBooking->id, Booking::STATE['waiting']);
                $newBooking->state = Booking::STATE['waiting'];
                $newBooking->save();

                DB::commit();

                return [
                    'message' => $responseFromCharge['message'],
                    'data'    => [
                        'redirect' => $responseFromCharge['data']['redirect'],
                    ],
                    'success' => true,
                ];
            } else {
                if ($responseFromCharge['success'] == false) {
                    $responseFromCancel = $payment->cancelPayment($request, $responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $newBooking->id);

                    $this->emitExtensionCancelledEvent($request);

                    DB::rollBack();

                    return [
                        'message' => $responseFromCharge['message'],
                        'success' => false,
                    ];
                }
            }

            $user = User::query()->where('id', $user->id)->first();
        }

        if ($user->wallet_balance - $newBooking->price >= 0) {
            $wallethistory             = new WalletHistory();
            $responseFromWalletHistory = $wallethistory->removeFundsFromWallet($user, $newBooking->id, $newBooking->price);

            if ($responseFromWalletHistory['success'] == false) {
                DB::rollBack();

                $this->emitExtensionCancelledEvent($request);

                return response()->json([
                    'message' => $responseFromWalletHistory['message'],
                    'success' => false,
                ], 200);
            }

            BookingsController::createBookingProtocolEvent($newBooking->id, Booking::STATE['paid']);

            // $calendar_account = $this->getCalendarAccount($oBooking->client, $oBooking->supplier);
            //
            // if (isset($calendar_account) && $oBooking->event_id) {
            //     $calendar = $calendar_account->talkila();
            //
            //     $request->request->add([
            //         'data' => [
            //             'end' => [
            //                 'dateTime' => convertToUserTimezone($newBooking->end_call)->toDateTimeLocalString(),
            //                 'timeZone' => getTimezoneAbbreviation(),
            //             ],
            //         ],
            //     ]);
            //
            //     (new CalendarController())->patchEvent($request, $calendar->user, $calendar, $oBooking->event_id)->getData(true);
            // }

            $this->extendSocketRoomInDB($oBooking, $nOriginalExtension, $user);

            if (isset($responseFromCharge['success']) && $responseFromCharge['success'] == true) {
                $responseFromCapture = $payment->capturePayment($responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $newBooking->id);

                if ($responseFromCapture['success'] == false) {
                    $responseFromCancel = $payment->cancelPayment($request, $responseFromCharge['data']['paymentId'], $request->payment_type, WalletHistory::SOURCE['BOOKING'], $newBooking->id);
                    DB::rollBack();

                    $this->emitExtensionCancelledEvent($request);

                    return response()->json([
                        'message' => $responseFromCapture['message'],
                        'success' => false,
                    ], 200);
                }
            }

            DB::commit();

            return [
                'message' => __('EXTENDED_SUCCESSFULLY'),
                'success' => true,
            ];
        } else {
            DB::rollBack();

            $this->emitExtensionCancelledEvent($request);

            return [
                'message' => 'Not enough coins in wallet',
                'success' => false,
            ];
        }
    }

    public function extendSocketRoomInDB($oBooking, $nOriginalExtension, $user)
    {
        $minutes_increased = intval($nOriginalExtension);

        $room_info = SocketRoom::query()
            ->where('talk_id', $oBooking->talk_id)
            ->where('state', RoomStates::ROOM_IN_PROGRESS)
            ->where('talk_start_time', '<=', date('Y-m-d H:i:00'))
            ->where('talk_end_time', '>=', date('Y-m-d H:i:00'))
            ->first();

        $socket_room_id = $room_info->id;
        $user_id        = $user->id;

        $participant = SocketParticipant::where('socket_room_id', '=', $socket_room_id)
            ->where('user_id', '=', $user_id)
            ->first();

        $current_end_time = $participant->room_end;

        $new_end_time = Carbon::parse($current_end_time)
            ->addMinutes($minutes_increased);

        $new_minutes = Carbon::parse($participant->room_joined)
            ->diffInMinutes($new_end_time);

        $current_minutes = Carbon::now()
            ->diffInMinutes($new_end_time);

        SocketParticipant::where('socket_room_id', '=', $socket_room_id)
            ->where('user_id', '=', $user_id)
            ->update(['room_end' => $new_end_time]);

        if (Carbon::parse($room_info->talk_end_time)->diffInMinutes($new_end_time, false) > 0) {
            SocketRoom::where('id', '=', $socket_room_id)
                ->update([
                    'talk_end_time' => $new_end_time,
                    'call_extended' => StateTypes::YES,
                ]);
            SocketParticipant::where('socket_room_id', '=', $socket_room_id)
                ->where('user_id', '=', $oBooking->teacher_user_id)
                ->update(['room_end' => $new_end_time]);
        } else {
            SocketRoom::where('id', '=', $socket_room_id)
                ->update(['call_extended' => StateTypes::YES]);
        }
    }

    /**
     * @param $id
     *
     * @return Booking[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    public function getFutureBookings($id)
    {
        Log::notice("\n\n" . '::BookingsApiController::getFutureBookings::$id');
        Log::notice($id);
        try {
            $sCurrentDate = date('Y-m-d H:i:s');
            $sFutureDate  = date('Y-m-d H:i:s', strtotime('+2 months'));
            $aBookingsId  = [];

            $oTalks = Talk::query()
                ->withGroup()
                ->where('teacher_user_id', $id)
                ->with(['talk_bookings'])
                ->get()
                ->pluck('talk_bookings');

            foreach ($oTalks as $oTalk) {
                array_push($aBookingsId, $oTalk[0]->booking_id);
            }

            $oFutureBookings = Booking::query()->whereIn('id', $aBookingsId)
                ->where('state', Booking::STATE['paid'])
                ->whereDate('start_call', '>', $sCurrentDate)
                ->whereDate('end_call', '<', $sFutureDate)
                ->get();

            return $oFutureBookings;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2311, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2311,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function setBookingNotification(Request $request)
    {
        Log::notice("\n\n" . '::BookingsApiController::setBookingNotification::$id');
        Log::notice($request->all());
        try {
            $bookingId  = $request->input('booking_id');
            $state      = $request->input('notification_state');
            $dataErrors = [];

            if (empty($bookingId)) {
                $dataErrors['booking_id'] = [
                    'The Booking id value is required.',
                ];
            }

            if (!isset($state) || (!is_numeric($state) && isset($state))) {
                $dataErrors['notification_state'] = [
                    'The Notification state is required.',
                ];
            }

            if (!empty($dataErrors)) {
                $response = response()->json([
                    'errors'  => $dataErrors,
                    'message' => 'These fields are required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::BookingsApiController::setBookingNotification::$response');
                Log::notice($response);

                return $response;
            }

            $oBookings = Booking::query()->select('id', 'participant_user_id', 'teacher_user_id', 'start_call', 'talk_id', 'notification_before_meeting')
                ->find($bookingId);

            if (empty($oBookings)) {
                $response = response()->json([
                    'message' => 'There is no requested booking in our database.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::BookingsApiController::setBookingNotification::$response');
                Log::notice($response);

                return $response;
            }
            DB::beginTransaction();

            $oBookings->update(['notification_before_meeting' => $state]);

            DB::commit();

            $response = response()->json([
                'message' => 'Booking notification status successfully updated',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::BookingsApiController::setBookingNotification::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2312, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2312,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $booking
     * @param  null     $reasonId
     * @param  false    $teacherRequest
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function cancelBooking(Request $request, $booking, $reasonId = null, $teacherRequest = false)
    {
        try {
            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request->all());

            $user               = $request->user();
            $cancellationReason = $request->input('reason_id');

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($cancellationReason)) {
                if ($reasonId > 0) {
                    $cancellationReason = $reasonId;
                } else {
                    $response = response()->json([
                        'errors'  => [
                            'reason_id' => ['Reason is required for Booking cancellation.'],
                        ],
                        'message' => 'Reason is required for Booking cancellation.',
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                    Log::notice($response);

                    return $response;
                }
            }

            $requestedBookings = Booking::query()
                ->select(['id', 'duration', 'participant_user_id', 'teacher_user_id', 'start_call', 'end_call', 'talk_id', 'cancellation_reason_id', 'state'])
                ->with(['talk'])
                ->find($booking);

            $originBookings = Booking::query()
                ->select(['id', 'duration', 'participant_user_id', 'teacher_user_id', 'start_call', 'end_call', 'talk_id', 'cancellation_reason_id', 'state', 'start_date', 'start_time', 'end_time'])
                ->with(['talk'])
                ->find($booking);

            $bookingBookedTalk = Talk::query()
                ->withGroup()
                ->where('id', $requestedBookings->talk_id)
                ->first();

            if ($bookingBookedTalk['talk_type'] == Talk::TALK_TYPE['group'] && $user->id == $requestedBookings->teacher_user_id) {
                $requestedCancelBookings = Booking::query()
                    ->select(['id', 'duration', 'price', 'participant_user_id', 'teacher_user_id', 'start_call', 'end_call', 'talk_id', 'cancellation_reason_id', 'state'])
                    ->where('talk_id', $requestedBookings->talk_id)
                    ->where('start_call', $requestedBookings->start_call)
                    ->where('state', Booking::STATE['paid'])
                    ->with(['talk'])
                    ->get();
            } else {
                $requestedCancelBookings = Booking::query()
                    ->select(['id', 'duration', 'price', 'participant_user_id', 'teacher_user_id', 'start_call', 'end_call', 'talk_id', 'cancellation_reason_id', 'state'])
                    ->where('id', $requestedBookings->id)
                    ->where('state', Booking::STATE['paid'])
                    ->with(['talk'])
                    ->get();
            }

            DB::beginTransaction();

            foreach ($requestedCancelBookings as $oBookings) {
                if ($oBookings->state == Booking::STATE['canceled'] || $oBookings->state == Booking::STATE['canceled_by_teacher'] || $oBookings->state == Booking::STATE['canceled_without_refund']) {
                    $response = response()->json([
                        'message' => __('BOOKING_ALREADY_CANCELED'), //'Booking already cancelled',
                        'success' => true,
                    ], 200);

                    Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                    Log::notice($response);

                    return $response;
                }

                $talk = $oBookings->talk()->withGroup()->first();

                $aValidation = $this->validateBookingAction($user, $oBookings);

                if (!$aValidation['success'] && $aValidation['message'] != __('NON_REFUND')) {
                    $response = response()->json([
                        'message' => $aValidation['message'],
                        'success' => $aValidation['success'],
                    ], 200);

                    Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                    Log::notice($response);

                    return $response;
                }

                $notificationData = [
                    'user_id'      => $oBookings->participant_user_id,
                    'supplier_id'  => $oBookings->teacher_user_id ?? null,
                    'type'         => !empty($talk->headline) ? $talk->headline : '',
                    'param_type'   => 'name_of_talk',
                    'param_id'     => $oBookings->id,
                    'talkName'     => $talk->headline,
                    'talkDate'     => Carbon::parse($oBookings->start_call)->format('d.m.Y'),
                    'talkTime'     => convertToUserTimezone($oBookings->start_call, 'H:i'),
                    'talkSupplier' => $oBookings->supplier->username,
                    'value'        => Notifications::VALUE['canceled_by_supplier'],
                ];

                $notification = NotificationsApiController::sendNotification($request, $notificationData);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$notification');
                Log::notice($notification);

                //Send Email here

                $oCancelReason = CallsCancellationReason::query()->select('id')->find($cancellationReason);

                // Decrement bookings in static metrics
                StaticMetric::query()->where('user_id', $oBookings->teacher_user_id)->decrement('received_bookings');
                StaticMetric::query()->where('user_id', $oBookings->participant_user_id)->decrement('my_bookings');

                // Decrement booked hours in static metrics
                StaticMetric::query()->where('user_id', $oBookings->teacher_user_id)->decrement('received_booked_hours', $oBookings->duration);
                StaticMetric::query()->where('user_id', $oBookings->participant_user_id)->decrement('my_booked_hours', $oBookings->duration);

                //            $adyen = new AdyenPaymentController();

                if ($user->id == $oBookings->teacher_user_id) {
                    $teacherRequest = true;
                }

                if ($user->id == $oBookings->teacher_user_id) {
                    $cancelUser = Booking::CANCEL_TYPE['supplier'];
                } else {
                    $cancelUser = Booking::CANCEL_TYPE['client'];
                }

                if ($aValidation['message'] === __('NON_REFUND') && $teacherRequest == false) {
                    BookingsController::createBookingProtocolEvent($oBookings->id, Booking::STATE['canceled_without_refund']);
                    $oBookings->update(['cancellation_reason_id' => $oCancelReason->id, 'cancel_type' => $cancelUser, 'state' => Booking::STATE['canceled_without_refund']]);
                } else {
                    if ($teacherRequest) {
                        $protocolEvent = Booking::STATE['canceled_by_teacher'];
                        $user          = User::withTrashed()->find($oBookings->participant_user_id);
                    } else {
                        $protocolEvent = Booking::STATE['canceled'];
                    }

                    BookingsController::createBookingProtocolEvent($oBookings->id, $protocolEvent);

                    $wallethistory             = new WalletHistory();
                    $responseFromWalletHistory = $wallethistory->addFundsInWallet($user, $oBookings->price, WalletHistory::TYPE['CREDIT'], $oBookings->id, Str::uuid()->toString(), null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['REFUND']);

                    if ($responseFromWalletHistory['success'] == false) {
                        DB::rollBack();

                        return response()->json([
                            'message' => $responseFromWalletHistory['message'],
                            'success' => false,
                        ], 200);
                    }
                    $oBookings->update(['cancellation_reason_id' => $oCancelReason->id, 'cancel_type' => $cancelUser, 'state' => $protocolEvent]);
                }

                // if ($originBookings->event_id) {
                //     $client_calendar_accounts   = $originBookings->participant_user->calendarAccounts;
                //     $supplier_calendar_accounts = $originBookings->teacher_user->calendarAccounts;
                //
                //     if ($client_calendar_accounts->isNotEmpty()) {
                //         $calendar_account = $client_calendar_accounts->first();
                //         $calendar_user    = $originBookings->participant_user;
                //     } elseif ($supplier_calendar_accounts->isNotEmpty()) {
                //         $calendar_account = $supplier_calendar_accounts->first();
                //         $calendar_user    = $originBookings->teacher_user;
                //     }
                //
                //     $calendar = $calendar_account->talkila();
                //
                //     (new CalendarController())->cancelEvent($request, $calendar_user, $calendar, $originBookings->event_id);
                // }

                $teacherData = \App\Models\User::query()->find($oBookings['teacher_user_id']);
                $clientData  = \App\Models\User::query()->find($oBookings['participant_user_id']);
                $partner     = $teacherData->partner;

                if ($partner) {
                    $dashboard = $partner->dashboard();
                    $dashboard->update([
                        'total_bookings' => DB::raw('total_bookings - 1'),
                        'total_revenue'  => DB::raw("total_revenue - {$oBookings['price']}"),
                    ]);
                }

                $talkType = $talk['talk_type'] == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk';

                Mail::to($teacherData->email)->queue(
                    new BookingCancellationSupplier(
                        $teacherData->last_language,
                        $clientData->email,
                        $teacherData->email,
                        $teacherData->username,
                        $talk['headline'],
                        convertToUserTimezone($originBookings->start_date, 'd.m.Y'),
                        convertToUserTimezone($originBookings->start_time, 'H:i'),
                        convertToUserTimezone($originBookings->end_time, 'H:i'),
                        $talk['duration'],
                        $talk['price'],
                        $talkType,
                        $originBookings->id
                    )
                );

                Mail::to($clientData->email)->queue(
                    new BookingCancellationClient(
                        $clientData->last_language,
                        $teacherData->email,
                        $teacherData->username,
                        $talk['id'],
                        $talk['headline'],
                        convertToUserTimezone($originBookings->start_date, 'd.m.Y'),
                        convertToUserTimezone($originBookings->start_time, 'H:i'),
                        convertToUserTimezone($originBookings->end_time, 'H:i'),
                        $talk['duration'],
                        $talk['price'],
                        $talkType,
                        $originBookings->id
                    )
                );

                StaticMetric::query()->where('user_id', $clientData->id)->increment('received_emails');
                StaticMetric::query()->where('user_id', $teacherData->id)->increment('received_emails');

                if ($oBookings['cancel_type'] == Booking::CANCEL_TYPE['supplier']) {
                    NotifyClientTalkCanceled::dispatch(
                        $clientData->id,
                        $originBookings->id,
                        $teacherData->username,
                        $talk['headline'],
                        Carbon::parse($originBookings->start_date)->format('d.m.Y'),
                        convertToUserTimezone($originBookings->start_time, 'H:i')
                    );
                } else {
                    if (Booking::CANCEL_TYPE['client']) {
                        NotifyTeacherTalkCanceled::dispatch(
                            $teacherData->id,
                            $originBookings->id,
                            $talk['headline'],
                            Carbon::parse($originBookings->start_date)->format('d.m.Y'),
                            convertToUserTimezone($originBookings->start_time, 'H:i')
                        );
                    }
                }

                $socketRoom = SocketRoom::query()
                    ->where('talk_id', $talk['id'])
                    ->where('state', RoomStates::ROOM_PENDING)
                    ->where('talk_start_time', date('Y-m-d H:i:00', strtotime('-1 minutes', strtotime($oBookings->start_call))))
                    ->where('talk_end_time', $oBookings->end_call)
                    ->first();

                $socketCancelWorkflow = $this->removeParticipants($socketRoom->id)->getData(true);

                if ($socketCancelWorkflow['success'] == false) {
                    DB::rollBack();

                    return response()->json([
                        'message' => $socketCancelWorkflow['message'],
                        'success' => false,
                    ], 200);
                }
            }
            DB::commit();
            $response = response()->json([
                'message' => __('SUCCESSFULLY_CANCELED_BOOKING'),
                'success' => true,
            ], 200);

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2313, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2313,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $booking
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function postponeBooking(Request $request, $booking)
    {
        try {
            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request->all());

            $oBookings = Booking::query()->select('id', 'participant_user_id', 'teacher_user_id', 'start_call', 'talk_id', 'cancellation_reason_id', 'state', 'duration')
                ->with(['talk'])
                ->find($booking);

            $aValidation = $this->validateBookingAction($request->user(), $oBookings);

            if (!$aValidation['success']) {
                $response = response()->json([
                    'message' => $aValidation['message'],
                    'success' => $aValidation['success'],
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            }

            DB::beginTransaction();

            $notificationData = [
                'user_id'    => $oBookings->participant_user_id,
                'type'       => !empty($oBookings->talk->headline) ? $oBookings->talk->headline : '',
                'param_type' => 'name_of_talk',
                'param_id'   => $oBookings->id,
                'talkName'   => !empty($oBookings->talk->headline) ? $oBookings->talk->headline : '',
                'value'      => Notifications::VALUE['booking_postponed'],
            ];
            $notification     = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$notification');
            Log::notice($notification);

            // Decrement bookings in static metrics
            StaticMetric::query()->where('user_id', $oBookings->teacher_user_id)->decrement('received_bookings');
            StaticMetric::query()->where('user_id', $oBookings->participant_user_id)->decrement('my_bookings');

            // Decrement booked hours in static metrics
            StaticMetric::query()->where('user_id', $oBookings->teacher_user_id)->decrement('received_booked_hours', $oBookings->duration);
            StaticMetric::query()->where('user_id', $oBookings->participant_user_id)->decrement('my_booked_hours', $oBookings->duration);

            BookingsController::createBookingProtocolEvent($oBookings->id, Booking::STATE['postponed']);

            $oBookings->update(['state' => Booking::STATE['postponed']]);

            DB::commit();

            $response = response()->json([
                'message' => 'Successfully postponed booking',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2314, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2314,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param $user
     * @param $oBookings
     * @param $changePeriod
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function validateBookingAction($user, $oBookings, $changePeriod = Booking::CHANGE_PERIOD)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$user');
        Log::notice($user);

        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$oBookings');
        Log::notice($oBookings);

        try {
            $sCurrentTime = date('Y-m-d H:i:s', strtotime('+' . $changePeriod . ' hours'));
            $status       = true;
            $message      = '';

            if (!in_array($user->id, [$oBookings->participant_user_id, $oBookings->teacher_user_id])) {
                $message = 'Cannot cancel requested booking, you dont have required permissions.';
                $status  = false;
            } else {
                if ($sCurrentTime > $oBookings->start_call) {
                    $message = __('NON_REFUND');
                    $status  = false;
                }
            }

            $response = [
                'message' => $message,
                'success' => $status,
            ];

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2315, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2315,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function setBookingMessage(Request $request)
    {
        try {
            Log::notice("\n\n" . '::BookingsApiController::setBookingMessage::$request');
            Log::notice($request);

            $booking_id = $request->input('booking_id');
            $message    = $request->input('message');
            $dataErrors = [];

            if (empty($booking_id)) {
                $dataErrors['booking_id'] = [
                    'The booking_id is required.',
                ];
            }
            if (empty($message)) {
                $dataErrors['message'] = [
                    'The message value is required.',
                ];
            }

            if (!empty($dataErrors)) {
                $response = response()->json([
                    'message' => 'The given data was invalid.',
                    'errors'  => $dataErrors,
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::BookingsApiController::setBookingMessage::$response');
                Log::notice($response);

                return $response;
            }

            DB::beginTransaction();

            $booking = Booking::query()->where('id', $booking_id);
            // TODO SEND MESSAGE TO TEACHER WITH INCLUDED RECEIVED MESSAGE

            if ($booking->exists()) {
                $booking->update(['message' => $message]);

                $booking        = $booking->first();
                $bookingTeacher = User::query()->find($booking->teacher_user_id);
                $bookingTalk    = Talk::query()->withGroup()->find($booking->talk_id);

                Mail::to($bookingTeacher->email)->queue(
                    new BookingMessage(
                        $bookingTeacher->last_language,
                        $bookingTeacher->name,
                        $request->user()->name,
                        $bookingTalk->headline,
                        // $booking->start_call,
                        convertToUserTimezone($booking->start_call)->toDateTimeString(),
                        // $booking->end_call,
                        convertToUserTimezone($booking->end_call)->toDateTimeString(),
                        route('api.bookings.show', [$booking->id]), $booking->message
                    )
                );

                StaticMetric::query()->where('user_id', $bookingTeacher->id)->increment('received_emails');
            } else {
                DB::rollBack();
                $response = [
                    'message' => 'Booking with requested id doesnt exist.',
                    'success' => false,
                ];

                Log::notice("\n\n" . '::BookingsApiController::setBookingMessage::$response');
                Log::notice($response);

                return $response;
            }

            DB::commit();

            $response = [
                'message' => 'Booking message successfully sent.',
                'success' => true,
            ];

            Log::notice("\n\n" . '::BookingsApiController::setBookingMessage::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2316, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2316,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param $talkId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeParticipants($socketId)
    {
        try {
            // Cancel socket room
            $socketRoom = SocketRoom::query()->where('id', $socketId)
                ->where('state', RoomStates::ROOM_PENDING)
                ->first();

            $logged_user = auth()->user();

            $socketRoomParticipants = SocketParticipant::query()->where('socket_room_id', $socketRoom->id)
                ->where('user_id', $logged_user->id)
                ->where('is_active', ParticipantStates::INACTIVE)
                ->first();

            if (empty($socketRoomParticipants)) {
                $response = response()->json([
                    'message' => __('BOOKING_REMOVED_PARTICIPANT_NOT_EXIST'), //'Requested participant not exists',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            }

            if ($socketRoomParticipants->user_type == UserTypes::PROVIDER || $socketRoom->call_type == CallTypes::ONE_TO_ONE) {
                SocketParticipant::query()->where('socket_room_id', $socketRoom->id)->delete();

                $socketRoom->update(['state' => RoomStates::UNDEFINED]);

                $message = 'Successfully closed socket room and removed participants.';
            } else {
                SocketParticipant::query()->where('socket_room_id', $socketRoom->id)
                    ->where('user_id', $logged_user->id)
                    ->delete();

                $message = 'Successfully removed from socket room.';

                $participiantsCount = SocketParticipant::query()
                    ->where('socket_room_id', $socketRoom->id)
                    ->count('id');

                if ($participiantsCount <= 1) {
                    SocketParticipant::query()->where('socket_room_id', $socketRoom->id)->delete();
                    $socketRoom->update(['state' => RoomStates::UNDEFINED]);

                    $message = 'Successfully closed socket room and removed participants.';
                }
            }

            $response = response()->json([
                'message' => $message,
                'success' => true,
            ], 200);

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2317, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2317,
                'success' => false,
            ], 500);
        }
    }

    public function getUserLastBooking(Request $request)
    {
        try {
            $logged_user = auth()->user();

            if (empty($logged_user)) {
                $loggedUserId = $request->input('user_id');
            } else {
                $loggedUserId = $logged_user->id;
            }

            $parentBooking          = null;
            $timezone               = $request->header('Time-Zone-Offset-UTC') ?? $request->user()->timezone;
            $requestTimezoneHour    = abs((int)(($timezone) / 60));
            $requestTimezoneMinutes = abs((int)(($timezone) % 60));
            $requestTimezoneSign    = $timezone > 0 ? '+' : '-';
            $caluclated_timezone    = $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes;

            $booking = Booking::query()
                ->where('participant_user_id', $loggedUserId)
                ->select('*')
                ->selectRaw("TO_CHAR(start_call + INTERVAL '" . $caluclated_timezone . " hours', 'YYYY-MM-DD HH24:MI:SS') AS start_call")
                ->selectRaw("TO_CHAR(end_call + INTERVAL '" . $caluclated_timezone . " hours', 'YYYY-MM-DD HH24:MI:SS') AS end_call")
                ->selectRaw("TO_CHAR(start_date + INTERVAL '" . $caluclated_timezone . " hours', 'YYYY-MM-DD') AS start_date")
                ->selectRaw("TO_CHAR(end_date + INTERVAL '" . $caluclated_timezone . " hours', 'YYYY-MM-DD') AS end_date")
                ->selectRaw("TO_CHAR(start_time + INTERVAL '" . $caluclated_timezone . " hours', 'HH24:MI:SS') AS start_time")
                ->selectRaw("TO_CHAR(end_time + INTERVAL '" . $caluclated_timezone . " hours', 'HH24:MI:SS') AS end_time")
                ->orderByDesc('id')
                ->first();

            $talk = Talk::query()->find($booking->talk_id);

            $user = User::query()->select(
                'id',
                'profile_picture',
                'profile_picture_tmp',
                'name',
                'username'
            )->where('id', $booking->teacher_user_id)->first()->toArray();


            if (!empty($booking->parent_id)) {
                $parentBooking = Booking::query()->select('id', 'talk_id', 'start_date', 'end_date', 'start_time', 'end_time')->where('id', $booking->parent_id)->with('talk:id,headline')->first();
            }

            $talkByIdData = new TalksApiController();
            $request->request->add(['talk_id' => $booking->talk_id]);
            $request->request->add(['talk_type' => $talk->talk_type]);

            $talkRequestData  = $talkByIdData->teacherTalks($request, $booking->teacher_user_id)->getData(true);
            $talkData         = $talkRequestData['data'][0] ?? [];
            $talkData['user'] = $user;

            if (!empty($talkData)) {
                $response = response()->json([
                    'data'    => [
                        'talkData'      => $talkData,
                        'bookingData'   => $booking,
                        'parentBooking' => $parentBooking,
                    ],
                    'message' => 'Last booked talk',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            } else {
                $response = response()->json([
                    'message' => 'There is no booked talk',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2318, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2318,
                'success' => false,
            ], 500);
        }
    }

    public function getUserFirstUpcomingBooking(Request $request)
    {
        try {
            $currentTime = date('Y-m-d H:i:s');
            $logged_user = auth()->user();
            if (empty($logged_user)) {
                $loggedUserId = $request->input('user_id');
            } else {
                $loggedUserId = $logged_user->id;
            }

            $booking = Booking::query()
                ->where(function ($q) use ($loggedUserId) {
                    $q->where('participant_user_id', $loggedUserId);
                    $q->orWhere('teacher_user_id', $loggedUserId);
                })
                ->where('start_call', '>', $currentTime)
                ->orderBy('start_call')
                ->first();

            if (!empty($booking)) {
                $response = response()->json([
                    'data'    => $booking,
                    'message' => 'First upcoming booking',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            } else {
                $response = response()->json([
                    'message' => 'There is no upcoming bookings',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2319, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2319,
                'success' => false,
            ], 500);
        }
    }

    protected function getUserBilling($request)
    {
        $billing = $request->user()->billing;

        if (!is_null($request->input('vat_id')) && $request->input('vat_id') != $request->user()->vat_id) {
            $old_billing               = $new_billing = clone $billing;
            $new_billing->countries_id = $request->input('vat_id');

            $billing = $request->user()->billingAddress()->create($new_billing->toArray());

            $request->user()->update([
                'vat_id'             => $request->input('vat_id'),
                'billing_address_id' => $billing->id,
            ]);

            $old_billing->update([
                'state' => BillingAddress::STATE['not_valid'],
            ]);
        }

        return $billing;
    }

    protected function getCalendarAccount($client, $supplier)
    {
        $client_calendar_accounts   = $client->calendarAccounts;
        $supplier_calendar_accounts = $supplier->calendarAccounts;

        if ($client_calendar_accounts->isNotEmpty()) {
            $calendar_account = $client_calendar_accounts;
        } else {
            if ($supplier_calendar_accounts->isNotEmpty()) {
                $calendar_account = $supplier_calendar_accounts;
            }
        }

        return isset($calendar_account) ? $calendar_account->where('is_primary', true)->first() : null;
    }

    protected function createCalendarEvent($request, $calendar_account, $existing_booking_id, $booking)
    {
        $calendar      = $calendar_account->talkila();
        $calendar_user = $calendar_account->user;
        $url           = config('app.frontend_url') . '/booking/' . $booking->id;

        $request->request->add([
            'data' => [
                'summary'     => $booking->talk->headline,
                'description' => "{$booking->talk->description} \n\n More details: {$url}",
                'status'      => 'confirmed',
                'start'       => [
                    'dateTime' => Carbon::parse($booking->start_call)->toDateTimeLocalString(),
                    'timeZone' => 'UTC',
                ],
                'end'         => [
                    'dateTime' => Carbon::parse($booking->end_call)->toDateTimeLocalString(),
                    'timeZone' => 'UTC',
                ],
                'attendees'   => [
                    [
                        'email'       => $booking->supplier->email,
                        'displayName' => $booking->supplier->name,
                    ],
                    [
                        'email'       => $booking->client->email,
                        'displayName' => $booking->client->name,
                    ],
                ],
                'visibility'  => 'private',
                'source'      => [
                    'title' => 'Talkila Booking',
                    'url'   => $url,
                ],
            ],
        ]);

        if ($existing_booking_id) {
            $initial_booking = Booking::find($existing_booking_id);

            if ($initial_booking->event_id) {
                $event = (new CalendarController())->updateEvent($request, $calendar_user, $calendar, $initial_booking->event_id)->getData(true);
            }
        } else {
            $event = (new CalendarController())->storeEvent($request, $calendar_user, $calendar)->getData(true);
        }

        $request->request->remove('data');

        if ($event['success']) {
            $booking->update([
                'calendar_id' => $calendar->id,
                'event_id'    => $event['data']['id'],
            ]);
        }
    }

    protected function updateDefaultPaymentMethod($request)
    {
        if ($request->has('selected_card_data') && !empty($request->input('selected_card_data'))) {
            $payment_method = $request->input('selected_card_data')['card_id'];
        }

        if ($request->has('account_id')) {
            $payment_method = $request->input('account_id');
        }

        if (!$request->has('admin_panel') && isset($payment_method)) {
            return $request->user()->update([
                'default_payment_method' => $payment_method,
            ]);
        }
    }

    protected function emitExtensionCancelledEvent(Request $request)
    {
        $socket_server_url = config('app.socket_url');
        $body              = json_encode(['event' => 58]);
        $cancelEvent       = Http::withHeaders(['Authorization' => session()->get('access_token') ?? $request->header('authorization')])
            ->post("$socket_server_url/api/socket-event?event=58");

        Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$cancelEvent');
        Log::notice(json_encode($cancelEvent->json()));

        return $cancelEvent;
    }

    protected function sendBookingMails($teacherData, $clientData, array $talk, $newBooking): void
    {
        Mail::to($teacherData->email)->queue(
            new BookingConfirmationSupplier(
                $teacherData->last_language,
                $teacherData->email,
                $teacherData->username,
                $talk['id'],
                $talk['headline'],
                convertToUserTimezone($newBooking->start_date, 'd.m.Y'),
                convertToUserTimezone($newBooking->start_time, 'H:i'),
                convertToUserTimezone($newBooking->end_time, 'H:i'),
                $talk['duration'],
                $talk['price'],
                $talk['talk_type'] == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                $newBooking->id,
                $teacherData->billing,
                $newBooking->vat
            )
        );
        Mail::to($clientData->email)->queue(
            new BookingConfirmationClient(
                $clientData->last_language,
                $clientData->email,
                $teacherData->username,
                $talk['id'],
                $talk['headline'],
                convertToUserTimezone($newBooking->start_date, 'd.m.Y'),
                convertToUserTimezone($newBooking->start_time, 'H:i'),
                convertToUserTimezone($newBooking->end_time, 'H:i'),
                $talk['duration'],
                $talk['price'],
                $talk['talk_type'] == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                $newBooking->id,
                $teacherData->billing,
                $newBooking->vat
            )
        );
    }

    /**
     * Set Talk Token for Supplier and the Client which will be used when redirecting from the Mobile App to the Web app.
     *
     * @param  int  $clientId    Booking Client ID.
     * @param  int  $supplierId  Booking Supplier ID.
     *
     * @return void
     */
    protected function setTalkTokens(int $clientId, int $supplierId): void
    {
        User::query()
            ->find($clientId)
            ->update([
                'talk_token'         => Str::random(40),
                'talk_token_used_at' => null,
            ]);

        User::query()
            ->find($supplierId)
            ->update([
                'talk_token'         => Str::random(40),
                'talk_token_used_at' => null,
            ]);
    }
}
