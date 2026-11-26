<?php

namespace App\Models;

use App\Entity\Notification;
use App\Exceptions\Handler;
use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use App\ModelsApi\Availability;
use App\ModelsApi\DisposalDomain;
use App\ModelsApi\DisposalEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\HelperModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|HelperModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HelperModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HelperModel query()
 * @mixin \Eloquent
 */
class HelperModel extends Model
{
    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public static function getSql($builder, $string = false)
    {
        $sql      = $builder->toSql();
        $bindings = $builder->getBindings();

        foreach ($bindings as $binding) {
            $pos = strpos($sql, '?');

            if ($pos !== false) {
                $sql = substr_replace($sql, is_numeric($binding) || is_bool($binding) ? $binding : "'" . $binding . "'", $pos, strlen('?'));
            }
        }

        if ($string == true) {
            return $sql;
        } else {
            echo $sql;
            die();
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public static function maskString($payout, $maskingCharacter = '*')
    {
        $payoutValue = $payout->value;

        if ($payout->method == 1) {
            return substr($payoutValue, 0, 4) . str_repeat($maskingCharacter, strlen($payoutValue) - 4);
        } else {
            $firstPartEmail = strtok($payoutValue, '@');

            return substr($firstPartEmail, 0, 1) . str_repeat($maskingCharacter, strlen($firstPartEmail) - 1) . '@paypal.com';
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     */
    public static function validateEmail($registrationEmail)
    {
        try {
            $disposedEmail = DisposalEmail::query()->where('email', $registrationEmail)->exists();

            if ($disposedEmail) {
                //Increment statistics count if user try registration with forbidden email
                DisposalEmail::query()->where('email', $registrationEmail)->increment('statistics');

                $response = response()->error(__('EMAIL_BLOCKED'), 401);

                Log::notice('::AuthController::validateEmail::$disposedEmail');
                Log::notice($response);

                return $response;
            }

            $domain = explode('@', $registrationEmail)[1];

            $disposedDomain = DisposalDomain::query()->where('domain', $domain)->exists();

            if ($disposedDomain) {
                //Increment statistics count if user try registration with blocked domain
                DisposalDomain::query()->where('domain', $domain)->increment('statistics');

                $response = response()->error(__('DOMAIN_BLOCKED'), 401);

                Log::notice('::AuthController::validateEmail::$disposedDomain');
                Log::notice($response);

                return $response;
            }

            return response()->success(__('EMAIL_VALID'));
        } catch (\Exception $exception) {
            Log::error(var_export($exception, true));

            return response()->error(__('REQUEST_FAILED') . ' ' . $exception->getMessage(), 500);
        }
    }


    public static function validateName($requestedName)
    {
        try {
            $forbiddenName = StaticForbiddenName::query()->where('name', $requestedName)->exists();

            if ($forbiddenName) {
                //Increment statistics count if user try registration with forbidden name
                StaticForbiddenName::query()->where('name', $requestedName)->increment('statistics');

                $response = response()->error(__('NAME_OR_USERNAME_FORBIDDEN'), 200);

                Log::notice('::AuthController::validateName::$forbiddenName');
                Log::notice($response);

                return $response;
            }

            return response()->success(__('NAME_VALID'));
        } catch (\Exception $exception) {
            Log::error(var_export($exception, true));

            return response()->error(__('REQUEST_FAILED') . ' ' . $exception->getMessage(), 500);
        }
    }

    public static function sendPushNotification($data)
    {
        try {
            $teacher = User::query()->find($data['user_id']);

            $notification = new Notification();

            $payload = [
                'registration_ids' => [$teacher->firebase_id],
                'data'             => [
                    'type'         => $data['type'] ?? null,
                    'value'        => $data['notification_value'] ?? null,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    'action'       => $data['action'] ?? null,
                ],
                'priority'         => 'high',
                'notification'     => [
                    'title' => $data['notification_title'] ?? null,
                    'body'  => $data['notification_body'] ?? null,
                ],
            ];

            $notification->sendPushNotification($payload);

            return response()->success(__('SUCCESSFULLY_PUSHED_NOTIFICATION'));
        } catch (\Exception $exception) {
            \Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3900, self::class, __FUNCTION__);

            return response()->error(__('FAILED_PUSHED_NOTIFICATION'), 500);
        }
    }

    public static function filterResults($filter, $model, $loggedUser)
    {
        foreach ($filter as $filterIndex => $filterItems) {
            switch ($filterIndex) {
                case 'type':
                case 'priceRange':
                case 'talks':
                    self::applyFilterByConfigValue($model, $filterIndex, $filterItems);
                    break;
                case 'availability':
                    self::applyFilterByAvailability($model, $filterIndex, $filterItems, $loggedUser);
                    break;
                case 'duration':
                case 'anonTalks':
                case 'language_id':
                    self::applyFilterByDynamicValue($model, $filterIndex, $filterItems);
                    break;
                case 'order_by':
                    if (!empty($filter['order_by'])) {
                        $param = $filter['order_by'];
                        if ($param == 'rating') {
                            $param = 'ratings';
                        }
                        if ($filter['order_by_type'] == 'DESC') {
                            $model->orderByDesc($param);
                        } else {
                            $model->orderBy($param);
                        }
                    }
                    break;
            }
        }
    }

    public static function applyFilterByConfigValue($talks, $filterIndex, $filterItems, $teacherAvailability = false)
    {
        $configField  = config('variables.filter.' . $filterIndex . '.field');
        $configValues = config('variables.filter.' . $filterIndex . '.values');

        $talks->where(function ($query) use ($configField, $configValues, $filterItems, $teacherAvailability) {
            foreach ($filterItems as $itemIndex => $filterItem) {
                $configValue = $configValues[$itemIndex];

                if ($filterItem) {
                    $query->orWhere(function ($query2) use ($configValue, $configField) {
                        foreach ($configValue as $item) {
                            if ($configField == 'talks.price') {
                                $query2->where($configField, $item['operator'], $item['value']);
                            } else {
                                $query2->orWhere($configField, $item['operator'], $item['value']);
                            }
                        }
                    });
                }
            }

            if (!empty($teacherAvailability)) {
                $query->orWhereIn('teacher_user_id', $teacherAvailability);
            }
        });
    }

    public static function applyFilterByAvailability($talks, $filterIndex, $filterItems, $loggedUser)
    {
        $teacherAvailability = \App\Models\Availability::query()
            ->select('user_id')
            ->where('state', Availability::STATE['valid'])
            ->where('user_id', '!=', $loggedUser);

        self::applyFilterByConfigValue($teacherAvailability, $filterIndex, $filterItems);
        self::applyFilterByConfigValue($talks, $filterIndex, $filterItems, $teacherAvailability);
    }

    public static function applyFilterByDynamicValue($talks, $filterIndex, $filterItems)
    {
        $configField = config('variables.filter.' . $filterIndex . '.field');

        $talks->where(function ($query) use ($configField, $filterItems) {
            if (is_array($filterItems)) {
                foreach ($filterItems as $filterValue) {
                    $query->orWhere($configField, $filterValue);
                }
            } else {
                $query->where($configField, $filterItems);
            }
        });
    }

    public static function getUnreadNotificationsCount(Request $request)
    {
        /* $tokenType      = session('token_type');
        $accessToken    = session('access_token'); */


        $notificationsCountObject = new NotificationsApiController();
        $notificationsCount       = $notificationsCountObject->countUnreadNotifications($request)->getData(true);
        /* $notificationsCount = Http::withHeaders([
            'Accept'                => 'application/json',
            'Authorization'         => "$tokenType $accessToken",
            'Application-Language'  => strtolower(App::getLocale())

        ])->get(config('app.appBackendServerUrl', '') . '/notifications-unread-count', [
        ]); */

        if (!empty($notificationsCount['data'])) {
            return $notificationsCount['data'];
        } else {
            return 0;
        }
    }

}
