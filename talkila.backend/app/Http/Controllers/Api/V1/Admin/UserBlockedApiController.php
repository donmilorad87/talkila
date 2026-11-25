<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\StaticMetric;
use App\Models\UserFollowed;
use App\ModelsApi\User;
use App\ModelsApi\UserBlocked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Blockeds",
 *     description="Everything about Blockeds / UserBlocked",
 * )
 */


/**
 * @OA\Get(
 *      path="/v1/blocked-users",
 *      operationId="usersBlocked",
 *      tags={"Blockeds"},
 *      summary="Get list of UserBlocked",
 *      description="Returns list of UserBlocked",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserFollowedResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of UserBlocked
 */


/**
 * @OA\Post(
 *      path="/v1/user-block",
 *      operationId="blockRequest",
 *      tags={"Blockeds"},
 *      summary="Add user to block list",
 *      description="Add user to block list",
 *      @OA\RequestBody(
 *          required=true,
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserFollowed")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * @OA\Post(
 *      path="/v1/user-unblock",
 *      operationId="removeBlock",
 *      tags={"Blockeds"},
 *      summary="Unblock user from the block list",
 *      description="Unblock user from the block list",
 *      @OA\RequestBody(
 *          required=true,
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserFollowed")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * Class UserBlockedApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class UserBlockedApiController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function usersBlocked(Request $request)
    {
        try {
            Log::notice("\n\n".'::UserBlockedApiController::usersBlocked::$request');
            Log::notice($request->all());
            $loggedUser    = $request->user();
            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 20);

            $usersBlocked = UserBlocked::query()->where('state', UserBlocked::STATE['valid'])
                ->pluck('blocked_user_id')
                ->toArray();

            $user = User::query()->select('id', 'name', 'username', 'profession', 'ratings')
                ->selectRaw('CONCAT("/", username) AS profile_url')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture");

            $user->whereIn('id', $usersBlocked);

            $countUser = clone $user;

            $user = $user
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->toArray();

            if (empty($user)) {
                $response = response()->success(__('NO_BLOCKED_USERS'));

                Log::notice("\n\n".'::UserBlockedApiController::usersBlocked::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => __('LIST_BLOCKED_USERS'),
                'data'    => [
                    'user'       => $user,
                    'user_count' => $countUser->get()->count(),
                ],
            ]);

            Log::notice("\n\n".'::UserBlockedApiController::usersBlocked::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4400,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4400,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_4400, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function blockRequest(Request $request)
    {
        try {
            Log::notice("\n\n".'::UserBlockedApiController::blockRequest::$request');
            Log::notice($request->all());

            $blocked_user_id = $request->input('teacher_id');

            if (empty($blocked_user_id)) {
                $response = response()->error(__('ATTRIBUTE_REQUIRED', ['attribute' => 'Teacher ID']));

                Log::notice("\n\n".'::UserBlockedApiController::blockRequest::$response');
                Log::notice($response);

                return $response;
            }

            if (auth()->user()->id == $blocked_user_id) {
                $response = response()->error(__('REQUEST_FAILED'));

                Log::notice("\n\n".'::UserBlockedApiController::blockRequest::$response');
                Log::notice($response);

                return $response;
            }

            $alreadyBlocked = UserBlocked::query()->where('blocked_user_id', $blocked_user_id)
                ->where('state', UserBlocked::STATE['valid'])
                ->exists();

            if ($alreadyBlocked) {
                $response = response()->success(__('ALREADY_BLOCKED'));

                Log::notice("\n\n".'::UserBlockedApiController::blockRequest::$response');
                Log::notice($response);


                return $response;
            } else {

                DB::beginTransaction();

                $state   = UserBlocked::STATE['valid'];
                $message = __('SUCCESSFULLY_BLOCKED_USER');

                // Increment block in static metrics
                StaticMetric::query()->where('user_id', $blocked_user_id)->increment('received_blocks');
                StaticMetric::query()->where('user_id', $request->user()->id)->increment('my_blocked');

                $blockUser                  = new UserBlocked();
                $blockUser->state           = $state;
                $blockUser->blocked_user_id = $blocked_user_id;
                $blockUser->created_at      = now();
                $blockUser->save();

                $userFollowed      = UserFollowed::query()->where('user_id', auth()->user()->id)
                    ->where('follower_user_id', $blocked_user_id)
                    ->where('state', ' != ', UserFollowed::STATE['not_valid']);
                $userFollowedExist = clone $userFollowed;

                $userFollowed->update(['state' => UserFollowed::STATE['not_valid']]);

                if ($userFollowedExist->exists()) {
                    // Decrement follow in static metrics
                    if (StaticMetric::query()->where('user_id', $blocked_user_id)->value('received_followers') > 0) {
                        StaticMetric::query()->where('user_id', $blocked_user_id)->decrement('received_followers');
                    }
                    if (StaticMetric::query()->where('user_id', $blocked_user_id)->value('my_follows') > 0) {
                        StaticMetric::query()->where('user_id', $blocked_user_id)->decrement('my_follows');
                    }
                }

                DB::commit();

                $response = response()->success($message);

                Log::notice("\n\n".'::UserBlockedApiController::blockRequest::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4401,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message'  => 'Error: '.Handler::TYPE_EXCEPTION_4401,
            //     'message1' => $exception->getMessage(),
            //     'success'  => false,
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_4401, 500);
        }
    }


    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function removeBlock(Request $request)
    {
        try {
            Log::notice("\n\n".'::UserBlockedApiController::removeBlock::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $blocked_user_id = $request->input('teacher_id');

            $user = UserBlocked::query()->where('state', UserBlocked::STATE['valid'])
                ->where('user_id', $request->user()->id)
                ->where('blocked_user_id', $blocked_user_id)
                ->first();

            if (empty($user)) {
                $response = response()->success(__('NOT_BLOCKED_USER'));

                Log::notice("\n\n".'::UserBlockedApiController::removeBlock::$response');
                Log::notice($response);

                return $response;
            }
            $user->update(['state' => UserBlocked::STATE['not_valid']]);

            // Decrement follow in static metrics
            StaticMetric::query()->where('user_id', $blocked_user_id)->decrement('received_blocks');
            StaticMetric::query()->where('user_id', $request->user()->id)->decrement('my_blocked');

            DB::commit();

            $response = response()->success(__('SUCCESSFULLY_UNBLOCKED_USER'));

            Log::notice("\n\n".'::UserBlockedApiController::removeBlock::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4402,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4402,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_4402, 500);
        }
    }
}
