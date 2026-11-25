<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetRedirectIntent
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() && !in_array($request->url(), $this->excludedRoutes())) {
            redirect()->setIntendedUrl($request->url());
        }

        return $next($request);
    }

    /**
     * List of routes that cannot be set as intended redirect routes.
     *
     * @return array
     */
    protected function excludedRoutes(): array
    {
        return [
            route('login'),
            route('login-user'),
            route('signup'),
            route('forgot_password'),
            route('redirect_to_google'),
            route('handle_google_callback'),
            route('redirect_to_facebook'),
            route('handle_facebook_callback'),
            route('logout-admin'),
        ];
    }
}
