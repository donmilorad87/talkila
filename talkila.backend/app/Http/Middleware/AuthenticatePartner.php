<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticatePartner
{
    /**
     * Handle an incoming request.
     *
     * @param  Request   $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user('partner')) {
            return response()->error('Unauthorized.', 401);
        }

        return $next($request);
    }
}
