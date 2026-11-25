<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Models\Affiliates\Affiliate;
use App\Models\Affiliates\Subaffiliate;
use App\Models\HelperModel;
use App\Models\User;
use App\Rules\Email\Blocked;
use App\Rules\Email\Domain;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * A User model.
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->user       = new User();
        $this->redirectTo = url()->previous();
    }

    /**
     * @param $driver
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToSocial($driver)
    {
        session()->put('route', request()->server('HTTP_REFERER'));

        return Socialite::driver($driver)->redirect();
    }

    /**
     * @param $driver
     *
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function handleSocialCallback(Request $request, $driver)
    {
        try {
            $social_user = Socialite::driver($driver)->stateless()->user();
            $user        = User::query()->where('email', '=', $social_user->getEmail())->first();

            if (is_null($user)) {
                $user = User::query()->where('facebook_token', '=', $social_user->token)
                    ->orWhere('google_token', '=', $social_user->token)
                    ->first();
            }

            if (!is_null($user)) {
                if ($user->roles[0]->title === 'Affiliate') {
                    Auth::login($user);

                    return redirect()->route('affiliate.home');
                } else {
                    $authController = new AuthController();
                    $request->request->add([
                        'accessToken' => $social_user->token,
                    ]);
                    $authController->loginWithSocialite($request, $driver);

                    if (auth()->user()->type == 2) {
                        return redirect()->route('home');
                    } else {
                        /* return redirect()->route('jtc_welcome'); */
                        return redirect()->route('courses');
                    }
                }
            } elseif (!is_null($social_user)) {
                if (session('route') == route('affiliate.login')) {
                    /**
                     * @var $newUser User;
                     */

                    $newUser           = new User;
                    $newUser->name     = $social_user->name;
                    $newUser->email    = $social_user->email;
                    $newUser->verified = 1;

                    if ($driver == 'facebook') {
                        $newUser->facebook_token = $social_user->token;
                    } elseif ($driver == 'gmail') {
                        $newUser->google_token = $social_user->token;
                    }

                    $newUser->save();
                    $newUser->roles()->sync(4);

                    // Create an Affiliate.
                    $affiliate = Affiliate::create([
                        'user_id' => $newUser->id,
                    ]);

                    // Create a Subaffiliate
                    Subaffiliate::create([
                        'affiliate_id' => $affiliate->id,
                        'tracking_id'  => uniqid(),
                        'name'         => $newUser->name,
                        'email'        => $newUser->email,
                    ]);

                    return redirect()->route('affiliate.home');
                    // TODO Check is this needed anymore
                    // return view('auth.socialRegister', [
                    //  'social_user' => $newUser->id,
                    // ]);
                } else {
                    $authController = new AuthController();
                    $request->request->add([
                        'accessToken' => $social_user->token,
                    ]);
                    $authController->loginWithSocialite($request, $driver);


                    if (auth()->user()->type == 2) {
                        return redirect()->route('home');
                    } else {
                        /* return redirect()->route('jtc_welcome'); */
                        return redirect()->route('courses');
                    }
                }
            } else {
                return redirect()->back()->withErrors(trans('auth.failed'));
            }
        } catch (Exception $e) {
            Log::notice("\n\n" . '::LoginController::handleSocialCallback::$e');
            Log::notice($e);

            return redirect('home');
        }
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $dataForm = $request->all();

        $rules = [
            'email'       => ['required', 'string', 'email', new Domain, new Blocked],
            'password'    => ['required', 'string'],
            'remember_me' => 'boolean',
        ];

        $validator = Validator::make($request->only('email', 'password', 'remember_me'), [
            'email'       => ['required', 'string', 'email', new Domain, new Blocked],
            'password'    => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'remember_me' => 'boolean',
        ]);

        // dd($validator->errors());

        $validator = validator($dataForm, $rules);

        Log::notice("\n\n" . '::AuthController::login::$validator');
        Log::notice($validator->errors()->all());

        if (!empty($validator->errors()->all())) {
            $response = response()->json([
                'error'   => $validator->errors()->all(),
                'success' => false,
            ], 200);

            Log::notice("\n\n" . '::AuthController::login::failed_validation::$response');
            Log::notice($response);

            return $response;
        }

        $validatedEmailResponse = HelperModel::validateEmail($request->input('email'))->getData(true);

        if (!$validatedEmailResponse['success']) {
            return $validatedEmailResponse;
        }

        $credentials = request(['email', 'password']);

        Log::notice("\n\n" . '::AuthController::login::$credentials');
        Log::notice($credentials);

        if (!Auth::attempt($credentials)) {
            $response = response()->json([
                'message' => 'Wrong email or password, please try again.',
                'success' => false,
            ], 200);

            Log::notice("\n\n" . '::AuthController::login::credentials::$response');
            Log::notice($response);

            return $response;
        }

        // In case the user is not verified,
        if (Auth::attempt($credentials)) {
            if (!auth()->user()->verified) {
                auth()->logout();

                return response()->json([
                    'success' => false,
                    'message' => __('UNVERIFIED_MESSAGE'),
                ]);
            }
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     */
    protected function sendLoginResponse(Request $request)
    {
        /**
         * Get the Role of currently logged-in User.
         */
        $role = $this->user->current()->role()->title;

        /**
         * Redirect Path according to the User role.
         */
        $redirectPath = $this->getRedirectPathByRole($role);

        /**
         * Generate Bearer token and store it into a session.
         */
        $token = $this->user->current()->createToken('Personal Access Token')->accessToken;

        /**
         * Update user's Timezone.
         */
        $this->user->current()->update([
            'timezone' => ($request->input('timezone_offset') ?: session()->get('timezone_offset')),
        ]);

        session()->put('access_token', 'Bearer ' . $token);
        session()->put('timezone_offset', $request->input('timezone_offset'));

        /**
         * Response to be returned.
         */
        $response = response()->json([
            'message' => trans('SUCCESIFUL_LOGIN'),
            'success' => true,
            'path'    => $redirectPath,
        ]);

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $request->wantsJson() ? $response : redirect()->intended($redirectPath);
    }

    /**
     * Return Redirect Path according to User Role.
     *
     * @param  string  $role
     *
     * @return string
     */
    protected function getRedirectPathByRole(string $role): string
    {
        switch ($role) {
            case 'Teacher':
                return redirect()->intended()->getTargetUrl() ?? route('home');
            case 'Affiliate':
                return route('affiliate.home');
            case 'Admin':
                return route('admin.home');
            default:
                return redirect()->intended()->getTargetUrl() ?? route('courses');
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        if (auth()->check() && auth()->user()->userRole() == 'Admin') {
            $redirectPath = 'login-admin';
        } else {
            $redirectPath = 'home';
        }

        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        /*
         * Laravel specific logic
         */
        Auth::logout();

        session()->forget('url.intended');

        return redirect()->route($redirectPath);
    }
}
