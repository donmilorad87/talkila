<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Api\V1\Admin\ProfilCvApiController;
use App\Http\Controllers\Api\V1\Admin\StaticProfessionsApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function editProfileName(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileNameObject = new UserApiController();
        $editProfileName = $editProfileNameObject->editProfileName($request)->getData(true);

        return $editProfileName;
    }



    public function editProfileBiography(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileBiographyObject = new UserApiController();
        $editProfileBiography = $editProfileBiographyObject->editProfileBiography($request)->getData(true);

        return $editProfileBiography;
    }

    public function editProfileEmail(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileEmailObject = new UserApiController();
        $editProfileEmail = $editProfileEmailObject->editProfileEmail($request)->getData(true);

        return $editProfileEmail;
    }

    public function editProfilePassword(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfilePasswordObject = new UserApiController();
        $editProfilePassword = $editProfilePasswordObject->editProfilePassword($request)->getData(true);

        return $editProfilePassword;
    }

    public function editProfileVideo(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileVideoObject = new UserApiController();
        $editProfileVideo = $editProfileVideoObject->editProfileVideo($request)->getData(true);

        return $editProfileVideo;
    }

    public function editProfilePrivateStatus(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfilePrivateStatusObject = new UserApiController();
        $editProfilePrivateStatus = $editProfilePrivateStatusObject->editProfilePrivateStatus($request)->getData(true);

        return $editProfilePrivateStatus;
    }

    public function getProfession(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $getProfessionObject = new StaticProfessionsApiController();
        $getProfession = $getProfessionObject->getProfession($request)->getData(true);

        return $getProfession;
    }

    public function userUpdateProfession(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileProfessionObject = new UserApiController();
        $editProfileProfession = $editProfileProfessionObject->editProfileProfession($request)->getData(true);

        return $editProfileProfession;
    }

    public function profilCvs(Request $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileProfessionObject = new ProfilCvApiController();
        $editProfileProfession = $editProfileProfessionObject->editProfileCsvCompany($request)->getData(true);

        return $editProfileProfession;
    }

}
