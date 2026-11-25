<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Notifications as NotificationsModel;
use App\ModelsApi\Notifications;
use App\ModelsApi\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotificationsApiController extends Controller
{
    /**
     * @param  Request  $request
     * @param           $data
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public static function sendNotification(Request $request, $data)
    {
        try {
            Log::notice("\n\n" . '::NotificationsApiController::sendNotification::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::NotificationsApiController::sendNotification::$data');
            Log::notice($data);

            $payload = [];
            $type    = '';

            if (! empty($data['type'])) {
                if (! empty($data['param_type'])) {
                    $payload[$data['param_type']]         = $data['type'];
                    $payload[$data['param_type'] . '_id'] = $data['param_id'];
                }

                if (! empty($data['username'])) {
                    $payload['username'] = $data['username'];
                }

                if (! empty($data['supplier_id'])) {
                    $payload['supplier_id'] = $data['supplier_id'];
                }

                if (! empty($data['talkSupplier'])) {
                    $payload['talkSupplier'] = $data['talkSupplier'];
                }

                if (! empty($data['talkName'])) {
                    $payload['talkName'] = $data['talkName'];
                }

                if (! empty($data['talkDate'])) {
                    $payload['talkDate'] = $data['talkDate'];
                }

                if (! empty($data['talkTime'])) {
                    $payload['talkTime'] = $data['talkTime'];
                }

                $type = $data['type'];
            }

            DB::beginTransaction();

            $newNotification            = new Notifications;
            $newNotification->users_id  = $data['user_id'];
            $newNotification->type      = $type;
            $newNotification->values    = $data['value'];
            $newNotification->pushed_at = date('Y-m-d H:i:s');
            $newNotification->state     = Notifications::STATE['new'];
            $newNotification->payload   = ! empty($payload) ? $payload : null;
            $newNotification->save();

            DB::commit();
            // $response = response()->json([
            //     'message' => __("NOTIFICATION_SUCCESS_CREATED"),
            //     'success' => true
            // ], 200);

            $response = response()->success(__("NOTIFICATION_SUCCESS_CREATED"));

            Log::notice("\n\n" . '::NotificationsApiController::sendNotification::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3002,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3002,
            //     'success' => false
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3002, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function getNotifications(Request $request)
    {
        try {
            Log::notice("\n\n" . '::NotificationsApiController::notifications::$request');
            Log::notice($request->all());

            $displayOffset = $request->input('offset', 0);
            $displayLimit  = $request->input('limit', 15);
            $loggedUser    = $request->user();

            $user = User::query()
                ->select('id')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture");

            $notificationUserCount = Notifications::query()
                ->where('users_id', $request->user()->id)
                ->count();

            $timezone               = $request->header('Time-Zone-Offset-UTC') ?? $request->user()->timezone;
            $requestTimezoneHour    = abs((int)(($timezone) / 60));
            $requestTimezoneMinutes = abs((int)(($timezone) % 60));
            $requestTimezoneSign    = $timezone > 0 ? '+' : '-';
            $calculatedTimezone     = $requestTimezoneSign . $requestTimezoneHour . ":" . $requestTimezoneMinutes;

            $notifications = Notifications::query()
                ->select([
                    'notifications.id',
                    'users_id',
                    'type',
                    'values',
                    'state',
                    'payload',
                    'profile_picture',
                ])
                ->selectRaw("TO_CHAR(pushed_at + INTERVAL '$calculatedTimezone', 'YYYY-MM-DD HH24:MI:SS') AS pushed_at")
                ->selectRaw("TO_CHAR(pushed_at + INTERVAL '$calculatedTimezone', 'DD.MM.YYYY') AS pushed_date")
                ->selectRaw("TO_CHAR(pushed_at + INTERVAL '$calculatedTimezone', 'HH24:MI:SS') AS pushed_time")
                ->where('users_id', $request->user()->id)
                ->leftJoinSub($user, 'users', function ($join) {
                    $join->on('users.id', '=', 'notifications.users_id');
                })
                ->orderByDesc('created_at')
                ->offset($displayOffset)
                ->limit($displayLimit);

            $notificationIds = clone $notifications;
            $notifications   = $notifications->get()->toArray();

            if (empty($notifications)) {
                $response = response()->success(__('NO_NOTIFICATIONS'));

                Log::notice("\n\n" . '::NotificationsApiController::notifications::$response');
                Log::notice($response);

                return $response;
            }

            app()->setlocale($request->user()->last_language ?? $request->header('Application-Language', 'de'));

            foreach ($notifications as &$notification) {
                Log::notice("\n\n" . 'NOTIFICATION_' . $notification['values']);
                Log::notice($notification['payload']);
                if (empty($notification['payload'])) {
                    $payloadTmp = [];
                } else {
                    $payloadTmp = $notification['payload'];
                }
                $notification['message'] = __('NOTIFICATION_' . $notification['values'], $payloadTmp);

                $payloadTmp = array_merge($payloadTmp, [
                    'dateTalk' => $notification['pushed_date'],
                    'timeTalk' => $notification['pushed_time'],
                ]);

                if ($notification['values'] == NotificationsModel::VALUE['canceled_by_supplier']) {
                    $notification['message'] = __('NOTIFICATION_TALK_CANCELED_BY_SUPPLIER_BODY', $payloadTmp);
                }

                // Appends Supplier full name to the notification.
                // if ($notification['values'] == NotificationsModel::VALUE['following_user']) {
                //     $notification['message'] = isset($notification['payload']['username_of_teacher']) ? $notification['message'] . ' ' . $notification['payload']['username_of_teacher'] : $notification['message'];
                // }

                // Appends Talk name to the notification.
                // else {
                //     $notification['message'] = isset($notification['payload']['name_of_talk']) ? $notification['message'] . ' ' . $notification['payload']['name_of_talk'] : $notification['message'];
                // }
            }

            $notificationIds = $notificationIds
                ->where('state', Notifications::STATE['new'])
                ->pluck('id')
                ->toArray();

            DB::beginTransaction();
            $seenNotifications = $this->seenNotification($request, $notificationIds)->getData(true);

            if (! $seenNotifications['success']) {
                DB::rollBack();
            }

            DB::commit();

            $response = response()->success([
                'message' => 'Logged in user notifications',
                'data'    => [
                    'notifications'      => $notifications,
                    'notificationsCount' => $notificationUserCount,
                ],
            ]);

            Log::notice("\n\n" . '::NotificationsApiController::notifications::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3000,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3000,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3000, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param  null     $notificationIds
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function seenNotification(Request $request, $notificationIds = null)
    {
        try {
            Log::notice("\n\n" . '::NotificationsApiController::seenNotification::$request');
            Log::notice($request->all());

            if (empty($notificationIds)) {
                $notificationIds = $request->input('notification_ids', []);
            }
            DB::beginTransaction();

            Notifications::query()->whereIn('id', $notificationIds)
                ->update(['state' => Notifications::STATE['seen']]);
            DB::commit();

            $response = response()->success(__('SUCCESSFULLY_SEEN_NOTIFICATION'));

            Log::notice("\n\n" . '::NotificationsApiController::seenNotification::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3003,
                self::class,
                __FUNCTION__
            );
            //
            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3003,
            //     'success' => false
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3003, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countUnreadNotifications(Request $request)
    {
        try {
            Log::notice("\n\n" . '::NotificationsApiController::countNotifications::$request');
            Log::notice($request->all());

            $notificationsCount = Notifications::query()
                ->where('state', Notifications::STATE['new'])
                ->where('users_id', optional($request->user())->id)
                ->count();

            // $response = response()->json([
            //     'data'    => $notificationsCount,
            //     'message' => __("COUNT_UNREAD_NOTIFICATIONS"),
            //     'success' => true,
            // ], 200);

            $response = response()->success([
                'message' => __("COUNT_UNREAD_NOTIFICATIONS"),
                'data'    => [
                    'notificationsCount' => $notificationsCount,
                ],
            ]);

            Log::notice("\n\n" . '::NotificationsApiController::countNotifications::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3001,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3001,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3001, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param  null     $notificationIds
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function seenAllNotifications(Request $request, $notificationIds = null)
    {
        try {
            Log::notice("\n\n" . '::NotificationsApiController::seenAllNotifications::$response');
            Log::notice($request->all());


            if (empty($notificationIds)) {
                $notificationIds = $request->input('notification_ids', []);
            }
            DB::beginTransaction();

            Notifications::query()->whereIn('id', $notificationIds)
                ->where('users_id', $request->user()->id)
                ->update(['state' => Notifications::STATE['seen']]);

            DB::commit();

            $response = response()->success(__('SUCCESSFULLY_SEEN_NOTIFICATION'));

            Log::notice("\n\n" . '::NotificationsApiController::seenAllNotifications::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3004,
                self::class,
                __FUNCTION__
            );
            //
            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3004,
            //     'success' => false
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3004, 500);
        }
    }

    /**
     * Read User notification.
     *
     * @param  Notifications  $notification
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function read(Notifications $notification): JsonResponse
    {
        Log::notice("\n\n" . '::NotificationsApiController::read::$notification');
        Log::notice(json_encode($notification));

        if ($this->markAsRead($notification)) {
            $response = response()->success(__('SUCCESSFULLY_READ_NOTIFICATION'));
        } else {
            $response = response()->error(__('ERROR_UPDATING_NOTIFICATION'), 500);
        }

        Log::notice("\n\n" . '::NotificationsApiController::read::$response');
        Log::notice(json_encode($response));

        return $response;
    }

    /**
     * Read all User notifications.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function readAll(Request $request): JsonResponse
    {
        Log::notice("\n\n" . '::NotificationsApiController::readAll::$request');
        Log::notice(json_encode($request->all()));

        if ($this->markAsRead()) {
            $response = response()->success(__('SUCCESSFULLY_READ_NOTIFICATIONS'));
        } else {
            $response = response()->error(__('ERROR_UPDATING_NOTIFICATIONS'), 500);
        }

        Log::notice("\n\n" . '::NotificationsApiController::readAll::$response');
        Log::notice(json_encode($response));

        return $response;
    }

    /**
     * Soft delete User notifications.
     *
     * @param  Notifications  $notification
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Notifications $notification): JsonResponse
    {
        Log::notice("\n\n" . '::NotificationsApiController::destroy::$notification');
        Log::notice(json_encode($notification));

        if ($this->softDelete($notification)) {
            $response = response()->success(__('SUCCESSFULLY_DELETED_NOTIFICATION'));
        } else {
            $response = response()->error(__('ERROR_DELETING_NOTIFICATION'), 500);
        }

        Log::notice("\n\n" . '::NotificationsApiController::destroy::$response');
        Log::notice(json_encode($response));

        return $response;
    }

    /**
     * Soft delete all User notifications.
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroyAll(Request $request): JsonResponse
    {
        Log::notice("\n\n" . '::NotificationsApiController::destroyAll::$request');
        Log::notice(json_encode($request));

        if ($this->softDelete()) {
            $response = response()->success(__('SUCCESSFULLY_DELETED_NOTIFICATION'));
        } else {
            $response = response()->error(__('ERROR_DELETING_NOTIFICATION'), 500);
        }

        Log::notice("\n\n" . '::NotificationsApiController::destroy::$response');
        Log::notice(json_encode($response));

        return $response;
    }

    /**
     * Mark notification as read.
     *
     * @param  Notifications|null  $notification
     *
     * @return bool
     * @throws Throwable
     */
    private function markAsRead(Notifications $notification = null): bool
    {
        try {
            DB::beginTransaction();

            if ($notification) {
                Log::notice("\n\n" . '::NotificationsApiController::markAsRead::$notification');
                Log::notice(json_encode($notification));

                if ($notification->users_id !== request()->user()->id) {
                    return false;
                }

                $notification->update([
                    'state' => Notifications::STATE['read'],
                ]);
            } else {
                Log::notice("\n\n" . '::NotificationsApiController::markAsRead::$request');
                Log::notice(json_encode(request()->all()));

                Notifications::query()
                    ->where('users_id', request()->user()->id)
                    ->where('state', '!=', Notifications::STATE['read'])
                    ->update([
                        'state' => Notifications::STATE['read'],
                    ]);
            }

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3007,
                self::class,
                __FUNCTION__
            );

            return false;
        }
    }

    /**
     * Soft delete notifications.
     *
     * @param  Notifications|null  $notification
     *
     * @return bool
     * @throws Throwable
     */
    private function softDelete(Notifications $notification = null): bool
    {
        try {
            DB::beginTransaction();

            if ($notification) {
                Log::notice("\n\n" . '::NotificationsApiController::softDelete::$notification');
                Log::notice(json_encode($notification));

                if ($notification->users_id !== request()->user()->id) {
                    return false;
                }

                $notification->delete();
            } else {
                Log::notice("\n\n" . '::NotificationsApiController::softDelete::$request->all()');
                Log::notice(json_encode(request()->all()));

                Notifications::query()
                    ->where('users_id', request()->user()->id)
                    ->delete();
            }

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3008,
                self::class,
                __FUNCTION__
            );

            return false;
        }
    }
}
