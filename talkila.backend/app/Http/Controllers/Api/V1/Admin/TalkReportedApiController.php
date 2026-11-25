<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\Talk;
use App\ModelsApi\TalkReported;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class TalkReportedApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class TalkReportedApiController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function reportTalk(Request $request)
    {
        try {
            Log::notice("\n\n".'::TalkReportedApiController::reportTalk::$request');
            Log::notice($request->all());

            $reporter_talk_id = $request->input('talk_id');
            $reason_id        = $request->input('reason_id');
            $reason_text      = $request->input('reason_text');

            $timeErrors = [];

            if (empty($reporter_talk_id)) {
                $timeErrors['teacher_id'] = 'Talk id is required';
            }

            if (empty($reason_id) && empty($reason_text)) {
                $timeErrors['reason'] = 'Reason id or reason text is required';
            }

            if (!empty($timeErrors)) {

                $response = response()->error([
                    'message' => __('FAILED_FIELDS'),
                    'data'    => [
                        'errors' => $timeErrors,
                    ],
                ], 400);

                Log::notice("\n\n".'::TalkReportedApiController::reportTalk::$response');
                Log::notice($response);

                return $response;
            }

            $requestedTalk = Talk::query()->where('id', $reporter_talk_id)->first();

            if (empty($requestedTalk)) {
                $response = response()->error(__('NO_REQUESTED_TALK'), 200);

                Log::notice("\n\n".'::TalkReportedApiController::reportTalk::$response');
                Log::notice($response);

                return $response;
            }

            if (auth()->user()->id == $requestedTalk->teacher_user_id) {
                $response = response()->error(__('REQUEST_FAILED'));

                Log::notice("\n\n".'::TalkReportedApiController::reportTalk::$response');
                Log::notice($response);

                return $response;
            }

            $alreadyReported = TalkReported::query()->where('reported_talk_id', $reporter_talk_id)
                ->where('state', TalkReported::STATE['valid'])
                ->exists();

            if ($alreadyReported) {
                $response = response()->success(__('TALK_ALREADY_REPORTED'));

                Log::notice("\n\n".'::TalkReportedApiController::reportTalk::$response');
                Log::notice($response);

                return $response;
            } else {
                DB::beginTransaction();

                $state   = TalkReported::STATE['valid'];
                $message = __('TALK_REPORTED');

                // Increment talks reported in static metrics
                StaticMetric::query()->where('user_id', $request->user()->id)->increment('talks_reported');

                $followUser                   = new TalkReported;
                $followUser->state            = $state;
                $followUser->reported_talk_id = $reporter_talk_id;
                $followUser->reason_id        = $reason_id;
                $followUser->reason_text      = $reason_text;
                $followUser->created_at       = date('Y-m-d H:i:s');
                $followUser->save();

                DB::commit();

                $response = response()->success($message);

                Log::notice("\n\n".'::TalkReportedApiController::reportTalk::$response');
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
