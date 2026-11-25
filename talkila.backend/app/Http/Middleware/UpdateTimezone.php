<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UpdateTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  Request                                        $request
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = $request->header();
        unset($headers['authorization']);
        Log::notice('Headers', $headers);

        $user     = $request->user();
        $timezone = $request->header('Time-Zone-Offset-UTC');

        if (isMobileApp() && $user && $this->userHasValidTimezoneHeader($user, $timezone) && $user->timezone !== $timezone) {
            Log::notice("User ID $user->id timezone was updated from '$user->timezone' to '$timezone'.");

            $user->update([
                'timezone' => $timezone,
            ]);
        }

        return $next($request);
    }

    /**
     * Determine whether the passed Timezone header matches the following rules:
     * <li>Timezone allows only numbers.</li>
     * <li>Timezone can begin with minus sign.</li>
     * <li>Timezone is between 1 and 3 characters long.</li>
     *
     * @param  User    $user
     * @param  string  $timezone
     *
     * @return bool
     */
    protected function userHasValidTimezoneHeader(User $user, string $timezone): bool
    {
        if (!preg_match('/^-?[0-9]{1,3}$/', $timezone)) {
            Log::error('User ID ' . $user->id . ' Timezone header (' . json_encode($timezone) . ') is incorrect.');

            return false;
        }

        return true;
    }
}