<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Entity\CallTypes;
use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use App\Http\Controllers\Api\V1\Admin\UsersApiController;
use App\Http\Controllers\Controller;
use App\Mail\AccountActivation;
use App\Models\Affiliates\Subaffiliate;
use App\Models\BillingAddress;
use App\Models\Country;
use App\Models\HelperModel;
use App\Models\JoinTheClub;
use App\Models\Notifications;
use App\Models\PartnerUser;
use App\Models\SocketParticipant;
use App\Models\StaticMetric;
use App\Models\User;
use App\Models\UserImages;
use App\Rules\Password\Lowercase;
use App\Rules\Password\Number;
use App\Rules\Password\SpecialCharacter;
use App\Rules\Password\Uppercase;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Laravel\Facades\Image;
use Laravel\Socialite\Facades\Socialite as Socialite;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api\V1\Auth
 */
class AuthController extends Controller
{

    const DIRECTORY_USER_IMAGES   = 'assets/images/user/';
    const SOCIALITE_TYPE_GOOGLE   = 'google';
    const SOCIALITE_TYPE_FACEBOOK = 'facebook';
    const SOCIALITE_TYPE_APPLE    = 'apple';

    use ResetsPasswords;

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $dataForm = $request->all();

                $rules = [
                    'name'     => 'required|string|min:2|max:100',
                    'email'    => 'required|string|email|unique:users',
                    'password' => ['required', 'string', 'min:8', 'max:50', new Uppercase(), new Lowercase(), new Number(), new SpecialCharacter()],
                ];

                app()->setLocale($request->header('Application-Language', 'de'));

                $messages = [
                    'name.required'     => __('ATTRIBUTE_REQUIRED', ['attribute' => 'name']),
                    'name.string'       => __('ATTRIBUTE_STRING', ['attribute' => 'name']),
                    'name.min'          => __('ATTRIBUTE_MIN', ['attribute' => 'name']),
                    'name.max'          => __('ATTRIBUTE_MAX', ['attribute' => 'name']),
                    'email.email'       => __('ATTRIBUTE_EMAIL', ['attribute' => 'email']),
                    'email.required'    => __('ATTRIBUTE_REQUIRED', ['attribute' => 'email']),
                    'email.string'      => __('ATTRIBUTE_STRING', ['attribute' => 'email']),
                    'email.unique'      => __('ATTRIBUTE_UNIQUE', ['attribute' => 'email']),
                    'password.required' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'password']),
                    'password.string'   => __('ATTRIBUTE_STRING', ['attribute' => 'password']),
                    'password.min'      => __('ATTRIBUTE_MIN', ['attribute' => 'password']),
                    'password.max'      => __('ATTRIBUTE_MAX', ['attribute' => 'password']),
                ];

                $validator = validator($dataForm, $rules, $messages);

                Log::notice('::AuthController::register::$validator');
                Log::notice($validator->errors()->messages());

                if (!empty($validator->errors()->messages())) {
                    $response = response()->error([
                        'message' => 'Fields validation failed.',
                        'data'    => [
                            'errors' => $validator->errors()->messages(),
                        ],
                    ], 400);

                    Log::notice('::AuthController::register::$response');
                    Log::notice($response);

                    return $response;
                }

                Log::notice('::AuthController::register::$request');
                Log::notice($request->all());

                $validatedEmailResponse = HelperModel::validateEmail($request->email)->getData(true);

                if (!$validatedEmailResponse['success']) {
                    return $validatedEmailResponse;
                }

                if (isset($request->affiliateRefereeHash) && !empty($request->affiliateRefereeHash)) {
                    $subAffiliate = Subaffiliate::query()
                        ->select('id', 'affiliate_id')
                        ->where('tracking_id', $request->affiliateRefereeHash)
                        ->first();
                }

                $partnerUser = PartnerUser::query()
                    ->where('partner_id', $request->route()->partner ? $request->route()->partner->id : null)
                    ->where('email', $request->partner_email)
                    ->first();

                $user = new User([
                    'name'                        => $request->name,
                    'username'                    => $partnerUser ? $request->username : null,
                    'email'                       => $request->email,
                    'description'                 => $partnerUser ? $request->description : null,
                    'affiliates_sub_id'           => $subAffiliate->id ?? null,
                    'affiliates_sub_affiliate_id' => $subAffiliate->affiliate_id ?? null,
                    'affiliates_valid_until'      => isset($subAffiliate->id) ? Carbon::now()->addYears(1) : Carbon::now(),
                    'password'                    => bcrypt($request->password),
                    'profile_picture_tmp'         => $partnerUser ? $request->image : config('app.default_image'),
                    'vat_id'                      => Country::GERMANY,
                    'timezone'                    => $request->timezone_offset ?? $request->header('Time-Zone-Offset-UTC', 0),
                    'partner_id'                  => $partnerUser ? ($partnerUser->is_unique ? $partnerUser->partner_id : null) : null,
                    'partner_user_id'             => $partnerUser->id ?? null,
                ]);

                $user->save();

                if ($user->partner_id && $user->partner_user_id && $partnerUser->is_unique) {
                    $user->createJTC();
                    $user->createTalks();
                    $user->createAvailabilities();
                    $user->createImageVerification($request->image);

                    $dashboard = $partnerUser->partner->dashboard;
                    $dashboard->update([
                        'total_new_registrations' => DB::raw('total_new_registrations + 1'),
                    ]);
                }

                $user->notificationSettings()->create([
                    'bookings'   => true,
                    'payments'   => true,
                    'followings' => true,
                    'reviews'    => true,
                    'payouts'    => true,
                ]);

                Log::notice('::AuthController::register::$user');
                Log::notice($user);

                $verificationMessage = config('app.frontend_url') . '/verification-account?id=' . $user->id . '&hash=' . $user->verification_token . '&user_email=' . $request->email;

