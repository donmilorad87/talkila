<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Api\V1\FrontendApiCalls\UserProfileApiController;
use App\Http\Controllers\Controller;
use App\Models\Talk;
use App\Models\User;
use Illuminate\Http\Request;

class TalkDetailsController extends Controller
{
    public $talk_details = 'Talk details';

    public function talk_details(Request $request, User $user, $id){

        if(!$user->talks()->where('id','=', $id)->first()) {
            return abort(404);
        }

        $request->request->add(['logged_in_user' => auth()->user()->id]);
        $talkDetailsObject = new UserProfileApiController();
        $talkDetails = $talkDetailsObject->getTalkUserData($request, $id)->getData(true);

        return view('frontend.pages.talk_details', [
            'talk_id'               => $id,
            'talk_details'          => $talkDetails['data'] ?? [],
            'teacher'               => $user->username,
            'page_name'             => __('TALK_DETAILS')
        ]);

    }
}
