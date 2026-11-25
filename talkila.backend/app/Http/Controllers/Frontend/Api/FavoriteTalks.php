<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\V1\Admin\UserBookmarkedTalksApiController;

class FavoriteTalks extends Controller
{
    public function unfallowSingeTalk(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $unfollowSingleTalkObject = new UserBookmarkedTalksApiController();
        $unfollowSingleTalk = $unfollowSingleTalkObject->unfollowSingleTalk($request)->getData(true);

        return $unfollowSingleTalk;

    }

    public function userBookmarkedTalks(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $userBookmarkedTalksObject = new UserBookmarkedTalksApiController();
        $userBookmarkedTalks = $userBookmarkedTalksObject->store($request)->getData(true);

        return $userBookmarkedTalks;
    }
}
