<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TeacherStudentUser
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
        $loggedUser   = auth()->user();


        if (empty($loggedUser)) {
            return redirect()->route('login');
        }

        $userRole   = $loggedUser->userRole();

        if($userRole != 'Admin') {
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
