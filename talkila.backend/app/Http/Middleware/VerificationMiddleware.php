<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

/**
 * Class VerificationMiddleware
 * @package App\Http\Middleware
 */
class VerificationMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->verified) {
                auth()->logout();

                return redirect()->route('login')->with('message', trans('global.verifyYourEmail'));
            }
        }

        return $next($request);
    }
}
