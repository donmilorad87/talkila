<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\UserFollowedApiController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public $home = 'Home';

    public function userToken()
    {

        $tokenType      = session('token_type');
        $accessToken    = session('access_token');

        return "$tokenType $accessToken";
    }

    public static function loggedUserData(Request $request)
    {
        if(isset(auth()->user()->id) && $request != NULL) {
            $userObject = new \App\Http\Controllers\Api\V1\Auth\AuthController();

            return $userObject->user($request)->getData(true);
        } else {
            return [];
        }

        return auth()->user();

        if(!$request->user()) {
            return redirect()->route('login');
        }
        $loggedUserDataObject = new AuthController();
        $loggedUserData = $loggedUserDataObject->user($request)->getData(true);

        return $loggedUserData->json()['data'];
    }

    public static function loggedUserJTC($request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $loggedUserJTCObject = new JoinTheClubApiController();
        $loggedUserJTC = $loggedUserJTCObject->joinTheClubAvailabilityCompleted($request)->getData(true);

        return $loggedUserJTC['data'];
    }


}
