<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\Password\Lowercase;
use App\Rules\Password\Number;
use App\Rules\Password\SpecialCharacter;
use App\Rules\Password\Uppercase;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255', 'regex:/([a-zA-Z]+\s?\b){2,}/'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'string', 'min:8', 'max:50', new Uppercase(), new Lowercase(), new Number(), new SpecialCharacter()],
        ], ['name.regex' => 'Only letters allowed for the name']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $verificationMessage = config('app.frontend_url') . '/verification-account?id=' . $user->id . '&hash=' . $user->verification_token;

//        EmailsHolderController::accountActivation('english', $data['email'], $data['name'], 'moj-url', $verificationMessage, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        Mail::to($data['email'])->queue(new AccountActivation('en', $data['email'], $data['name'], 'moj-url', $verificationMessage, date('Y-m-d H:i:s')));

        return $user;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param                            $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function socialiteRegister(\Illuminate\Http\Request $request, $user)
    {
        $requestedUser       = User::query()->find($user);
        $requestedUser->name = $request->input('name');
        $requestedUser->save();


        Auth::login($requestedUser);

        if ($requestedUser->roles[0]->title === 'Affiliate') {
            return redirect()->route('affiliate.home');
        }

        return redirect('/');
    }
}
