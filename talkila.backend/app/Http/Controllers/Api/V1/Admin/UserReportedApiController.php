<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\User;
use App\ModelsApi\UserReported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Reported users",
 *     description="Everything about Reported users / UserReported",
 * )
 */


/**
 * @OA\Get(
 *      path="/v1/blocked-users",
 *      operationId="usersBlocked",
 *      tags={"Reported users"},
 *      summary="Get list of UserReported",
 *      description="Returns list of UserReported",
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
 * Returns list of UserReported
 */


/**
 * @OA\Post(
 *      path="/v1/user-report",
 *      operationId="reportUser",
 *      tags={"Reported users"},
 *      summary="Add user to report list",
 *      description="Add user to report list",
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
 * Class UserReportedApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class UserReportedApiController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function usersReported(Request $request)
    {
        try {
            Log::notice("\n\n".'::UserReportedApiController::usersReported::$request');
            Log::notice($request->all());
            $loggedUser    = $request->user();
            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 20);

            $usersReported = UserReported::query()->where('state', UserReported::STATE['valid'])
                ->pluck('reporter_user_id')
                ->toArray();

            $user = User::query()->select('id', 'name', 'username', 'profession', 'ratings')
                ->selectRaw('CONCAT("/", username) AS profile_url')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture");

            $user->whereIn('id', $usersReported);

            $countUser = clone $user;

            $user = $user
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->toArray();

            if (empty($user)) {
                $response = response()->success(__('NO_REPORTED_USERS'));

                Log::notice("\n\n".'::UserReportedApiController::usersReported::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => __('LIST_REPORTED_USERS'),
                'data'    => [
                    'user'       => $user,
                    'user_count' => $countUser->get()->count(),
                ],
            ]);

            Log::notice("\n\n".'::UserReportedApiController::usersReported::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4500,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_4500, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function reportUser(Request $request)
    {
        try {
            Log::notice("\n\n".'::UserReportedApiController::reportUser::$request');
            Log::notice($request->all());

            $reporter_user_id = $request->input('teacher_id');
            $reason_id        = $request->input('reason_id');
            $reason_text      = $request->input('reason_text');

            $timeErrors = [];

            if (empty($reporter_user_id)) {
                $timeErrors['teacher_id'] = 'Teacher id is required';
            }

            if (empty($reason_id) && empty($reason_text)) {
                $timeErrors['reason'] = 'Reason id or reason text is required';
            }

            if (!empty($timeErrors)) {
                // $response = response()->json([
                //     'errors'  => $timeErrors,
                //     'message' => 'Not sent all required data for the finish of the report.',
                //     'success' => false,
                // ], 200);

                $response = response()->error([
                    'message' => 'Not sent all required data for the finish of the report.',
                    'data'    => [
                        'errors' => $timeErrors,
                    ],
                ]);

                Log::notice("\n\n".'::UserReportedApiController::reportUser::$response');
                Log::notice($response);

                return $response;
            }

            if (auth()->user()->id == $reporter_user_id) {
                $response = response()->error(__('REQUEST_FAILED'));

                Log::notice("\n\n".'::UserReportedApiController::reportUser::$response');
                Log::notice($response);

                return $response;
            }

            $alreadyReported = UserReported::query()->where('reporter_user_id', $reporter_user_id)
                ->where('state', UserReported::STATE['valid'])
                ->exists();

            if ($alreadyReported) {
                $response = response()->success(__('ALREADY_REPORTED'));

                Log::notice("\n\n".'::UserReportedApiController::reportUser::$response');
                Log::notice($response);

                return $response;
            } else {
                DB::beginTransaction();

                $state   = UserReported::STATE['valid'];
                $message = __('SUCCESSFULLY_REPORTED_USER');

                // Increment report in static metrics
                StaticMetric::query()->where('user_id', $reporter_user_id)->increment('received_reports');
                StaticMetric::query()->where('user_id', $request->user()->id)->increment('my_reports');


                $followUser                   = new UserReported;
                $followUser->state            = $state;
                $followUser->reporter_user_id = $reporter_user_id;
                $followUser->reason_id        = $reason_id;
                $followUser->description      = $reason_text;
                $followUser->created_at       = date('Y-m-d H:i:s');
                $followUser->save();

                DB::commit();

                $response = response()->success($message);

                Log::notice("\n\n".'::UserReportedApiController::reportUser::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4501,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message'  => 'Error: '.Handler::TYPE_EXCEPTION_4501,
            //     'message1' => $exception->getMessage(),
            //     'success'  => false,
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_4501, 500);
        }
    }
}
