<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\ModelsApi\AppFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Class FeedbackApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */

/**
 * @OA\Tag(
 *     name="AppFeedback",
 *     description="Everything about AppFeedback",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/app-feedback",
 *      operationId="appFeedback",
 *      tags={"AppFeedback"},
 *      summary="Method appFeedback of AppFeedbackApiController",
 *      description="Method appFeedback of AppFeedbackApiController",
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
 *      path="/v1/send-feedback",
 *      operationId="sendFeedback",
 *      tags={"AppFeedback"},
 *      summary="Method sendFeedback of AppFeedbackApiController",
 *      description="Method sendFeedback of AppFeedbackApiController",
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
class AppFeedbackApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appFeedback(Request $request)
    {
        try {
            Log::notice("\n\n" . '::AppFeedbackApiControllerA::appFeedback::$request');
            Log::notice($request->all());

            $appFeedback = AppFeedback::query()->select('rating', 'comment')
                                               ->where('state', AppFeedback::STATE['active'])
                                               ->first();

            if (empty($appFeedback)) {
                $response = response()->json([
                    'message'   => 'There is no feedback for application',
                    'success'   => true
                ], 200);

                Log::notice("\n\n" . '::AppFeedbackApiControllerA::appFeedback::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $appFeedback->toArray(),
                'message' => 'Application feedback.',
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::AppFeedbackApiControllerA::appFeedback::$response');
            Log::notice($response);

            return $response;

        } catch (\Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2000, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_2000,
                'success' => false
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function sendFeedback(Request $request)
    {
        try {
            Log::notice("\n\n" . '::AppFeedbackApiControllerA::sendFeedback::$request');
            Log::notice($request->all());

            $user       = $request->user();
            $rating     = $request->input('rating');
            $comment    = $request->input('comment');
            $dataErrors = [];

            if(!isset($rating) || (!is_numeric($rating) && isset($rating))) {
                $dataErrors['rating'] = [
                    __('ATTRIBUTE_REQUIRED', ['attribute' => 'rating'])
                ];
            }

            if (!empty($dataErrors)) {
                $response = response()->json([
                    'errors'    => $dataErrors,
                    'message'   => __('REQUIRED_FIELDS'),
                    'success'   => false
                ], 200);

                Log::notice("\n\n" . '::AppFeedbackApiControllerA::sendFeedback::$response');
                Log::notice($response);

                return $response;
            }
            DB::beginTransaction();

            $appFeedback = AppFeedback::query()->where('state', AppFeedback::STATE['active'])->first();

            if (!empty($appFeedback)) {
                $appFeedback->update(['state' =>  AppFeedback::STATE['inactive']]);
            }

            AppFeedback::query()->create($request->all());

            Mail::to('feedback@talkila.com')->queue(new \App\Mail\AppFeedback($user->username, $rating, $comment, date('Y-m-d H:i:s')));

            $response = response()->json([
                'message' => 'Successfully sent feedback of application.',
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::AppFeedbackApiControllerA::sendFeedback::$response');
            Log::notice($response);

            DB::commit();

            return $response;

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2001, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_2001,
                'success' => false
            ], 500);
        }
    }
}
