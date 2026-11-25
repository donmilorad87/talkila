<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function userToken(Request $request)
    {
        $tokenType      = session('token_type');
        $accessToken    = session('access_token');
        return "$tokenType $accessToken";
    }
}
