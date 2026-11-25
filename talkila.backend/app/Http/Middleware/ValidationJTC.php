<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ValidationJTC
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
        if (!isset(Auth()->user()->id)) {
            return redirect()->route('login');
        }

        $responseLoggedInUserObject = new AuthController();
        $responseLoggedInUser = $responseLoggedInUserObject->user($request)->getData(true);

        if (!isset(Auth()->user()->id)) {
            Session::flash('alert-danger', 'Something went wrong!');
            return redirect()->route('login');
        }

        if (!$responseLoggedInUser['success']) {
            Session::flash('alert-danger', $responseLoggedInUser['message'] ?? 'Something went wrong!');
            return redirect()->route('login');
        }

        $loggedUser = $responseLoggedInUser['data'];

        if(
            $loggedUser['availability_step_basic_info'] === true &&
            $loggedUser['availability_step_talks'] === true &&
            $loggedUser['availability_step_availabilities'] === true &&
            $loggedUser['availability_step_verification'] === true
        ) {
            return redirect()->route('courses');
        }
        return $next($request);
    }
}
