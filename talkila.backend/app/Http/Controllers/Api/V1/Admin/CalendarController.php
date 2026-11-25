<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserCalendarDisconnected;
use App\Mail\CalendarDisconnected;
use App\Models\CalendarAccount;
use App\Models\Event;
use App\Models\User;
use App\Services\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;

class CalendarController extends Controller
{
    public Calendar $calendar;

    const GOOGLE = 1;

    const BAD_REQUEST     = 400;
    const UNAUTHENTICATED = 401;

    const TALKILA_COLOR    = '#FFB805';
    const TALKIAL_CALENDAR = 'Talkila Bookings';

    public function __construct()
    {
        $this->calendar = new Calendar();
    }

    public function connect(Request $request)
    {
        Log::notice("\n\n" . '::CalendarController::connect::$request');
        Log::notice($request->all());

        $user = $request->user();
        $code = ($request->input('authorization_code') ?: $request->input('server_auth_code')) ?: $request->input('code');

        if (! $code) {
            return response()->error([
                'message' => 'Authorization code required.',
                'data'    => [
                    'errors' => [
                        'authorization_code' => 'Authorization code required',
                    ],
                ],
            ]);
        }

        $google_response = $this->calendar->connect(urldecode($code));

        Log::notice("\n\n" . '::CalendarController::connect::$google_response');
        Log::notice(json_encode($google_response->json()));

        if ($google_response->failed()) {
            return response()->error('Something went wrong while adding a new calendar.');
        }

        $access_token  = $google_response->json('access_token');
        $refresh_token = $google_response->json('refresh_token');
        $expires_at    = $google_response->json('expires_in');

        $user_info = $this->calendar->token($google_response->json('access_token'))->userInfo();

        Log::notice("\n\n" . '::CalendarController::connect::$user_info');
        Log::notice(json_encode($user_info->json()));

        if ($user_info->failed()) {
            return response()->error('Something went wrong while getting User Info.');
        }

        $from_jtc                  = $request->boolean('from_jtc');
        $existing_calendar_account = CalendarAccount::where('email', $user_info->json('email'))->first();
        $email                     = $user_info->json('email');

        if ($existing_calendar_account) {
            $data = [
                'email'             => $email,
                'calendar_provider' => self::GOOGLE,
                'access_token'      => $access_token,
                'expires_at'        => now()->addSeconds($expires_at),
                'refresh_token'     => $refresh_token ?: $existing_calendar_account->refresh_token,
            ];
        } else {
            $data = [
                'calendar_provider' => self::GOOGLE,
                'email'             => $email,
                'access_token'      => $access_token,
                'refresh_token'     => $refresh_token,
                'expires_at'        => now()->addSeconds($expires_at),
            ];

            if ($from_jtc) {
                $data['state'] = CalendarAccount::SUPPLIER_ONLY;
            }
        }

        $data['is_primary'] = $this->getPrimaryStatus($data);

        $calendar_account = $request->user()
            ->calendarAccounts()
            ->updateOrCreate([
                'email' => $user_info->json('email'),
            ], $data);

        $calendar_list = $this->calendar->token($access_token)->calendarList();

        Log::notice("\n\n" . '::CalendarController::connect::$calendar_list');
        Log::notice(json_encode($calendar_list->json()));

        if ($calendar_list->failed()) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }

        $has_talkila_calendar = false;
        $added_calendar       = [];

        foreach ($calendar_list->json('items') as $calendar) {
            if ($calendar['summary'] == self::TALKIAL_CALENDAR) {
                $has_talkila_calendar = true;
            }

            $calendar = $user->calendars()
                ->updateOrCreate(
                    [
                        'calendar_account_id' => $calendar_account->id,
                        'calendar_id'         => $calendar['id'],
                    ],
                    [
                        'name'     => $calendar['summary'],
                        'timezone' => $calendar['timeZone'],
                        'color'    => $calendar['summary'] == self::TALKIAL_CALENDAR ? self::TALKILA_COLOR : $calendar['backgroundColor'],
                        'state'    => in_array($calendar['summary'], [$email, self::TALKIAL_CALENDAR]),
                    ]
                );

            $added_calendar[] = $calendar;
        }

