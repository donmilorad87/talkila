<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\UserBlocked;
use App\ModelsApi\Booking;
use App\ModelsApi\Language;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\User;
use App\ModelsApi\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="UsersApiController",
 *     description="Everything about Suggesstions / UserApiController",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/users/{user}",
 *      operationId="show",
 *      tags={"Users"},
 *      summary="Get Suggesstions / UserApiController information",
 *      description="Returns Suggesstions / UserApiController data",
 *      @OA\Parameter(
 *          name="user",
 *          description="Autocomplete Tag id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/User")
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
class UsersApiController extends Controller
{
    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UsersApiController::show::$request');
            Log::notice($request->all());
            $loggedUser = $request->user();


            $requestedUser = User::query()->select(\App\Models\User::API_COLUMNS)
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture");

            if ((int)$id != 0) {
                $requestedUser->where('id', $id);
            } else {
                $requestedUser->where('username', 'LIKE', '%' . $id . '%');
            }
            $user = $requestedUser->with('partner:id,name,slug,logo,url')->first();

            if (empty($user)) {
                $response = response()->success(__('NO_USER'));

                Log::notice("\n\n" . '::UsersApiController::show::$response');
                Log::notice($response);

                return $response;
            }

            $user = $user->toArray();

            $blockedByUser = UserBlocked::query()->where('blocked_user_id', $loggedUser->id)
                ->where('user_id', $user['id'])
                ->where('state', UserBlocked::STATE['valid'])
                ->exists();


            if ($blockedByUser) {
                $response = response()->success(__('BLOCKED_BY_USER'));

                Log::notice("\n\n" . '::UsersApiController::show::$response');
                Log::notice($response);

                return $response;
            }

            $availability = JoinTheClubApiController::joinTheClubAvailabilityCompleted($request, $user['id'])->getData(
                true
            );

            $aTeacherBookingList = User::query()->selectRaw(
                '
                    CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews,
                    CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS ratings
                '
            )
                ->where('id', $user['id'])
                ->first()
                ->toArray();

            $user['is_me']   = $user['id'] == $request->user()->id;
            $user['gallery_talks_count'] = $request->user()->talks()
                ->withGroup()
                ->where('call_type', CallTypes::GROUP)
                ->count();
            $user['ratings'] = $aTeacherBookingList['ratings'];

            $followingUser = UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('follower_user_id', $user['id'])
                ->exists();

            $pendingFollowings = UserFollowed::query()
                ->where([
                    'state'            => UserFollowed::STATE['requested'],
                    'follower_user_id' => $user['id'],
                    'user_id'          => $request->user()->id,
                ])
                ->exists();

            $followerUser = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('user_id', $user['id'])
                ->where('follower_user_id', $request->user()->id)
                ->exists();

            $blockedUser = UserBlocked::query()->where('user_id', $request->user()->id)
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
                    'follower'     => $followingUser,
                    'following'    => $followerUser,
                    'blocked'      => $blockedUser,
                ]
            );

            if ($user['id'] != auth()->user()->id) {
                // Increment visited in static metrics
                StaticMetric::query()->where('user_id', $user['id'])->increment('visited');
            }

            // const STATUS = [
            //     '0' => 'Pending',
            //     '1' => 'Approved',
            //     '2' => 'Declined'
            // ];

            $pending_user = User::where('id', $id)->orWhere('username', $id)->first();
            $user['account_verified'] = $pending_user->pendingProfileVerificationRequest ? $pending_user->pendingProfileVerificationRequest->status : null;
            $user['follow_pending'] = $pendingFollowings;

            // $response = response()->json([
            //     'data'      => array_merge($user, $dataTalkBooking),
            //     'message'   => 'Data of requested user',
            //     'success'   => true
            // ], 200);

            $response = response()->success([
                'message' => 'Data of requested user',
                'data'    => [
                    'user' => array_merge($user, $dataTalkBooking),
                ],
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

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4300,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4300, 500);
        }
    }

    public static function userProfileTalkBookingData($userId, $language)
    {
        try {
            // Get talk data for teacher
            $talksData = optional(
                StaticMetric::query()
                    ->selectRaw(
                        'ROUND(my_booked_hours/60) as teacher_booked_hours,
                                talks as teacher_booked_talks,
                                my_bookings AS teacher_booked_bookings,
                                received_reviews AS teacher_booked_review_count,
                                received_followers as total_followers'
                    )
                    ->where('user_id', $userId)
                    ->first()
            )
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
                ->get()->pluck('language')
                ->toArray();

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

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4301,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4301, 500);
        }
    }
}
