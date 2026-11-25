<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\VerifiedSocialProviders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function socials(Request $request)
    {
        if ($request->has('social')) {
            if ($request->get('social') === 'facebook') {
                session()->put('facebookSettingsVerify', 1);
                return redirect('https://www.facebook.com/v15.0/dialog/oauth?client_id=' . config('services.facebook.client_id') . '&redirect_uri=' . config('services.facebook.redirect_url_2') . '&state=%22{st=state123abc,ds=123456789}%22&response_type=code');
            } else {
                if ($request->get('social') === 'twitter') {
                    session()->put('twitterSettingsVerify', 1);

                    return redirect('https://twitter.com/i/oauth2/authorize?response_type=code&client_id=' . config('services.twitter.client_id_oauth2') . '&redirect_uri=' . config('services.twitter.redirect') . '&state=state&scope=tweet.read%20users.read&code_challenge_method=plain&code_challenge=challenge&response_type=code');
                } else {
                    if ($request->get('social') === 'instagram') {
                        session()->put('instagramVerification', 1);
                        return redirect('https://api.instagram.com/oauth/authorize?client_id=' . config('services.instagram.client_id') . '&redirect_uri=' . config('services.instagram.redirect') . '&scope=user_profile,user_media&response_type=code');
                    } else {
                        if ($request->get('social') === 'linkedin') {
                            session()->put('linkedinVerification', 1);
                            return redirect('https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . config('services.linkedin.client_id') . '&scope=r_liteprofile%20r_emailaddress&redirect_uri=' . config('services.linkedin.redirect') . '&state=DCEeFWf45A53sdfKef424');
                        }
                    }
                }
            }
        }
    }

    public function addSocialVerification(Request $request)
    {
        Log::notice("\n\n" . '::SettingsCongroller::addSocialVerification::$request');
        Log::notice($request->all());

        try {
            $user = $request->user();

            if (empty($user)) {
                $response = response()->error('There is no user with that id');

                Log::notice("\n\n" . '::SettingsCongroller::addSocialVerification::$response');
                Log::notice($response);

                return $response;
            }

            $user->verifiedSocialProviders()->updateOrCreate([
                'social_id' => $request->get('social_id'),
                'user_id'   => $user->id,
            ], [

                'social_providers' => $request->get('social_providers'),
                'social_id'        => $request->get('social_id'),
                'social_username'  => $request->get('social_username'),
                'updated_at'       => now(),
            ]);

            $response = response()->success(__('SUCCESSFULLY_VERIFIED_SOCIAL'));

            Log::notice("\n\n" . '::CountriesApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], 77101, self::class, __FUNCTION__);
            \Session::flash('error', 'Something went wrong while adding item to verifiedSocialProviders; please check log.');

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function deleteSocialVerification(Request $request)
    {
        Log::notice("\n\n" . '::SettingsCongroller::deleteSocialVerification::$request');
        Log::notice($request->all());

        try {
            $user = $request->user();

            if (empty($user)) {
                $response = response()->error(__('NO_USER'));

                Log::notice("\n\n" . '::SettingsController::addSocialVerification::$response');
                Log::notice($response);

                return $response;
            }

            if ($request->has('socialVerifyId')) {
                VerifiedSocialProviders::find($request->get('socialVerifyId'))->delete();
                $response = response()->success(__('SUCCESSFULLY_DELETED_SOCIAL'));

                Log::notice("\n\n" . '::CountriesApiController::index::$response');
                Log::notice($response);

                return $response;
            } else {
                $response = response()->error(__('ATTRIBUTE_REQUIRED', ['attribute' => 'Verify ID']));

                Log::notice("\n\n" . '::SettingsController::addSocialVerification::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], 77102, self::class, __FUNCTION__);
            \Session::flash('error', 'Something went wrong while adding item to deleteSocialVerification; please check log.');

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function getSocialVerification()
    {
    }

    public function verifyFacebook()
    {
        session()->put('timezone_offset', request()->input('timezone_offset'));
        session()->put('email', request()->input('email'));

        return Socialite::driver('facebook')->redirect();
    }

    public function verifyInstagram()
    {
        return Socialite::driver('instagram')->redirect();
    }

    public function verifyLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function redirectToGoogle()
    {
        session()->put('timezone_offset', request()->input('timezone_offset'));
        session()->put('email', request()->input('email'));

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle login with google
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback()
    {
        try {
            $gUser = Socialite::driver('google')->user();

            // TODO set time headers: 'Time-Zone-Offset-UTC' and 'Time-Zone-Name'
            $responseLoginWithGoogle = Http::withHeaders([
                'Accept'               => 'application/json',
                'Content-Type'         => 'application/json',
                'Application-Language' => strtolower(App::getLocale()),

            ])->post(env('APP_BACKEND_URL', '') . '/login-with-google', [
                'accessToken' => $gUser->token,
            ]);

            if ($responseLoginWithGoogle->failed()) {
                // throw new NotFoundHttpException();
                Session::flash('alert-danger', 'Something went wrong!');
                return redirect()->back();
            }

            if (! $responseLoginWithGoogle->json()['success']) {
                Session::flash('alert-danger', $responseLoginWithGoogle->json()['message'] ?? 'Something went wrong!');
                return redirect()->back();
            }

            // TODO optimize, move to separate method on global level
            $tokenType   = $responseLoginWithGoogle->json()['data']['token_type'];
            $accessToken = $responseLoginWithGoogle->json()['data']['access_token'];
            $expiresAt   = $responseLoginWithGoogle->json()['data']['expires_at'];

            session(['token_type' => $tokenType]);
            session(['access_token' => $accessToken]);
            session(['expires_at' => $expiresAt]);

            return redirect()->route('courses');
        } catch (\Exception $e) {
            return redirect('auth/google');
        }
    }

    public function redirectToFacebook()
    {
        session()->put('timezone_offset', request()->input('timezone_offset'));
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle login with facebook
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            $fUser = Socialite::driver('facebook')->user();
            //
            //            // TODO set time headers: 'Time-Zone-Offset-UTC' and 'Time-Zone-Name'
            //            $responseLoginWithFacebook = Http::withHeaders([
            //                'Accept'                => 'application/json',
            //                'Content-Type'          => 'application/json',
            //                'Application-Language'  =>  strtolower(App::getLocale())
            //
            //            ])->post(env('APP_BACKEND_URL', '').'/login-with-facebook', [
            //                'accessToken' => $fUser->token
            //            ]);
            $request->request->add([
                'accessToken' => $fUser->token,
            ]);
            $authController            = new \App\Http\Controllers\Api\V1\Auth\AuthController();
            $responseLoginWithFacebook = $authController->loginWithSocialite($request, 'facebook')->getData(true);


            if (! $responseLoginWithFacebook['success']) {
                Session::flash('alert-danger', $responseLoginWithFacebook['message'] ?? 'Something went wrong!');
                return redirect()->back();
            }

            // TODO optimize, move to separate method on global level
            $tokenType   = $responseLoginWithFacebook['data']['token_type'];
            $accessToken = $responseLoginWithFacebook['data']['access_token'];
            $expiresAt   = $responseLoginWithFacebook['data']['expires_at'];

            session(['token_type' => $tokenType]);
            session(['access_token' => $accessToken]);
            session(['expires_at' => $expiresAt]);

            return redirect()->route('courses');
        } catch (\Exception $e) {
            Log::error($e);


            return redirect()->back();
        }
    }

    public function handleGoogleCalendarCallback(Request $request)
    {
        if($request->has('error')) {
            return redirect('/settings/profile')->with('alert-danger', 'Access denied.');
        }

        if ($request->has('code')) {
            if (session()->get('addCalendarFromJtc') === 1) {
                return redirect()->route('jtc_set_availability', [
                    'code' => $request->input('code'),
                ]);
            } else {
                if (session()->get('addCalendarFromHome') === 1) {
                    return redirect()->route('home', [
                        'code' => $request->input('code'),
                    ]);
                } else {
                    return redirect()->route('settings_profile', [
                        'code' => $request->input('code'),
                    ]);
                }
            }
        }
    }
}
