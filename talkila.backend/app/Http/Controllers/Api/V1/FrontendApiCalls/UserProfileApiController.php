<?php

namespace App\Http\Controllers\Api\V1\FrontendApiCalls;

use App\Exceptions\Handler;
use App\Http\Controllers\Api\V1\Admin\AvailabilityApiController;
use App\Http\Controllers\Api\V1\Admin\BookingsApiController;
use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CallsCancellationReasonResource;
use App\Models\HelperModel;
use App\Models\UserBlocked;
use App\Models\UserBookmarkedTalks;
use App\ModelsApi\Availability;
use App\ModelsApi\Booking;
use App\ModelsApi\CallsCancellationReason;
use App\ModelsApi\Feedback;
use App\ModelsApi\Language;
use App\ModelsApi\ProfilCv;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\TalkCategories;
use App\ModelsApi\TalkSubcategories;
use App\ModelsApi\User;
use App\ModelsApi\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class UserProflieApiController
 * @package App\Http\Controllers\Api\V1\FrontendApiCalls
 */
class UserProfileApiController extends Controller
{
    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse\
     */
    public function show(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UsersApiController::show::$request');
            Log::notice($request->all());

            if (empty($request->user())) {
                $loggedUserID = -99;
            } else {
                $loggedUserID = $request->user()->id;
            }

            $requestedUser = User::query()->select(\App\Models\User::API_COLUMNS)->selectRaw(
                "CASE WHEN id = $loggedUserID THEN profile_picture_tmp ELSE profile_picture END AS profile_picture"
            );

            if ((int)$id != 0) {
                $requestedUser->where('id', $id);
            } else {
                $requestedUser->where('username', $id);
            }

            $user = $requestedUser->with('partner:id,name,slug,logo,url')->first();



            if (empty($user)) {
                $response = response()->success(__('USER_NOT_FOUND'));

                Log::notice("\n\n" . '::UsersApiController::show::$response');
                Log::notice($response);

                return $response;
            }

            $blockedByUser = UserBlocked::query()->where('blocked_user_id', $loggedUserID)
                ->where('user_id', $user->id)
                ->where('state', UserBlocked::STATE['valid'])
                ->exists();

            if ($blockedByUser) {
                $response = response()->success(__('BLOCKED_BY_USER'));

                Log::notice("\n\n" . '::UsersApiController::show::$response');
                Log::notice($response);

                return $response;
            }

            $user = $user->toArray();

            // ->with('partner:id,name,slug,logo,url')

            $availability = JoinTheClubApiController::joinTheClubAvailabilityCompleted($request, $user['id'])->getData(
                true
            );

            // $aTeacherBookingList = User::query()->selectRaw(
            //     '
            //         CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews,
            //         CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS ratings
            //     '
            // )
            //     ->where('id', $id)
            //     ->orWhere('username', $id)
            //     ->first()
            //     ->toArray();

            $bookings  = User::query()->where(is_numeric($id) ? 'id' : 'username', $id)->first()->bookings->pluck('id');
            $feedbacks = Feedback::whereIn('booking_id', $bookings)
                ->where('user_id', '!=', $user['id'])
                ->selectRaw('SUM(stars_content) as stars')
                ->selectRaw('COUNT(id) as total')
                ->first();

            $user['is_me']            = $user['id'] == $loggedUserID;
            $user['ratings']          = $feedbacks->total > 0 ? round($feedbacks->stars / $feedbacks->total, 2) : 0;
            $userForVerification = User::where(is_numeric($id) ? 'id' : 'username', $id)->first();
            $user['account_verified'] = $userForVerification?->pendingProfileVerificationRequest?->status;

            $followingUser = UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('user_id', $loggedUserID)
                ->where('follower_user_id', $user['id'])
                ->exists();

            $pendingFollowingUser = UserFollowed::query()->where('state', UserFollowed::STATE['requested'])
                ->where('user_id', $loggedUserID)
                ->where('follower_user_id', $user['id'])
                ->exists();

            $followerUser = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('user_id', $user['id'])
                ->where('follower_user_id', $loggedUserID)
                ->exists();

            $blockedUser = UserBlocked::query()->where('user_id', $loggedUserID)
                ->where('blocked_user_id', $user['id'])
                ->where('state', UserBlocked::STATE['valid'])
                ->exists();

            $userTalkBookingData = self::userProfileTalkBookingData(
                $user['id'],
                $request->header('Application-Language', 'en')
            )->getData(true);

            $dataTalkBooking = array_merge(
                $userTalkBookingData['data'],
                [
                    /* 'availability'     => $availability['data']['percentage'], */
                    'pending_follower' => $pendingFollowingUser,
                    'follower'         => $followerUser,
                    'following'        => $followingUser,
                    'blocked'          => $blockedUser,
                ]
            );

            if ($user['id'] != $loggedUserID) {
                // Increment visited in static metrics
                StaticMetric::query()->where('user_id', $user['id'])->increment('visited');
            }

            $response = response()->success([
                'message' => __('USER_DATA'),
                'data'    => array_merge($user, $dataTalkBooking),
            ]);

            Log::notice("\n\n" . '::UsersApiController::show::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4300,
                self::class,
                __FUNCTION__
            );

            return response()->error($exception->getMessage(), 500);
        }
    }

    public static function userProfileTalkBookingData($userId, $language)
    {
        try {
            // Get talk data for teacher
            $talksData = StaticMetric::query()
                ->selectRaw(
                    '
                ROUND(my_booked_hours/60) as teacher_booked_hours,
                talks as teacher_booked_talks,
                my_bookings AS teacher_booked_bookings,
                received_reviews AS teacher_booked_review_count,
                received_followers as total_followers'
                )
                ->where('user_id', $userId)
                ->first()
                ->toArray();

            // Get count of unique students on logged in user talks
            $teacherBookingData = optional(
                Booking::query()
                    ->selectRaw('COUNT(participant_user_id) AS teacher_booked_students')
                    ->where('teacher_user_id', $userId)
                    ->where('state', Booking::STATE['paid'])
                    ->groupBy('participant_user_id')
                    ->first()
            )
                ->toArray();

            // User talks languages
            $teacherLanguagesData = Talk::query()
                ->where('teacher_user_id', $userId)
                ->get()
                ->pluck('languages_id')
                ->toArray();

            $teacherSkills = Language::query()
                ->select(StaticProfession::DATABASE_LANGUAGE[$language] . ' as language')
                ->whereIn('id', array_unique($teacherLanguagesData))
                ->get()->pluck('language')->toArray();

            $talksData['teacher_booked_hours'] = (int)$talksData['teacher_booked_hours'];

            if (isset($teacherBookingData['teacher_booked_students'])) {
                $talksData['teacher_booked_students'] = (int)$teacherBookingData['teacher_booked_students'];
            } else {
                $talksData['teacher_booked_students'] = 0;
            }


            $dataTalkBooking = array_merge(
                $talksData,
                [
                    'teacher_skills' => $teacherSkills,
                ]
            );

            return response()->json([
                'data' => $dataTalkBooking,
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4301,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4301, 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCv(Request $request)
    {
        try {
            $userCsv = \App\Models\ProfilCv::query()->select(
                'id',
                'type',
                'start_date',
                'end_date',
                'company_name',
                'profession',
                'location',
                'work_here'
            )
                ->orderByDesc('start_date');
            if ($request->has('user_id') && $request->input('user_id') != null) {
                $userCsv->where('user_id', $request->input('user_id'));
            } else {
                $userCsv->where('user_id', $request->user()->id);
            }

            $educationCv = clone $userCsv;

            $groupedProfileCv = [];

            $userJobCsv       = $userCsv->where('type', ProfilCv::TYPE['job'])->get()->toArray();
            $userEducationCsv = $educationCv->where('type', ProfilCv::TYPE['education'])->get()->toArray();

            $groupedProfileCv['job']       = $userJobCsv;
            $groupedProfileCv['education'] = $userEducationCsv;

            if (empty($groupedProfileCv['job']) && empty($groupedProfileCv['education'])) {
                $response = response()->success(__('NO_CV'));

                Log::notice("\n\n" . '::ProfilCvApiController::userCv::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                // 'message' => 'Cv-s for logged in user grouped by type of CV.',
                'message' => __('CV_GROUPED_BY_TYPE'),
                'data'    => $groupedProfileCv,
            ]);

            Log::notice("\n\n" . '::ProfilCvApiController::userCv::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3400,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => $exception->getMessage(),//'Error: '.Handler::TYPE_EXCEPTION_3400,
            //     'success' => false
            // ], 500);

            return response()->error($exception->getMessage(), 500);
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
            $feedbackType  = $request->input('feedback_type', Feedback::TYPE['received']);

            if (empty($request->user())) {
                $loggedUserID = -99;
            } else {
                $loggedUserID = $request->user()->id;
            }

            $requestedUser = User::query()->select(\App\Models\User::API_COLUMNS)->selectRaw(
                "CASE WHEN id = $userId THEN profile_picture_tmp ELSE profile_picture END AS profile_picture"
            );

            $requestedUser->where('id', $userId);


            $noLoggedTeacher = $requestedUser->first();

            $userId = $noLoggedTeacher->id;

            if (empty($userId)) {
                $dataErrors['user_id'] = [
                    'The user id is required.',
                ];
            }

            if (! empty($dataErrors)) {
                $response = response()->error([
                    'message' => __('INVALID_DATA'),
                    'data'    => [
                        'errors' => $dataErrors,
                    ],
                ]);

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
                ->get()
                ->pluck('id')
                ->toArray();

            $feedback = Feedback::query()
                ->selectRaw('SUM(CASE WHEN stars_content = 5 THEN 1 ELSE 0 END) AS five_stars')
                ->selectRaw('SUM(CASE WHEN stars_content = 4 THEN 1 ELSE 0 END) AS four_stars')
                ->selectRaw('SUM(CASE WHEN stars_content = 3 THEN 1 ELSE 0 END) AS three_stars')
                ->selectRaw('SUM(CASE WHEN stars_content = 2 THEN 1 ELSE 0 END) AS two_stars')
                ->selectRaw('SUM(CASE WHEN stars_content = 1 THEN 1 ELSE 0 END) AS one_stars')
                ->selectRaw('SUM(stars_content) AS totalRatings')
                ->selectRaw('COUNT(id) AS totalReviews')
                ->where('user_id', '!=', $userId);

            if ($feedbackType == Feedback::TYPE['received']) {
                $feedback->whereIn('booking_id', $aUserBookingList);
            } else {
                $feedback->where('user_id', $userId);
            }

            $feedback = $feedback->first()->toArray();

            if ($feedback['totalReviews'] == 0) {
                $response = response()->success(__('NO_REVIEWS'));

                Log::notice("\n\n" . '::FeedbackApiController::getRating::$response');
                Log::notice($response);

                return $response;
            }

            $feedbackComments = Feedback::query()
                ->select(['feedback.id', 'headline', 'user_id', 'stars_content', 'feedback.description', 'name'])
                ->selectRaw("CASE WHEN users.id = $loggedUserID THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->selectRaw("TO_CHAR(feedback.created_at,'FMMonth YYYY') as created_date")
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', 'feedback.user_id');
                })
                ->leftJoin('bookings', function ($join) {
                    $join->on('bookings.id', '=', 'feedback.booking_id');
                })
                ->leftJoin('talks', function ($join) {
                    $join->on('talks.id', '=', 'talk_id');
                })
                ->offset($displayOffset)->limit($displayLimit);

            if ($feedbackType == Feedback::TYPE['received']) {
                $feedbackComments->whereIn('booking_id', $aUserBookingList)->where('user_id', '!=', $userId);
            } else {
                $feedbackComments->where('user_id', $userId);
            }

            if (! empty($request->input('stars_rating'))) {
                $feedbackComments->where('stars_content', $request->input('stars_rating'));
            }
            $feedbackComments = $feedbackComments->whereHas('user')->get();

            $aTeacherBookingList['user_rating'] = $aTeacherBookingList['total_reviews'] > 0 ? round(
                $aTeacherBookingList['total_ratings'] / $aTeacherBookingList['total_reviews'],
                2
            ) : 0;

            $data = [
                'user_feedback'     => $aTeacherBookingList,
                'stars_feedback'    => $feedback,
                'feedback_comments' => $feedbackComments,
            ];

            $response = response()->success([
                'message' => __('RATING_SUCCESS'),
                'data'    => $data,
            ]);

            Log::notice("\n\n" . '::FeedbackApiController::getRating::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_2703,
                self::class,
                __FUNCTION__
            );

            return response()->error($exception->getMessage(), 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $teacherId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function teacherTalks(Request $request, $teacherId)
    {
        $talkApi = new TalksApiController();
        return $talkApi->teacherTalks($request, $teacherId);
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAvailability(Request $request)
    {
        // try {
        Log::notice("\n\n" . '::JoinTheClubApiController::getUserAvailability::$request');
        Log::notice($request->all());

        $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
        $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
        $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';

        if ($request->has('user_id') && $request->input('user_id')) {
            $user_id = $request->input('user_id');
        } else {
            $user_id = $request->user()->id;
        }

        $availability = \App\Models\Availability::query()->select('id', 'weekday', 'state')
            ->selectRaw(
                "TO_CHAR(start_time + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours', 'HH24:MI:SS') AS start_time, TO_CHAR(end_time + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . " hours', 'HH24:MI:SS') AS end_time"
            )
            ->where('user_id', $user_id)
            ->orderBy('weekday')
            ->orderBy('start_time')
            ->get()->toArray();

        if (empty($availability)) {
            $response = response()->success(__('NO_AVAILABILITIES'));

            Log::notice("\n\n" . '::JoinTheClubApiController::getUserAvailability::$response');
            Log::notice($response);

            return $response;
        }

        $response = response()->success([
            'message' => __('SUPPLIER_AVAILABILITIES'),
            'data'    => $availability,
        ]);

        Log::notice("\n\n" . '::JoinTheClubApiController::getUserAvailability::$response');
        Log::notice($response);

        return $response;
        // } catch (\Exception $exception) {
        //     Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');
        //
        //     app(Handler::class)->report(
        //         $exception,
        //         Handler::PRIORITY['HIGH'],
        //         Handler::TYPE_EXCEPTION_2801,
        //         self::class,
        //         __FUNCTION__
        //     );
        //
        //     // return response()->json([
        //     //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_2801,
        //     //     'success' => false
        //     // ], 500);
        //
        //     return response()->error('Error: '.Handler::TYPE_EXCEPTION_2801, 500);
        // }
    }

    /**
     * @param  Request  $request
     * @param           $talkId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTeacherAvailability(Request $request, $talkId)
    {
        // TODO Unit test
        $talkApi = new AvailabilityApiController();
        return $talkApi->getTeacherAvailability($request, $talkId);
    }


    /**
     * @param  Request  $request
     * @param           $talkId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTalkUserData(Request $request, $talkId)
    {
        try {
            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkUserData::$request');
            Log::notice($request->all());

            if (empty($talkId)) {
                $response = response()->error(__('ATTRIBUTE_REQUIRED', ['attribute' => 'Talk ID']));

                Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkUserData::$response');
                Log::notice($response);

                return $response;
            }

            if ($request->user()) {
                $userId = $request->user()->id;
            } elseif ($request->has('logged_in_user') && ! empty($request->input('logged_in_user'))) {
                $userId = $request->input('logged_in_user');
            } else {
                $userId = -99;
            }

            $requestedTalk = Talk::query()
                ->select('*')
                ->selectRaw("CAST(reviews AS NUMERIC(10,1)) as total_reviews")
                ->selectRaw("CAST(CASE WHEN reviews > 0 THEN ROUND(ratings::NUMERIC / reviews::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS computed_ratings")
                ->find($talkId);

            $talkUser = User::query()
                ->select([
                    'users.id',
                    'users.type',
                    'users.visibility',
                    'users.gender',
                    'users.name',
                    'users.username',
                    'users.email',
                    'users.description',
                    'users.profession',
                    'users.youtube_video',
                    'users.billing_address_id',
                    'users.notification_message',
                    'users.notification_sound',
                    'users.approved',
                    'users.verified',
                    'billing_addresses.pays_vat',
                ])
                ->selectRaw("CASE WHEN users.id = $userId THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->rightJoin('billing_addresses', 'users.billing_address_id', '=', 'billing_addresses.id')
                ->find($requestedTalk->teacher_user_id)
                ->toArray();

            $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

            $talkCategories    = TalkCategories::query()->select('id', $userLanguage . ' as value')->where(
                'id',
                $requestedTalk->talk_categories_id
            )->first();
            $talkSubcategories = TalkSubcategories::query()->select('id', $userLanguage . ' as value')->where(
                'id',
                $requestedTalk->talk_subcategories_id
            )->first();
            $followTalk        = UserBookmarkedTalks::query()
                ->where('user_id', $userId)
                ->where('talks_id', $requestedTalk->id)
                ->where('state', UserBookmarkedTalks::STATE['valid'])
                ->exists();

            $talkUser['ratings']                  = $requestedTalk->computed_ratings;
            $talkUser['talk']                     = $requestedTalk;
            $talkUser['talk']['ratings']          = $requestedTalk->computed_ratings;
            $talkUser['talk']['category_name']    = $talkCategories->value ?? null;
            $talkUser['talk']['subcategory_name'] = $talkSubcategories->value ?? null;
            $talkUser['talk']['following']        = $followTalk;

            $response = response()->success([
                'message' => __('SUCCESSFULLY_RETRIEVED_SUPPLIER'),
                'data'    => $talkUser,
            ]);

            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkUserData::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3909,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3909, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoggedUserBookings(Request $request)
    {
        $bookingsApi = new BookingsApiController();
        return $bookingsApi->getLoggedUserBookings($request);
    }

    /**
     * @return CallsCancellationReasonResource
     */
    public function cancellationReason(Request $request)
    {
        try {
            Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$request');
            Log::notice($request->all());

            $cancellationReason = CallsCancellationReason::query()->select(
                'id',
                StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as value'
            )
                ->where('state', CallsCancellationReason::STATE['valid']);

            if ($request->has('booking_id')) {
                $booking = Booking::query()->find($request->input('booking_id'));

                if (! empty($booking)) {
                    if ($booking->teacher_user_id == auth()->user()->id) {
                        $cancellationReason->where('type', Booking::CANCEL_TYPE['customer']);
                    } else {
                        $cancellationReason->where('type', Booking::CANCEL_TYPE['client']);
                    }
                } else {
                    $response = response()->error(__('NO_BOOKING'));

                    Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$response');
                    Log::notice($response);

                    return $response;
                }
            }

            $cancellationReason = $cancellationReason->get()->toArray();

            if (empty($cancellationReason)) {
                $response = response()->error(__('NO_CANCELLATION_REASONS'));

                Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => __('SUCCESSFULLY_RETRIEVED_CANCELLATION'),
                'data'    => $cancellationReason,
            ]);

            Log::notice("\n\n" . '::CallsCancellationReasonApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_2500,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_2500, 500);
        }
    }

    public function searchTalks(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::userFollowers::$request');
            Log::notice($request->all());

            if (! empty($request->user())) {
                $loggedUser = $request->user();
            } else {
                $loggedUser = User::query()->find($request->input('logged_user'));
            }

            $teacherId             = $request->input('teacher_id', null);
            $displayOffset         = $request->input('offset', 0);
            $displayLimit          = $request->input('limit', 20);
            $requestedTalkCategory = $request->input('requested_category');
            $clonedTalksIDs        = [];
            $bookmarkedTalks       = $request->input('bookmarkedTalks', []);
            $requestedCategory     = null;

            $talks = Talk::query()->select('teacher_user_id')
                ->groupBy('teacher_user_id');

            $blockedByUsers = UserBlocked::query()->where('blocked_user_id', $loggedUser->id)
                ->where('state', UserBlocked::STATE['valid'])
                ->get()->pluck('user_id')->toArray();

            $user = User::query()->select('id', 'name', 'username', 'profession', 'approved')
                ->selectRaw(
                    '
                                    CAST(CASE WHEN SUM(users.reviews) > 0 THEN ROUND(SUM(users.ratings)::NUMERIC / SUM(users.reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS rating'
                )
                ->selectRaw(
                    '
                                    CAST(SUM(users.reviews) AS NUMERIC(10,1)) as total_reviews'
                )
                ->selectRaw('CONCAT("/", username) AS profile_url')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->where('id', '!=', $loggedUser->id)
                ->where('approved', User::STATE['approved'])
                ->where('type', User::TYPE['supplier'])
                ->groupBy('id', 'name', 'username', 'profession', 'approved', 'profile_picture', 'profile_picture_tmp');

            if (! empty($teacherId)) {
                $talks->where('teacher_user_id', $teacherId);
                $user->where('id', $teacherId);
            }

            if (! empty($blockedByUsers)) {
                $user->whereNotIn('id', $blockedByUsers);
            }

            if (! empty($requestedTalkCategory)) {
                $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

                $talkCategory = TalkCategories::query()->select('id', $userLanguage . ' as headline')
                    ->get()
                    ->pluck('id', 'headline')
                    ->toArray();

                if (! empty($talkCategory[$requestedTalkCategory])) {
                    $requestedCategory = $talkCategory[$requestedTalkCategory];
                }
            }
            $userBookmarkedTalks = UserBookmarkedTalks::query()->where('user_id', $loggedUser->id)
                ->where('state', UserBookmarkedTalks::STATE['valid'])
                ->pluck('talks_id')
                ->toArray();


            if (! empty($bookmarkedTalks)) {
                $bookmarkedTalks = UserBookmarkedTalks::query()->where('user_id', $loggedUser->id)
                    ->where('state', UserBookmarkedTalks::STATE['valid'])
                    ->pluck('talks_id')
                    ->toArray();
                $filterUserTalks = Talk::query()->whereIn('id', $bookmarkedTalks)->get()->pluck(
                    'teacher_user_id'
                )->toArray();

                $talks->whereIn('id', $bookmarkedTalks);
                $user->whereIn('id', $filterUserTalks);
            }

            if (! empty($requestedCategory)) {
                $categoryUserTalks = Talk::query()->where('talk_categories_id', $requestedCategory)->get()->pluck(
                    'teacher_user_id'
                )->toArray();

                $user->whereIn('id', $categoryUserTalks);
            }

            if (! empty($requestedTalkCategory)) {
                $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

                $talkCategory = TalkCategories::query()->select('id', $userLanguage . ' as headline')
                    ->get()
                    ->pluck('id', 'headline')
                    ->toArray();

                if (! empty($talkCategory[$requestedTalkCategory])) {
                    $talks->where('talk_categories_id', $talkCategory[$requestedTalkCategory]);
                }
            }

            if ($request->has('filter') && ! empty($request->input('filter'))) {
                $filterTalks      = Talk::query();
                $userAvailability = Availability::query()->where('state', Availability::STATE['valid']);
                $filter           = json_decode($request->input('filter'), true);

                HelperModel::filterResults($filter, $filterTalks, $loggedUser);

                $clonedTeacherTalks = clone $filterTalks;

                $filterUserAvailability = $userAvailability->get()->pluck('user_id')->toArray();

                $filterTeacherTalks = $clonedTeacherTalks->whereIn('teacher_user_id', $filterUserAvailability)->select('teacher_user_id')->groupBy(
                    'teacher_user_id'
                )->get()->pluck('teacher_user_id')->toArray();
                $clonedTalksIDs     = $filterTalks->get()->pluck('id')->toArray();
                $userIDs            = array_unique($filterTeacherTalks);

                $talks->whereIn('id', $clonedTalksIDs);
                $user->whereIn('id', $userIDs);
//                $user->whereIn('id', $filterUserAvailability);
            }

            $user->leftJoinSub($talks, 'talks', function ($join) {
                $join->on('talks.teacher_user_id', '=', 'users.id');
            })
                ->with([
                    'talks' => function ($query) use (
                        $clonedTalksIDs,
                        $bookmarkedTalks,
                        $requestedCategory,
                        $userBookmarkedTalks
                    ) {
                        if (! empty($clonedTalksIDs)) {
                            $query->whereIn('id', $clonedTalksIDs);
                        }
                        if (! empty($bookmarkedTalks)) {
                            $query->whereIn('id', $bookmarkedTalks);
                        }
                        if (! empty($requestedCategory)) {
                            $query->where('talk_categories_id', $requestedCategory);
                        }

                        $userBookmarkedTalksId = implode(',', $userBookmarkedTalks);
                        if (empty($userBookmarkedTalksId)) {
                            $query->selectRaw("*, 0 AS following_talk");
                        } else {
                            $query->selectRaw('*, CASE WHEN id IN (' . $userBookmarkedTalksId . ') THEN 1 ELSE 0 END AS following_talk');
                        }
                    },
                ])
                ->withCount([
                    'talks' => function ($query) use ($clonedTalksIDs, $bookmarkedTalks, $requestedCategory) {
                        if (! empty($clonedTalksIDs)) {
                            $query->whereIn('id', $clonedTalksIDs);
                        }
                        if (! empty($bookmarkedTalks)) {
                            $query->whereIn('id', $bookmarkedTalks);
                        }
                        if (! empty($requestedCategory)) {
                            $query->where('talk_categories_id', $requestedCategory);
                        }
                    },
                ])
                ->having('talks_count', '>', 0);


            $followerUser     = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('user_id', $loggedUser->id)
                ->get()->pluck('follower_user_id')->toArray();
            $followingUsersId = implode(',', $followerUser);

            if (empty($followingUsersId)) {
                $user->selectRaw("0 AS following");
            } else {
                $user->selectRaw('CASE WHEN id IN (' . $followingUsersId . ') THEN 1 ELSE 0 END AS following');
            }

            $countUser = clone $user;

            $user = $user->withCount('followerUserUserFolloweds as total_followers')
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->map(function ($talks) use ($teacherId, $displayLimit, $requestedCategory) {
                    if (empty($teacherId)) {
                        $talks->setRelation('talks', $talks->talks->take(2));
                    } elseif ($displayLimit == '2') {
                        $talks->setRelation('talks', $talks->talks->take(2));
                    }
                    if (! empty($requestedCategory)) {
                        $talks->where('talk_categories_id', $requestedCategory);
                    }

                    return $talks;
                })
                ->toArray();

            if (empty($user)) {
                $response = response()->success(__('NO_USERS_WITH_TALKS'));

                Log::notice("\n\n" . '::UserFollowedApiController::userFollowers::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => __('USERS_WITH_TALKS'),
                'data'    => [
                    'user'       => $user,
                    'user_count' => $countUser->get()->count(),
                ],
            ]);

            Log::notice("\n\n" . '::UserFollowedApiController::userFollowers::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4201,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4201, 500);
        }
    }

    public function searchTalksByCategory(Request $request, $requestedTalkCategory, $subcategory)
    {
        $talkApi = new TalksApiController();
        return $talkApi->searchTalksByCategory($request, $requestedTalkCategory, $subcategory);
    }

    public function getTalkSearch(Request $request, $requestedTalkCategory, $subcategory = null)
    {
        $talkApi = new TalksApiController();
        return $talkApi->getTalkSearch($request, $requestedTalkCategory, $subcategory);
    }
}
