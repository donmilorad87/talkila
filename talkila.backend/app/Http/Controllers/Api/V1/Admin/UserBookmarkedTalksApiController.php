<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserBookmarkedTalksRequest;
use App\Http\Resources\Admin\UserBookmarkedTalksResource;
use App\Models\HelperModel;
use App\Models\Notifications;
use App\Models\UserBlocked;
use App\ModelsApi\Booking;
use App\ModelsApi\Language;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\User;
use App\ModelsApi\UserBookmarkedTalks;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


/**
 * @OA\Tag(
 *     name="UserBookmarkedTalks",
 *     description="Everything about UserBookmarkedTalks",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/user-bookmarked-talks",
 *      operationId="index",
 *      tags={"UserBookmarkedTalks"},
 *      summary="Get list of UserBookmarkedTalks",
 *      description="Returns list of UserBookmarkedTalks",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserBookmarkedTalksResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of UserBookmarkedTalks
 */

/**
 * @OA\Post(
 *      path="/v1/user-bookmarked-talks",
 *      operationId="store",
 *      tags={"UserBookmarkedTalks"},
 *      summary="Get requested fields from form and create new UserBookmarkedTalk",
 *      description="Get requested fields from form and create new UserBookmarkedTalk",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreUserBookmarkedTalksRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserBookmarkedTalks")
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
 *      path="/v1/user-bookmarked-talks/{id}",
 *      operationId="show",
 *      tags={"UserBookmarkedTalks"},
 *      summary="Get UserBookmarkedTalks information",
 *      description="Returns UserBookmarkedTalks data",
 *      @OA\Parameter(
 *          name="id",
 *          description="UserBookmarkedTalk id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserBookmarkedTalks")
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
 *      path="/v1/user-bookmarked-talks/{id}",
 *      operationId="update",
 *      tags={"UserBookmarkedTalks"},
 *      summary="Get UserBookmarkedTalks update information",
 *      description="Get requested fields from form and update requested UserBookmarkedTalk",
 *      @OA\Parameter(
 *          name="id",
 *          description="UserBookmarkedTalk id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateUserBookmarkedTalksRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserBookmarkedTalks")
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
 *      path="/v1/user-bookmarked-talks/{id}",
 *      operationId="destroy",
 *      tags={"UserBookmarkedTalk"},
 *      summary="Delete UserBookmarkedTalk",
 *      description="Take requested UserBookmarkedTalk and delete it from system",
 *      @OA\Parameter(
 *          name="id",
 *          description="UserBookmarkedTalk id",
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
 *      path="/v1/unfollow-single-talk",
 *      operationId="unfollowSingleTalk",
 *      tags={"UserBookmarkedTalks"},
 *      summary="Method unfollowSingleTalk of UserBookmarkedTalksApiController",
 *      description="Method unfollowSingleTalk of UserBookmarkedTalksApiController",
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
 * Class UserBookmarkedTalksApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class UserBookmarkedTalksApiController extends Controller
{
    /**
     * @return UserBookmarkedTalksResource
     */
    public function index()
    {
        try {
            $bookmarkedTalk = UserBookmarkedTalks::query()->where('state', UserBookmarkedTalks::STATE['valid'])->pluck('talks_id')->toArray();
            $talks          = Talk::query()->whereIn('id', $bookmarkedTalk);

            if (! empty($bookmarkedTalk)) {
                $talksId = implode(',', $bookmarkedTalk);
                $talks->selectRaw("CASE WHEN talks.id IN ($talksId) THEN 1 ELSE 0 END AS is_favorite");
            } else {
                $talks->selectRaw("0 AS is_favorite");
            }

            $talks = $talks->get()->toArray();

            $response = response()->json([
                'data'    => $talks,
                'message' => 'User favorite talks with talk information.',
                'success' => false,
            ], 200);

            Log::notice('::UserBookmarkedTalksApiController::store::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_4100, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4100,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Log::notice("\n\n" . '::UserBookmarkedTalksApiController::store::$response');
        Log::notice($request->all());
        try {
            $dataForm = $request->all();

            $rules = [
                'talks_id' => 'required|integer',
            ];

            app()->setLocale($request->header('Application-Language', 'en'));

            $messages = [
                // 'talks_id.required' => 'The :attribute is required.',
                'talks_id.required' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'Talk ID']),
                // 'talks_id.string'   => 'The :attribute need to be string.',
                'talks_id.string'   => __('ATTRIBUTE_STRING', ['attribute' => 'Talk ID']),
            ];

            $validator = validator($dataForm, $rules, $messages);

            Log::notice('::UserBookmarkedTalksApiController::store::$validator');
            Log::notice($validator->errors()->messages());

            if (! empty($validator->errors()->messages())) {
                $response = response()->json([
                    'errors'  => $validator->errors()->messages(),
                    'message' => 'Fields validation failed.',
                    'success' => false,
                ], 200);

                Log::notice('::UserBookmarkedTalksApiController::store::$response');
                Log::notice($response);

                return $response;
            }

            $talkToBookmark = Talk::query()->find($request->input('talks_id'));
            if ($talkToBookmark && $talkToBookmark->teacher_user_id == $request->user()->id) {
                return response()->json([
                    'message' => 'You cannot favorite your own talk.',
                    'success' => false,
                ], 403);
            }

            DB::beginTransaction();

            // If the talk has already been followed by the user, unfollow it.
            if (UserBookmarkedTalks::find($request->input('talks_id'))) {
                $this->unfollowSingleTalk($request);
            }

            $user_bookmarked_talks = UserBookmarkedTalks::create($request->all());

            $createdBookmark = Talk::query()->find($user_bookmarked_talks->talks_id)->toArray();

            $notificationData = [
                'user_id'    => $request->user()->id,
                'type'       => $createdBookmark['headline'],
                'param_type' => 'name_of_talk',
                'param_id'   => $createdBookmark['id'],
                'talkName'   => $createdBookmark['headline'],
                'value'      => Notifications::VALUE['following_talk'],
            ];

            $notification = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::store::$notification');
            Log::notice($notification);

            $createdBookmark['is_favorite'] = 1;

            DB::commit();
            $response = response()->json([
                'data'    => $createdBookmark,
                'message' => 'Successfully stored bookmark talk',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::store::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_4101, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4101,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  UserBookmarkedTalks  $user_bookmarked_talks
     *
     * @return UserBookmarkedTalksResource
     */
    public function show(UserBookmarkedTalks $user_bookmarked_talks)
    {
        abort_if(Gate::denies('user_bookmarked_talks_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserBookmarkedTalksResource($user_bookmarked_talks);
    }

    /**
     * @param  UpdateUserBookmarkedTalksRequest  $request
     * @param                                    $id
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(UpdateUserBookmarkedTalksRequest $request, $id)
    {
        UserBookmarkedTalks::query()->find($id)->update($request->all());

        $user_bookmarked_talks = UserBookmarkedTalks::query()->find($id);

        return (new UserBookmarkedTalksResource($user_bookmarked_talks))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('user_bookmarked_talks_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        UserBookmarkedTalks::query()->find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unfollowTalk(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::unfollowTalk::$request');
            Log::notice($request->all());

            $talksIds = $request->input('talks_id');

            if (empty($talksIds)) {
                $response = response()->json([
                    'errors'  => ['talks_id' => 'Talk id is required.'],
                    'message' => 'Fields validation failed.',
                    'success' => false,
                ], 200);

                Log::notice('::UserBookmarkedTalksApiController::unfollowTalk::$response');
                Log::notice($response);

                return $response;
            }
            DB::beginTransaction();

            UserBookmarkedTalks::query()
                ->whereIn('talks_id', $talksIds)
                ->update(['state' => UserBookmarkedTalks::STATE['not_valid']]);

            DB::commit();
            $response = response()->json([
                'message' => 'Talk successfully unfollowed',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::unfollowTalk::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_4102, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4102,
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
    public function unfollowSingleTalk(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::unfollowSingleTalk::$request');
            Log::notice($request->all());

            $talksId = $request->input('talks_id');

            if (empty($talksId)) {
                $response = response()->json([
                    'errors'  => ['talks_id' => 'Talk id is required.'],
                    'message' => 'Fields validation failed.',
                    'success' => false,
                ], 200);

                Log::notice('::UserBookmarkedTalksApiController::unfollowSingleTalk::$response');
                Log::notice($response);

                return $response;
            }
            DB::beginTransaction();

            UserBookmarkedTalks::query()
                ->where('talks_id', $talksId)
                ->update(['state' => UserBookmarkedTalks::STATE['not_valid']]);

            UserBookmarkedTalks::where('talks_id', $talksId)->delete();

            // TODO ???
            //            $bookmarkedTalk = UserBookmarkedTalks::query()
            //                ->where('talks_id', $talksId)
            //                ->where('state', true)
            //                ->pluck('talks_id')
            //                ->toArray();
            //
            //            $talk     = Talk::query()->whereIn('id', $bookmarkedTalk);
            //
            //            if(!empty($bookmarkedTalk)) {
            //                $talksId  = implode(',', $bookmarkedTalk);
            //                $talk->selectRaw("IF(id IN ($talksId), 1, 0) AS is_favorite");
            //            }
            //
            //            $talk = $talk->get()->toArray();

            $removedBookmark                = Talk::query()->find($talksId)->toArray();
            $removedBookmark['is_favorite'] = 0;

            DB::commit();
            $response = response()->json([
                'data'    => $removedBookmark,
                'message' => 'Talk successfully unfollowed',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::unfollowSingleTalk::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_4103, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4103,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function userFavoriteTalks(Request $request, $includedGroupTalks)
    {
        try {
            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::userFavoriteTalks::$request');
            Log::notice($request->all());

            if (! empty($request->user())) {
                $loggedUser = $request->user()->id;
            } elseif ($request->input('logged_user')) {
                $loggedUser = User::query()->where('id', $request->input('logged_user'))->first()->id;
            } else {
                $loggedUser = -99;
            }

            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 20);

            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';

            $bookmarkedTalks = UserBookmarkedTalks::query()
                ->where('state', UserBookmarkedTalks::STATE['valid'])
                ->pluck('talks_id')
                ->unique()
                ->toArray();

            $blockedByUser = UserBlocked::query()
                ->where('user_id', $loggedUser)
                ->where('state', UserBlocked::STATE['valid'])
                ->pluck('blocked_user_id')
                ->toArray();

            $bookings = Booking::query()->selectRaw('COUNT(id) AS taken_slots, talk_id, start_call::date AS start_call_date')
                ->where('state', Booking::STATE['paid'])
                ->whereIn('talk_id', $bookmarkedTalks)
                ->groupBy('start_call_date', 'talk_id');

            $languages = Language::query()->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as language_name')
                ->orderByRaw('-order_by DESC')
                ->orderBy('language_name');

            $talkDetails = Talk::query()
                ->leftJoinSub($bookings, 'bookings', function ($join) {
                    $join
                        ->on('bookings.talk_id', '=', 'talks.id');
                })
                ->leftJoinSub($languages, 'languages', function ($join) {
                    $join
                        ->on('languages.id', '=', 'talks.languages_id');
                })
                ->select([
                    'talks.id',
                    'talks.duration',
                    'headline',
                    'call_type',
                    'talk_type',
                    'description',
                    'max_participiants',
                    'talks.price',
                    'anonym_call as is_anonymous_allowed',
                    'reviews',
                    'ratings',
                    'weekday',
                    'talk_categories_id',
                    'talk_subcategories_id',
                    'languages_id',
                    'language_name',
                    'finance_currencies_id',
                    'taken_slots',
                    'start_call_date',
                    'teacher_name'            => User::select('name')->whereColumn('id', 'talks.teacher_user_id')->take(1),
                    'teacher_profile_picture' => User::select('profile_picture')->whereColumn('id', 'talks.teacher_user_id')->take(1),
                ])
                ->selectRaw("TO_CHAR(start_time_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . "', 'HH24:MI:SS') AS start_time_call, TO_CHAR(end_time_call + INTERVAL '" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . "', 'HH24:MI:SS') AS end_time_call")
                ->selectRaw('CASE WHEN taken_slots > 0 THEN taken_slots ELSE 0 END  AS taken_places')
                ->selectRaw('CASE WHEN talks.teacher_user_id = ' . $request->user()->id . ' THEN true ELSE false END  AS is_edit_enabled')
                ->whereIn('talks.id', $bookmarkedTalks)
                ->where('talks.state', Talk::STATE['valid'])
                ->whereNotIn('talks.teacher_user_id', $blockedByUser)
                ->groupBy('talks.id')
                ->orderBy('headline');

            if ($request->has('filter') && ! empty($request->input('filter'))) {
                $filter = json_decode($request->input('filter'), true);


                HelperModel::filterResults($filter, $talkDetails, $loggedUser);
            }

            /* Talk Type Change */
            if ($includedGroupTalks == 0) {
                // $talkDetails->where('talk_type', Talk::TALK_TYPE['face_to_face']);
                $talkDetails->where('call_type', CallTypes::ONE_TO_ONE);
            }

            $countTalk = clone $talkDetails;
            //HelperModel::getSql($talkDetails);
            $talkDetails = $talkDetails->offset($displayOffset)->limit($displayLimit)->get()->toArray();

            if (empty($talkDetails)) {
                $response = response()->json([
                    'data'    => [],
                    'message' => 'There is no teacher favorite talks',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::UserBookmarkedTalksApiController::userFavoriteTalks::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'       => $talkDetails,
                'talk_count' => $countTalk->get()->count(),
                'message'    => 'Successfully get favorite talks',
                'success'    => true,
            ], 200);

            Log::notice("\n\n" . '::UserBookmarkedTalksApiController::userFavoriteTalks::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_4104, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4104,
                'success' => false,
            ], 500);
        }
    }
}
