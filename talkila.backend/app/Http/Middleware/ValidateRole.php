<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string  $role
     * @return mixed|void
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        /**
         * Check if Authenticated User has sufficient permissions to access the page.
         */
        if ($request->user()->roles()->whereIn('title', explode('|', $role))->exists()) {
            return $next($request);
        }

        return redirect()->back();

        // abort(403, 'You do not have sufficient permissions to access this page');
    }
}
