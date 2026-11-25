<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JoinTheClub;
use App\Models\StaticMetric;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class UserVerificationController
 * @package App\Http\Controllers
 */
class UserVerificationController extends Controller
{
    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($token)
    {
        $user = User::where('verification_token', $token)->first();
        abort_if(!$user, 404);

        $user->verified           = 1;
        $user->verified_at        = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        $user->verification_token = null;
        $user->save();

        $existJoinTheClub = JoinTheClub::query()->where('users_id', $user->id)->exists();

        if(!$existJoinTheClub) {
            $joinTheClubStepOne             = new JoinTheClub();
            $joinTheClubStepOne->users_id    = $user->id;
            $joinTheClubStepOne->save();
        }

        $existStaticMetric = StaticMetric::query()->where('user_id', $user->id)->exists();

        if(!$existStaticMetric) {
            //Create static metric
            $staticMetric           = new StaticMetric();
            $staticMetric->user_id  = $user->id;
            $staticMetric->save();
        }

        return redirect()->route('login')->with('message', trans('global.emailVerificationSuccess'));
    }
}
