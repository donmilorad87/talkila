<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivation;
use App\Models\Affiliates\Affiliate;
use App\Models\Affiliates\Affiliates;
use App\Models\Affiliates\Subaffiliate;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the request.
            $data = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'regex:/([a-zA-Z]+\s?\b){2,}/'
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:users'
                ],
                'password' => [
                    'required',
                    'min:8',
                    'regex:/[a-z]/',    // At least one lowercase letter
                    'regex:/[A-Z]/',    // At least one uppercase letter
                    'regex:/[0-9]/',    // At least one digit
                    'confirmed'
                ],
            ]);

            // Create User.
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => \Hash::make($data['password']),
            ]);

            // Assign Affiliate role.
            $user->roles()->sync(4);

            // Create an Affiliate.
            $affiliate = Affiliate::create([
                'user_id' => $user->id
            ]);

            // Create a Subaffiliate
            Subaffiliate::create([
                'affiliate_id' => $affiliate->id,
                'tracking_id' => uniqid(),
                'name' => $user->name,
                'email' => $user->email
            ]);

            // Send Verification message.
            $verificationMessage = env('APP_FRONTEND_URL') . '/verification-account?id=' . $user->id . '&hash=' . $user->verification_token;
            Mail::to($data['email'])->queue(new AccountActivation('en', $data['email'], $data['name'], 'moj-url', $verificationMessage, date('Y-m-d H:i:s')));

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();

            return redirect()->route('affiliate.register')->with('alert-danger', 'Something went wrong. Please try again.');
        }

        return redirect()->route('affiliate.login')->with('alert-success', 'We sent verification email, please verify your account.');
    }

}
