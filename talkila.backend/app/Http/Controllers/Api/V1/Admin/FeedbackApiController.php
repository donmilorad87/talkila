<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\ApiRequests\StoreFeedbackApiRequest;
use App\Mail\BookingInvoiceClient;
use App\Mail\BookingInvoiceSupplier;
use App\Mail\FeedbackDeleted;
use App\Mail\FeedbackNew;
use App\Models\Notifications;
use App\Models\User;
use App\ModelsApi\Booking;
use App\ModelsApi\Feedback;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\Talk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


/**
 * @OA\Tag(
 *     name="Feedbacks",
 *     description="Everything about Feedbacks",
 * )
 */

/**
 * @OA\Post(
 *      path="/v1/feedbacks",
 *      operationId="store",
 *      tags={"Feedbacks"},
 *      summary="Get requested fields from form and create new Feedback",
 *      description="Get requested fields from form and create new Feedback",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreFeedbackRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Feedback")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * @OA\Delete(
 *      path="/v1/feedbacks/{feedback}",
 *      operationId="destroy",
 *      tags={"Feedback"},
 *      summary="Delete Feedback",
 *      description="Take requested Feedback and delete it from system",
 *      @OA\Parameter(
 *          name="feedback",
 *          description="Feedback id",
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
 * @OA\Post(
 *      path="/v1/feedback/media",
 *      operationId="storeMedia",
 *      tags={"Feedback"},
 *      summary="Method storeMedia of FeedbackApiController",
 *      description="Method storeMedia of FeedbackApiController",
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
 *      path="/v1/user-feedback-rating",
 *      operationId="getRating",
 *      tags={"Feedback"},
 *      summary="Method getRating of FeedbackApiController",
 *      description="Method getRating of FeedbackApiController",
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
 *      path="/v1/teacher-feedback",
 *      operationId="getTeacherRating",
 *      tags={"Feedback"},
 *      summary="Method getTeacherRating of FeedbackApiController",
 *      description="Method getTeacherRating of FeedbackApiController",
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
 *      path="/v1/talk-feedback",
 *      operationId="getTalkRating",
 *      tags={"Feedback"},
 *      summary="Method getTalkRating of FeedbackApiController",
 *      description="Method getTalkRating of FeedbackApiController",
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
 * Class FeedbackApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class FeedbackApiController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param  StoreFeedbackApiRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(StoreFeedbackApiRequest $request)
    {
        Log::notice("\n\n" . '::FeedbackApiController::store::$request');
        Log::notice($request->all());

        try {
            DB::beginTransaction();
            $feedbackData = $request->all();
            $star_content = (int)$request->input('stars_content');

            $feedback_time = date('Y-m-d H:i:s');
            $user_id       = auth()->user()->id;

            $feedbackData['user_id'] = $user_id;

            if ($request->has('booking_id') && ! empty($request->input('booking_id'))) {
                $bookingId     = $request->input('booking_id');
                $activeBooking = Booking::query()->where('id', $bookingId)->first();
            } else {
                $activeBooking = Booking::query()->where(function ($query) use ($user_id) {
                    $query->where('participant_user_id', $user_id);
                    $query->orWhere('teacher_user_id', $user_id);
                })
                    ->where(function ($query) use ($feedback_time) {
                        $query->where('end_call', '<=', $feedback_time);
                        $query->orWhere(function ($query_second) use ($feedback_time) {
                            $query_second->where('start_call', '<=', $feedback_time);
                            $query_second->where('end_call', '>=', $feedback_time);
                        });
                    })
                    ->orderBy('end_call', 'DESC')
                    ->first();

                $backupBooking = Booking::query()
                    ->where(function ($query) use ($user_id) {
                        $query->where('participant_user_id', $user_id);
                        $query->orWhere('teacher_user_id', $user_id);
                    })
                    ->orderBy('end_call', 'DESC')
                    ->first();

                $bookingId = ! empty($activeBooking->id) ? $activeBooking->id : $backupBooking->id;
            }

            if ($user_id == $activeBooking->teacher_user_id) {
                $feedbackData['user_role'] = Feedback::USER_ROLE['teacher'];
            }

            $feedbackData['booking_id'] = $bookingId;

            if ($activeBooking->anonym) {
                $feedbackData['anonym'] = Booking::ANONYM['anonym'];
            }
            $feedback = Feedback::create($feedbackData);

            $booking = Booking::query()->find($feedback->booking_id);

            if ($user_id == $activeBooking->teacher_user_id) {
                User::query()->find($activeBooking->participant_user_id)->increment('reviews');
                User::query()->find($activeBooking->participant_user_id)->increment('ratings', $star_content);
            } else {
                Talk::query()->find($booking->talk_id)->increment('reviews');
                Talk::query()->find($booking->talk_id)->increment('ratings', $star_content);

                User::query()->find($user_id)->increment('reviews');
                User::query()->find($user_id)->increment('ratings', $star_content);
            }

            $feedbackUserName = 'Anonymous';
            if (! $booking->anonym) {
                $feedbackUserName = User::query()->where('id', $user_id)->first()->username;
            }

            $talk = Talk::query()->select(['id', 'ratings', 'headline', 'price'])->find($booking->talk_id);

            // Increment reviews in static metrics
            StaticMetric::query()->where('user_id', $booking->teacher_user_id)->increment('received_reviews');
            StaticMetric::query()->where('user_id', $request->user()->id)->increment('my_reviews');

            $participantData = User::query()->find($booking->participant_user_id);
            $teacherData     = User::query()->find($booking->teacher_user_id);
            $language        = $request->header('Application-Language', 'en');

            if ($user_id == $activeBooking->participant_user_id) {
                // TODO: Invoice Mail
                Mail::to($participantData->email)->queue(new BookingInvoiceClient($language, $booking, $teacherData, $participantData));
                Mail::to($participantData->email)->queue(new FeedbackNew($language, $participantData->email, $user_id, $star_content, $request->input('description'), $talk['id'], $talk['headline'], $feedbackUserName));
                StaticMetric::query()->where('user_id', $participantData->id)->increment('received_emails');
            } else {
                // TODO: Invoice Mail
                Mail::to($teacherData->email)->queue(new BookingInvoiceSupplier($language, $booking, $teacherData, $participantData));
                Mail::to($teacherData->email)->queue(new FeedbackNew($language, $teacherData->email, $user_id, $star_content, $request->input('description'), $talk['id'], $talk['headline'], $feedbackUserName));
                StaticMetric::query()->where('user_id', $teacherData->id)->increment('received_emails');
            }

            $notificationData = [
                'user_id'    => $feedback->user_id,
                'type'       => $talk->headline ?: '',
                'param_type' => 'name_of_talk',
                'param_id'   => $talk->id,
                'talkName'   => $talk->id,
                'value'      => Notifications::VALUE['new_rating'],
            ];
            $notification     = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::FeedbackApiController::store::$notification');
            Log::notice($notification);

            DB::commit();
            $response = response()->json([
                'message' => 'Booking was successfully reviewed.',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::FeedbackApiController::store::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2700, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2700,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Feedback  $feedback
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Feedback $feedback)
    {
        try {
            DB::beginTransaction();
            // Decrement reviews in static metrics
            StaticMetric::query()->where('user_id', $feedback->teacher_user_id)->decrement('received_reviews');
            StaticMetric::query()->where('user_id', $request->user()->id)->decrement('my_reviews');

            $booking = Booking::query()->find($feedback->booking_id);
            Talk::query()->find($booking->talk_id)->decrement('reviews');
            Talk::query()->find($booking->talk_id)->decrement('ratings', $feedback->stars_content);

            $clientData = \App\Models\User::query()->find($feedback->user_id);

            Mail::to($clientData->email)->queue(new FeedbackDeleted($request->header('Application-Language', 'en'), $clientData->email, 'reason'));
            StaticMetric::query()->where('user_id', $clientData->id)->increment('received_emails');

            $feedback->delete();

            DB::commit();

            return response()->json([
                'message' => 'Feedback successfully deleted.',
                'success' => true,
            ], 500);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2701, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2701,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRating(Request $request)
    {
        try {
            Log::notice("\n\n" . '::FeedbackApiController::getRating::$request');
            Log::notice($request->all());

            $aTeacherBookingList = Booking::query()->where('teacher_user_id', $request->user()->id)->get()
                ->pluck('id')
                ->toArray();

            $feedbacks = Feedback::query()->selectRaw('AVG(stars_content) as rating, COUNT(id) as totalRatings')
                ->whereIn('booking_id', $aTeacherBookingList)
                ->whereHas('user')
                ->first();

            $data     = [
                'talk_rating'       => number_format($feedbacks->rating, 1),
                'talk_total_rating' => $feedbacks->totalRatings,
            ];
            $response = response()->json([
                'data'    => $data,
                'message' => 'Successfully got rating',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::FeedbackApiController::getRating::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2702, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2702,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeacherRating(Request $request)
    {
        try {
            Log::notice("\n\n" . '::FeedbackApiController::getTeacherRating::$request');
            Log::notice($request->all());

            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 15);
            $userId        = $request->input('user_id');
            $loggedUser    = $request->user();
            $feedbackType  = $request->input('feedback_type', Feedback::TYPE['received']);

            if (empty($userId)) {
                $dataErrors['user_id'] = [
                    'The user id is required.',
                ];
            }

            if (! empty($dataErrors)) {
                $response = response()->json([
                    'message' => 'The given data was invalid.',
                    'errors'  => $dataErrors,
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::FeedbackApiController::getTeacherRating::$response');
                Log::notice($response);

                return $response;
            }

            $aTeacherBookingList = User::query()->selectRaw(
                '
                    CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews,
                    CAST(SUM(ratings) AS NUMERIC(10,1)) as total_ratings
                '
            )
                ->where('id', $userId)
                ->first()
                ->toArray();

            $aUserBookingList = Booking::query()
                ->where('teacher_user_id', $userId)
                ->where('teacher_user_id', $userId)
                ->get()
                ->pluck('id')
                ->toArray();

            $feedback = Feedback::query()->selectRaw(
                '
                    sum(case when stars_content = 5 then 1 else 0 end) as five_stars,
                    sum(case when stars_content = 4 then 1 else 0 end) as four_stars,
                    sum(case when stars_content = 3 then 1 else 0 end) as three_stars,
                    sum(case when stars_content = 2 then 1 else 0 end) as two_stars,
                    sum(case when stars_content = 1 then 1 else 0 end) as one_stars,
                    SUM(stars_content) as totalRatings,
                    COUNT(id) as totalReviews'
            )
                ->whereHas('user');

            if ($feedbackType == Feedback::TYPE['received']) {
                $feedback->whereIn('booking_id', $aUserBookingList);

                if (! empty($loggedUser)) {
                    $feedback->where('user_id', '!=', $loggedUser->id);
                }
            } else {
                $feedback->where('user_id', $userId);
            }

            $feedback = $feedback->first()->toArray();


            if ($feedback['totalReviews'] == 0) {
                $response = response()->json([
                    'message' => 'There is no reviews.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::FeedbackApiController::getRating::$response');
                Log::notice($response);

                return $response;
            }
            $loggedUser       = $request->user();
            $feedbackComments = Feedback::query()
                ->select('booking_id', 'feedback.id', 'user_id', 'stars_content', 'feedback.description', 'name', 'feedback.anonym')
                ->selectRaw("TO_CHAR(feedback.created_at,'YYYY-MM-DD HH24:MI:SS') as created_date")
                ->leftJoin('users', function ($join) {
                    $join
                        ->on('users.id', '=', 'feedback.user_id');
                })
                ->whereHas('user')
                ->orderByDesc('feedback.created_at')
                ->offset($displayOffset)->limit($displayLimit);

            if ($feedbackType == Feedback::TYPE['received']) {
                $feedbackComments->selectRaw("CASE WHEN users.id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                    ->whereIn('booking_id', $aUserBookingList);

                if (! empty($loggedUser)) {
                    $feedbackComments->where('user_id', '!=', $loggedUser->id);
                }
            } else {
                $users    = User::query()->selectRaw('id, profile_picture');
                $bookings = Booking::query()->selectRaw('bookings.id, participant_user_id, profile_picture')
                    ->leftJoinSub($users, 'users', function ($join) {
                        $join
                            ->on('users.id', '=', 'bookings.participant_user_id');
                    });

                $feedbackComments->selectRaw("bookings.profile_picture")
                    ->where('user_id', $userId)
                    ->leftJoinSub($bookings, 'bookings', function ($join) {
                        $join->on('bookings.id', '=', 'feedback.booking_id');
                    });
            }

            if (! empty($request->input('stars_rating'))) {
                $feedbackComments->where('stars_content', $request->input('stars_rating'));
            }
            $feedbackComments = $feedbackComments->get();

            $aTeacherBookingList['user_rating'] = $aTeacherBookingList['total_reviews'] > 0 ? round($aTeacherBookingList['total_ratings'] / $aTeacherBookingList['total_reviews'], 2) : 0;

            $data = [
                'user_feedback'     => $aTeacherBookingList,
                'stars_feedback'    => $feedback,
                'feedback_comments' => $feedbackComments,
            ];

            $response = response()->json([
                'data'    => $data,
                'message' => 'Successfully got rating',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::FeedbackApiController::getRating::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2703, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2703,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTalkRating(Request $request)
    {
        try {
            Log::notice("\n\n" . '::FeedbackApiController::getRating::$request');
            Log::notice($request->all());

            $dataErrors    = [];
            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 15);
            $talk_id       = $request->input('talk_id');

            if (empty($talk_id)) {
                $dataErrors['talk_id'] = [
                    'The talk id is required.',
                ];
            }

            if (! empty($dataErrors)) {
                $response = response()->json([
                    'message' => 'The given data was invalid.',
                    'errors'  => $dataErrors,
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::FeedbackApiController::getTalkRating::$response');
                Log::notice($response);

                return $response;
            }
            $talkFeedbackData = Talk::query()
                ->selectRaw(
                    '
                    id,
                    CAST(SUM(reviews) AS NUMERIC(10,1)) as reviews,
                    CAST(SUM(ratings) AS NUMERIC(10,1)) as ratings
                '
                )
                ->where('id', $talk_id)
                ->first()
                ->toArray();

            $bookingsId = Booking::query()->where('talk_id', $talk_id)->get()->pluck('id')->toArray();

            $feedback = Feedback::query()->selectRaw(
                '
                    sum(case when stars_content = 5 then 1 else 0 end) as five_stars,
                    sum(case when stars_content = 4 then 1 else 0 end) as four_stars,
                    sum(case when stars_content = 3 then 1 else 0 end) as three_stars,
                    sum(case when stars_content = 2 then 1 else 0 end) as two_stars,
                    sum(case when stars_content = 1 then 1 else 0 end) as one_stars,
                    CAST(SUM(stars_content) AS NUMERIC(10,1)) as totalRatings,
                    COUNT(id) as totalReviews
                '
            )
                ->whereHas('user')
                ->whereIn('booking_id', $bookingsId)
                ->first()
                ->toArray();

            if ($feedback['totalReviews'] == 0) {
                $response = response()->json([
                    'message' => 'There is no reviews.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::FeedbackApiController::getRating::$response');
                Log::notice($response);

                return $response;
            }
            $loggedUser       = $request->user();
            $feedbackComments = Feedback::query()
                ->select('feedback.id', 'user_id', 'stars_content', 'feedback.description', 'name')
                ->selectRaw("CASE WHEN users.id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->selectRaw("TO_CHAR(feedback.created_at,'FMMonth YYYY') as created_date")
                ->whereHas('user')
                ->leftJoin('users', function ($join) {
                    $join
                        ->on('users.id', '=', 'feedback.user_id');
                })
                ->whereIn('booking_id', $bookingsId)
                ->offset($displayOffset)->limit($displayLimit);


            if (! empty($request->input('stars_rating'))) {
                $feedbackComments->where('stars_content', $request->input('stars_rating'));
            }
            $feedbackComments = $feedbackComments->get();

            $talkFeedbackData['talk_rating'] = $talkFeedbackData['reviews'] > 0 ? round($talkFeedbackData['ratings'] / $talkFeedbackData['reviews'], 2) : 0;

            $data     = [
                'talk_feedback'     => $talkFeedbackData,
                'stars_feedback'    => $feedback,
                'feedback_comments' => $feedbackComments,
            ];
            $response = response()->json([
                'data'    => $data,
                'message' => 'Successfully got talk rating',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::FeedbackApiController::getTalkRating::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2704, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2704,
                'success' => false,
            ], 500);
        }
    }
}