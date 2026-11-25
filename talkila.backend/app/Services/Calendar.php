<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Calendar
{
    protected ?string $client_id;
    protected ?string $client_secret;
    protected ?string $redirect_uri;
    protected ?string $calendar;
    protected ?string $api_endpoint;

    function __construct()
    {
        $this->client_id     = config('services.google.client_id');
        $this->client_secret = config('services.google.client_secret');
        $this->redirect_uri  = config('services.google.calendar_redirect');
        $this->calendar      = null;
        $this->api_endpoint  = null;
    }

    public function token($token)
    {
        $this->access_token = $token;

        return $this;
    }

    public function refreshToken($token)
    {
        $this->refresh_token = $token;

        return $this;
    }

    public function connect($code)
    {
        $endpoint = isMobileApp()
            ? "https://www.googleapis.com/oauth2/v4/token"
            : "https://oauth2.googleapis.com/token";

        return Http::post("https://oauth2.googleapis.com/token", [
            'code'          => $code,
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri'  => $this->redirect_uri,
            'grant_type'    => 'authorization_code',
        ]);
    }

    public function refresh($token = null)
    {
        return Http::post("https://oauth2.googleapis.com/token", [
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $token ?: $this->refresh_token,
            'grant_type'    => 'refresh_token',
        ]);
    }

    public function revoke($token = null)
    {
        return Http::asForm()
            ->post("https://oauth2.googleapis.com/revoke", [
                'token' => $token ?: $this->access_token,
            ]);
    }

    public function userInfo()
    {
        return Http::withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->get("https://www.googleapis.com/oauth2/v1/userinfo?alt=json");
    }

    public function calendarList()
    {
        return Http::withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->get("https://www.googleapis.com/calendar/v3/users/me/calendarList");
    }

    public function calendar($calendar = null)
    {
        $this->api_endpoint = 'https://www.googleapis.com/calendar/v3/calendars';

        if ($calendar) {
            $this->api_endpoint = "https://www.googleapis.com/calendar/v3/calendars/{$calendar}";
            $this->calendar     = $calendar;
        }

        return $this;
    }

    public function event($event = null)
    {
        $this->api_endpoint = "{$this->api_endpoint}/events";

        if (! is_null($event)) {
            $this->api_endpoint = "{$this->api_endpoint}/{$event}";
        }

        return $this;
    }

    public function watch()
    {
        $this->api_endpoint = "{$this->api_endpoint}/watch";

        $body = json_encode([
            'id'      => Str::uuid(),
            'type'    => 'web_hook',
            'address' => route('api.calendar.watch', $this->calendar),
        ]);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->post($this->api_endpoint);
    }

    public function unwatch($calendar)
    {
        $this->api_endpoint = "https://www.googleapis.com/calendar/v3/channels/stop";

        $body = json_encode([
            'id'         => $calendar->watcher_id,
            'resourceId' => $calendar->resource_id,
        ]);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->post($this->api_endpoint);
    }

    public function get($data = null)
    {
        return Http::withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->get($this->api_endpoint, $data);
    }

    public function insert($data)
    {
        $body = json_encode($data);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->post($this->api_endpoint, [
                'sendUpdates' => 'all',
            ]);
    }

    public function put($data)
    {
        $body = json_encode($data);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->patch($this->api_endpoint, [
                'sendUpdates' => 'all',
            ]);
    }

    public function patch($data)
    {
        $body = json_encode($data);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->patch($this->api_endpoint, [
                'sendUpdates' => 'all',
            ]);
    }

    public function events($calendar_id, $timezone = null, $start_time = null, $end_time = null)
    {
        $attributes = ['singleEvents' => 'true'];

        if (! is_null($start_time)) {
            $start      = Carbon::parse($start_time)->toTimeString();
            $start_date = Carbon::parse($start_time)->format('Y-m-d') . 'T' . $start . '-00:00';

            $attributes['timeMin'] = $start_date;
        }

        if (! is_null($end_time)) {
            $end      = Carbon::parse($end_time)->toTimeString();
            $end_date = Carbon::parse($end_time)->format('Y-m-d') . 'T' . $end . '-00:00';

            $attributes['timeMax'] = $end_date;
        }

        if (! is_null($timezone)) {
            $attributes['timeZone'] = $timezone;
        }

        return Http::withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->get("https://www.googleapis.com/calendar/v3/calendars/{$calendar_id}/events", $attributes);
    }

    public function insertEvent($calendar_id, $data)
    {
        $body = json_encode([
            "summary"     => $data['name'],
            "description" => $data['description'],
            "status"      => ($data['status'] ?? 'confirmed'),
            "start"       => [
                "dateTime" => Carbon::parse($data['start_time'])->toDateTimeLocalString(),
                "timeZone" => $data['timezone'],
            ],
            "end"         => [
                "dateTime" => Carbon::parse($data['end_time'])->toDateTimeLocalString(),
                "timeZone" => $data['timezone'],
            ],
            "attendees"   => [
                [
                    "email"       => $data['supplier'],
                    "displayName" => $data['supplier_name'],
                ],
                [
                    "email"       => $data['client'],
                    "displayName" => $data['client_name'],
                ],
            ],
            "source"      => [
                "url" => ($data['url'] ?? config('app.frontend_url')),
            ],
        ]);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->post("https://www.googleapis.com/calendar/v3/calendars/{$calendar_id}/events", [
                'sendUpdates' => 'all',
            ]);
    }

    public function updateEvent($calendar_id, $event_id, $data)
    {
        $body = json_encode([
            "summary"     => $data['name'],
            "description" => $data['description'],
            "status"      => ($data['status'] ?? 'confirmed'),
            "start"       => [
                "dateTime" => Carbon::parse($data['start_time'])->toDateTimeLocalString(),
                "timeZone" => $data['timezone'],
            ],
            "end"         => [
                "dateTime" => Carbon::parse($data['end_time'])->toDateTimeLocalString(),
                "timeZone" => $data['timezone'],
            ],
            "attendees"   => [
                [
                    "email"          => $data['supplier'],
                    "displayName"    => $data['supplier_name'],
                    "responseStatus" => ($data['supplier_status'] ?? 'needsAction'),
                ],
                [
                    "email"          => $data['client'],
                    "displayName"    => $data['client_name'],
                    "responseStatus" => ($data['client_status'] ?? 'needsAction'),
                ],
            ],
            "source"      => [
                "url" => ($data['url'] ?? config('app.frontend_url')),
            ],
        ]);


        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->put("https://www.googleapis.com/calendar/v3/calendars/{$calendar_id}/events/{$event_id}", [
                'sendUpdates' => 'all',
            ]);
    }

    public function patchEvent($calendar_id, $event_id, $data)
    {
        $body = json_encode($data);

        return Http::withBody($body, 'application/json')
            ->withHeaders(['Authorization' => 'Bearer ' . $this->access_token])
            ->patch("https://www.googleapis.com/calendar/v3/calendars/{$calendar_id}/events/{$event_id}", [
                'sendUpdates' => 'all',
            ]);
    }


}
