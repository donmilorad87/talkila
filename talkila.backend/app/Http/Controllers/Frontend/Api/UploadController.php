<?php

namespace App\Http\Controllers\Frontend\Api;
use App\Http\Controllers\Api\V1\Admin\ProfileVerificationApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function addProfileVerification(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $addProfileVerificationObject = new ProfileVerificationApiController();
        $addProfileVerification = $addProfileVerificationObject->addProfileVerification($request)->getData(true);

        return $addProfileVerification;
    }

    public function editProfilePhoto(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfilePhotoObject = new UserApiController();
        $editProfilePhoto = $editProfilePhotoObject->editProfilePhoto($request)->getData(true);

        return $editProfilePhoto;

    }

}
