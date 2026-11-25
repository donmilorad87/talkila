<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Entity\CancellationReasons;
use App\Entity\TalkCategory;
use App\Entity\TalkSubcategory;
use App\Entity\TalkTypes;
use App\Entity\UserTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\ApiRequests\StoreTalkRequest;
use App\Http\Requests\ApiRequests\UpdateTalkRequest;
use App\Mail\NewTalkCreated;
use App\Mail\TalkPaused;
use App\Models\CallsCancellationReason;
use App\Models\HelperModel;
use App\Models\JoinTheClub;
use App\Models\Notifications;
use App\Models\UserBlocked;
use App\Models\UserBookmarkedTalks;
use App\ModelsApi\Availability;
use App\ModelsApi\Booking;
use App\ModelsApi\Language;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\TalkCategories;
use App\ModelsApi\TalkSubcategories;
use App\ModelsApi\User;
use App\ModelsApi\UserFollowed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TalksApiController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::index::$request');
            Log::notice($request->all());

            $bookmarkedTalk = UserBookmarkedTalks::query()->where('state', UserBookmarkedTalks::STATE['valid'])
                ->where('user_id', $request->user()->id)
                ->pluck('talks_id')
                ->toArray();

            $talk = Talk::query()->select('*')
//                ->with(['teacher_user', 'languages', 'finance_currencies', 'billing_address'])
                ->where('state', Talk::STATE['valid']);

            if (! empty($bookmarkedTalk)) {
                $talksId = implode(',', $bookmarkedTalk);
                $talk->selectRaw("CASE WHEN talks.id IN ($talksId) THEN 1 ELSE 0 END AS is_favorite");
            } else {
                $talk->selectRaw("0 AS is_favorite");
            }

            $talk = $talk->get()->toArray();

            if (empty($talk)) {
                $response = response()->json([
                    'message' => 'There is no talks.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $talk,
                'message' => 'List of active talks',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3900, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3900,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  StoreTalkRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Throwable
     */
    public function store(StoreTalkRequest $request)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::store::$request');
            Log::notice($request->all());

            $newTalkData = $request->all();

            /* Talk Type Change */
            // if ($request->input('talk_type') == Talk::TALK_TYPE['group']) {
            if ($request->input('call_type') == CallTypes::GROUP) {
                $checkTalk = $this->checkGroupTalk($request)->getData(true);

                if ($checkTalk['success']) {
                    $newTalkData['duration'] = $checkTalk['data']['duration'];
                } else {
                    return $checkTalk;
                }
            }

            $user                           = $request->user();
            $newTalkData['teacher_user_id'] = $user->id;
            // $newTalkData['billing_address_id'] = $request->user()->billing_address_id;

            DB::beginTransaction();

            $talk = Talk::create($newTalkData);

            // Increment talks in static metrics
            StaticMetric::query()->where('user_id', $user->id)->increment('talks');

            $addressUser = User::query()->where('id', $user->id)->first();
            //$newTalk        = Talk::query()->where('id', $talk->id)->with('countries')->first();
            $newTalk   = Talk::query()->where('id', $talk->id)->first();
            $languages = Language::query()->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as language_name')->where('id', $newTalk->languages_id)->first();
            Mail::to($addressUser->email)->queue(new NewTalkCreated($request->header('Application-Language', 'en'), $addressUser->email, $newTalk->id, $newTalk->headline, $newTalk->description, $newTalk->price, $newTalk->duration, $newTalk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk', $newTalk->anonym_call ? __('PERMITTED') : __('FORBIDDEN'), $languages->language_name));

            $notificationData = [
                'user_id'    => $talk->teacher_user_id,
                'type'       => $talk->headline,
                'param_type' => 'name_of_talk',
                'param_id'   => $talk->id,
                'talkName'   => $talk->headline,
                'value'      => Notifications::VALUE['new_talk'],
            ];

            $notification = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::TalksApiController::store::$notification');
            Log::notice($notification);

            DB::commit();
            $response = response()->json([
                'data'    => ['talk_id' => $talk->id],
                'message' => __('TALK_SUCCESSFULLY_CREATED'),
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::store::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3901, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3901,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  UpdateTalkRequest  $request
     * @param  Talk               $talk
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Throwable
     */
    public function update(UpdateTalkRequest $request, Talk $talk)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::update::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::TalksApiController::update::$talk');
            Log::notice($talk);

            if ($request->user()->id != $talk->teacher_user_id) {
                $response = response()->json([
                    'message' => 'Cannot update talk from other teacher.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::update::$response');
                Log::notice($response);

                return $response;
            }

            $newTalkData = $request->all();
            DB::beginTransaction();

            /* Talk Type Change */
            // if ($request->input('talk_type') == Talk::TALK_TYPE['group']) {
            if ($request->input('call_type') == CallTypes::GROUP) {
                $checkTalk = $this->checkGroupTalk($request, $talk->id)->getData(true);

                if ($checkTalk['success']) {
                    $newTalkData['duration'] = $checkTalk['data']['duration'];
                } else {
                    return $checkTalk;
                }
            }

            $talk->update($newTalkData);

            DB::commit();

            $response = response()->json([
                'data'    => ['talk_id' => $talk->id],
                'message' => 'Talk successfully updated',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::update::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3902, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3902,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param  null     $talkId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkGroupTalk(Request $request, $talkId = null)
    {
        try {
            $timeErrors = [];

            if (empty($request->input('start_time_call'))) {
                $timeErrors['start_time_call'] = 'Start time is required for group talk and need to be format H:i:00';
            }

            if (empty($request->input('end_time_call'))) {
                $timeErrors['end_time_call'] = 'Start time is required for group talk and need to be format H:i:00';
            }

            if (! empty($timeErrors)) {
                $response = response()->json([
                    'errors'  => $timeErrors,
                    'message' => 'For group talk start and end time is required.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::store::$response');
                Log::notice($response);

                return $response;
            } else {
                if (strtotime($request->input('start_time_call')) > strtotime($request->input('end_time_call'))) {
                    $response = response()->json([
                        'message' => 'End time cannot be lower then start time.',
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::TalksApiController::store::$response');
                    Log::notice($response);

                    return $response;
                } else {
                    if (empty($request->input('weekday'))) {
                        $response = response()->json([
                            'errors'  => ['weekday' => 'Weekday is required for group talk.'],
                            'message' => 'For group talk weekday is required.',
                            'success' => false,
                        ], 200);

                        Log::notice("\n\n" . '::TalksApiController::store::$response');
                        Log::notice($response);

                        return $response;
                    }
                }
            }

            // check if talk overlap with existing one
            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '+' : '-';

            $startCallTimeCheck = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($request->input('start_time_call'))));
            $endCallTimeCheck   = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($request->input('end_time_call'))));

            $weekday = $request->input('weekday');

            $isTalkTaken = Talk::query()
                ->select('id', 'start_time_call', 'end_time_call')
                ->where('teacher_user_id', $request->user()->id)
                ->where('state', Talk::STATE['valid'])
                ->where('weekday', $weekday)
                ->where(function ($q) use ($startCallTimeCheck, $endCallTimeCheck) {
                    /* @var $q \Illuminate\Database\Eloquent\Builder */

                    $q->where(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->where('start_time_call', '>', $startCallTimeCheck)->where('start_time_call', '<', $endCallTimeCheck);
                    });

                    $q->orWhere(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->where('end_time_call', '>', $startCallTimeCheck)->where('end_time_call', '<=', $endCallTimeCheck);
                    });

                    $q->orWhere('start_time_call', $startCallTimeCheck)->orWhere('end_time_call', $endCallTimeCheck);

                    $q->orWhere(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->whereRaw("'{$startCallTimeCheck}' > start_time_call")->whereRaw("'{$startCallTimeCheck}' < end_time_call");
                    });
                });
            if ($talkId != null) {
                $isTalkTaken->where('id', '!=', $talkId);
            }
            $isTalkTaken = $isTalkTaken->first();

            $requestTimezoneSignReturn = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';

            if (! empty($isTalkTaken)) {
                $response = response()->json([
                    'message' => 'Already existing talk for requested time. Existing talk start time:
                ' . date('Y-m-d H:i', strtotime($requestTimezoneSignReturn . $requestTimezoneHour . ' hours ' . $requestTimezoneSignReturn . $requestTimezoneMinutes . ' minutes', strtotime($isTalkTaken->start_time_call))) . ' - end time:
                ' . date('Y-m-d H:i', strtotime($requestTimezoneSignReturn . $requestTimezoneHour . ' hours ' . $requestTimezoneSignReturn . $requestTimezoneMinutes . ' minutes', strtotime($isTalkTaken->end_time_call))),
                    'success' => false,
                ], 200);

                        Log::notice("\n\n" . '::TalksApiController::store::$response');
                        Log::notice($response);

                return $response;
            }

            $duration = round(abs(strtotime($startCallTimeCheck) - strtotime($endCallTimeCheck)) / 60, 2);

            $newTalkData['duration'] = $duration;

            return response()->json([
                'data'    => ['duration' => $duration],
                'message' => 'Request is valid',
                'success' => true,
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3903, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3903,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param  Talk     $talk
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Request $request, Talk $talk): JsonResponse
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::destroy::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::TalksApiController::destroy::$talk');
            Log::notice($talk);

            $user = $request->user();

            if ($user->id != $talk->teacher_user_id) {
                $response = response()->error('Cannot delete talk from other teacher.', Response::HTTP_FORBIDDEN);

                Log::notice("\n\n" . '::TalksApiController::destroy::$response');
                Log::notice($response);

                return $response;
            }

            if ($user->talks->count() === 1) {
                $response = response()->error(__('CANNOT_DELETED_LAST_TALK'), Response::HTTP_FORBIDDEN);

                Log::notice("\n\n" . '::TalksApiController::destroy::$response');
                Log::notice($response);

                return $response;
            }

            DB::beginTransaction();
            //Take all future bookings for this talk and delete them and refund

            $sCurrentTime = date('Y-m-d H:i:s');

            $oTalkBookings = Booking::query()
                ->where('start_call', '>', $sCurrentTime)
                ->where('talk_id', $talk->id)
                ->get();

            if ($oTalkBookings->count() > 0 && $request->boolean('cancel_bookings')) {
                $cancellationReason = CallsCancellationReason::query()
                    ->where('english', 'Talk Deleted.')
                    ->first();

                foreach ($oTalkBookings as $booking) {
                    (new BookingsApiController())->cancelBooking($request, $booking->id, $cancellationReason->id, true);
                }
            }

            $notificationData = [
                'user_id'    => $talk->teacher_user_id,
                'type'       => $talk->headline,
                'param_type' => 'name_of_talk',
                'param_id'   => $talk->id,
                'talkName'   => $talk->headline,
                'value'      => Notifications::VALUE['talk_deleted'],
            ];

            $notification = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::TalksApiController::destroy::$notification');
            Log::notice($notification);

            // Decrement talk in static metrics
            StaticMetric::query()->where('user_id', $talk->teacher_user_id)->decrement('talks');

            $talk->delete();

            DB::commit();

            $response = response()->success(__('SUCCESSFULLY_DELETED_TALK'));

            Log::notice("\n\n" . '::TalksApiController::destroy::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3904, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3904,
                'success' => false,
            ], 500);
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
        try {
            Log::notice("\n\n" . '::TalksApiController::teacherTalks::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::TalksApiController::teacherTalks::$teacher_id');
            Log::notice($teacherId);


            $talkId        = $request->input('talk_id');
            $callType      = $request->input('call_type');
            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 25);

            if (! empty($request->user())) {
                $loggedUserID = $request->user()->id;
            } else {
                $loggedUserID = -99;
            }


            Log::notice("\n\n" . '::TalksApiController::teacherTalks::$talkId');
            Log::notice($talkId);

            $requestedTeacher = User::query()->find($teacherId);

            if (empty($requestedTeacher)) {
                $response = response()->json([
                    'message' => 'The requested teacher is deleted or does not exist.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::teacherTalks::$response');
                Log::notice($response);

                return $response;
            }

            $blockedByUser = UserBlocked::query()->where('blocked_user_id', $loggedUserID)
                ->where('user_id', $teacherId)
                ->where('state', UserBlocked::STATE['valid'])
                ->exists();

            if ($blockedByUser) {
                $response = response()->json([
                    'message' => 'Blocked by requested user.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::teacherTalks::$response');
                Log::notice($response);

                return $response;
            }

            $userFollowing = UserFollowed::query()->where('follower_user_id', $teacherId)
                ->where('state', UserFollowed::STATE['valid'])
                ->exists();

            if (($requestedTeacher->visibility == User::VISIBILITY['private'] && ! $userFollowing)) {
                if ($teacherId == $loggedUserID) {
                } else {
                    $response = response()->json([
                        'message' => "You doesn't follow requested user.",
                        'success' => true,
                    ], 200);

                    Log::notice("\n\n" . '::TalksApiController::teacherTalks::$response');
                    Log::notice($response);

                    return $response;
                }
            }
            $monthDateDiff = date('Y-m-d 23:59:59', strtotime('+1 months'));

            $bookings = Booking::query()->selectRaw('COUNT(id) AS taken_slots, talk_id, start_call::date AS start_call_date')
                ->where('state', true)
                ->whereBetween('start_call', [date('Y-m-d 00:00:00'), $monthDateDiff])
                ->groupBy('start_call_date', 'talk_id');

            $bookmarkedTalk = UserBookmarkedTalks::query()->where('state', true)
                ->where('user_id', $loggedUserID)
                ->pluck('talks_id')
                ->toArray();

            $languages = Language::query()->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as language_name')
                ->orderByRaw('-order_by DESC')
                ->orderBy('language_name');


            if (! empty($callType)) {
                $callTypeExist = Talk::query()->where('talks.teacher_user_id', $teacherId)->where('call_type', $callType)->exists();
                if (! $callTypeExist) {
                    $response = response()->json([
                        'message' => 'There is no teacher talks',
                        'success' => true,
                    ], 200);

                    Log::notice("\n\n" . '::TalksApiController::teacherTalks::$typeTalks');
                    Log::notice($response);

                    return $response;
                }


            }
            $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

            $talkCategories    = TalkCategories::query()->select(['id', $userLanguage . ' as talk_category_name']);
            $talkSubcategories = TalkSubcategories::query()->select(['id', $userLanguage . ' as talk_subcategory_name']);

            $oTeacherTalks = Talk::query()->select([
                'talks.id',
                'talks.duration',
                'headline',
                'call_type',
                'talk_type',
                'description',
                'max_participiants',
                'talks.price',
                'anonym_call as is_anonymous_allowed',
                'start_time_call',
                'end_time_call',
                'weekday',
                'talk_categories_id',
                'talk_subcategories_id',
                'talk_category_name',
                'talk_subcategory_name',
                'languages_id',
                'language_name',
                'finance_currencies_id',
                'taken_slots',
                'start_call_date',
                'talks.state',
            ])
                ->where('teacher_user_id', $teacherId)
                ->leftJoinSub($languages, 'languages', function ($join) {
                    $join->on('languages.id', '=', 'talks.languages_id');
                })
                ->leftJoinSub($talkCategories, 'talk_categories', function ($join) {
                    $join->on('talk_categories.id', '=', 'talks.talk_categories_id');
                })
                ->leftJoinSub($talkSubcategories, 'talk_subcategories', function ($join) {
                    $join->on('talk_subcategories.id', '=', 'talks.talk_subcategories_id');
                })
                ->selectRaw('CASE WHEN taken_slots > 0 THEN taken_slots ELSE 0 END AS taken_places')
                ->selectRaw('CASE WHEN talks.teacher_user_id = ' . $loggedUserID . ' THEN true ELSE false END AS is_edit_enabled')
                ->selectRaw('reviews as total_reviews, CASE WHEN reviews > 0 THEN ROUND(ratings::NUMERIC / reviews::NUMERIC, 1) ELSE 0 END AS ratings')
                ->whereRaw("CASE WHEN talks.teacher_user_id = $loggedUserID THEN talks.state IN ('0', '1', '2') ELSE talks.state IN ('1') END")
                ->withCount('followers_count as countFollowers')
                ->withCount('talk_bookings as bookingsCount');

            $talks_count = $oTeacherTalks->count();

            if (! empty($bookmarkedTalk)) {
                $talksId = implode(',', $bookmarkedTalk);
                $oTeacherTalks->selectRaw("CASE WHEN talks.id IN ($talksId) THEN 1 ELSE 0 END AS is_favorite");
            } else {
                $oTeacherTalks->selectRaw("0 AS is_favorite");
            }

            if (! empty($callType)) {
                $oTeacherTalks = $oTeacherTalks->where('call_type', $callType);
            }

            $oTeacherTalks = $oTeacherTalks->where('talks.teacher_user_id', $teacherId)
                ->leftJoinSub($bookings, 'bookings', function ($join) {
                    $join
                        ->on('bookings.talk_id', '=', 'talks.id');
                });

            if ($talkId > 0) {
                $oTeacherTalks = $oTeacherTalks
                    ->where('talks.id', $talkId);
            }

            $oTeacherTalks = $oTeacherTalks
                ->orderBy('start_call_date')
                ->orderBy('start_time_call')
                ->groupBy(
                    'talks.id',
                    'talks.duration',
                    'headline',
                    'call_type',
                    'talk_type',
                    'description',
                    'max_participiants',
                    'talks.price',
                    'anonym_call',
                    'start_time_call',
                    'end_time_call',
                    'weekday',
                    'talk_categories_id',
                    'talk_subcategories_id',
                    'talk_category_name',
                    'talk_subcategory_name',
                    'languages_id',
                    'language_name',
                    'finance_currencies_id',
                    'taken_slots',
                    'start_call_date',
                    'talks.state',
                    'reviews',
                    'ratings',
                    'talks.teacher_user_id'
                )
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->toArray();

            if (empty($oTeacherTalks)) {
                $response = response()->json([
                    'message' => 'There is no teacher talks',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::teacherTalks::$response');
                Log::notice($response);

                return $response;
            }

            if ($callType == CallTypes::GROUP) {
                $currentDayDate = date('N');

                $talks = [];

                $talkHolderData = [];
                foreach ($oTeacherTalks as $talk) {
                    $talkHolderData[$talk['id']]['db_data']                         = $talk;
                    $talkHolderData[$talk['id']]['dates'][$talk['start_call_date']] = $talk['taken_places'];
                }

                $counter = 0;
                foreach ($talkHolderData as $talk) {
                    $talkTmp = $talk["db_data"];

                    $counter++;
                    if ((int)$currentDayDate > $talkTmp['weekday']) {
                        $dayResult = $talkTmp['weekday'] - $currentDayDate + 7;
                    } else {
                        $dayResult = $talkTmp['weekday'] - $currentDayDate;
                    }

                    for ($i = 0; $i < Talk::TALK_DAYS_IN_ADVANCE; $i = $i + 7) {
                        $talkDate = date('Y-m-d', strtotime('+' . ($dayResult + $i) . ' days'));


                        $talkTemp2                     = $talkTmp;
                        $talkTemp2['free_places_left'] = $talkTmp['max_participiants'];

                        if (isset($talk['dates'][$talkDate])) {
                            $talkTemp2['taken_slots']      = $talk['dates'][$talkDate];
                            $talkTemp2['free_places_left'] = $talkTmp['max_participiants'] - $talkTemp2['taken_slots'];
                        }
                        $talkTemp2['start_call_date'] = $talkDate;

                        $talks[] = $talkTemp2;
                    }
                }

                $oTeacherTalks = $talks;
            }

            $response = response()->json([
                'data'          => $oTeacherTalks,
                'talks_count'   =>  $talks_count,
                'message'       => 'All talks for requested teacher',
                'success'       => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::teacherTalks::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3905, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3905,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     * @param           $type
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function pauseUnpauseTalk(Request $request, $id, $type)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::pauseTalk::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::TalksApiController::pauseTalk::$id');
            Log::notice($id);

            $talk = Talk::query()->find($id);

            if ($request->user()->id != $talk->teacher_user_id) {
                $response = response()->json([
                    'message' => 'Cannot pause talk from other teacher.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::destroy::$response');
                Log::notice($response);

                return $response;
            }
            DB::beginTransaction();

            Talk::query()->find($id)->update(['state' => $type]);
            $talk = Talk::query()->find($id);

            if ($type == 1) {
                $notification_value = Notifications::VALUE['talk_unpaused'];
                $message            = 'Successfully unpaused talk';
            } else {
                $notification_value = Notifications::VALUE['talk_paused'];
                $message            = 'Successfully paused talk';

                $addressUser = User::query()->where('id', $request->user()->id)->first();
                $languages   = Language::query()->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as language_name')->where('id', $talk->languages_id)->first();
                Mail::to($addressUser->email)->queue(new TalkPaused($request->header('Application-Language', 'en'), $addressUser->email, $talk->id, $talk->headline, $talk->price, $talk->duration, $talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk', $talk->anonym_call ? __('YES') : __('NO'), $languages->language_name));
            }

            $notificationData = [
                'user_id'    => $talk->teacher_user_id,
                'type'       => $talk->headline,
                'param_type' => 'name_of_talk',
                'param_id'   => $talk->id,
                'talkName'   => $talk->headline,
                'value'      => $notification_value,
            ];

            $notification = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::TalksApiController::pauseTalk::$notification');
            Log::notice($notification);

            DB::commit();

            $response = response()->json([
                'message' => $message,
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::pauseTalk::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3906, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3906,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function pauseTalk(Request $request, $id)
    {
        return $this->pauseUnpauseTalk($request, $id, 2);
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function unpauseTalk(Request $request, $id)
    {
        return $this->pauseUnpauseTalk($request, $id, 1);
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function markAsInappropriateTalk(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::markAsInappropriateTalk::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::TalksApiController::markAsInappropriateTalk::$id');
            Log::notice($id);

            DB::beginTransaction();

            Talk::query()->find($id)->update(['state' => Talk::STATE['inappropriate']]);

            DB::commit();

            $response = response()->json([
                'message' => 'Successfully marked talk as inappropriate.',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::markAsInappropriateTalk::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3907, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3907,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param $talkId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function talkDetailsWithFeedback($talkId)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::talkDetailsWithFeedback::$talkId');
            Log::notice($talkId);

            $oTalk = Talk::query()->where('id', $talkId)
                ->with([
                    'talk_bookings.taksFeedback' => function ($query) {
                        $query->where('stars_content', '>=', 4);
                        $query->orderByDesc('created_at');
                        $query->limit(3);
                    },
                ])
                ->get();

            $response = response()->json([
                'oTalk'   => $oTalk,
                'message' => 'Successfully taken best 3 feedback for talk',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::talkDetailsWithFeedback::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3908, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3908,
                'success' => false,
            ], 500);
        }
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
                $response = response()->json([
                    'message' => 'Talk id is required for this action',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkUserData::$response');
                Log::notice($response);

                return $response;
            }
            $loggedUser = $request->user();

            $requestedTalk = Talk::query()
                ->select('*')
                ->selectRaw('CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews, CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS ratings')
                ->find($talkId);

            $talkUser = User::query()->select(\App\Models\User::API_COLUMNS)
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->find($requestedTalk->teacher_user_id)
                ->toArray();

            $talkUser['ratings'] = $requestedTalk->ratings;
            $talkUser['talk']    = $requestedTalk;

            $response = response()->json([
                'data'    => $talkUser,
                'message' => 'User data of requested talk teacher',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkUserData::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3909, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3909,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $requestedTalkCategory
     * @param           $subcategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchTalksByCategory(Request $request, $requestedTalkCategory, $subcategory)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::userFollowers::$request');
            Log::notice($request->all());

            if (! empty($request->user())) {
                $loggedUser = $request->user()->id;
            } else {
                if ($request->input('logged_user')) {
                    $loggedUser = User::query()->where('id', $request->input('logged_user'))->first()->id;
                } else {
                    $loggedUser = -99;
                }
            }

            $displayOffset     = $request->input('offset', 0);
            $displayLimit      = $request->input('limit', 20);
            $clonedTalksIDs    = [];
            $requestedCategory = null;

            $talks = Talk::query()->select('teacher_user_id')
                ->where('state', Talk::STATE['valid'])
                /* Talk Type Change */
                // ->where('talk_type', Talk::TALK_TYPE['face_to_face'])
                ->where('talk_type', CallTypes::ONE_TO_ONE)
                ->groupBy('teacher_user_id');

            $user = User::query()->select('id', 'name', 'username', 'profession', 'approved')
                ->selectRaw('CAST(CASE WHEN SUM(users.reviews) > 0 THEN ROUND(SUM(users.ratings)::NUMERIC / SUM(users.reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS rating')
                ->selectRaw('CAST(SUM(users.reviews) AS NUMERIC(10,1)) as total_reviews')
                ->selectRaw('CONCAT("/", username) AS profile_url')
                ->selectRaw("CASE WHEN id = $loggedUser THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->where('id', '!=', $loggedUser)
                ->where('approved', User::STATE['approved'])
                ->where('type', User::TYPE['supplier'])
                ->groupBy('id', 'name', 'username', 'profession', 'approved', 'profile_picture', 'profile_picture_tmp');

            if (! empty($requestedTalkCategory)) {
                $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

                $talkCategory = TalkCategories::query()->select('id', $userLanguage . ' as headline')
                    ->get()
                    ->pluck('id', 'headline')
                    ->toArray();

                if (! empty($talkCategory[$requestedTalkCategory])) {
                    $requestedCategory = $talkCategory[$requestedTalkCategory];
                }
            } else {
                $response = response()->json([
                    'data'    => [],
                    'message' => 'There is no results for the requested category.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::searchTalksByCategory::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($requestedCategory)) {
                $response = response()->json([
                    'data'    => [],
                    'message' => 'There is no results for the requested category.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::searchTalksByCategory::$response');
                Log::notice($response);

                return $response;
            }

            if (! empty($subcategory)) {
                $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

                $talkSubcategory = TalkSubcategories::query()->select('id', $userLanguage . ' as headline')
                    ->get()
                    ->pluck('id', 'headline')
                    ->toArray();

                if (! empty($talkSubcategory[$subcategory])) {
                    $requestedSubcategory = $talkSubcategory[$subcategory];
                }
            } else {
                $response = response()->json([
                    'data'    => [],
                    'message' => 'There is no results for the requested category.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::searchTalksByCategory::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($requestedSubcategory)) {
                $response = response()->json([
                    'data'    => [],
                    'message' => 'There is no results for the requested subcategory.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::searchTalksByCategory::$response');
                Log::notice($response);

                return $response;
            }

            if (! empty($requestedSubcategory)) {
                $categoryUserTalks = Talk::query()->where('talk_subcategories_id', $requestedSubcategory)->select('teacher_user_id')->groupBy('teacher_user_id')->get()->pluck('teacher_user_id')->toArray();

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
            $bookmarkedTalk = UserBookmarkedTalks::query()->where('state', true)
                ->where('user_id', $loggedUser)
                ->pluck('talks_id')
                ->toArray();

            $user->leftJoinSub($talks, 'talks', function ($join) {
                $join->on('talks.teacher_user_id', '=', 'users.id');
            })
                ->with([
                    'talks' => function ($query) use ($clonedTalksIDs, $requestedSubcategory, $bookmarkedTalk) {
                        $query->where('state', Talk::STATE['valid']);
                        /* Talk Type Change */
                        // $query->where('talk_type', Talk::TALK_TYPE['face_to_face']);
                        $query->where('call_type', CallTypes::ONE_TO_ONE);
                        if (! empty($clonedTalksIDs)) {
                            $query->whereIn('id', $clonedTalksIDs);
                        }
                        if (! empty($requestedSubcategory)) {
                            $query->where('talk_subcategories_id', $requestedSubcategory);
                        }

                        if (! empty($bookmarkedTalk)) {
                            $talksId = implode(',', $bookmarkedTalk);
                            $query->selectRaw("*, CASE WHEN talks.id IN ($talksId) THEN 1 ELSE 0 END AS is_favorite");
                        } else {
                            $query->selectRaw("*, 0 AS is_favorite");
                        }
                    },
                ])
                ->withCount([
                    'talks' => function ($query) use ($clonedTalksIDs, $requestedSubcategory) {
                        if (! empty($clonedTalksIDs)) {
                            $query->whereIn('id', $clonedTalksIDs);
                        }
                        if (! empty($requestedSubcategory)) {
                            $query->where('talk_subcategories_id', $requestedSubcategory);
                        }
                        /* Talk Type Change */
                        // $query->where('talk_type', Talk::TALK_TYPE['face_to_face']);
                        $query->where('call_type', CallTypes::ONE_TO_ONE);
                    },
                ])
                ->having('talks_count', '>', 0);


            $followerUser     = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('user_id', $loggedUser)
                ->get()->pluck('follower_user_id')->toArray();
            $followingUsersId = implode(',', $followerUser);

            if (empty($followingUsersId)) {
                $user->selectRaw("0 AS following");
            } else {
                $user->selectRaw('CASE WHEN id IN (' . $followingUsersId . ') THEN 1 ELSE 0 END AS following');
            }

            $countUser = clone $user;
            $user      = $user->withCount('followerUserUserFolloweds as total_followers')
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->map(function ($talks) use ($displayLimit, $requestedSubcategory) {
                    /* Talk Type Change */
                    // $talks->where('talk_type', Talk::TALK_TYPE['face_to_face']);
                    $talks->where('call_type', CallTypes::ONE_TO_ONE);
                    if ($displayLimit == '2') {
                        $talks->setRelation('talks', $talks->talks->take(2));
                    }
                    if (! empty($requestedSubcategory)) {
                        $talks->where('talk_subcategories_id', $requestedSubcategory);
                    }

                    return $talks;
                })
                ->toArray();

            if (empty($user)) {
                $response = response()->json([
                    'data'    => [],
                    'message' => 'There is no users with talks.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::searchTalksByCategory::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'       => $user,
                'user_count' => $countUser->get()->count(),
                'message'    => 'List of users that have talks.',
                'success'    => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::searchTalksByCategory::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3910, self::class, __FUNCTION__);

            return response()->json([
                'message'  => 'Error: ' . Handler::TYPE_EXCEPTION_3910,
                'message2' => $exception->getMessage(),
                'success'  => false,
            ], 500);
        }
    }

    public function getTalkSearch(Request $request, $requestedTalkCategory, $subcategory = null)
    {
        try {
            Log::notice("\n\n" . '::TalksApiController::getTalkSearch::$request');
            Log::notice($request->all());

            if (! empty($request->user())) {
                $loggedUser = $request->user()->id;
            } else if ($request->input('logged_user')) {
                $loggedUser = User::query()->where('id', $request->input('logged_user'))->first()->id;
            } else {
                $loggedUser = -99;
            }

            $displayOffset     = $request->input('offset', 0);
            $displayLimit      = $request->input('limit', config('app.show_more_talks'));
            $requestedCategory = null;
            $monthDateDiff     = date('Y-m-d 23:59:59', strtotime('+1 months'));

            $user = User::query()->select('id', 'name as teacher_name', 'username as teacher_username')
                ->selectRaw("CASE WHEN id = $loggedUser THEN profile_picture_tmp ELSE profile_picture END AS teacher_profile_picture");

            $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', $request->user() ? $request->user()->last_language : 'en')];

            $bookings = Booking::query()->selectRaw('COUNT(id) AS taken_slots, talk_id, start_call::date AS start_call_date')
                ->where('state', true)
                ->whereBetween('start_call', [date('Y-m-d 00:00:00'), $monthDateDiff])
                ->groupBy('start_call_date', 'talk_id')->get()->toArray();

            $bookmarkedTalk = UserBookmarkedTalks::query()
                ->where('state', true)
                ->where('user_id', $loggedUser)
                ->pluck('talks_id')
                ->toArray();

            $languages = Language::query()->select(['id', $userLanguage . ' as language_value']);

            $blocked_users = $request->user()
                ? $request->user()
                    ->blockedUsers()
                    ->pluck('blocked_user_id')
                    ->toArray()
                : [];

            $following_users = $request->user()
                ? $request->user()
                    ->followings()
                    ->where('user_followeds.state', UserFollowed::STATE['valid'])
                    ->whereNotIn('follower_user_id', $blocked_users)
                    ->pluck('follower_user_id')
                    ->toArray()
                : [];

            $talks = Talk::query()
                ->select([
                    'talks.id',
                    'talks.teacher_user_id',
                    'users.visibility',
                    'talk_categories_id',
                    'talk_subcategories_id',
                    'languages.language_value',
                    'start_time_call',
                    'end_time_call',
                    'headline',
                    'talk_type',
                    'call_type',
                    'duration',
                    'weekday',
                    'max_participiants',
                    'anonym_call',
                    'price',
                    'users.name as teacher_name',
                    'users.username as teacher_username',
                    'users.profile_picture as teacher_profile_picture',
                    'talks.created_at',
                ])
                ->selectRaw('talks.reviews as total_reviews, CASE WHEN talks.reviews > 0 THEN ROUND(talks.ratings::NUMERIC / talks.reviews::NUMERIC, 1) ELSE 0 END AS ratings')
                ->selectRaw('CASE WHEN user_bookmarked_talks.state = true THEN 1 ELSE 0 END AS is_favorite')
                // ->where('teacher_user_id', '!=', $loggedUser) // TODO: re-enable in production to hide own talks from search
                ->where('talks.state', Talk::STATE['valid'])
                ->join('users', 'users.id', '=', 'talks.teacher_user_id')
                ->whereHas('teacher', function ($query) use ($following_users, $blocked_users) {
                    $query->join('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                        ->where('approved', User::STATE['approved'])
                        ->where('type', User::TYPE['supplier'])
                        ->where('user_verification_requests.status', 1)
                        ->whereNotIn('users.id', $blocked_users)
                        ->where(function ($q) use ($following_users, $blocked_users) {
                            $q->where('visibility', \App\Models\User::VISIBILITY['open']);
                            $q->orWhereIn('users.id', $following_users);
                        });
                })
                ->leftJoinSub($languages, 'languages', function ($join) {
                    $join->on('languages.id', '=', 'talks.languages_id');
                })
                ->leftJoin('user_bookmarked_talks', function ($query) use ($loggedUser) {
                    $query->on('user_bookmarked_talks.talks_id', '=', 'talks.id')
                        ->where('user_bookmarked_talks.user_id', '=', $loggedUser)
                        ->whereNull('user_bookmarked_talks.deleted_at');
                });

            if ($requestedTalkCategory == 'favorites' && $subcategory == 'talks') {
                if (! empty($bookmarkedTalk)) {
                    $talks->whereIn('talks.id', $bookmarkedTalk);
                } else {
                    $talks->whereIn('talks.id', [-99]);
                }
            } else if ($requestedTalkCategory == 'favorites' && $subcategory == 'users') {
                $userFollowing = UserFollowed::query()->where('user_id', $loggedUser)
                    ->where('state', UserFollowed::STATE['valid'])
                    ->pluck('follower_user_id')
                    ->toArray();

                $talksFromFavoriteUsers = Talk::query()->whereIn('teacher_user_id', $userFollowing)
                    ->pluck('id')
                    ->toArray();

                if (! empty($talksFromFavoriteUsers)) {
                    $talks->whereIn('talks.id', $talksFromFavoriteUsers);
                } else {
                    $talks->whereIn('talks.id', [-99]);
                }
            }

            if (! empty($requestedTalkCategory)) {
                $talkCategory = TalkCategories::query()->select('id', $userLanguage . ' as headline')
                    ->get()
                    ->pluck('id', 'headline')
                    ->toArray();

                if (! empty($talkCategory[$requestedTalkCategory])) {
                    $requestedCategory = $talkCategory[$requestedTalkCategory];
                }
            } else {
                $notificationsCount     = new NotificationsApiController();
                $notificationsCountData = $notificationsCount->countUnreadNotifications($request)->getData(true);

                $response = response()->json([
                    'data'               => [],
                    'message'            => 'There is no results for the requested category.',
                    'success'            => true,
                    'notificationsCount' => $notificationsCountData['data'],
                ], 200);

                Log::notice("\n\n" . '::TalksApiController::getTalkSearch::$response');
                Log::notice($response);

                return $response;
            }

            if (! empty($subcategory)) {
                $talkSubcategory = TalkSubcategories::query()->select(['id', $userLanguage . ' as headline'])
                    ->get()
                    ->pluck('id', 'headline')
                    ->toArray();

                if (! empty($talkSubcategory[$subcategory])) {
                    // $requestedSubcategory = $talkSubcategory[$subcategory];
                    $requestedSubcategory = TalkSubcategories::where('talk_categories_id', $requestedCategory)->where($userLanguage, $subcategory)->first()->id;
                    // Subcategory ID
                }

                if (! empty($requestedSubcategory)) {
                    $talks->where('talk_subcategories_id', $requestedSubcategory);
                }
            }

            if ($requestedTalkCategory != 'favorites') {
                $talks->where('talk_categories_id', $requestedCategory);
            }

            if ($request->has('filter') && ! empty($request->input('filter'))) {
                $filter = json_decode($request->input('filter'), true);

                HelperModel::filterResults($filter, $talks, $loggedUser);
            }

            $talksCount = $talks->get()->count();

            $talks = $talks->offset($displayOffset)->limit($displayLimit)->get();

            foreach ($talks as $key => $talk) {
                if ($talk->visibility == 2 && ! in_array($talk->teacher_user_id, $following_users)) {
                    $talks->forget($key);
                };
            }

            $talks = $talks->toArray();

            $currentDayDate = date('N');
            $talksArray     = [];

            $counter = 0;

            foreach ($talks as $talk) {
                $counter++;

                /* Talk Type Change */
                // if ($talk['talk_type'] == Talk::TALK_TYPE['group']) {
                if ($talk['call_type'] == CallTypes::GROUP) {
                    if ((int)$currentDayDate > $talk['weekday']) {
                        $dayResult = $talk['weekday'] - $currentDayDate + 7;
                    } else {
                        $dayResult = $talk['weekday'] - $currentDayDate;
                    }

                    for ($i = 0; $i < Talk::TALK_DAYS_IN_ADVANCE; $i = $i + 7) {
                        $talkDate = date('Y-m-d', strtotime('+' . ($dayResult + $i) . ' days'));

                        $takenSlots = 0;

                        if (! empty($bookings)) {
                            foreach ($bookings as $booking) {
                                if ($booking['talk_id'] == $talk['id'] && $booking['start_call_date'] == $talkDate) {
                                    $takenSlots = $booking['taken_slots'];
                                }
                            }
                        }

                        $talk['group_talks'][] = [
                            'talk_date'        => $talkDate . ' ' . substr($talk['start_time_call'], 0, -3) . '-' . substr($talk['end_time_call'], 0, -3),
                            'free_places_left' => $talk['max_participiants'] - $takenSlots,
                        ];
                    }
                }

                $talkCategoriesName = TalkCategories::query()->where('id', $talk['talk_categories_id'])
                    ->select($userLanguage . ' as category_name')
                    ->first();

                $talkSubCategoriesName = TalkSubcategories::query()->where('id', $talk['talk_subcategories_id'])
                    ->select($userLanguage . ' as subcategory_name')
                    ->first();


                $talkCreatedAt = new \DateTime($talk['created_at']);
                $timeNow       = new \DateTime();

                $diff = $timeNow->diff($talkCreatedAt);

                $hours = $diff->h;
                $hours = $hours + ($diff->days * 24);

                $talk['time_left_from_creation'] = $hours;

                $talk['talk_category']    = $talkCategoriesName->category_name;
                $talk['talk_subcategory'] = $talkSubCategoriesName->subcategory_name;
                $talksArray[]             = $talk;
            }

            if ($talksCount > 0) {
                if ($requestedTalkCategory == 'favorites' && $subcategory == 'talks') {
                    $message = 'LIST_OF_REQUESTED_FAVORITE_TALKS';
                } else {
                    if ($requestedTalkCategory == 'favorites' && $subcategory == 'users') {
                        $message = 'LIST_OF_REQUESTED_FAVORITE_USERS';
                    } else {
                        $message = 'LIST_OF_REQUESTED_CATEGORY_TALKS';
                    }
                }
            } else {
                $message = 'NO_TALKS_FOR_SELECTED_FILTER';
            }

            $response = response()->json([
                'data'        => $talksArray,
                'talks_count' => $talksCount,
                'message'     => $message,
                'success'     => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::getTalkSearch::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3911, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3911,
                'success' => false,
            ], 500);
        }
    }

    public function checkActiveFilters(Request $request, $category = null, $subcategory = null)
    {
        Log::notice("\n\n" . '::TalksApiController::checkActiveFilters::$request');
        Log::notice($request);
        Log::notice("\n\n" . '::TalksApiController::checkActiveFilters::$category');
        Log::notice($category);
        Log::notice("\n\n" . '::TalksApiController::checkActiveFilters::$subcategory');
        Log::notice($subcategory);

        try {
            if (! empty($request->user())) {
                $loggedUser = $request->user()->id;
            } else {
                if ($request->input('logged_user')) {
                    $loggedUser = User::query()->where('id', $request->input('logged_user'))->first()->id;
                } else {
                    $loggedUser = -99;
                }
            }

            $userLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', $request->user() ? $request->user()->last_language : 'en')];

            $talks = Talk::query()
                // ->where('teacher_user_id', '!=', $loggedUser) // TODO: re-enable in production
                ->where('state', Talk::STATE['valid'])
                ->where('call_type', CallTypes::ONE_TO_ONE)
                ->whereHas('teacher', function ($query) {
                    $query->join('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                        ->where('approved', User::STATE['approved'])
                        ->where('type', User::TYPE['supplier'])
                        ->where('visibility', User::VISIBILITY['open'])
                        ->where('user_verification_requests.status', 1);
                });

            if ($category == 'favorites' && $subcategory == 'talks') {
                $bookmarkedTalk = UserBookmarkedTalks::query()->where('state', true)
                    ->where('user_id', $loggedUser)
                    ->pluck('talks_id')
                    ->toArray();

                if (! empty($bookmarkedTalk)) {
                    $talks->whereIn('id', $bookmarkedTalk);
                } else {
                    $talks->whereIn('id', [-99]);
                }
            } else {
                if ($category == 'favorites' && $subcategory == 'users') {
                    $userFollowing = UserFollowed::query()->where('user_id', $loggedUser)
                        ->where('state', UserFollowed::STATE['valid'])
                        ->pluck('follower_user_id')
                        ->toArray();

                    $talksFromFavoriteUsers = Talk::query()->whereIn('teacher_user_id', $userFollowing)
                        ->pluck('id')
                        ->toArray();

                    if (! empty($talksFromFavoriteUsers)) {
                        $talks->whereIn('id', $talksFromFavoriteUsers);
                    } else {
                        $talks->whereIn('id', [-99]);
                    }
                } else {
                    if (! empty($category)) {
                        $requestedCategory = TalkCategories::query()->select('id')
                            ->where($userLanguage, $category)
                            ->first();

                        $talks->where('talk_categories_id', $requestedCategory->id);
                    }
                    if (! empty($subcategory)) {
                        $requestedSubcategory = TalkSubcategories::query()->select('id')
                            ->where('talk_categories_id', $requestedCategory['id'],)
                            ->where($userLanguage, $subcategory)
                            ->first();


                        $talks->where('talk_subcategories_id', $requestedSubcategory->id);
                    }
                }
            }

            $cloneTalkPrivate   = clone $talks;
            $cloneTalkGroup     = clone $talks;
            $cloneTalkPrice1    = clone $talks;
            $cloneTalkPrice2    = clone $talks;
            $cloneTalkPrice3    = clone $talks;
            $cloneTalkPrice4    = clone $talks;
            $cloneTalkDuration1 = clone $talks;
            $cloneTalkDuration2 = clone $talks;
            $cloneTalkDuration3 = clone $talks;
            $cloneTalkDuration4 = clone $talks;
            $cloneTalkDuration5 = clone $talks;
            $cloneTalkDuration6 = clone $talks;
            $cloneTalkDuration7 = clone $talks;
            $cloneTalkDuration8 = clone $talks;
            $cloneTalkDuration9 = clone $talks;
            $cloneTalkTeachers  = clone $talks;

            $talkTypePrivate = $cloneTalkPrivate->where('talk_type', Talk::TALK_TYPE['face_to_face'])->exists();
            $talkTypeGroup   = $cloneTalkGroup->where('talk_type', Talk::TALK_TYPE['group'])->exists();

            $talkPrice1_10    = $cloneTalkPrice1->where('price', '>=', 1)->where('price', '<=', 10)->exists();
            $talkPrice10_50   = $cloneTalkPrice2->where('price', '>=', 10)->where('price', '<=', 50)->exists();
            $talkPriceOver50  = $cloneTalkPrice3->where('price', '>=', 50)->exists();
            $talkPriceOver100 = $cloneTalkPrice4->where('price', '>=', 100)->exists();


            $talkDuration15      = $cloneTalkDuration1->where('duration', 15)->exists();
            $talkDuration30      = $cloneTalkDuration2->where('duration', 30)->exists();
            $talkDuration45      = $cloneTalkDuration3->where('duration', 45)->exists();
            $talkDuration60      = $cloneTalkDuration4->where('duration', 60)->exists();
            $talkDuration75      = $cloneTalkDuration5->where('duration', 75)->exists();
            $talkDuration90      = $cloneTalkDuration6->where('duration', 90)->exists();
            $talkDuration105     = $cloneTalkDuration7->where('duration', 105)->exists();
            $talkDuration120     = $cloneTalkDuration8->where('duration', 120)->exists();
            $talkDurationOver120 = $cloneTalkDuration9->where('duration', '>', 120)->exists();

            // $talkTeachers          = $cloneTalkTeachers->whereNull('weekday')->get()->pluck('teacher_user_id')->toArray();
            // $availabilityCondition = \App\Models\Availability::query()->where('state', Availability::STATE['valid'])->groupBy('weekday');
            // $cloneAvailability     = clone $availabilityCondition;
            // $teacherAvailabilities = $cloneAvailability->where('user_id', '!=', $loggedUser)
            //     ->get()
            //     ->pluck('weekday')
            //     ->toArray();
            //
            // $teacherAvailabilitiesNull = $cloneAvailability->whereIn('user_id', $talkTeachers)
            //     ->get()
            //     ->pluck('weekday')
            //     ->toArray();
            //
            // $mergedAvailabilityArrays = array_unique(array_merge($teacherAvailabilities, $teacherAvailabilitiesNull), SORT_REGULAR);
            //
            // $availableDays            = [
            //     '1' => false,
            //     '2' => false,
            //     '3' => false,
            //     '4' => false,
            //     '5' => false,
            //     '6' => false,
            //     '7' => false,
            // ];
            //
            // foreach ($mergedAvailabilityArrays as $availability) {
            //     $cloneTalkAvailability = clone $talks;
            //     $availableDays[$availability] = $cloneTalkAvailability->where('weekday', $availability)->exists();
            // }
            //
            // foreach ($teacherAvailabilitiesNull as $availability) {
            //     $availableDays[$availability] = true;
            // }

            $availableDays = [
                '1' => false,
                '2' => false,
                '3' => false,
                '4' => false,
                '5' => false,
                '6' => false,
                '7' => false,
            ];

            $availabilities = \App\Models\Availability::query()
                ->select('weekday')
                ->where('state', Availability::STATE['valid'])
                ->whereIn('user_id', $talks->pluck('teacher_user_id'))
                ->groupBy('weekday')
                ->get();

            foreach ($availableDays as $key => $value) {
                $availableDays[$key] = $availabilities->where('weekday', $key)->count() != 0;
            }

            $cloneTalkAnonymYes = clone $talks;
            $cloneTalkAnonymNo  = clone $talks;
            $cloneTalkVoice     = clone $talks;
            $cloneTalkVideo     = clone $talks;
            $cloneTalkLanguage  = clone $talks;

            $talkAnonymAllowed  = $cloneTalkAnonymYes->where('anonym_call', Talk::ANONYM_CALL['allowed'])->exists();
            $talkAnonNotAllowed = $cloneTalkAnonymNo->where('anonym_call', Talk::ANONYM_CALL['not_allowed'])->exists();

            /* Call Type Change */
            // $talkVoiceCall = $cloneTalkVoice->where('call_type', Talk::CALL_TYPE['voice_call'])->exists();
            // $talkVoiceCall = $cloneTalkVoice->where('talk_type', TalkTypes::VOICE_CALL)->exists();
            $talkVoiceCall = $cloneTalkVoice->count() != 0;
            /* Call Type Change */
            // $talkVideoCall = $cloneTalkVideo->where('call_type', Talk::CALL_TYPE['video_call'])->exists();
            $talkVideoCall = $cloneTalkVideo->where('talk_type', TalkTypes::VIDEO_CALL)->exists();

            $availableLanguages = $cloneTalkLanguage->select('languages_id')->groupBy('languages_id')->get()->pluck('languages_id')->toArray();

            $languageController = new LanguagesApiController();

            $parsedLanguages    = $languageController->index($request, $availableLanguages);
            $getLanguageContent = json_decode($parsedLanguages->getContent(), true);

            // This conditional has been checking if the message exists, and not if the response was successful.
            // if ($getLanguageContent['message']) {
            if ($getLanguageContent['success']) {
                $languageContent = $getLanguageContent['data'];
            } else {
                $languageContent = [];
            }

            $availableFilters = [
                'typePrivate'      => $talkTypePrivate,
                'typeGroup'        => $talkTypeGroup,
                'price1_10'        => $talkPrice1_10,
                'price10_50'       => $talkPrice10_50,
                'priceOver50'      => $talkPriceOver50,
                'priceOver100'     => $talkPriceOver100,
                'duration15'       => $talkDuration15,
                'duration30'       => $talkDuration30,
                'duration45'       => $talkDuration45,
                'duration60'       => $talkDuration60,
                'duration75'       => $talkDuration75,
                'duration90'       => $talkDuration90,
                'duration105'      => $talkDuration105,
                'duration120'      => $talkDuration120,
                'durationOver120'  => $talkDurationOver120,
                'availableDays'    => $availableDays,
                'anonymAllowed'    => $talkAnonymAllowed,
                'anonymNotAllowed' => $talkAnonNotAllowed,
                'voiceCall'        => $talkVoiceCall,
                'videoCall'        => $talkVideoCall,
                'languages'        => $languageContent,
            ];

            $response = response()->json([
                'data'    => $availableFilters,
                'message' => __('AVAILABLE_FILTERS'),
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::TalksApiController::checkActiveFilters::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3912, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3912,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Get all Talk reviews.
     *
     * @param  Request  $request
     * @param  Talk     $talk
     *
     * @return void
     */
    public function getTalkReviews(Request $request, Talk $talk)
    {
        $offset = $request->get('offset');
        $limit  = $request->get('limit');

        // Get all Talk reviews
        $reviews = $talk->getTalkReviews($offset, $limit);

        // Get Talk reviews count.
        $reviewsCount = $talk->getTalkReviewsCount();

        // If the Talk has no reviews, notify the user.
        if (! $reviews) {
            return response()->success(__('TALK_NO_REVIEWS'));
        }

        // Return JSON response with all Talk reviews.
        if ($reviews) {
            return response()->success([
                'message' => __('TALK_REVIEWS'),
                'data'    => [
                    'total_reviews' => $reviewsCount,
                    'reviews'       => $reviews,
                ],
            ]);
        }
    }
}
