<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use App\Http\Controllers\Api\V1\Admin\UserFollowedApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequests\StoreAvailabilityRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function talks(StoreAvailabilityRequest $request)
    {

        if (!$request->user()) {
            return redirect()->route('login');
        }

        $joinTheClubAvailabilityObject = new JoinTheClubApiController();
        $joinTheClubAvailability = $joinTheClubAvailabilityObject->joinTheClubAvailability($request)->getData(true);

        return $joinTheClubAvailability;
    }

    public function userValidateUsername(Request $request)
    {

        $checkUsernameUniqueObject = new UserApiController();
        $checkUsernameUnique = $checkUsernameUniqueObject->checkUsernameUnique($request)->getData(true);

        return $checkUsernameUnique;
    }

    public function editProfileNameAndUsername(Request $request)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $editProfileNameAndUsernameObject = new UserApiController();
        $editProfileNameAndUsername = $editProfileNameAndUsernameObject->editProfileNameAndUsername($request)->getData(true);

        return $editProfileNameAndUsername;
    }

    public function removeUserImage(Request $request)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $removeUserImageObject = new UserApiController();
        $removeUserImage = $removeUserImageObject->removeUserProfilePicture($request)->getData(true);

        return $removeUserImage;
    }

    public function joinTheClubAvailability(StoreAvailabilityRequest $request)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $joinTheClubAvailabilityObject = new JoinTheClubApiController();
        $joinTheClubAvailability = $joinTheClubAvailabilityObject->joinTheClubAvailability($request)->getData(true);


        if(isset( $joinTheClubAvailability['data'])){
            $html = view('frontend.partials.components.availabilities', ['userAvailability' => $joinTheClubAvailability['data']['availabilities']])->render();

        }

        return  [
            'data'          => ['html' => $html ?? []],
            'success'       => true,
            'message'       => $joinTheClubAvailability['message'] ?? '',
        ];

    }

    public function deleteAvailability(Request $request, $id)
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $deleteAvailabilityObject = new JoinTheClubApiController();
        $deleteAvailability = $deleteAvailabilityObject->joinTheClubDeleteAvailability($id)->getData(true);

        return $deleteAvailability;
    }

    public function removeFollow(Request $request, $id)
    {

        if (!$request->user()) {
            return redirect()->route('login');
        }

        $removeFollowObject = new UserFollowedApiController();
        $removeFollow = $removeFollowObject->removeFollow($request, $id)->getData(true);

        return $removeFollow;
    }
}
