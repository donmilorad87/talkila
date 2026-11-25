<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\UserTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequests\StoreAvailabilityRequest;
use App\Http\Requests\ApiRequests\StoreBillingAddressRequest;
use App\Mail\BillingInformationAdded;
use App\Mail\BillingInformationChanged;
use App\Mail\JtcFinished;
use App\Models\JoinTheClub;
use App\ModelsApi\Availability;
use App\ModelsApi\BillingAddress;
use App\ModelsApi\Country;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @OA\Tag(
 *     name="JoinTheClub/Availability",
 *     description="API Endpoints of JoinTheClub/Availability"
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/join-the-club-availabilities",
 *      operationId="getUserAvailability",
 *      tags={"JoinTheClub"},
 *      summary="Method getUserAvailability of JoinTheClubApiController",
 *      description="Method getUserAvailability of JoinTheClubApiController",
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
 *      path="/v1/join-the-club-availability",
 *      operationId="joinTheClubAvailability",
 *      tags={"JoinTheClub"},
 *      summary="Method joinTheClubAvailability of JoinTheClubApiController",
 *      description="Method joinTheClubAvailability of JoinTheClubApiController",
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
 * @OA\Delete(
 *      path="/v1/join-the-club-delete-availability/{id}",
 *      operationId="joinTheClubDeleteAvailability",
 *      tags={"JoinTheClub"},
 *      summary="Method joinTheClubDeleteAvailability of JoinTheClubApiController",
 *      description="Method joinTheClubDeleteAvailability of JoinTheClubApiController",
 *
 *      @OA\Response(
 *          response=204,
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
 *      path="/v1/join-the-club-accounting",
 *      operationId="joinTheClubAccounting",
 *      tags={"JoinTheClub"},
 *      summary="Method joinTheClubAccounting of JoinTheClubApiController",
 *      description="Method joinTheClubAccounting of JoinTheClubApiController",
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
 * @OA\Get(
 *      path="/v1/join-the-club-completed",
 *      operationId="joinTheClubAvailabilityCompleted",
 *      tags={"JoinTheClub"},
 *      summary="Method joinTheClubAvailabilityCompleted of JoinTheClubApiController",
 *      description="Method joinTheClubAvailabilityCompleted of JoinTheClubApiController",
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
class JoinTheClubApiController extends Controller
{
    /**
     * A User model.
     */
    public User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param  Request  $request
     * @param  null     $requested_user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public static function joinTheClubAvailabilityCompleted(Request $request, $requested_user = null)
    {
        try {
            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailabilityCompleted::$request');
            Log::notice($request->all());

            if (!empty($requested_user)) {
                $userId = $requested_user;
            } else {
                $userId = $request->user()->id;
            }

            DB::beginTransaction();

            $joinTheClub = JoinTheClub::query()->where('users_id', $userId)->first();

            if (!$joinTheClub) {
                DB::rollBack();
                return response()->json([
                    'message' => 'JoinTheClub record not found for user.',
                    'data'    => [
                        'jtc_started'    => false,
                        'step_1'         => false,
                        'step_2'         => false,
                        'step_3'         => false,
                        'step_4'         => false,
                        'jtc_completed'  => false,
                    ],
                    'success' => true,
                ]);
            }

            $started              = $joinTheClub->jtc_started;
            $existingBasicInfo    = $joinTheClub->step_1;
            $existingTalks        = $joinTheClub->step_2;
            $existingAvailability = $joinTheClub->step_3;
            $existingVerification = $joinTheClub->step_4;

            if ($joinTheClub->state == 0 && $existingBasicInfo && $existingTalks && $existingAvailability && $existingVerification) {
                User::query()->find($request->user()->id)->update(['type' => User::TYPE['supplier']]);
                $joinTheClub->update(['state' => JoinTheClub::STATE['sent_notification']]);

                // Mail::to($request->user()->email)->queue(new UpgradeTeacherAccount($request->user()->email, $request->user()->username, $existingTalks, $existingClubPrice, $existingAvailability, $existingAccounting, $existingBasicInfo));
                $billingInformation = BillingAddress::query()->where('user_id', $userId)->where('state', true)->with('countries')->first();

                // Setting App language prior to sending an e-mail.
                app()->setLocale($request->user()->last_language);

                // TODO: Change email content in case the user has skipped Verification. Email should point to Admin Panel Users section with user pre-selected.
                Mail::to($request->user()->email)->queue(new JtcFinished($request->user()->email, $request->user()->name, $request->user()->username, $billingInformation->company_name, $billingInformation->street, $billingInformation->city, $billingInformation->zipcode, $billingInformation->tax_number, $billingInformation->countries->name));

                StaticMetric::query()->where('user_id', $request->user()->id)->increment('received_emails');

                // NotifyUserProfileConfirmedAsTeacher::dispatch($request->user()->id);
                //
                // $notificationData = [
                //     'user_id' => $userId,
                //     'type'    => 'custom',
                //     'value'   => 402,
                // ];
                //
                // $notification = NotificationsApiController::sendNotification($request, $notificationData);
                //
                // Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailabilityCompleted::$notification');
                // Log::notice($notification);
            }
            DB::commit();
            $response = response()->json([
                'data'    => [
                    'jtc_started'         => $started,
                    'step_basic_info'     => $existingBasicInfo,
                    'step_talks'          => $existingTalks,
                    'step_availabilities' => $existingAvailability,
                    'step_verification'   => $existingVerification,
                ],
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailabilityCompleted::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2800, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2800,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAvailability(Request $request)
    {
        try {
            Log::notice("\n\n" . '::JoinTheClubApiController::getUserAvailability::$request');
            Log::notice($request->all());

            $requestTimezoneHour    = abs((int)(($request->user()->timezone) / 60));
            $requestTimezoneMinutes = abs((int)(($request->user()->timezone) % 60));
            $requestTimezoneSign    = $request->user()->timezone < 0 ? '-' : '+';

            if ($request->has('user_id') && $request->input('user_id')) {
                $user_id = $request->input('user_id');
            } else {
                $user_id = $request->user()->id;
            }

            $availability = \App\Models\Availability::query()
                ->select(['id', 'weekday', 'state', 'start_time', 'end_time'])
                //->selectRaw("DATE_FORMAT(CONVERT_TZ(start_time,'+00:00','" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . "'),'%H:%i:%s') AS start_time, DATE_FORMAT(CONVERT_TZ(end_time,'+00:00','" . $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes . "'),'%H:%i:%s') AS end_time")
                ->where('user_id', $user_id)
                ->when($user_id != $request->user()->id, function ($query) {
                    $query->where('state', 1);
                })
                ->orderBy('weekday')
                ->orderBy('start_time')
                ->get()
                ->toArray();

            $adjustedAvailability = [];

            foreach ($availability as $value) {
                $start_time = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($value['start_time'])));
                $end_time   = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($value['end_time'])));

                $start_time_control_date = date('Y-m-d', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($value['start_time'])));
                $today_date              = date('Y-m-d');

                $weekday = $value['weekday'];
                if ($start_time_control_date > $today_date) {
                    ++$weekday;

                    if ($weekday > 7) {
                        $weekday = 1;
                    }
                } else {
                    if ($start_time_control_date < $today_date) {
                        --$weekday;

                        if ($weekday < 1) {
                            $weekday = 7;
                        }
                    }
                }

                $value['start_time'] = $start_time;
                $value['end_time']   = $end_time;
                $value['weekday']    = $weekday;

                $adjustedAvailability[] = $value;
            }

            if (empty($adjustedAvailability)) {
                $response = response()->json([
                    'message' => 'Logged in user dont have set availability.',
                    'success' => true,
                ]);

                Log::notice("\n\n" . '::JoinTheClubApiController::getUserAvailability::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => 'Teacher availabilities',
                'data'    => [
                    'availabilities' => $adjustedAvailability,
                ],
            ]);

            Log::notice("\n\n" . '::JoinTheClubApiController::getUserAvailability::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2801, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2801,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  StoreAvailabilityRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function joinTheClubAvailability(StoreAvailabilityRequest $request)
    {
        try {
            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailability::$request');
            Log::notice($request->all());

            $timezone               = intval($request->header('Time-Zone-Offset-UTC') ?? $request->user()->timezone);
            $requestTimezoneHour    = abs($timezone / 60);
            $requestTimezoneMinutes = abs($timezone % 60);
            $requestTimezoneSign    = $timezone < 0 ? '+' : '-';
            $timezoneDifference     = "{$requestTimezoneSign}{$requestTimezoneHour}:{$requestTimezoneMinutes}";

            DB::beginTransaction();

            $dataErrors = [];
            $weekday    = $request->input('weekday');

            if (empty($request->input('start_time'))) {
                $dataErrors['start_time'] = [
                    'The start time value is required.',
                ];
            }
            if (empty($request->input('end_time'))) {
                $dataErrors['end_time'] = [
                    'The end time value is required.',
                ];
            }
            if (empty($weekday)) {
                $dataErrors['weekday'] = [
                    'The weekday value is required.',
                ];
            }

            if (!empty($dataErrors)) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'The given data was invalid.',
                    'errors'  => $dataErrors,
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailability::$response');
                Log::notice($response);

                return $response;
            }

            // This is original time from user and check is start time lower then end time
            if (strtotime($request->input('start_time')) > strtotime($request->input('end_time'))) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'Requested end time cannot be lower from start time.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailability::$response');
                Log::notice($response);

                return $response;
            }

            $start_time = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($request->input('start_time'))));
            $end_time   = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($request->input('end_time'))));

            $start_time_control_date = date('Y-m-d', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime($request->input('start_time'))));
            $today_date              = date('Y-m-d');

            if ($start_time_control_date > $today_date) {
                ++$weekday;

                if ($weekday > 7) {
                    $weekday = 1;
                }
            } else {
                if ($start_time_control_date < $today_date) {
                    --$weekday;

                    if ($weekday < 1) {
                        $weekday = 7;
                    }
                }
            }

            $newAvailability = new Availability;

            $availabilityId = $request->input('id') > 0 ? $request->input('id') : null;
            $stateFromInput = (!empty($request->input('state')) || $request->input('state') == 0) ? $request->input('state') : Availability::STATE['valid'];

            if ($availabilityId > 0) {
                $newAvailability = \App\Models\Availability::query()->whereKey($availabilityId)->first();

                if (!$newAvailability) {
                    return response()->error(__('SOMETHING_WENT_WRONG'), Response::HTTP_NOT_FOUND);
                }

                $newAvailability->state      = $stateFromInput;
                $newAvailability->start_time = $start_time;
                $newAvailability->end_time   = $end_time;
                $newAvailability->save();
            }

            if ($stateFromInput == Availability::STATE['valid']) {
                $existingAvailability = $this->checkExistAvailability($request->user()->id, $weekday, $start_time, $end_time)->getData(true);
                if (!empty($existingAvailability['data'])) {
                    foreach ($existingAvailability['data'] as $index => $tmpAvailability) {
                        if ($index == 0) {
                            $newAvailability = Availability::query()->where('id', $tmpAvailability['id'])->first();
                        } else {
                            Availability::query()->where('id', $tmpAvailability['id'])->delete();
                        }

                        if ($tmpAvailability['start_time'] < $start_time) {
                            $start_time = $tmpAvailability['start_time'];
                        }

                        if ($tmpAvailability['end_time'] > $end_time) {
                            $end_time = $tmpAvailability['end_time'];
                        }
                    }
                }

                $noAvailabilities = $this->countActiveAvailabilities($request, $weekday, $newAvailability->id);

                if (!$noAvailabilities) {
                    DB::rollBack();
                    $response = response()->json([
                        'message' => 'Cannot have more then two active availability in one day',
                        'success' => false,
                    ], 200);

                    Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailability::$response');
                    Log::notice($response);

                    return $response;
                }

                // $joinTheClubStepThree = JoinTheClub::query()->where('users_id', $request->user()->id)->first();
                //
                // if ($joinTheClubStepThree->step_3 != 1) {
                //     $joinTheClubStepThree->update(['step_3' => 1]);
                // }

                $newAvailability->weekday    = $weekday;
                $newAvailability->start_time = $start_time;
                $newAvailability->end_time   = $end_time;
                $newAvailability->state      = $stateFromInput;
                $newAvailability->save();
            }

            DB::commit();

            // We are flipping the timezone sign, in order to retrieve the data accurately.
            $requestTimezoneSign = $timezone < 0 ? '-' : '+';
            $timezoneDifference  = "{$requestTimezoneSign}{$requestTimezoneHour}:{$requestTimezoneMinutes}";

            $availabilities = $request->user()
                ->availabilities()
                ->select(['id', 'weekday', 'state'])
                ->selectRaw("TO_CHAR(start_time + INTERVAL '{$timezoneDifference}', 'HH24:MI:SS') AS start_time")
                ->selectRaw("TO_CHAR(end_time + INTERVAL '{$timezoneDifference}', 'HH24:MI:SS') AS end_time")
                ->orderBy('weekday')
                ->orderBy('start_time')
                ->get();

            if (is_null($availabilityId)) {
                $message = __('SUCCESSFULLY_ADDED_AVAILABILITY');
                $status  = Response::HTTP_CREATED;
            } else {
                if ($newAvailability->state) {
                    $message = __('SUCCESSFULLY_UNPAUSED_AVAILABILITY');
                } else {
                    $message = __('SUCCESSFULLY_PAUSED_AVAILABILITY');
                }
            }

            $response = response()->success([
                'message' => $message,
                'data'    => [
                    'availabilities' => $availabilities,
                ],
            ], $status ?? Response::HTTP_CREATED);

            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAvailability::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2802, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2802,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param        $request
     * @param        $weekday
     * @param  null  $availabilityId
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function countActiveAvailabilities($request, $weekday, $availabilityId = null)
    {
        $timezone               = $request->user()->timezone;
        $requestTimezoneHour    = abs((int)(($timezone) / 60));
        $requestTimezoneMinutes = abs((int)(($timezone) % 60));
        $requestTimezoneSign    = $timezone < 0 ? '+' : '-';
        $timeDifference         = date('H:i:s', strtotime($requestTimezoneSign . $requestTimezoneHour . ' hours ' . $requestTimezoneSign . $requestTimezoneMinutes . ' minutes', strtotime('00:00:00')));

        $countAvailabilities = Availability::query()
            ->where('user_id', $request->user()->id)
            ->where('state', Availability::STATE['valid']);

        if (!empty($availabilityId)) {
            $countAvailabilities->where('id', '!=', $availabilityId);
        }

        $countAvailabilities->where(function ($q) use ($weekday, $timezone, $timeDifference, $requestTimezoneHour, $requestTimezoneMinutes, $requestTimezoneSign) {
            /* @var $q \Illuminate\Database\Eloquent\Builder */

            $q->where('weekday', $weekday);

            $q->orWhere(function ($q2) use ($weekday, $timezone, $timeDifference, $requestTimezoneHour, $requestTimezoneMinutes, $requestTimezoneSign) {
                /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                if ($timezone > 0) {
                    --$weekday;

                    if ($weekday < 1) {
                        $weekday = 7;
                    }
                    $q2->where('weekday', $weekday);
                    $q2->where(function ($q3) use ($timeDifference) {
                        /* @var $q3 \Illuminate\Database\Eloquent\Builder */

                        $q3->where('start_time', '>=', $timeDifference);
                        $q3->orWhere('end_time', '>=', $timeDifference);
                    });
                } else {
                    if ($timezone < 0) {
                        ++$weekday;

                        if ($weekday > 7) {
                            $weekday = 1;
                        }
                        $q2->where('weekday', $weekday);
                        $q2->where(function ($q3) use ($timeDifference) {
                            /* @var $q3 \Illuminate\Database\Eloquent\Builder */

                            $q3->where('start_time', '<=', $timeDifference);
                            $q3->orWhere('end_time', '<=', $timeDifference);
                        });
                    }
                }
            });
        });

        return $countAvailabilities->count() < 2 ? true : false;
    }

    /**
     * @param        $teacher_id
     * @param        $workday
     * @param        $start_time
     * @param        $end_time
     * @param  null  $availabilityId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkExistAvailability($teacher_id, $workday, $start_time, $end_time, $availabilityId = null)
    {
        Log::notice("\n\n" . '::JoinTheClubApiController::checkExistAvailability::$teacher_id');
        Log::notice([$teacher_id, $workday, $start_time, $end_time, $availabilityId]);

        try {
            $existingAvailability = Availability::query()->where('user_id', $teacher_id)
                ->where('weekday', $workday)
                ->where('state', Availability::STATE['valid'])
                ->where(function ($q) use ($start_time, $end_time) {
                    /* @var $q \Illuminate\Database\Eloquent\Builder */

                    $q->where(function ($q2) use ($start_time, $end_time) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->where('start_time', '>=', $start_time)->where('start_time', '<=', $end_time);
                    });

                    $q->orWhere(function ($q2) use ($start_time, $end_time) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->where('end_time', '>=', $start_time)->where('end_time', '<=', $end_time);
                    });

                    $q->orWhere('start_time', $start_time)->orWhere('end_time', $end_time);

                    $q->orWhere(function ($q2) use ($start_time, $end_time) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->whereRaw("'{$start_time}' >= start_time")->whereRaw("'{$start_time}' <= end_time");
                    });
                });

            if (!empty($availabilityId)) {
                $existingAvailability->where('id', '!=', $availabilityId);
            }

            $response = response()->json([
                'data'    => $existingAvailability->get(),
                'message' => 'Check if exist availability',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::JoinTheClubApiController::checkExistAvailability::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2803, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2803,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function joinTheClubDeleteAvailability($id)
    {
        try {
            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubDeleteAvailability::$id');
            Log::notice($id);

            DB::beginTransaction();

            $user                 = request()->user();
            $availabilities_count = $user->availabilities->count();

            if ($user->type == UserTypes::PROVIDER && $availabilities_count === 1) {
                $response = response()->json([
                    'success' => false,
                    'message' => __('CANNOT_DELETED_LAST_AVAILABILITY'),
                ]);

                Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubDeleteAvailability::$response');
                Log::notice($response);

                return $response;
            }

            $availability = Availability::query()->find($id);
            $availability->delete();

            if ($user->type != UserTypes::PROVIDER && $availabilities_count - 1 === 0) {
                $user->jtc()->update([
                    'step_3' => false,
                ]);
            }

            DB::commit();

            $response = response()->success(__('SUCCESSFULLY_DELETED_AVAILABILITY'));

            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubDeleteAvailability::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2805, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2805,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  StoreBillingAddressRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function joinTheClubAccounting(StoreBillingAddressRequest $request)
    {
        try {
            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAccounting::$request');
            Log::notice($request->all());

            $checkBillingAddress = BillingAddress::query()
                ->select(['id', 'street', 'street', 'zipcode', 'city', 'company_name', 'tax_number', 'iban_recipient_name', 'email'])
                ->where('state', BillingAddress::STATE['valid'])
                ->where('id', '!=', 1)
                ->where('user_id', $request->user()->id)
                ->where(function ($query) {
                    $query->whereNull('street');
                    $query->whereNull('zipcode');
                    $query->whereNull('city');
                    // $query->whereNull('company_name');
                    $query->whereNull('tax_number');
                })->where(function ($query) {
                    $query->whereNotNull('iban_recipient_name');
                    $query->orWhereNotNull('email');
                })
                ->first();

            $old_billing = $request->user()->billing;

            DB::beginTransaction();

            $user          = User::query()->where('id', $request->user()->id)->first();
            $new_country   = Country::query()->where('id', $request->input('countries_id'))->first();
            $localizedName = $this->getCountryNameLocalized($user->last_language);

            if (!empty($checkBillingAddress)) {
                $existingBillingAddress = $checkBillingAddress;
                $checkBillingAddress->update($request->all());
                $mailPointer = false;
            } else {
                $dataUpdate = $request->all();

                /* if ($request->has('billing_type')) {
                    if ($request->get('billing_type') === '0') {

                        $dataUpdate['type'] =  BillingAddress::TYPE['supplier'];
                    } else if ($request->get('billing_type') === '1') {

                        $dataUpdate['type'] = BillingAddress::TYPE['client'];
                    }
                } */

                if (!empty($request->input('id')) && $request->input('id') != null) {
                    $activeBilling                     = BillingAddress::query()->select('iban_recipient_name', 'email')->find($request->input('id'));
                    $dataUpdate['iban_recipient_name'] = $activeBilling->iban_recipient_name;
                    $dataUpdate['email']               = $activeBilling->email;

                    BillingAddress::query()->find($request->input('id'))->update(['state' => Availability::STATE['not_valid']]);
                    /* if ($dataUpdate['type'] !== BillingAddress::TYPE['client']) {
                        BillingAddress::query()->find($request->input('id'))->where('type', 0)->update(['state' => Availability::STATE['not_valid']]);
                    } */
                }

                $dataUpdate['user_id'] = $request->user()->id;

                /* if ($dataUpdate['type'] !== BillingAddress::TYPE['client']) {
                    $request->user()->billingAddress()->where('type', 0)->update(['state' => Availability::STATE['not_valid']]);
                } */
                $request->user()->billingAddress()->update(['state' => Availability::STATE['not_valid']]);
                $existingBillingAddress = BillingAddress::create($dataUpdate);

                $mailPointer = true;
            }

            $request->user()->update(['billing_address_id' => $existingBillingAddress->id]);
            $request->user()->update(['vat_id' => request()->input('countries_id')]);
            /*           dd(request()->all()); */
            if ($request->has('from_jtc')) {
                if ($request->get('from_jtc')) {
                    $joinTheClubStepFive = JoinTheClub::query()->where('users_id', $request->user()->id)->first();
                    if ($joinTheClubStepFive->step_5 != 1) {
                        $joinTheClubStepFive->update(['step_5' => 1]);
                    }
                }
            }

            if ($request->has('from_jtc') && $request->get('from_jtc')) {
                $joinTheClubStepFive = JoinTheClub::query()->where('users_id', $request->user()->id)->first();
                if ($joinTheClubStepFive->step_5 != 1) {
                    $joinTheClubStepFive->update(['step_5' => 1]);
                }
            }


            /* if($request->has('jtc_billing') || $request->has('settings_supplier')){
                $request->user()->billingAddress()->update(['TYPE' => BillingAddress::TYPE['supplier']]);
            }else if($request->has('settings_client')){
                $request->user()->billingAddress()->update(['TYPE' => BillingAddress::TYPE['client']]);
            } */

            if ($mailPointer && $old_billing) {
                $old_country = BillingAddress::query()->where('id', $user->billing_address_id)->first()->countries;

                $message = __('BILLING_INFO_SUCCESS_UPDATE');
                Mail::to($user->email)->queue(
                    new BillingInformationChanged(
                        $request->header('Application-Language', 'en'),
                        $user->email,
                        $old_billing->company_name,
                        $request->company_name,
                        $old_billing->street,
                        $request->street,
                        $old_billing->city,
                        $request->city,
                        $old_billing->zipcode,
                        $request->zipcode,
                        $old_billing->pays_vat ? __('INCLUDING_TAX') : __('EXCLUDING_TAX'),
                        $request->pays_vat ? __('INCLUDING_TAX') : __('EXCLUDING_TAX'),
                        $new_country->$localizedName,
                        $old_country->$localizedName,
                        // now()->toDateTimeString(),
                        convertToUserTimezone(now())
                    )
                );
            } else {
                $message = __('BILLING_INFO_SUCCESS_ADDED');
                Mail::to($user->email)->queue(
                    new BillingInformationAdded(
                        $request->header('Application-Language', 'en'),
                        $user->email,
                        $request->company_name,
                        $request->street,
                        $request->city,
                        $request->zipcode,
                        $request->tax_number,
                        $new_country->$localizedName,
                        $user->username
                    )
                );
            }


            DB::commit();

            $response = response()->json([
                'message' => $message,
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubAccounting::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2806, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2806,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Begin 'Join The Club' process.
     */
    public function joinTheClubStart()
    {
        $this->user->current()->startJTC();

        return response()->success(__('SUCCESSFULLY_STARTED_JTC_PROCESS'));
    }

    /**
     * Complete JTC step.
     *
     * @param  Request  $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function joinTheClubComplete(Request $request)
    {
        $request->validate([
            'step' => ['required', 'in:1,2,3,4'],
        ]);

        try {
            $user = $request->user();
            $step = $request->input('step');

            if ($step == 1 && !$user->isPartner()) {
                if (!$user->hasTalks()) {
                    $user->createTalks();
                }

                if (!$user->hasAvailabilities()) {
                    $user->createAvailabilities();
                }
            }

            if ($step == 4 && !$user->hasCompletedJTCStep(4) && $user->isPartner()) {
                $dashboard = $user->partner->dashboard;
                $dashboard->update([
                    'total_jtc_finished' => DB::raw('total_jtc_finished + 1'),
                ]);
            }

            $user->completeJTCStep($step);

            $addProfileVerificationObject = new JoinTheClubApiController();
            $addProfileVerificationObject->joinTheClubAvailabilityCompleted($request);

            $response = response()->success("JTC step {$step} completed successfully!");

            Log::notice("\n\n" . '::JoinTheClubApiController::joinTheClubComplete::$response');
            Log::notice(json_encode($response));

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2807, self::class, __FUNCTION__);

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    protected function getCountryNameLocalized($language)
    {
        switch ($language) {
            case 'en':
                return 'english';
            case 'en_GB':
                return 'english';
            case 'hr':
                return 'croatian';
            case 'pl':
                return 'polish';
            default:
                return 'german';
        }
    }
}
