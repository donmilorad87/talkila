<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\UserBlocked;
use App\ModelsApi\Booking;
use App\ModelsApi\Language;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\User;
use App\ModelsApi\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="Searches",
 *     description="Everything about Searches",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/searches",
 *      operationId="index",
 *      tags={"Searches"},
 *      summary="Get list of Searches",
 *      description="Returns list of Searches",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/SearchResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of Searches
 */

/**
 * @OA\Post(
 *      path="/v1/searches",
 *      operationId="store",
 *      tags={"Searches"},
 *      summary="Get requested fields from form and create new Searches",
 *      description="Get requested fields from form and create new Searches",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreSearchRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Search")
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
 *      path="/v1/searches/{id}",
 *      operationId="show",
 *      tags={"Searches"},
 *      summary="Get Searches information",
 *      description="Returns Searches data",
 *      @OA\Parameter(
 *          name="id",
 *          description="Searches id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Search")
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
 *      path="/v1/searches/{id}",
 *      operationId="update",
 *      tags={"Searches"},
 *      summary="Get Searches update information",
 *      description="Get requested fields from form and update requested Searches",
 *      @OA\Parameter(
 *          name="id",
 *          description="Searches id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateSearchRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Search")
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
 *      path="/v1/searches/{id}",
 *      operationId="destroy",
 *      tags={"Searches"},
 *      summary="Delete Searches",
 *      description="Take requested Searches and delete it from system",
 *      @OA\Parameter(
 *          name="id",
 *          description="Searches id",
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
 * @OA\Get(
 *      path="/v1/search-talks",
 *      operationId="searchTalks",
 *      tags={"Searches"},
 *      summary="Method searchTalks of SearchesApiController",
 *      description="Method searchTalks of SearchesApiController",
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
 *      path="/v1/search-users",
 *      operationId="searchUsers",
 *      tags={"Searches"},
 *      summary="Method searchUsers of SearchesApiController",
 *      description="Method searchUsers of SearchesApiController",
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
 * Class SearchesApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class SearchesApiController extends Controller
{
    /**
     * A Talk model.
     */
    protected $talk;

    public function __construct()
    {
        $this->talk = new \App\Models\Talk();
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchTalks(Request $request)
    {
        try {
            Log::notice("\n\n".'::SearchesApiController::searchTalks::$request');
            Log::notice($request->all());

            $requestTimezoneHour    = abs((int)(($request->header('Time-Zone-Offset-UTC')) / 60));
            $requestTimezoneMinutes = abs((int)(($request->header('Time-Zone-Offset-UTC')) % 60));
            $requestTimezoneSign    = $request->header('Time-Zone-Offset-UTC') < 0 ? '-' : '+';

            $requestedSubcategoryTerm = $request->input('requested_subcategory');
            $includedGroupTalks       = $request->input('group_talks_included', 1);
            $displayOffset            = $request->input('offset');
            $displayLimit             = $request->input('limit');

            $searchData = [];

            $bookings = Booking::query()->selectRaw(
                'COUNT(id) AS taken_slots, talk_id, start_call::date AS start_call_date'
            )
                ->where('state', Booking::STATE['paid'])
                ->groupBy('start_call_date', 'talk_id');

            $languages = Language::query()->select(
                'id',
                StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')].' as language_name'
            )
                ->orderByRaw('-order_by DESC')
                ->orderBy('language_name');

            $talkDetails = Talk::query()
                ->select(
                    'talks.id',
                    'teacher_user_id',
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
                )
                ->selectRaw(
                    "TO_CHAR(start_time_call + INTERVAL '".$requestTimezoneSign.$requestTimezoneHour.":".$requestTimezoneMinutes." hours', 'HH24:MI:SS') AS start_time_call, TO_CHAR(end_time_call + INTERVAL '".$requestTimezoneSign.$requestTimezoneHour.":".$requestTimezoneMinutes." hours', 'HH24:MI:SS') AS end_time_call"
                )
                ->selectRaw('CASE WHEN taken_slots > 0 THEN taken_slots ELSE 0 END  AS taken_places')
                ->selectRaw('CASE WHEN talks.teacher_user_id = '.$request->user()->id.' THEN true ELSE false END  AS is_edit_enabled')
                ->where('state', Talk::STATE['valid'])
                ->leftJoinSub($bookings, 'bookings', function ($join) {
                    $join
                        ->on('bookings.talk_id', '=', 'talks.id');
                })
                ->leftJoinSub($languages, 'languages', function ($join) {
                    $join
                        ->on('languages.id', '=', 'talks.languages_id');
                });

            if (!empty($displayOffset)) {
                $talkDetails->offset($displayOffset);
            }
            if (!empty($displayLimit)) {
                $talkDetails->limit($displayLimit);
            }

            $talkDetails->groupBy('talks.id')
                ->orderBy('headline');

            if (!empty($requestedSubcategoryTerm)) {
                $searchData['filters']['requested_subcategory'] = $requestedSubcategoryTerm;
                $talkDetails                                    = $talkDetails->where(
                    'talk_subcategories_id',
                    $requestedSubcategoryTerm
                );
            }

            /* Talk Type Change */
            if ($includedGroupTalks == 0) {
                // $talkDetails->where('talk_type', Talk::TALK_TYPE['face_to_face']);
                $talkDetails->where('call_type', CallTypes::ONE_TO_ONE);
            }

            $talkDetails = $talkDetails->get()->toArray();

            $searchData['talks'] = $talkDetails;

            if (empty($searchData['talks'])) {
                $response = response()->success(__('NO_TALKS'));

                Log::notice("\n\n".'::SearchesApiController::searchTalks::$response');
                Log::notice($response);

                return $response;
            }

            // $response = response()->json([
            //     'data'      => $searchData,
            //     'message'   => 'List of talks for requested search term..',
            //     'success'   => true
            // ], 200);

            $response = response()->success([
                'message' => 'List of talks for requested search term..',
                'data'    => $searchData,
            ]);

            Log::notice("\n\n".'::SearchesApiController::searchTalks::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3600,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3600,
            //     'success' => false
            // ], 500);

            return response()->json('Error: '.Handler::TYPE_EXCEPTION_3600, 500);
        }
    }

    public function getTalk($talkId)
    {
        Log::notice("\n\n".'::SearchesApiController::getTalk::$talkId');
        Log::notice($talkId);

        $talk = $this->talk->getTalkById($talkId);

        if (!$talk) {
            return response()->error(__('NO_TALK'));
        }

        return response()->success([
            'message' => 'Talk details.',
            'data'    => $talk,
        ]);
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUsers(Request $request)
    {
        try {
            Log::notice("\n\n".'::SearchesApiController::searchUsers::$request');
            Log::notice($request->all());

            $requestedTerm = $request->input('requested_term');
            $searchData    = [];
            $loggedUser    = $request->user();

            $userFollowedTrue = UserFollowed::STATE['valid'];
            $userBlockedTrue  = UserBlocked::STATE['valid'];

            $talks = Talk::query()->select('teacher_user_id')->groupBy('teacher_user_id');


            $blockedByUser = UserBlocked::query()->where('blocked_user_id', $loggedUser->id)
                ->where('state', UserBlocked::STATE['valid'])
                ->get()
                ->pluck('user_id')
                ->toArray();

            $usersList = User::query()->select('users.id', 'name', 'username', 'profession')
                ->selectRaw(
                    '
                    CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(users.ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS ratings'
                )
                ->selectRaw(
                    '
                    CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews'
                )
                ->selectRaw('CASE WHEN COUNT(user_followeds.id) > 0 THEN COUNT(user_followeds.id) ELSE 0 END AS total_followers')
                ->selectRaw("CASE WHEN users.id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->leftJoin('user_followeds', function ($join) use ($userFollowedTrue) {
                    $join
                        ->on('user_followeds.follower_user_id', '=', 'users.id')
                        ->where('user_followeds.state', '=', $userFollowedTrue);
                })->leftJoin('user_blockeds', function ($join) use ($userBlockedTrue) {
                    $join
                        ->on('user_blockeds.blocked_user_id', '=', 'users.id')
                        ->where('user_blockeds.state', '!=', $userBlockedTrue);
                })
                ->leftJoinSub($talks, 'talks', function ($join) {
                    $join->on('talks.teacher_user_id', '=', 'users.id');
                })
                ->where(function ($q) use ($requestedTerm) {
                    $q->where('name', 'LIKE', '%'.$requestedTerm.'%');
                    $q->orWhere('username', 'LIKE', '%'.$requestedTerm.'%');
                })
                ->where('users.id', '!=', $loggedUser->id)
                ->where('type', User::TYPE['supplier'])
                ->where('verified', true)
                ->where('approved', true);

            if (!empty($blockedByUser)) {
                $usersList->whereNotIn('users.id', $blockedByUser);
            }
            $usersList = $usersList->groupBy('users.id')->get()->toArray();

            $searchData['users'] = $usersList;

            if (empty($searchData['users'])) {
                $response = response()->success(__('NO_USERS'));

                Log::notice("\n\n".'::SearchesApiController::searchUsers::$response');
                Log::notice($response);

                return $response;
            }

            if (!empty($requestedTerm)) {
                $searchData['terms']['requested_term'] = $requestedTerm;
            }

            // $response = response()->json([
            //     'data'      => $searchData,
            //     'message'   => 'List of talks for requested search term..',
            //     'success'   => true
            // ], 200);

            $response = response()->success([
                'message' => 'List of talks for requested search term..',
                'data'    => $searchData,
            ]);

            Log::notice("\n\n".'::SearchesApiController::searchUsers::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3601,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3601,
            //     'success' => false
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_3601, 500);
        }
    }
}
