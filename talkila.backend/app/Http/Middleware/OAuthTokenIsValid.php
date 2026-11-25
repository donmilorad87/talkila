<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OAuthTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenType   = session('token_type');
        $accessToken = session('access_token');
        $expiresAt   = session('expires_at');

        if (empty($tokenType) || empty($accessToken)) {
            return redirect()->route('login');
        }

        $responseLoggedInUser = Http::withHeaders([
            'Accept'                => 'application/json',
            'Content-Type'          => 'application/json',
            'Authorization'         => "$tokenType $accessToken",
            'Application-Language'  =>  strtolower(App::getLocale())

        ])->post(env('APP_BACKEND_URL', '') . '/user');

        if ($responseLoggedInUser->failed()) {
            Session::flash('alert-danger', 'Something went wrong!');
            return redirect()->route('login');
        }

        if (!$responseLoggedInUser->json()['success']) {
            Session::flash('alert-danger', $responseLoggedInUser->json()['message'] ?? 'Something went wrong!');
            return redirect()->route('login');
        }

        $request = $request->merge(['user' => $responseLoggedInUser->json()['data']]);

        return $next($request);
    }
}
