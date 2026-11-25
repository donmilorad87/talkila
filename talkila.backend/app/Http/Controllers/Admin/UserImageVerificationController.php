<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserImageDeclined;
use App\Models\User;
use App\Models\UserImages;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Laravel\Facades\Image;

class UserImageVerificationController extends Controller
{
    public function index(Request $request)
    {

        $verifications = UserImages::with('user')
        ->where('state', 0)
        ->orderBy('updated_at')
        ->get();



        $user = $verifications->first();

        $total = $verifications->count('id');

        return view('admin.userImagesVerification.index',compact('user', 'total'));
    }

    public function approve(Request $request)
    {
        try {
          UserImages::query()->find($request->input('id'))->update(['state' => 1]);

            $verification = UserImages::query()->find($request->input('id'));


            User::query()->find($verification->user_id)->update(['profile_picture' => $verification->image]);
            session()->flash('message', 'Image successfully approved.');

            return redirect()->route('admin.user-image-verification.index')->with('message', __('Image successfully approved.'));

        } catch (\Exception $exception) {

            session()->flash('error', 'Something went wrong, please try again.');

            return redirect()->route('admin.user-image-verification.index');
        }
    }

    public function skip(Request $request)
    {
        try {
            UserImages::query()->find($request->input('id'))->update(['updated_at' => date('Y-m-d H:i:s')]);

            return redirect()->route('admin.user-image-verification.index')->with('message', __('Image skipped.'));

        } catch (\Exception $exception) {

            session()->flash('error', 'Something went wrong, please try again.');

            return redirect()->route('admin.user-image-verification.index');
        }
    }

    public function disapprove(Request $request)
    {
        try {
            $userImageRequest = UserImages::query()->find($request->input('id'));
            $userImageRequest->update(['state' => 2]);

            session()->flash('error', 'Image successfully disapproved.');

            NotifyUserImageDeclined::dispatch($userImageRequest->user_id);

            return redirect()->route('admin.user-image-verification.index')->with('message', __('Image successfully disapproved.'));

        } catch (\Exception $exception) {
            session()->flash('error', 'Something went wrong, please try again.');

            return redirect()->route('admin.user-image-verification.index');
        }

    }
}
