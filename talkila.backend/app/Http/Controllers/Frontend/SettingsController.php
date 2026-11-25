<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Api\V1\Admin\BillingAddressApiController;
use App\Http\Controllers\Api\V1\Admin\CalendarController;
use App\Http\Controllers\Api\V1\Admin\CreditCardController;
use App\Http\Controllers\Api\V1\Admin\PaymentMethodController;
use App\Http\Controllers\Api\V1\Admin\PayoutsMethodsApiController;
use App\Http\Controllers\Api\V1\Admin\PayPalController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Api\V1\Admin\UserBlockedApiController;
use App\Http\Controllers\Api\V1\Admin\UserFollowedApiController;
use App\Http\Controllers\Api\V1\Admin\VATController;
use App\Http\Controllers\Api\V1\Admin\WalletController;
use App\Http\Controllers\Controller;
use App\Mail\AccountDeleted;
use App\Models\Country;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Log;

class SettingsController extends Controller
{


    public function settings_profile(Request $request)
    {

        $blockedUsers     = new UserBlockedApiController();
        $blockedUsersData = $blockedUsers->usersBlocked($request)->getData(true);


        if ($request->has('code')) {

                $addCalendar     = new CalendarController();
                $addCalendarData = $addCalendar->connect($request)->getData(true);
                /* if ($addCalendarData['success']) {
                    Session::flash('alert-info', $addCalendarData['message']);
                } */

        }

        $calendars     = new CalendarController();
        $calendarsData = $calendars->calendars($request)->getData(true);

        return view('frontend.pages.settings_profile', [
            'page_name'                 => __('SETTINGS'),
            'blockedUsers'              => $blockedUsersData['data'] ?? [],
            'calendarsData'             => $calendarsData['data'] ?? []

        ]);
    }

    public function billing_ingormations(Request $request)
    {
        $loggedUser    = UserController::loggedUserData($request);
        $loggedUserJTC = UserController::loggedUserJTC($request);

        if (! $loggedUser['data']['verified']) {
            Session::flash('alert-danger', __('PAGE_AVAILABLE_ONLY_FOR_VERIFIED_SUPPLIERS'));
            return redirect()->back();
        }

        $countriesDataObject = new VATController();
        $countriesData       = $countriesDataObject->index($request)->getData(true);

        $userAccountingObject = new BillingAddressApiController();
        $userAccounting       = $userAccountingObject->userAccounting($request)->getData(true);





        return view('frontend.pages.settings_billing_informations', [
            'loggedUserJTC'  => $loggedUserJTC,
            'loggedUserData' => $loggedUser['data'] ?? [],
            'userAccounting' => $userAccounting['data'] ?? [],
            'countries'      => $countriesData['data'] ?? [],
            'taxes'          => Country::whereHasVAT()->get(),
            'page_name'      => __('SETTINGS'),

        ]);
    }

    public function cv_function(Request $request)
    {
        $loggedUser    = UserController::loggedUserData($request);
        $loggedUserJTC = UserController::loggedUserJTC($request);

        $countriesDataObject = new VATController();
        $countriesData       = $countriesDataObject->index($request)->getData(true);

        $userAccountingObject = new BillingAddressApiController();
        $userAccounting       = $userAccountingObject->userAccounting($request)->getData(true);



        return view('frontend.pages.settings_cv', [
            'loggedUserData' => $loggedUser['data'],
            'loggedUserJTC'  => $loggedUserJTC,
            'userAccounting' => $userAccounting['data'] ?? [],
            'countries'      => $countriesData['data'] ?? [],
            'page_name'      => __('SETTINGS'),

        ]);
    }

    public function settings_payouts_page(Request $request)
    {
        #settings payout page
        $loggedUser = UserController::loggedUserData($request);

        $user = auth()->user();

        $userPayoutMethodsObject = new PayoutsMethodsApiController();
        $userPayoutMethods       = $userPayoutMethodsObject->userPayoutMethods($request)->getData(true);

        if ($request->has('code')) {
            $paypal = new PayPalController();

            $request->request->add([
                'authorization_code' => $request->input('code'),
            ]);

            $paypal->paypalPayoutConnect($request);
        }

        return view(
            'frontend.pages.settings_payout_page',
            [
                'page_name'         => __('SETTINGS'),
                'loggedUserData'    => $loggedUser['data'],

                'userPayoutMethods' => $userPayoutMethods['data'] ?? [],
                'payouts'           => $user->payouts,
                'totalEarnings'     => $user->payouts->sum('price') + $user->getCurrentEarnings()->get('total'),
                'current_earnings'  => number_format($user->getCurrentEarnings()->get('total'), 2),
            ]
        );
    }

    public function deleteProfile(Request $request)
    {
        try {
            $user_email = $request->user()->email;
            $request->user()->deactivate();
            Mail::to($user_email)->queue(new AccountDeleted($user_email));
            return redirect()->route('login');
        } catch (\Exception $exception) {
            Log::error(var_export($exception));
        }
    }

    public function settings_wallets(Request $request)
    {


        if ($request->has('code')) {
            (new PayPalController())->paypalConnect($request);

            if (session()->has('redirect_to')) {
                return redirect()->to(session()->get('redirect_to'));
            }
        }

        $cards     = new PaymentMethodController();
        $cardsData = $cards->index($request)->getData(true);

        $userCardsObject = new CreditCardController();
        $userCards        = $userCardsObject->cardList($request)->getData(true);

        return view('frontend.pages.settings_wallets', [
            'page_name'      => __('SETTINGS'),
            'user_id'        => auth()->user()->id,
            'cards_data'     => $cardsData['data'] ?? [],
            'user_cards'     => $userCards ?? [],
        ]);
    }

    public function settings_following(Request $request)
    {
        $userFollowRequests     = new UserFollowedApiController();
        $userFollowRequestsData = $userFollowRequests->followRequests($request)->getData(true); //

        $usersThatIamFallowing     = new UserFollowedApiController();
        $usersThatIamFallowingData = $usersThatIamFallowing->followingRequests($request)->getData(true);

        $usersThatFallowsMe     = new UserFollowedApiController();
        $usersThatFallowsMeData = $usersThatFallowsMe->followingUser($request)->getData(true);


        return view(
            'frontend.pages.settings_following',
            [
                'page_name'                 => __('FOLLOWING'),
                'userPrivateTalks'          => $userPrivateTalks['data'] ?? [],
                'userFollowRequests'        => $userFollowRequestsData['data'] ?? [],
                'usersThatFallowsMe'        => $usersThatFallowsMeData['data'] ?? [],
                'usersThatIamFallowingData' => $usersThatIamFallowingData['data'] ?? [],
            ]
        );
    }

    public function settings_blocked_profiles(Request $request)
    {
        $blockedUsers     = new UserBlockedApiController();
        $blockedUsersData = $blockedUsers->usersBlocked($request)->getData(true);


        return view(
            'frontend.pages.settings_blocked_users',
            [
                'page_name'    => __('BLOCKED_USERS'),
                'blockedUsers' => $blockedUsersData['data'] ?? [],
            ]
        );
    }



    public function settings_transaction_history(Request $request)
    {
        #settings transaction history

        $request->request->add(['user_id' => auth()->user()->id]);

        $historyDataObject = new WalletController();
        $historyData       = $historyDataObject->getTransactionHistory($request)->getData(true);

        return view('frontend.pages.settings_transaction_history', [
            'page_name'      => __('SETTINGS'),
            'history_data'   => $historyData['data'] ?? []
        ]);
    }
}
