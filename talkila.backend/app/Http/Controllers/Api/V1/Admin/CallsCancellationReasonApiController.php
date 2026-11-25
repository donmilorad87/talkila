<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CallsCancellationReasonResource;
use App\ModelsApi\Booking;
use App\ModelsApi\CallsCancellationReason;
use App\ModelsApi\StaticProfession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="CallsCancellationReasons",
 *     description="Everything about CallsCancellationReasons",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/calls-cancellation-reasons",
 *      operationId="index",
 *      tags={"CallsCancellationReasons"},
 *      summary="Get list of CallsCancellationReasons",
 *      description="Returns list of CallsCancellationReasons",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/CallsCancellationReasonResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of CallsCancellationReasons
 */

/**
 * @OA\Post(
 *      path="/v1/calls-cancellation-reasons",
 *      operationId="store",
 *      tags={"CallsCancellationReasons"},
 *      summary="Get requested fields from form and create new CallsCancellationReason",
 *      description="Get requested fields from form and create new CallsCancellationReason",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreCallsCancellationReasonRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/CallsCancellationReason")
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
 *      path="/v1/calls-cancellation-reasons/{id}",
 *      operationId="show",
 *      tags={"CallsCancellationReasons"},
 *      summary="Get CallsCancellationReasons information",
 *      description="Returns CallsCancellationReasons data",
 *      @OA\Parameter(
 *          name="id",
 *          description="CallsCancellationReason id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/CallsCancellationReason")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Put(
 *      path="/v1/calls-cancellation-reasons/{id}",
 *      operationId="update",
 *      tags={"CallsCancellationReasons"},
 *      summary="Get CallsCancellationReasons update information",
 *      description="Get requested fields from form and update requested CallsCancellationReason",
 *      @OA\Parameter(
 *          name="id",
 *          description="CallsCancellationReason id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateCallsCancellationReasonRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/CallsCancellationReason")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Delete(
 *      path="/v1/calls-cancellation-reasons/{id}",
 *      operationId="destroy",
 *      tags={"CallsCancellationReason"},
 *      summary="Delete CallsCancellationReason",
 *      description="Take requested CallsCancellationReason and delete it from system",
 *      @OA\Parameter(
 *          name="id",
 *          description="CallsCancellationReason id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=204,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */


/**
 * Class CallsCancellationReasonApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class CallsCancellationReasonApiController extends Controller
{
    /**
     * @return CallsCancellationReasonResource
     */
    public function index(Request $request)
    {
        try {
            Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$request');
            Log::notice($request->all());

            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';

            $todayDate = date(
                'Y-m-d H:i:s',
                strtotime(
                    $requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes',
                    strtotime(
                        date('Y-m-d H:i:s')
                    )
                )
            );

            $user_language = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', $request->user() ? $request->user()->last_language : 'en')];

            $cancellationReason = CallsCancellationReason::query()
                ->select([
                    'id',
                    $user_language . ' as value',
                ])
                ->where('state', CallsCancellationReason::STATE['valid'])
                ->whereNotNull($user_language);

            if ($request->has('booking_id')) {
                $booking = Booking::query()->find($request->input('booking_id'));

                $extendedBooking = Booking::query()->where('parent_id', $request->input('booking_id'))->latest('id')->first();

                if ($extendedBooking) {
                    $booking = $extendedBooking;

                    $todayDate = date(
                        'Y-m-d H:i:s',
                        strtotime(
                            $requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes',
                            strtotime(
                                date($booking->start_call)
                            )
                        )
                    );
                }

                $activeBooking = false;

                $bookingStart = date('Y-m-d H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking->start_call)));
                $bookingEnd   = date('Y-m-d H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($booking->end_call)));

                if ($bookingStart <= $todayDate && $bookingEnd >= $todayDate) {
                    $activeBooking = true;
                }

                if (! empty($booking)) {
                    if ($booking->teacher_user_id == auth()->user()->id) {
                        if ($activeBooking) {
                            $cancellationReason->where('type', Booking::CANCEL_TYPE['active_talk_supplier']);
                        } else {
                            $cancellationReason->where('type', Booking::CANCEL_TYPE['supplier']);
                        }
                    } else {
                        if ($activeBooking) {
                            $cancellationReason->where('type', Booking::CANCEL_TYPE['active_talk_client']);
                        } else {
                            $cancellationReason->where('type', Booking::CANCEL_TYPE['client']);
                        }
                    }
                } else {
                    $response = response()->json([
                        'message' => 'There is no requested booking',
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$response');
                    Log::notice($response);

                    return $response;
                }
            }

            $cancellationReason = $cancellationReason->get()->toArray();

            if (empty($cancellationReason)) {
                $response = response()->json([
                    'message' => 'There is no cancellation reasons.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $cancellationReason,
                'message' => __('LIST_OF_CANCELATION_REASONS'),
                'success' => true,
            ]);

            Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2500, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2500,
                'success' => false,
            ], 500);
        }
    }
}
