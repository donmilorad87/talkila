<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AffiliateUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $loggedUser = auth()->user();

        if (empty($loggedUser)) {
            return redirect()->route('affiliate.login');
        }

        $userRole = $loggedUser->userRole();

        if ($userRole == 'Affiliate') {
            return $next($request);
        } else {
            return redirect()->route('affiliate.login');
        }
    }
}
