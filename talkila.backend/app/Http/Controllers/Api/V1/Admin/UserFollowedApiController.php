<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyClientFollowAccepted;
use App\Jobs\NotifySupplierFollowRequested;
use App\Mail\FollowRequestAccepted;
use App\Models\HelperModel;
use App\Models\Notifications;
use App\Models\UserBlocked;
use App\ModelsApi\Availability;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\Talk;
use App\ModelsApi\User;
use App\ModelsApi\UserBookmarkedTalks;
use App\ModelsApi\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;

/**
 * Class UserFollowedApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class UserFollowedApiController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function followingUser(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::followingUser::$request');
            Log::notice($request->all());
            $loggedUser    = $request->user();
            $userFollowers = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->where('follower_user_id', $request->user()->id)
                ->pluck('user_id')
                ->toArray();

            $user = User::query()->select('id', 'name', 'username', 'profession')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->whereIn('id', $userFollowers)
                ->get()
                ->toArray();

            if (empty($user)) {
                $response = response()->json([
                    'message' => 'There is no users that follow logged in user.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::UserFollowedApiController::followingUser::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $user,
                'message' => 'List of users that follow logged in user.',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserFollowedApiController::followingUser::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4202,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4202,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userFollowRequests(Request $request)
    {

        try {
            Log::notice("\n\n" . '::UserFollowedApiController::userFollowRequests::$request');
            Log::notice($request->all());
            $loggedUser = $request->user();

            $userFollowRequests = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['requested'])
                ->where('follower_user_id', $request->user()->id)
                ->pluck('user_id')
                ->toArray();

            $user = User::query()->select('id', 'name', 'username', 'profession')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->whereIn('id', $userFollowRequests)
                ->get()
                ->toArray();

            if (empty($user)) {
                $response = response()->success(__('NO_FOLLOW_REQUEST'));

                Log::notice("\n\n" . '::UserFollowedApiController::userFollowRequests::$response');
                Log::notice($response);

                return $response;
            }

            // $response = response()->json([
            //     'data'    => $user,
            //     'message' => 'List of users that request to follow.',
            //     'success' => true,
            // ], 200);

            // $response = response()->success([
            //     'message' => 'List of users that request to follow.',
            //     'data'    => [
            //         'user' => $user,
            //     ],
            // ]);

            $response = response()->success([
                'message' => 'List of users that request to follow.',
                'data'    => $user,
            ]);

            Log::notice("\n\n" . '::UserFollowedApiController::userFollowRequests::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4203,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4203,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4203, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function numberOfFollowers(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::numberOfFollowers::$request');
            Log::notice($request->all());

            $user = User::query()->where('id', $request->user()->id)->withCount('followerUserUserFolloweds')->first();

            // $response = response()->json([
            //     'follower_count' => $user->follower_user_user_followeds_count,
            //     'message'        => 'Successfully get count of followers',
            //     'success'        => true,
            // ], 200);

            $response = response()->success([
                'message' => 'Successfully get count of followers',
                'data'    => [
                    'follower_count' => $user->follower_user_user_followeds_count,
                ],
            ]);

            Log::notice("\n\n" . '::UserFollowedApiController::numberOfFollowers::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4204,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4204,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4204, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function followRequest(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$request');
            Log::notice($request->all());

            if (auth()->user()->id == $id) {
                $response = response()->error(__('REQUEST_FAILED'));

                Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$response');
                Log::notice($response);

                return $response;
            }

            $alreadyFollowing = UserFollowed::query()
                ->where('follower_user_id', $id)
                ->where('state', UserFollowed::STATE['valid'])
                ->exists();

            $pendingFollowing = UserFollowed::query()
                ->where('follower_user_id', $id)
                ->where('state', UserFollowed::STATE['requested'])
                ->exists();

            $requestedUser = User::query()->find($id);

            if ($alreadyFollowing) {
                $response = response()->success(__('ALREADY_FOLLOWING'));

                Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$response');
                Log::notice($response);

                return $response;
            } else if ($pendingFollowing) {
                $response = response()->success(__('ALREADY_SENT_FOLLOW'));

                Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$response');
                Log::notice($response);

                return $response;
            } else {
                if ($pendingFollowing) {
                    $response = response()->success(__('ALREADY_SENT_FOLLOW'));

                    Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$response');
                    Log::notice($response);

                    NotifySupplierFollowRequested::dispatch($requestedUser->id, $requestedUser->username);

                } else {

                    DB::beginTransaction();

                    if ($requestedUser->visibility == User::VISIBILITY['private']) {



                        $state   = 2;
                        $message = __('SUCCESSFULLY_SENT_FOLLOW_REQUEST');

                        NotifySupplierFollowRequested::dispatch(
                            $requestedUser->id,
                            $requestedUser->username
                        );
                    } else {
                        $state   = 1;
                        $message = __('SUCCESSFULLY_FOLLOWED_USER');

                        $notificationData = [
                            'user_id'    => $request->user()->id,
                            'type'       => $requestedUser->name,
                            'param_type' => 'username_of_teacher',
                            'param_id'   => $requestedUser->id,
                            'username'   => $requestedUser->username,
                            'value'      => Notifications::VALUE['following_user'],
                        ];

                        $notification = NotificationsApiController::sendNotification($request, $notificationData);

                        Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$notification');
                        Log::notice($notification);

                        // Increment follow in static metrics
                        StaticMetric::query()->where('user_id', $id)->increment('received_followers');
                        StaticMetric::query()->where('user_id', $request->user()->id)->increment('my_follows');
                    }

                    $followUser                   = new UserFollowed;
                    $followUser->state            = $state;
                    $followUser->follower_user_id = $id;
                    $followUser->created_at       = date('Y-m-d H:i:s');
                    $followUser->save();

                    DB::commit();

                    $response = response()->success($message);

                    Log::notice("\n\n" . '::UserFollowedApiController::followRequest::$response');
                    Log::notice($response);

                    return $response;
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4205,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4205,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4205);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function acceptFollowRequest(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::acceptFollowRequest::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $alreadyFollowing = $request->user()->followers()
                ->where('user_id', $id)
                ->where('state', UserFollowed::STATE['requested'])
                ->first();

            if (empty($alreadyFollowing)) {
                $response = response()->success(__('NO_FOLLOW_REQUESTS'));

                Log::notice("\n\n" . '::UserFollowedApiController::acceptFollowRequest::$response');
                Log::notice($response);

                return $response;
            } else {
                $alreadyFollowing->update(['state' => 1]);

                NotifyClientFollowAccepted::dispatch($alreadyFollowing->user_id);

                Mail::to($alreadyFollowing->user->email)->queue(new FollowRequestAccepted($alreadyFollowing->user->email, $request->user()->username));

                // Increment follow in static metrics
                StaticMetric::query()->where('user_id', $id)->increment('received_followers');
                StaticMetric::query()->where('user_id', $request->user()->id)->increment('my_follows');

                DB::commit();

                $response = response()->success(__('SUCCESSFULLY_ACCEPTED_FOLLOW_REQUEST'));

                Log::notice("\n\n" . '::UserFollowedApiController::acceptFollowRequest::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4206,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4206,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4206, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function rejectFollowRequest(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::acceptFollowRequest::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            // $alreadyFollowing = \App\Models\UserFollowed::query()
            // ->where('follower_user_id', $id)
            // ->where('user_id', $request->user()->id)
            // ->where('state', UserFollowed::STATE['requested'])
            // ->first();

            $alreadyFollowing = $request->user()->followers()
                ->where('user_id', $id)
                ->where('state', UserFollowed::STATE['requested'])
                ->first();

            if (empty($alreadyFollowing)) {
                $response = response()->success(__('NO_FOLLOW_REQUESTS'));

                Log::notice("\n\n" . '::UserFollowedApiController::rejectFollowRequest::$response');
                Log::notice($response);

                return $response;
            } else {
                $alreadyFollowing->update(['state' => UserFollowed::STATE['not_valid']]);

                DB::commit();

                $response = response()->success(__('SUCCESSFULLY_REJECTED_FOLLOW_REQUEST'));

                Log::notice("\n\n" . '::UserFollowedApiController::rejectFollowRequest::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4206,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4206,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4206, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function removeFollow(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::removeFollow::$request');
            Log::notice($request->all());
            DB::beginTransaction();
            if($request->has('teacher_cancel')){
                if($request->input('teacher_cancel')){
                    $user = $request->user()
                        ->followers()
                        ->where('follower_user_id', auth()->user()->id)
                        ->where('user_id', $id)
                        ->where('state', UserFollowed::STATE['valid'])
                        ->first();

                }
            }else{
                $user = $request->user()
                    ->followings()
                    ->where('follower_user_id', $id)
                    ->where('state', UserFollowed::STATE['valid'])
                    ->first();
            }


            if (empty($user)) {
                $response = response()->success(__('NOT_IN_FOLLOW_LIST'));

                Log::notice("\n\n" . '::UserFollowedApiController::removeFollow::$response');
                Log::notice($response);

                return $response;
            }

            $user->update(['state' => 0]);
            $user->delete();

            $my_metrics       = StaticMetric::query()->where('user_id', $id)->first();
            $received_metrics = StaticMetric::query()->where('user_id', $request->user()->id)->first();

            if ($my_metrics->my_follows > 0) {
                $my_metrics->update([
                    'my_metrics' => $my_metrics->my_follows - 1,
                ]);
            }

            if ($received_metrics->received_followers > 0) {
                $received_metrics->update([
                    'received_followers' => $received_metrics->received_followers - 1,
                ]);
            }

            DB::commit();
            if($request->has('teacher_cancel')){
                if($request->input('teacher_cancel')){
                    $response = response()->success(__('USER_HAS_SUCCESSFULLY_REMOVED_FROM_PRIVATE_LIST'));
                }
            }else{
                $response = response()->success(__('SUCCESSFULLY_UNFOLLOWED_USER'));
            }



            Log::notice("\n\n" . '::UserFollowedApiController::removeFollow::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4207,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4207,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4207, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function cancelFollow(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::cancelFollow::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            // $user = \App\Models\UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
            //     ->where('follower_user_id', $id)
            //     ->where('user_id', $request->user()->id)
            //     ->first();

            $user = $request->user()->followings()
                ->where('follower_user_id', $id)
                ->where('state', '!=', UserFollowed::STATE['not_valid'])
                ->first();

            if (empty($user)) {
                $response = response()->success(__('NOT_IN_FOLLOW_LIST'));

                Log::notice("\n\n" . '::UserFollowedApiController::cancelFollow::$response');
                Log::notice($response);

                return $response;
            }

            $user->update(['state' => 0]);

            // Decrement follow in static metrics

            $my_metrics       = StaticMetric::query()->where('user_id', $id)->first();
            $received_metrics = StaticMetric::query()->where('user_id', $request->user()->id)->first();

            if ($my_metrics->my_follows > 0) {
                $my_metrics->update([
                    'my_metrics' => $my_metrics->my_follows - 1,
                ]);
            }

            if ($received_metrics->received_followers > 0) {
                $received_metrics->update([
                    'received_followers' => $received_metrics->received_followers - 1,
                ]);
            }

            DB::commit();

            $response = response()->success(__('SUCCESSFULLY_UNFOLLOWED_USER'));

            Log::notice("\n\n" . '::UserFollowedApiController::removeFollow::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4207,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4207,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4207, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Throwable
     */
    public function unfollowFavorites(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::unfollowFavorites::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $talksIds = $request->input('talks_id', []);

            $talk = UserBookmarkedTalks::query()
                ->whereIn('talks_id', $talksIds);

            $talk->update([
                'state' => UserBookmarkedTalks::STATE['not_valid'],
            ]);

            $talk->delete();

            $usersIds = $request->input('users_id', []);

            UserFollowed::query()->where('user_id', $request->user()->id)
                ->whereIn('follower_user_id', $usersIds)
                ->update(['state' => UserFollowed::STATE['not_valid']]);

            foreach ($usersIds as $userId) {
                // Decrement follow in static metrics
                StaticMetric::query()->where('user_id', $userId)->decrement('received_followers');
                StaticMetric::query()->where('user_id', $request->user()->id)->decrement('my_follows');
            }

            $response = $this->userTalkFollowers($request)->getData(true);

            DB::commit();

            Log::notice("\n\n" . '::UserFollowedApiController::unfollowFavorites::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4208,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4208,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4208, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userTalkFollowers(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::userTalkFollowers::$request');
            Log::notice($request->all());
            $requestType        = $request->input('favorite_type');
            $includedGroupTalks = $request->input('group_talks_included', 1);

            $followersData = [];
            if ($requestType == 1) {
                $userFollowersData = $this->userFollowers($request)->getData(true);

                if (empty($userFollowersData['data'])) {
                    $response = response()->success(__('NO_FOLLOWING_USERS'));

                    Log::notice("\n\n" . '::UserFollowedApiController::userTalkFollowers::$response');
                    Log::notice($response);

                    return $response;
                }

                $followersData['users_total'] = $userFollowersData['data']['user_count'];

                $followersData = array_merge($followersData, $userFollowersData['data']);
            } elseif ($requestType == 2) {
                $userBookmarkedTalks = UserBookmarkedTalksApiController::userFavoriteTalks(
                    $request,
                    $includedGroupTalks
                )->getData(true);

                if (empty($userBookmarkedTalks['data'])) {
                    $response = response()->success(__('NO_FOLLOWING_TALKS'));

                    Log::notice("\n\n" . '::UserFollowedApiController::userTalkFollowers::$response');
                    Log::notice($response);

                    return $response;
                }

                $followersData['talks_total'] = $userBookmarkedTalks['talk_count'];
                $followersData['talks']       = $userBookmarkedTalks['data'];
            } else {
                $userFollowersData   = $this->userFollowers($request)->getData(true);
                $userBookmarkedTalks = UserBookmarkedTalksApiController::userFavoriteTalks(
                    $request,
                    $includedGroupTalks
                )->getData(true);

                if (empty($userFollowersData['data']) && empty($userBookmarkedTalks['data'])) {
                    $response = response()->success(__('NO_FOLLOWING_USERS_AND_TALKS'));

                    Log::notice("\n\n" . '::UserFollowedApiController::userTalkFollowers::$response');
                    Log::notice($response);

                    return $response;
                }

            if (!empty($userFollowersData['data'])) {
                $followersData['users_total'] = $userFollowersData['data']['user_count'];
                $followersData                = array_merge($followersData, $userFollowersData['data']);
            }
            if (!empty($userBookmarkedTalks['data'])) {
                $followersData['talks_total'] = $userBookmarkedTalks['talk_count'];
                $followersData['talks']       = $userBookmarkedTalks['data'];
                }
            }


            if (empty($followersData)) {
                $response = response()->success(__('NO_FOLLOWINGS'));

                Log::notice("\n\n" . '::UserFollowedApiController::userTalkFollowers::$response');
                Log::notice($response);

                return $response;
            }
            unset($followersData['user_count']);

            $response = response()->success([
                'message' => 'List of users or talks that logged in user is following.',
                'data'    => $followersData,
            ], 200);

            Log::notice("\n\n" . '::UserFollowedApiController::userTalkFollowers::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4200,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4200,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4200, 500);
        }
    }


    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userFollowers(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserFollowedApiController::userFollowers::$request');
            Log::notice($request->all());
            $loggedUser     = $request->user();
            $displayOffset  = $request->input('offset', 0);
            $displayLimit   = $request->input('limit', 20);
            $clonedTalksIDs = [];

            $userFollowers = UserFollowed::query()
                ->where('user_id', $loggedUser->id)
                ->where('state', UserFollowed::STATE['valid'])
                ->pluck('follower_user_id')
                ->toArray();

            $talks = Talk::query()->select('teacher_user_id')
                ->selectRaw('CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(talks.ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS rating')
                ->selectRaw('CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews')
                ->groupBy('teacher_user_id');

            $user = User::query()->select('id', 'name', 'username', 'profession', 'rating')
                ->selectRaw('CONCAT("/", username) AS profile_url')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->leftJoinSub($talks, 'talks', function ($join) {
                    $join->on('talks.teacher_user_id', '=', 'users.id');
                });

            if ($request->has('filter') && !empty($request->input('filter'))) {
                $filterTalks      = Talk::query()->whereIn('teacher_user_id', $userFollowers);
                $userAvailability = \App\Models\Availability::query()->where('state', Availability::STATE['valid']);
                $filter           = json_decode($request->input('filter'), true);

                HelperModel::filterResults($filter, $filterTalks, $loggedUser);

                $clonedTeacherTalks = clone $filterTalks;

                $filterTeacherTalks     = $clonedTeacherTalks->groupBy('teacher_user_id')->get()->pluck(
                    'teacher_user_id'
                )->toArray();
                $filterUserAvailability = $userAvailability->get()->pluck('user_id')->toArray();
                $clonedTalksIDs         = $filterTalks->get()->pluck('id')->toArray();

                $talks->whereIn('id', $clonedTalksIDs);
                $user->whereIn('id', $filterTeacherTalks);
                $user->whereIn('id', $filterUserAvailability);
            } else {
                $user->whereIn('id', $userFollowers);
            }

            $blockedByUser = UserBlocked::query()->where('user_id', $loggedUser->id)
                ->where('state', UserBlocked::STATE['valid'])
                ->get()
                ->pluck('blocked_user_id')
                ->toArray();

            if (!empty($blockedByUser)) {
                $user->whereNotIn('id', $blockedByUser);
            }

            $countUser = clone $user;

            $user = $user->with([
                'talks' => function ($query) use ($clonedTalksIDs) {
                    if (!empty($clonedTalksIDs)) {
                        $query->whereIn('id', $clonedTalksIDs);
                    }
                },
            ])
                ->withCount('followerUserUserFolloweds as total_followers')
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->map(function ($talks) {
                    $talks->setRelation('talks', $talks->talks->take(2));
                    return $talks;
                })
                ->toArray();

            if (empty($user)) {
                $response = response()->success(__('NO_FOLLOWINGS'));

                Log::notice("\n\n" . '::UserFollowedApiController::userFollowers::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => __('LIST_FOLLOWING'),
                'data'    => [
                    'users'      => $user,
                    'user_count' => $countUser->get()->count(),
                ],
            ]);

            // $response = response()->success([
            //     'message'    => 'List of users that logged in user is following.',
            //     'data'       => $user,
            //     'user_count' => $countUser->get()->count(),
            // ]);

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

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4201,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4201, 500);
        }
    }

    public function followRequests(Request $request)
    {
        Log::notice("\n\n" . '::UserFollowedApiController::followRequests::$request');
        Log::notice($request->all());

        try {
            $offset = $request->input('offset');
            $limit  = $request->input('limit') ?: 5;
            $query  = $request->user()
                ->followers()
                ->join('users', function ($join) {
                    $join->on('user_followeds.user_id', '=', 'users.id')
                        ->whereNull('users.deleted_at');
                })
                ->where('user_followeds.state', '=', UserFollowed::STATE['requested'])
                ->select([
                    'users.id as id',
                    'users.name',
                    'users.username',
                    'users.profile_picture',
                    // 'user_followeds.state',
                ]);

            $followers_count = $query->count();

            $followers = $query->when($offset, function ($query) use ($offset) {
                $query->offset($offset);
            })->limit($limit)->get();

            if ($followers->isEmpty()) {
                return response()->success(__('NO_FOLLOW_REQUESTS'));
            }

            return response()->success([
                'message' => 'List of follow requests.',
                'data'    => [
                    'follow_requests_count' => $followers_count,
                    'follow_requests'       => $followers,
                ],
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4209,
                self::class,
                __FUNCTION__
            );

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function followingRequests(Request $request)
    {
        Log::notice("\n\n" . '::UserFollowedApiController::followingRequests::$request');
        Log::notice($request->all());

        try {
            // $followers = $request->user()
            //     ->followings()
            //     ->join('users', 'user_followeds.follower_user_id', '=', 'users.id')
            //     ->when($request->input('state') === 'pending', function ($query) {
            //         $query->where('user_followeds.state', '=', UserFollowed::STATE['requested']);
            //     })
            //     ->when($request->input('state') === 'accepted', function ($query) {
            //         $query->where('user_followeds.state', '=', UserFollowed::STATE['valid']);
            //     })
            //     ->where('user_followeds.state', '!=', UserFollowed::STATE['not_valid'])
            //     ->select([
            //         'user_followeds.follower_user_id as id',
            //         'users.name',
            //         'users.profile_picture',
            //         'user_followeds.state',
            //     ])
            //     ->get();

            $offset = $request->input('offset');
            $limit  = $request->input('limit') ?: 5;

            $query = $request->user()
                ->followings()
                ->join('users', function ($join) {
                    $join->on('user_followeds.follower_user_id', '=', 'users.id')
                        ->whereNull('users.deleted_at');
                })
                ->where('user_followeds.state', '!=', UserFollowed::STATE['not_valid'])
                ->select([
                    'users.id as id',
                    'users.name',
                    'users.username',
                    'users.profile_picture',
                    // 'user_followeds.state',
                ]);

            $followings_count = $query->count();

            $followings = $query->when($offset, function ($query) use ($offset) {
                $query->offset($offset);
            })->limit($limit)->get();

            if ($followings->isEmpty()) {
                return response()->success(__('NO_FOLLOW_REQUESTS'));
            }

            return response()->success([
                'message' => __('LIST_FOLLOWING_REQUESTS'),
                'data'    => [
                    'follow_requests_count' => $followings_count,
                    'follow_requests'       => $followings,
                ],
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4210,
                self::class,
                __FUNCTION__
            );

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }
}