        if (! $has_talkila_calendar && $calendar_account->is_primary) {
            $calendar_insertion = $this->calendar
                ->token($access_token)
                ->calendar()
                ->insert([
                    'summary'     => self::TALKIAL_CALENDAR,
                    'description' => 'Displays dates of all Talkila Bookings.',
                    'timeZone'    => $this->getTimezone($request),
                ]);

            if ($calendar_insertion->failed()) {
                Log::notice("\n\n" . '::CalendarController::connect::$calendar_insertion');
                Log::notice(json_encode($calendar_insertion->json()));
            } else {
                $user->calendars()->create([
                    'calendar_account_id' => $calendar_account->id,
                    'calendar_id'         => $calendar_insertion->json('id'),
                    'name'                => $calendar_insertion->json('summary'),
                    'timezone'            => $calendar_insertion->json('timeZone'),
                    'color'               => self::TALKILA_COLOR,
                ]);
            }
        }

        $calendar = $calendar_account->with([
            'calendars' => function ($query) {
                $query->select(['id', 'calendar_account_id', 'calendar_id', 'name', 'color', 'state']);
            },
        ])
            ->get(['id', 'email', 'calendar_provider as type', 'state', 'is_primary'])
            ->where('id', $calendar_account->id)
            ->map(function ($calendar_account) {
                if ($calendar_account->calendars->count() != 0) {
                    $calendar_account->calendars->map(function ($calendar) {
                        unset($calendar->calendar_account_id);
                    });
                }

                return $calendar_account;
            })
            ->first();