//            $emailResponse       = EmailsHolderController::accountActivation('english', $request->email, $request->username, 'moj-url', $verificationMessage, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
                $emailResponse = Mail::to($request->email)->queue(
                    new AccountActivation(
                        $request->header('Application-Language', session('language')),
                        $request->email,
                        $request->name,
                        $verificationMessage,
                        date('Y-m-d H:i:s')
                    )
                );

                Log::notice('::AuthController::register::$emailResponse');
                Log::notice($emailResponse);

                $notificationData = [
                    'user_id' => $user->id,
                    'type'    => 'custom',
                    'value'   => Notifications::VALUE['offer_your_talks'],
                ];

                $notification = NotificationsApiController::sendNotification($request, $notificationData);

                Log::notice("\n\n" . '::AuthController::register::$notification');
                Log::notice($notification);

                $response = response()->json([
                    'message' => 'Successfully created user!',
                    'success' => true,
                ]);
                Log::notice('::AuthController::register::$response');
                Log::notice($response);

                return $response;
            });
        } catch (\Exception $exception) {
            Log::error($exception);

            return response()->json([
                'message' => 'Request failed',
                'success' => false,
            ], 500);
        }
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Login with Google and create token
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function loginWithGoogle(Request $request)
    {
        return $this->loginWithSocialite($request, self::SOCIALITE_TYPE_GOOGLE);
    }

    /**
     * Login with Facebook and create token
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */

    /**
     * Login with Socialite (google|facebook) and create token
     *
     * @param  [string] accessToken
     * @param  [string] driver (google, facebook)
     *
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function loginWithSocialite(Request $request, $driver)
    {
        DB::beginTransaction();

        Log::notice("\n\n" . '::AuthController::loginWithSocialite::$request');
        Log::notice($request->all());

        $request->validate([
            'accessToken'   => ['required', 'string'],
            'partner_email' => ['sometimes', 'email'],
            'name'          => ['sometimes', 'nullable', 'string'],
        ]);

        $credentials = request(['accessToken']);

        Log::notice($credentials);

        try {
            if ($driver === self::SOCIALITE_TYPE_APPLE) {
                $apple_response = \Http::asForm()->withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])->post('https://appleid.apple.com/auth/token', [
                    'client_id'     => config('socials.apple.client_id'),
                    'client_secret' => config('socials.apple.client_secret'),
                    'grant_type'    => 'authorization_code',
                    'code'          => $credentials['accessToken'],
                ]);

                $credentials['accessToken'] = $apple_response->json('id_token');
            }

            $socialiteUser = Socialite::driver($driver)->stateless()->userFromToken($credentials['accessToken']);
            $partnerUser   = PartnerUser::query()
                ->where('email', '=', $request->partner_email ?? session()->get('email'))
                ->where('partner_id', '=', $request->partner_id)
                ->first();
            $new_user      = true;

            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$email');
            Log::notice($request->email);
            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$partnerUser');
            Log::notice(json_encode($partnerUser));
            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$socialiteUser');
            Log::notice(var_export($socialiteUser, true));

            if ($driver === self::SOCIALITE_TYPE_APPLE) {
                // TODO need improvements
                // from apple unique field is ID (not email)
                // email can be hidden / obfuscated
                // check apple_token (only saved ID) and email for user
                if (!empty($socialiteUser->getEmail())) {
                    $user = User::query()->where('email', $socialiteUser->getEmail())->first();
                }

                if (empty($user)) {
                    $user = User::query()->where('apple_token', $socialiteUser->getID())->first();
                }
            } else {
                $socialiteUserEmail = $socialiteUser->getEmail();

                Log::notice("\n\n" . '::AuthController::loginWithSocialite::$user::email');
                Log::notice($socialiteUserEmail);

                $user = User::withTrashed()->where('email', $socialiteUserEmail)->first();
            }

            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$user');
            Log::notice(json_encode($user));

            if (empty($user)) {
                if ($driver === self::SOCIALITE_TYPE_GOOGLE) {
                    $fields = [
                        'google_token'        => $socialiteUser->getID(),
                        'google_details'      => json_encode($socialiteUser),
                        'login_type'          => User::LOGIN_TYPE['gmail'],
                        'name'                => $partnerUser ? $request->name : $socialiteUser->getName(),
                        'profile_picture_tmp' => config('app.default_image'),
                    ];
                } elseif ($driver === self::SOCIALITE_TYPE_FACEBOOK) {
                    $fields = [
                        'facebook_token'      => $socialiteUser->getID(),
                        'facebook_details'    => json_encode($socialiteUser),
                        'login_type'          => User::LOGIN_TYPE['facebook'],
                        'name'                => $partnerUser ? $request->name : $socialiteUser->getName(),
                        'profile_picture_tmp' => config('app.default_image'),
                    ];
                } else {
                    $fields = [
                        'apple_token'         => $socialiteUser->getID(),
                        'apple_details'       => json_encode($apple_response) ?: null,
                        'login_type'          => User::LOGIN_TYPE['apple'],
                        'name'                => $request->name,
                        'profile_picture_tmp' => config('app.default_image'),
                    ];
                }


                Log::notice("\n\n" . '::AuthController::loginWithSocialite::$fields');
                Log::notice(
                    var_export(
                        array_merge([
                            'email'    => $socialiteUser->getEmail(),
                            'password' => bcrypt($socialiteUser->getID()),
                            'verified' => true,
                        ], $fields),
                        true
                    )
                );

                if (isset($_COOKIE['affiliateRefereeHash']) && !empty($_COOKIE['affiliateRefereeHash'])) {
                    $subAffiliate = Subaffiliate::query()
                        ->select('id', 'affiliate_id')
                        ->where('tracking_id', $_COOKIE['affiliateRefereeHash'])
                        ->first();

                    setcookie("affiliateRefereeHash", '', time() + (24 * 3600 * 30), "/lp");
                    setcookie("affiliateRefereeHash", '', time() + (24 * 3600 * 30), "/account/signup");
                    setcookie("affiliateRefereeHash", '', time() + (24 * 3600 * 30), "/account/login");
                    setcookie("affiliateRefereeHash", '', time() + (24 * 3600 * 30), "/login/facebook/callback");
                    setcookie("affiliateRefereeHash", '', time() + (24 * 3600 * 30), "/login/google/callback");
                }

                $user = new User(
                    array_merge([
                        'email'                       => $socialiteUser->getEmail(),
                        'password'                    => bcrypt($socialiteUser->getID()),
                        'affiliates_sub_id'           => $subAffiliate->id ?? null,
                        'affiliates_sub_affiliate_id' => $subAffiliate->affiliate_id ?? null,
                        'affiliates_valid_until'      => isset($subAffiliate->id) ? Carbon::now()->addYears(1) : Carbon::now(),
                        'approved'                    => true,
                        'verified'                    => true,
                        'timezone'                    => $request->header('Time-Zone-Offset-UTC') ?? session()->get('timezone_offset'),
                        'vat_id'                      => Country::GERMANY,
                        'partner_id'                  => $partnerUser ? ($partnerUser->is_unique ? $partnerUser->partner_id : null) : null,
                        'partner_user_id'             => $partnerUser->id ?? null,
                    ], $fields)
                );

                $user->save();

                if ($user->partner_id && $user->partner_user_id && $partnerUser->is_unique) {
                    $user->createJTC(false);
                    $user->createTalks();
                    $user->createAvailabilities();
                    $user->createImageVerification($socialiteUser->getAvatar());
                }
            } elseif ($driver === self::SOCIALITE_TYPE_APPLE) {
                $new_user = false;

                $user->update([
                    'apple_token'   => $socialiteUser->getID(),
                    'apple_details' => $apple_response->json(),
                    'timezone'      => $request->header('Time-Zone-Offset-UTC') ?? session()->get('timezone_offset'),
                ]);
            } else {
                $new_user = false;

                $user->update([
                    "{$driver}_token"   => $socialiteUser->getID(),
                    "{$driver}_details" => json_encode($socialiteUser),
                    'timezone'          => $request->header('Time-Zone-Offset-UTC') ?? session()->get('timezone_offset'),
                    // 'partner_id'        => $partnerUser ? $partnerUser->partner_id : null,
                    'partner_user_id'   => $partnerUser ? $partnerUser->id : null,
                ]);

                if ($partnerUser) {
                    $partnerUser->update([
                        'is_unique' => false,
                    ]);
                }
            }

            if (!$user->verified) {
                $response = response()->error(__('ACCOUNT_NOT_VERIFIED'), 401);

                Log::notice("\n\n" . '::AuthController::loginWithSocialite::verified::$response');
                Log::notice($response);

                DB::rollBack();

                return $response;
            } else {
                if ($user->state == User::STATE['spam']) {
                    $response = response()->error(__('MARKED_AS_SPAM'), 401);

                    Log::notice("\n\n" . '::AuthController::loginWithSocialite::spam::$response');
                    Log::notice($response);

                    DB::rollBack();

                    return $response;
                } else {
                    if ($user->state == User::STATE['deactivated']) {
                        $response = response()->error(__('MARKED_AS_DEACTIVATED'));

                        Log::notice("\n\n" . '::AuthController::loginWithSocialite::spam::$response');
                        Log::notice($response);

                        DB::rollBack();

                        return $response;
                    } else {
                        if (!empty($user->deleted_at)) {
                            $response = response()->error(__('USER_DELETED'), 401);

                            Log::notice("\n\n" . '::AuthController::loginWithSocialite::spam::$response');
                            Log::notice($response);

                            DB::rollBack();

                            return $response;
                        }
                    }
                }
            }

            /**
             * Generate Bearer token and store it into a session.
             */
            $token = $user->createToken('Personal Access Token')->accessToken;

            session()->put('access_token', 'Bearer ' . $token);

            Auth::login($user);

            $avatar = \Http::withHeaders(['Authorization' => "Bearer $token"])
                ->post(config('app.backend_url') . '/v1/profile-picture', [
                    'avatar' => $request->image ?? $socialiteUser->getAvatar(),
                ]);

            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$avatar status');
            Log::notice($avatar->status());

            $user = $request->user();

            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$token');

            $firebase_token = $request->input('fcm_token');
            $firebase_type  = $request->input('device_type');
            $voip_token     = $request->input('voip_token');

            if (!empty($firebase_type)) {
                if (!empty($firebase_token) && $firebase_token != $user->firebase_id) {
                    Log::notice("\n\n" . '::AuthController::loginWithSocialite::$firebase_token');
                    Log::notice($firebase_token);

                    User::query()->where('id', $user->id)->update(['firebase_id' => $firebase_token]);

                    User::query()->where('firebase_id', $firebase_token)->where('id', '!=', $user->id)->update(['firebase_id' => null]);
                }

                if (/*!empty($voip_token) && */ $voip_token != $user->voip_token) {
                    Log::notice("\n\n" . '::AuthController::loginWithSocialite::$firebase_token');
                    Log::notice($voip_token);

                    User::query()->where('id', $user->id)->update(['voip_token' => $voip_token]);

                    if (!empty($voip_token)) {
                        User::query()->where('voip_token', $voip_token)->where('id', '!=', $user->id)->update(['voip_token' => null]);
                    }
                }

                if (!empty($voip_token) && $firebase_type == 'ios' && $voip_token != $user->voip_token) {
                    SocketParticipant::query()->where('user_id', $user->id)->update(['firebase_id' => $voip_token]);

                    SocketParticipant::query()->where('user_id', '!=', $user->id)->where('firebase_id', $voip_token)->update(['firebase_id' => null]);
                } elseif (!empty($firebase_token) && $firebase_type == 'android' && $firebase_token != $user->firebase_id) {
                    SocketParticipant::query()->where('user_id', $user->id)->update(['firebase_id' => $firebase_token]);

                    SocketParticipant::query()->where('user_id', '!=', $user->id)->where('firebase_id', $firebase_token)->update(['firebase_id' => null]);
                }
            }

            if (!empty($firebase_type) && $firebase_type != $user->device_type) {
                Log::notice("\n\n" . '::AuthController::loginWithSocialite::$firebase_type');
                Log::notice($firebase_type);

                User::query()->where('id', $user->id)->update(['device_type' => $firebase_type]);
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token       = $tokenResult->token;
            $token->save();

            Log::notice("\n\n" . '::AuthController::login::loginWithSocialite::$token');
            Log::notice($token);

            if ($new_user) {
                $notificationData = [
                    'user_id' => $user->id,
                    'type'    => 'custom',
                    'value'   => Notifications::VALUE['offer_your_talks'],
                ];

                $user->notificationSettings()->create([
                    'bookings'   => true,
                    'payments'   => true,
                    'followings' => true,
                    'reviews'    => true,
                    'payouts'    => true,
                ]);

                $notification = NotificationsApiController::sendNotification($request, $notificationData);

                Log::notice("\n\n" . '::AuthController::register::$notification');
                Log::notice($notification);
            }


            $existJoinTheClub = JoinTheClub::query()->where('users_id', $user->id)->exists();

            if (!$existJoinTheClub) {
                $joinTheClubStepOne           = new JoinTheClub();
                $joinTheClubStepOne->users_id = $user->id;
                $joinTheClubStepOne->save();
            }

            $existStaticMetric = StaticMetric::query()->where('user_id', $user->id)->exists();

            if (!$existStaticMetric) {
                //Create static metric
                $staticMetric          = new StaticMetric();
                $staticMetric->user_id = $user->id;
                $staticMetric->save();
            }

            $response = response()->success([
                'message' => 'Successfully logged-in using ' . ($driver === self::SOCIALITE_TYPE_GOOGLE ? 'google' : ($driver === self::SOCIALITE_TYPE_FACEBOOK ? 'facebook' : 'apple')) . ' account.',
                'data'    => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type'   => 'Bearer',
                    'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                ],
            ]);

            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$response');
            Log::notice($response);

            DB::commit();

            return $response;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::notice("\n\n" . '::AuthController::loginWithSocialite::$e');
            Log::notice($e);

            return response()->error('Unauthorized 1', 401);
        }
    }

    /**
     * Login with Apple and create token
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     *
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        try {
            $dataForm = $request->all();

            $rules = [
                'email'       => 'required|string|email',
                'password'    => 'required|string',
                'remember_me' => 'boolean',
            ];

            $validator = validator($dataForm, $rules);

            Log::notice("\n\n" . '::AuthController::login::$validator');
            Log::notice($validator->errors()->all());

            if (!empty($validator->errors()->all())) {
                // $response = response()->json([
                //     'error'   => $validator->errors()->all(),
                //     'success' => false,
                // ], 200);

                $response = response()->error([
                    'message' => 'Failed to login',
                    'data'    => [
                        'errors' => $validator->errors()->all(),
                    ],
                ]);

                Log::notice("\n\n" . '::AuthController::login::failed_validation::$response');
                Log::notice($response);

                return response()->error([
                    'message' => 'Failed to login',
                    'data'    => [
                        'errors' => $validator->errors()->all(),
                    ],
                ]);
            }

            $validatedEmailResponse = HelperModel::validateEmail($request->input('email'))->getData(true);

            if (!$validatedEmailResponse['success']) {
                return $validatedEmailResponse;
            }

            $credentials = request(['email', 'password']);

            Log::notice("\n\n" . '::AuthController::login::$credentials');
            Log::notice($credentials);

            if (!Auth::attempt($credentials)) {
                $response = response()->error(__('WRONG_EMAIL_OR_PASSWORD'), 400);

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

            $user = $request->user();

            Log::notice("\n\n" . '::AuthController::login::$user');
            Log::notice($user);

            if (!$user->verified) {
                $response = response()->error(__('ACCOUNT_NOT_VERIFIED'), 400);

                Log::notice("\n\n" . '::AuthController::login::verified::$response');
                Log::notice($response);

                return $response;
            } else {
                if ($user->state == User::STATE['spam']) {
                    $response = response()->error(__('MARKED_AS_SPAM'), 400);

                    Log::notice("\n\n" . '::AuthController::login::spam::$response');
                    Log::notice($response);

                    return $response;
                } else {
                    if ($user->state == User::STATE['deactivated']) {
                        $response = response()->error(__('MARKED_AS_DEACTIVATED'), 200);

                        Log::notice("\n\n" . '::AuthController::login::spam::$response');
                        Log::notice($response);

                        return $response;
                    }
                }
            }

            $tokenResult = $user->createToken('Personal Access Token');
            $token       = $tokenResult->token;

            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            Log::notice("\n\n" . '::AuthController::login::$token');
            Log::notice($token);


            $firebase_token = $request->input('fcm_token');
            $firebase_type  = $request->input('device_type');
            $voip_token     = $request->input('voip_token');

            if (!empty($firebase_type)) {
                if (!empty($firebase_token) && $firebase_token != $user->firebase_id) {
                    Log::notice("\n\n" . '::AuthController::login::$firebase_token');
                    Log::notice($firebase_token);

                    User::query()->where('id', $user->id)->update(['firebase_id' => $firebase_token]);

                    User::query()->where('firebase_id', $firebase_token)->where('id', '!=', $user->id)->update(['firebase_id' => null]);
                }

                if (/*!empty($voip_token) && */ $voip_token != $user->voip_token) {
                    Log::notice("\n\n" . '::AuthController::login::$firebase_token');
                    Log::notice($voip_token);

                    User::query()->where('id', $user->id)->update(['voip_token' => $voip_token]);

                    if (!empty($voip_token)) {
                        User::query()->where('voip_token', $voip_token)->where('id', '!=', $user->id)->update(['voip_token' => null]);
                    }
                }

                if (!empty($voip_token) && $firebase_type == 'ios' && $voip_token != $user->voip_token) {
                    SocketParticipant::query()->where('user_id', $user->id)->update(['firebase_id' => $voip_token]);

                    SocketParticipant::query()->where('user_id', '!=', $user->id)->where('firebase_id', $voip_token)->update(['firebase_id' => null]);
                } elseif (!empty($firebase_token) && $firebase_type == 'android' && $firebase_token != $user->firebase_id) {
                    SocketParticipant::query()->where('user_id', $user->id)->update(['firebase_id' => $firebase_token]);

                    SocketParticipant::query()->where('user_id', '!=', $user->id)->where('firebase_id', $firebase_token)->update(['firebase_id' => null]);
                }
            }

            if (!empty($firebase_type) && $firebase_type != $user->device_type) {
                Log::notice("\n\n" . '::AuthController::login::$firebase_type');
                Log::notice($firebase_type);

                User::query()->where('id', $user->id)->update(['device_type' => $firebase_type]);
            }

            if ($user->last_language !== $request->header('Application-Language', 'en')) {
                User::query()->where('id', $user->id)->update([
                        'last_language' => $request->header('Application-Language', 'en'),
                    ]
                );
            }

            if (!empty($request->header('Time-Zone-Offset-UTC')) && $user->timezone !== $request->header('Time-Zone-Offset-UTC')) {
                User::query()->where('id', $user->id)->update([
                    'timezone' => $request->header('Time-Zone-Offset-UTC'),
                ]);
            }

            // $response = response()->json([
            //     'success' => true,
            //     'message' => 'Access granted',
            //     'data'    => [
            //         'access_token' => $tokenResult->accessToken,
            //         'token_type'   => 'Bearer',
            //         'expires_at'   => Carbon::parse(
            //             $tokenResult->token->expires_at
            //         )->toDateTimeString(),
            //     ],
            // ]);

            $response = response()->success([
                'message' => 'Access granted',
                'data'    => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type'   => 'Bearer',
                    'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                ],
            ]);

            Log::notice('::AuthController::login::final_response::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            // Log::error(var_export($exception, true));
            Log::error($exception->getMessage());
            //
            // return response()->json([
            //     'message' => 'Request failed',
            //     'success' => false,
            // ], 500);

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    /**
     * NOTE: only needed for login with apple on android
     *
     * Login with Apple Callback
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */

    /**
     * @OA\Post(
     *      path="/v1/user",
     *      operationId="user",
     *      tags={"Auth"},
     *      summary="Method user of AuthController",
     *      description="Method user of AuthController",
     *
     *      @OA\Response(
     *          response=201,
     *          description="successful operation",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Server error"),
     *      @OA\Response(response=503, description="Service unavailable"),
     *      security={
     *         {
     *             "bearer_token": {}
     *         }
     *     },
     * )
     */

    public function user(Request $request)
    {
        try {
            $availability = JoinTheClubApiController::joinTheClubAvailabilityCompleted($request)->getData(true);

            $talkBookingData = UsersApiController::userProfileTalkBookingData(
                $request->user()->id,
                $request->input('language', 'en')
            )->getData(true);

            $userFeedback = User::query()
                ->selectRaw('CAST(SUM(reviews) AS NUMERIC(10,1)) as total_reviews')
                ->selectRaw('CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS ratings')
                ->where('id', $request->user()->id)
                ->first()
                ->toArray();

            $jtcData = $availability['data'] ?? [
                'jtc_started'        => false,
                'step_basic_info'    => false,
                'step_talks'         => false,
                'step_availabilities'=> false,
                'step_verification'  => false,
            ];

            $dataTalkBooking = array_merge(
                $talkBookingData['data'],
                [
                    'jtc_started'                      => $jtcData['jtc_started'] ?? false,
                    // 'availability'                     => $jtcData['percentage'],
                    'availability_step_basic_info'     => $jtcData['step_basic_info'] ?? false,
                    'availability_step_talks'          => $jtcData['step_talks'] ?? false,
                    'availability_step_availabilities' => $jtcData['step_availabilities'] ?? false,
                    // 'availability_step_money'          => $jtcData['step_money'],
                    // 'availability_step_accounting'     => $jtcData['step_accounting'],
                    'availability_step_verification'   => $jtcData['step_verification'] ?? false,
                    'total_reviews'                    => $userFeedback['total_reviews'],
                    'ratings'                          => $userFeedback['ratings'],
                    'profile_picture'                  => $request->user()->profile_picture_tmp,
                    'state'                            => $request->user()->jtc?->state ?? null,
                ]
            );

            // return $request->user()->profileVerificationRequests;
            return response()->success([
                'message' =>
                    'Logged-in user',
                'data'    => array_merge(
                    $request->user()->only([
                        'id',
                        'type',
                        'visibility',
                        'verified',
                        'gender',
                        'name',
                        'username',
                        'email',
                        'paypal_email',
                        'description',
                        'wallet_balance',
                        'profession',
                        'youtube_video',
                        'billing_address_id',
                        'notification_message',
                        'notification_sound',
                        'approved',
                        'login_type',
                        'vat_id',
                    ]),
                    $dataTalkBooking,
                    [
                        'pays_vat'          => (bool)(BillingAddress::select('pays_vat')->where('user_id', $request->user()->id)->latest()->first()->pays_vat ?? null),
                        'gallery_talks_count' => $request->user()->talks()
                            ->withGroup()
                            ->where('call_type', CallTypes::GROUP)
                            ->count(),
                        'is_me'             => true,
                        'account_verified'  => $request->user()->pendingProfileVerificationRequest ? $request->user()->pendingProfileVerificationRequest->status : null,
                        'partner'           => $request->user() ? ($request->user()->partner ? $request->user()->partner->only('id', 'name', 'slug', 'logo', 'url') : null) : null,
                    ],
                ),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    public function loginWithFacebook(Request $request)
    {
        return $this->loginWithSocialite($request, self::SOCIALITE_TYPE_FACEBOOK);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */

    /**
     * @OA\Post(
     *      path="/v1/login-with-apple",
     *      operationId="loginWithApple",
     *      tags={"Auth"},
     *      summary="Method loginWithApple of AuthController",
     *      description="Method loginWithApple of AuthController",
     *
     *      @OA\Response(
     *          response=201,
     *          description="successful operation",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Server error"),
     *      @OA\Response(response=503, description="Service unavailable"),
     *      security={
     *         {
     *             "bearer_token": {}
     *         }
     *     },
     * )
     */

    public function loginWithApple(Request $request)
    {
        return $this->loginWithSocialite($request, self::SOCIALITE_TYPE_APPLE);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */

    /**
     * @OA\Get(
     *      path="/v1/callbacks/login-with-apple",
     *      operationId="loginWithAppleCallback",
     *      tags={"Auth"},
     *      summary="Method loginWithAppleCallback of AuthController",
     *      description="Method loginWithAppleCallback of AuthController",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Server error"),
     *      @OA\Response(response=503, description="Service unavailable"),
     *      security={
     *         {
     *             "bearer_token": {}
     *         }
     *     },
     * )
     */


    public function loginWithAppleCallback(Request $request)
    {
        try {
            Log::notice('::AuthController::loginWithAppleCallback::test::$request');

            Log::notice($request);

            // get abstract user object, not persisted
            $user = Socialite::driver(self::SOCIALITE_TYPE_APPLE)
                ->user();

            Log::notice('::AuthController::loginWithAppleCallback::Socialite::$user');
            Log::notice($user);

            // or use Socialiter to automatically manage user resolution and persistence
//            $user = Socialiter::driver(self::SOCIALITE_TYPE_APPLE)
//                ->login();
//
//            Log::notice('::AuthController::loginWithAppleCallback::Socialiter::$user');
//            Log::notice($user);B

        } catch (\Exception $e) {
            Log::notice('::AuthController::loginWithApple::exception::$e');
            Log::notice($e);

            // return response()->json([
            //     'message' => $e,
            // ], 500);

            return response()->error($e, 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/v1/forgot-password",
     *      operationId="sendResetLinkEmail",
     *      tags={"Auth"},
     *      summary="Method sendResetLinkEmail of AuthController",
     *      description="Method sendResetLinkEmail of AuthController",
     *
     *      @OA\Response(
     *          response=201,
     *          description="successful operation",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Server error"),
     *      @OA\Response(response=503, description="Service unavailable"),
     *      security={
     *         {
     *             "bearer_token": {}
     *         }
     *     },
     * )
     */

    public function storeProfilePicture(Request $request)
    {
        Log::notice("\n\n" . '::AuthController::storeProfilePicture::$request');
        Log::notice(var_export($request->all(), true));

        $user            = $request->user();
        $avatar          = $request->input('avatar');
        $imageName       = "{$user->id}.jpg";
        $imagePath       = self::DIRECTORY_USER_IMAGES . $user->id;
        $imagePathPublic = public_path($imagePath);

        if (!is_dir($imagePathPublic)) {
            mkdir($imagePathPublic, 0777, true);
        }

        try {
            Image::read($avatar)->resize(300, 300)->save($imagePathPublic . DIRECTORY_SEPARATOR . $imageName);
            $image = config('app.backend_url') . '/assets/images/user/' . $user->id . '/' . $imageName;
        } catch (\Exception $e) {
            $image = config('app.backend_url') . '/assets/images/avatar.svg';
            Log::notice("\n\n" . '::AuthController::storeProfilePicture::$exception');
            Log::error($e->getMessage());
        }

        $userImage          = new UserImages;
        $userImage->user_id = $user->id;
        $userImage->image   = $image;
        $userImage->state   = UserImages::STATE['approved'];
        $userImage->size    = 300;
        $userImage->save();

        Log::notice("\n\n" . '::AuthController::storeProfilePicture::$userImage');
        Log::notice($userImage);

        $user->update([
            'profile_picture_tmp' => $userImage->image . "?t=" . microtime(true),
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            Log::notice("\n\n" . '::AuthController::sendResetLinkEmail::$request');
            Log::notice($request->all());

            $this->validateEmail($request);

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $result = $this->broker()->sendResetLink(
                $this->credentials($request)
            );

            // Code below was commented out due to the fact that in case an email that
            // does not exist in our database is used, error message will be thrown.

            // if ($result == Password::RESET_LINK_SENT) {
            //     // $response = response()->json([
            //     //     'success' => true,
            //     //     'message' => __('SUCCESSFULLY_SENT_PASSWORD_RESET,
            //     // ]);
            //     $response = response()->success(__('SUCCESSFULLY_SENT_PASSWORD_RESET);
            // } else {
            //     // $response = response()->json([
            //     //     'success' => false,
            //     //     'message' => 'Error happen during send reset password',
            //     //     'errors'  => $this->sendResetLinkFailedResponse($request, $result),
            //     // ]);
            //
            //     $response = response()->errors([
            //         'message' => 'Error happen during send reset password',
            //         'data'    => [
            //             'errors' => $this->sendResetLinkFailedResponse($request, $result),
            //         ],
            //     ]);
            // }

            $response = response()->success(__('RESET_PASSWORD_RESPONSE'));

            Log::notice("\n\n" . '::AuthController::sendResetLinkEmail::$response');
            Log::notice($response);

            return $response;


//        return $response == Password::RESET_LINK_SENT
//            ? $this->sendResetLinkResponse($request, $response)
//            : $this->sendResetLinkFailedResponse($request, $response);
        } catch (\Exception $e) {
            // return response()->json([
            //     'message' => $e,
            // ], 500);
            return response()->error($e, 500);
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [trans($response)],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * @OA\Post(
     *      path="/v1/reset-password",
     *      operationId="resetLink",
     *      tags={"Auth"},
     *      summary="Method resetLink of AuthController",
     *      description="Method resetLink of AuthController",
     *
     *      @OA\Response(
     *          response=201,
     *          description="successful operation",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Server error"),
     *      @OA\Response(response=503, description="Service unavailable"),
     *      security={
     *         {
     *             "bearer_token": {}
     *         }
     *     },
     * )
     */
    public function resetLink(Request $request)
    {
        try {
            Log::notice("\n\n" . '::AuthController::resetLink::$request');
            Log::notice($request->all());

            $input     = $request->only('email', 'token', 'password', 'password_confirmation');
            $validator = Validator::make($input, [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => ['required', 'confirmed', 'string', 'min:8', 'max:50', new Uppercase(), new Lowercase(), new Number(), new SpecialCharacter()],
            ]);

            if ($validator->fails()) {
                // return response()->json($validator->errors());

                return response()->error([
                    'message' => 'Validation failed.',
                    'data'    => [
                        'errors' => $validator->errors(),
                    ],
                ]);
            }
            $result = Password::reset($input, function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            });

            if ($result == Password::PASSWORD_RESET) {
                $response = response()->success(__('SUCCESSFULLY_SENT_PASSWORD_RESET'));
            } else {
                $response = response()->error([
                    'message' => __('SOMETHING_WENT_WRONG'),
                    'data'    => [
                        'errors' => $this->sendResetFailedResponse($request, $result),
                    ],
                ]);
            }

            Log::notice("\n\n" . '::AuthController::resetLink::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $e) {
            // return response()->json([
            //     'message' => $e->getMessage(),
            // ], 500);

            return response()->error($e->getMessage(), 500);
        }
    }

    /**
     * Get the authenticated User
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     */

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $firebase_type = $request->input('device_type');

        if (isset($request->user()->id) && in_array($firebase_type, ['ios', 'android'])) {
            User::query()->find($request->user()->id)->update(['firebase_id' => null, 'voip_token' => null]);

            SocketParticipant::query()->where('user_id', $request->user()->id)->update(['firebase_id' => null]);
        }

        $request->user()->token()->revoke();

        return response()->success(__('SUCCESSFULLY_LOGGED_OUT'));
    }


    /**
     * @OA\Post(
     ** path="/v1/logout",
     *   tags={"Auth"},
     *   summary="Logout",
     *   operationId="logout",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     *
     * @return [string] message
     */

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($response)], 200)
            : back()->with('status', trans($response));
    }
}
