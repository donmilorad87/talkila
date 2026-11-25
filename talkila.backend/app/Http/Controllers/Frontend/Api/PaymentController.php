<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Api\V1\Admin\BookingsApiController;
use App\Http\Controllers\Api\V1\Admin\CreditCardController;
use App\Http\Controllers\Api\V1\Admin\PayPalController;
use App\Http\Controllers\Api\V1\Admin\WalletController;
use App\Http\Controllers\Controller;
use App\Services\PayPal;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function addCards(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $request->request->add(['adding_card_pointer' => true]);

        $addCardsObject = new CreditCardController();
        $addCards       = $addCardsObject->addCard($request)->getData(true);

        return $addCards;
    }

    public function addPayPal(Request $request)
    {
        $pay_pal = new PayPal();

        $paypal_response           = $pay_pal->connect($request->input('code'));
        $paypal_user_info_response = $pay_pal->getUserInfo($paypal_response->json('access_token'));

        $paypal_email         = $paypal_user_info_response->collect('emails')->pluck('value')->first();
        $paypal_access_token  = $paypal_response->json('access_token');
        $paypal_refresh_token = $paypal_response->json('refresh_token');

        $request->user()->update([
            'paypal_email'         => $paypal_email,
            'paypal_access_token'  => $paypal_access_token,
            'paypal_refresh_token' => $paypal_refresh_token,
        ]);
    }

    public function updateDefaultCard(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $updateDefaultCardObject = new CreditCardController();
        $updateDefaultCard       = $updateDefaultCardObject->updateDefaultCard($request)->getData(true);



        return $updateDefaultCard;
    }

    public function depositeInWallet(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $depositeInWalletObject = new WalletController();
        $depositeInWallet       = $depositeInWalletObject->depositeWallet($request)->getData(true);

        return [
            'depositeInWallet'  => $depositeInWallet,
            'wallet_balance'    => auth()->user()->fresh()->wallet_balance,
        ];

    }

    public function bookingsPay(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $bookingsPayObject = new BookingsApiController();
        $bookingsPay       = $bookingsPayObject->store($request)->getData(true);

        return $bookingsPay;
    }

    public function payPallCreateOrder(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $paypalCreateOrderbject = new PayPalController();
        $paypalCreateOrder      = $paypalCreateOrderbject->paypalCreateOrder($request)->getData(true);

        return $paypalCreateOrder;
    }

    public function paypalCaptureOrder(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $paypalCaptureOrderObject = new PayPalController();
        $paypalCaptureOrder       = $paypalCaptureOrderObject->paypalCaptureOrder($request)->getData(true);

        return $paypalCaptureOrder;
    }

    public function paypalAuthorizeOrder(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $paypalCaptureOrderObject = new PayPalController();
        $paypalCaptureOrder       = $paypalCaptureOrderObject->paypalAuthorizeOrder($request)->getData(true);

        return $paypalCaptureOrder;
    }

    public function paypalPayment(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }
        return (new PayPalController())->paypalPayment($request);
    }

    public function bookExtendion(Request $request)
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $bookExtendionObject = new BookingsApiController();
        $bookExtendion       = $bookExtendionObject->bookExtension($request)->getData(true);

        return $bookExtendion;
    }
}
