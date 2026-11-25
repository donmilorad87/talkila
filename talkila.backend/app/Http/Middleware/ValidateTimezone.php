<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

class ValidateTimezone
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
        if (!$request->hasHeader('Time-Zone-Offset-UTC')) {
            Log::notice('::Middleware::ValidateTimezone::$headers', [
                'Application-Language' => $request->header('Application-Language'),
                'Time-Zone-Offset-UTC' => $request->header('Time-Zone-Offset-UTC'),
                'Time-Zone-Name'       => $request->header('Time-Zone-Name'),
                'Is-Mobile-App'        => $request->header('Is-Mobile-App'),
            ]);

            $request->headers->set('Time-Zone-Offset-UTC', 0);

            if ($request->user() && $request->user()->timezone === '') {
                $request->user()->update([
                    'timezone' => 0,
                ]);

                Log::error("User ID {$request->user()->id} had no Time-Zone-Offset-UTC header and was manually set to 0 (UTC).");
            }
        }

        return $next($request);
    }
}