        return response()->success([
            'message' => __('SUCCESSFULLY_ADDED_CALENDAR'),
            'data'    => $calendar,
        ]);
    }

    public function disconnect(Request $request, $calendar_id)
    {
        Log::notice("\n\n" . '::CalendarController::disconnect::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::CalendarController::disconnect::$calendar_id');
        Log::notice($calendar_id);

        try {
            DB::beginTransaction();

            $user                     = $request->user();
            $calendar_account         = CalendarAccount::find($calendar_id);
            $other_calendars_accounts = CalendarAccount::query()
                ->where('user_id', '!=', $user->id)
                ->where('email', $calendar_account->email)
                ->get();

            $this->handleExpiredTokens($user, $calendar_account);

            $access_token             = $calendar_account->access_token;

            if ($user->calendarAccounts->count() > 1 && $calendar_account->is_primary) {
                return response()->error('Cannot remove primary Calendar.');
            }

            foreach ($other_calendars_accounts as $other_calendars_account) {
                foreach ($other_calendars_account->calendars as $other_calendar) {
                    $other_calendar->delete();
                }

                $user = $other_calendar->user()->withTrashed()->first();

                Mail::to($user->email)->queue(new CalendarDisconnected($user, $other_calendars_account));
                NotifyUserCalendarDisconnected::dispatch($user);

                $other_calendars_account->delete();
            }

            if (! $calendar_account) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 404);
            }

            if ($calendar_account->user_id != $request->user()->id) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 403);
            }

            foreach ($calendar_account->calendars as $calendar) {
                if (! is_null($calendar->resource_id) && ! is_null($calendar->watcher_id)) {
                    $watcher = $this->calendar
                        ->token($access_token)
                        ->unwatch($calendar);

                    Log::notice("\n\n" . '::CalendarController::events::$watcher');
                    Log::notice(json_encode($watcher->json()));

                    if ($watcher->failed()) {
                        return response()->error(__('SOMETHING_WENT_WRONG'));
                    }
                }

                $calendar->delete();
            }

            $this->calendar->token($access_token)->revoke();

            $calendar_account->delete();

            DB::commit();

            return response()->success([
                'message' => __('SUCCESSFULLY_DISCONNECTED_CALENDAR'),
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function refreshToken($user, $calendar)
    {
        Log::notice("\n\n" . '::CalendarController::refreshToken::$calendar');
        Log::notice(json_encode($calendar));

        $refresh_token = $user->getCalendarRefreshToken($calendar);

        $response = $this->calendar->refreshToken($refresh_token)->refresh();

        Log::notice("\n\n" . '::CalendarController::refreshToken::$response');
        Log::notice(json_encode($response->json()));

        if ($response->failed()) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }

        $calendar->update([
            'access_token' => $response->json('access_token'),
            'expires_at'   => now()->addSeconds($response->json('expires_in')),
        ]);

        return response()->success([
            'message' => 'Successfully refreshed access token.',
            'data'    => [
                'access_token' => $response->json('access_token'),
            ],
        ]);
    }

    public function calendars(Request $request)
    {
        Log::notice("\n\n" . '::CalendarController::calendars::$request');
        Log::notice($request->all());

        try {
            if ($request->user()->calendarAccounts->isEmpty()) {
                return response()->success(__('CALENDAR_NOT_CONNECTED'));
            }

            $calendar_accounts = $request->user()
                ->calendarAccounts()
                ->with([
                    'calendars' => function ($query) {
                        $query->select(['id', 'calendar_account_id', 'calendar_id', 'name', 'color', 'state']);
                    },
                ])
                ->get(['id', 'email', 'calendar_provider as type', 'state', 'is_primary'])
                ->map(function ($calendar_account) {
                    if ($calendar_account->calendars->count() != 0) {
                        $calendar_account->calendars->map(function ($calendar) {
                            unset($calendar->calendar_account_id);
                        });
                    }

                    return $calendar_account;
                });

            return response()->success([
                'message' => __('LIST_CALENDAR'),
                'data'    => [
                    'calendar_accounts' => $calendar_accounts,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function events(Request $request, User $user, \App\Models\Calendar $calendar)
    {
        Log::notice("\n\n" . '::CalendarController::events::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::CalendarController::events::$calendar');
        Log::notice(json_encode($calendar));

        try {
            $this->handleExpiredTokens($user, $calendar);

            $access_token = $user->getCalendarAccessToken($calendar);
            $calendar_id  = urlencode($calendar->calendar_id);
            $start_time   = $this->getEventsStartTime($request);
            $end_time     = $this->getEventsEndTime($request);

            $data = [
                'singleEvents' => 'true',
                'timeMin'      => Carbon::parse($start_time)->toDateTimeLocalString() . '-00:00',
                'timeMax'      => Carbon::parse($end_time)->toDateTimeLocalString() . '-00:00',
                'timeZone'     => 'UTC',
            ];

            $events = $this->calendar
                ->token($access_token)
                ->calendar($calendar_id)
                ->event()
                ->get($data);

            Log::notice("\n\n" . '::CalendarController::events::$events');
            Log::notice(json_encode($events->json()));

            if ($events->failed()) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            if ($events->json('nextSyncToken') !== null) {
                $calendar->update([
                    'sync_token' => $events->json('nextSyncToken'),
                ]);
            }

            $event_ids = [];

            foreach ($events->json('items') as $event) {
                $event = Event::query()
                    ->updateOrCreate(
                        [
                            'event_id' => $event['id'],
                        ],
                        [
                            'status'       => $event['status'],
                            'name'         => $event['summary'] ?? 'No title',
                            'start_time'   => $event['start']['dateTime'] ?? $event['start']['date'],
                            'end_time'     => $event['end']['dateTime'] ?? $event['end']['date'],
                            'is_whole_day' => isset($event['start']['date']) && isset($event['end']['date']),
                            'timezone'     => $event['start']['timeZone'] ?? $calendar->timezone,
                        ]
                    );

                $event_ids[] = $event->id;
            }

            $calendar->events()->sync($event_ids, false);
            $user->events()->sync($event_ids, false);

            $watcher = $this->calendar
                ->token($access_token)
                ->calendar($calendar_id)
                ->event()
                ->watch();

            Log::notice("\n\n" . '::CalendarController::events::$watcher');
            Log::notice(json_encode($watcher->json()));

            if ($watcher->failed()) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            $calendar->update([
                'resource_id' => $watcher->json('resourceId'),
                'watcher_id'  => $watcher->json('id'),
            ]);

            return $events->json();
        } catch (\Exception $exception) {
            Log::error($exception->getFile() . ' ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function storeEvent(Request $request, User $user, \App\Models\Calendar $calendar)
    {
        Log::notice("\n\n" . '::CalendarController::storeEvent::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::CalendarController::storeEvent::$calendar');
        Log::notice(json_encode($calendar));

        $this->handleExpiredTokens($user, $calendar);

        $access_token = $user->getCalendarAccessToken($calendar);
        $calendar_id  = urlencode($calendar->calendar_id);
        $data         = $request->input('data');

        $event = $this->calendar
            ->token($access_token)
            ->calendar($calendar_id)
            ->event()
            ->insert($data);

        Log::notice("\n\n" . '::CalendarController::storeEvent::$event');
        Log::notice(json_encode($event->json()));

        if ($event->failed()) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }

        return response()->success([
            'message' => __('SUCCESSFULLY_ADDED_EVENT'),
            'data'    => $event->json(),
        ]);
    }

    public function updateEvent(Request $request, User $user, \App\Models\Calendar $calendar, $event_id)
    {
        Log::notice("\n\n" . '::CalendarController::updateEvent::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::CalendarController::updateEvent::$calendar');
        Log::notice(json_encode($calendar));

        Log::notice("\n\n" . '::CalendarController::updateEvent::$event_id');
        Log::notice(json_encode($event_id));

        $this->handleExpiredTokens($user, $calendar);

        $access_token = $user->getCalendarAccessToken($calendar);
        $calendar_id  = urlencode($calendar->calendar_id);
        $data         = $request->input('data');

        $event = $this->calendar
            ->token($access_token)
            ->calendar($calendar_id)
            ->event($event_id)
            ->put($data);

        Log::notice("\n\n" . '::CalendarController::updateEvent::$event');
        Log::notice(json_encode($event->json()));

        if ($event->failed()) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }

        return response()->success([
            'message' => __('SUCCESSFULLY_UPDATED_EVENT'),
            'data'    => $event->json(),
        ]);
    }

    public function patchEvent(Request $request, User $user, \App\Models\Calendar $calendar, $event_id)
    {
        Log::notice("\n\n" . '::CalendarController::patchEvent::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::CalendarController::patchEvent::$calendar');
        Log::notice(json_encode($calendar));

        Log::notice("\n\n" . '::CalendarController::patchEvent::$event_id');
        Log::notice(json_encode($event_id));

        $this->handleExpiredTokens($user, $calendar);

        $access_token = $user->getCalendarAccessToken($calendar);
        $calendar_id  = urlencode($calendar->calendar_id);
        $data         = $request->input('data');

        $event = $this->calendar
            ->token($access_token)
            ->calendar($calendar_id)
            ->event($event_id)
            ->patch($data);

        Log::notice("\n\n" . '::CalendarController::patchEvent::$event');
        Log::notice(json_encode($event->json()));

        if ($event->failed()) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }

        return response()->success([
            'message' => 'Successfully patched Calendar event.',
            'data'    => $event->json(),
        ]);
    }

    public function cancelEvent(Request $request, User $user, \App\Models\Calendar $calendar, $event_id)
    {
        Log::notice("\n\n" . '::CalendarController::cancelEvent::$request');
        Log::notice($request->all());

        Log::notice("\n\n" . '::CalendarController::cancelEvent::$calendar');
        Log::notice(json_encode($calendar));

        Log::notice("\n\n" . '::CalendarController::cancelEvent::$event_id');
        Log::notice(json_encode($event_id));

        $this->handleExpiredTokens($user, $calendar);

        $access_token = $user->getCalendarAccessToken($calendar);
        $calendar_id  = urlencode($calendar->calendar_id);

        $data = [
            "status" => 'cancelled',
        ];

        $event = $this->calendar
            ->token($access_token)
            ->calendar($calendar_id)
            ->event($event_id)
            ->patch($data);

        Log::notice("\n\n" . '::CalendarController::cancelEvent::$event');
        Log::notice(json_encode($event->json()));

        if ($event->failed()) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }

        return response()->success([
            'message' => __('SUCCESSFULLY_CANCELLED_EVENT'),
            'data'    => $event->json(),
        ]);
    }

    public function accountState(Request $request)
    {
        Log::notice("\n\n" . '::CalendarController::accountState::$request');
        Log::notice($request->all());

        try {
            $calendar = CalendarAccount::find($request->input('calendar_id'));

            if (! $calendar) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 404);
            }

            if ($calendar->user_id != $request->user()->id) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 403);
            }

            $calendar->update([
                'state' => $request->input('state'),
            ]);

            return response()->success(__('SUCCESSFULLY SET CALENDAR ACCOUNT STATE'));
        } catch (\Exception $e) {
            Log::notice("\n\n" . '::CalendarController::accountState::$exception');
            Log::notice($e->getMessage());

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function calendarState(Request $request)
    {
        Log::notice("\n\n" . '::CalendarController::calendarState::$request');
        Log::notice($request->all());

        try {
            $calendar = \App\Models\Calendar::find($request->input('calendar_id'));

            if (! $calendar) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 404);
            }

            if ($calendar->user_id != $request->user()->id) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 403);
            }

            $calendar->update([
                'state' => $request->input('state'),
            ]);

            return response()->success(__('SUCCESSFULLY_SET_CALENDAR_STATE'));
        } catch (\Exception $e) {
            Log::notice("\n\n" . '::CalendarController::calendarState::$exception');
            Log::notice($e->getMessage());

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function setPrimaryCalendar(Request $request, $calendar_id)
    {
        Log::notice("\n\n" . '::CalendarController::setPrimaryCalendar::$request');
        Log::notice($request->all());

        try {
            $calendar_account = CalendarAccount::find($calendar_id);
            $user             = $request->user();

            if (! $calendar_account) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 404);
            }

            if ($calendar_account->user_id != $request->user()->id) {
                return response()->error(__('SOMETHING_WENT_WRONG'), 403);
            }

            $user->calendarAccounts()->update([
                'is_primary' => false,
            ]);

            $calendar_account->update([
                'is_primary' => true,
            ]);

            $talkila_calendar = $calendar_account->calendars()->where('name', self::TALKIAL_CALENDAR)->first();

            if (! $talkila_calendar) {
                $this->handleExpiredTokens($user, $calendar_account);
                $access_token       = $user->getCalendarAccessToken($calendar_account);
                $calendar_insertion = $this->calendar
                    ->token($access_token)
                    ->calendar()
                    ->insert([
                        'summary'     => self::TALKIAL_CALENDAR,
                        'description' => 'Displays dates of all Talkila Bookings.',
                        'timeZone'    => $this->getTimezone($request),
                    ]);

                if ($calendar_insertion->failed()) {
                    Log::notice("\n\n" . '::CalendarController::connect::$calendar_insertion');
                    Log::notice(json_encode($calendar_insertion->json()));
                } else {
                    $request->user()->calendars()->create([
                        'calendar_account_id' => $calendar_account->id,
                        'calendar_id'         => $calendar_insertion->json('id'),
                        'name'                => $calendar_insertion->json('summary'),
                        'timezone'            => $calendar_insertion->json('timeZone'),
                        'color'               => self::TALKILA_COLOR,
                    ]);
                }
            }

            return response()->success(__('SUCCESSFULLY_SET_CALENDAR_ACCOUNT_PRIMARY'));
        } catch (\Exception $e) {
            Log::notice("\n\n" . '::CalendarController::setPrimaryCalendar::$exception');
            Log::notice($e->getMessage());

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function watch(Request $request, \App\Models\Calendar $calendar)
    {
        Log::notice('Request', $request->all());
        Log::notice('X-Goog-Channel-ID' . ' : ' . $request->header('x-goog-channel-id'));
        Log::notice('X-Goog-Channel-Token' . ' : ' . $request->header('x-goog-channel-token'));
        Log::notice('X-Goog-Channel-Expiration' . ' : ' . $request->header('x-goog-channel-expiration'));
        Log::notice('X-Goog-Resource-ID' . ' : ' . $request->header('x-goog-resource-id'));
        Log::notice('X-Goog-Resource-URI' . ' : ' . $request->header('x-goog-resource-uri'));
        Log::notice('X-Goog-Resource-State' . ' : ' . $request->header('x-goog-resource-state'));
        Log::notice('X-Goog-Message-Number' . ' : ' . $request->header('x-goog-message-number'));
        Log::notice('Calendar', $calendar->toArray());
        // $this->events($request, $calendar->user, $calendar);
    }

    protected function handleExpiredTokens($user, $calendar)
    {
        if ($user->calendarAccounts->isEmpty()) {
            return;
        }

        switch (class_basename(get_class($calendar))) {
            case 'Calendar':
                $expires_at = $calendar->calendarAccount->expires_at;
                $calendar   = $calendar->calendarAccount;
                break;
            case 'CalendarAccount':
                $expires_at = $calendar->expires_at;
                break;
        }

        if (now() > $expires_at) {
            return $this->refreshToken($user, $calendar)->getData(true);
        }
    }

    protected function getTimezone(Request $request)
    {
        $timezone = $request->header('Time-Zone-Offset-UTC') ?? $request->user()->timezone;
        $hours    = $timezone / 60;
        $minutes  = str_pad($timezone % 60, 2, 0);
        $seconds  = $hours * 60 * 60 + $minutes * 60;

        return timezone_name_from_abbr('', $seconds, 1) ?: null;
    }

    protected function getPrimaryStatus($data): bool
    {
        $is_primary        = false;
        $user              = auth()->user();
        $existing_calendar = $user->calendarAccounts()->where('email', $data['email'])->first();

        if ($user->calendarAccounts()->count() == 0) {
            $is_primary = true;
        }

        if ($existing_calendar) {
            $is_primary = $existing_calendar->is_primary;
        }

        return $is_primary;
    }

    protected function getEventsStartTime(Request $request): string
    {
        $start_time = $request->has('start_time')
            ? Carbon::parse($request->input('start_time'))->format('Y-m-d 00:00:00')
            : now()->format('Y-m-d 00:00:00');
        return $start_time;
    }

    protected function getEventsEndTime(Request $request): string
    {
        return $request->has('end_time')
            ? Carbon::parse($request->input('end_time'))->format('Y-m-d 00:00:00')
            : now()->addMonths(2)->format('Y-m-d 00:00:00');
    }
}
