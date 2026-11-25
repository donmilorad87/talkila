<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PayPal\PayPalHelper;
use App\Models\ProfilPayoutMethod;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function paypalCreateOrder(Request $request)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $data         = $request->all();
            $currency     = "EUR";
            $amount       = round($data['total_amt'], 2, PHP_ROUND_HALF_UP);
            $paymentType  = $data['payment_type']; //0=Booking, 1=Add points into wallet, 2=Extend Call

            $intent = $data['intent'] ?? 'AUTHORIZE';

            $paypalHelper = new PayPalHelper();

            $orderData    = json_encode([
                "intent"              => $intent,
                "application_context" => [
                    "return_url" => config('app.frontend_url') . (isMobileApp() ? "/booking-thank-you" : "/booking-payment"),
                    "cancel_url" => config('app.frontend_url') . "/cancel",
                ],
                "purchase_units"      => [
                    [
                        "custom_id" => $paymentType,
                        "amount"    => [
                            "currency_code" => $currency,
                            "value"         => $amount,
                        ],
                    ],
                ],
            ]);


            $orderData = $paypalHelper->orderCreate($orderData);

            return response()->success([
                'message' => 'PayPal order created.',
                'data'    => [
                    'ack'           => $orderData['ack'],
                    'id'            => $orderData['data']['id'],
                    'approval_link' => $orderData['data']['approval_link'],
                ],
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_10000,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10000, 500);
        }
    }

    public function paypalCaptureOrder(Request $request, $sourceOfPayment = WalletHistory::SOURCE['WALLET'], $bookingId = 0)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $data = $request->all();

            $paypalHelper   = new PayPalHelper();
            $paypalResponse = $paypalHelper->orderCapture($data['order_id']);
            if (! isset($paypalResponse['data'])) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            $user            = $request->user();
            $amount          = $paypalResponse['data']['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? '';
            $transactionType = $paypalResponse['data']['purchase_units'][0]['payments']['captures'][0]['custom_id'] ?? '';
            $transactionId   = $paypalResponse['data']['id'] ?? '';
            $status          = isset($paypalResponse['data']['status']) ? ($paypalResponse['data']['status'] == "COMPLETED" ? 1 : 2) : '';   //1=Completed, 2=Failed

            $tempData = [
                'user_id'          => $user->id,
                'amount'           => $amount,
                'transaction_type' => $transactionType,
                'transaction_id'   => $transactionId,
                'response'         => json_encode($paypalResponse),
                'status'           => $status,
            ];

            $wallet     = new WalletController();
            $paypalData = $wallet->addPayPalTransaction($tempData, $bookingId, $sourceOfPayment);
            Log::notice($paypalData);

            return response()->json($paypalData, 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_10001,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10001, 500);
        }
    }

    public function paypalAuthorizeOrder(Request $request, $sourceOfPayment = WalletHistory::SOURCE['WALLET'], $bookingId = 0)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $data = $request->all();

            $paypalHelper   = new PayPalHelper();
            $paypalResponse = $paypalHelper->orderAuthorize($data['order_id']);

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paypalResponse');
            Log::notice($paypalResponse);
            if (! isset($paypalResponse['data'])) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            $user            = $request->user();
            $amount          = $paypalResponse['data']['purchase_units'][0]['payments']['authorizations'][0]['amount']['value'] ?? '';
            $transactionType = $paypalResponse['data']['purchase_units'][0]['payments']['authorizations'][0]['custom_id'] ?? '';
            $transactionId   = $paypalResponse['data']['id'] ?? '';
            $captureId       = $paypalResponse['data']['purchase_units'][0]['payments']['authorizations'][0]['id'] ?? '';
            $status          = isset($paypalResponse['data']['status']) ? ($paypalResponse['data']['status'] == "COMPLETED" ? 1 : 2) : '';   //1=Completed, 2=Failed

            $tempData = [
                'user_id'          => $user->id,
                'amount'           => $amount,
                'transaction_type' => $transactionType,
                'transaction_id'   => $transactionId,
                'response'         => json_encode($paypalResponse),
                'status'           => $status,
            ];

            $wallet     = new WalletController();
            $paypalData = $wallet->addPayPalTransaction($tempData, $bookingId, $sourceOfPayment);

            $paypalData['data'] = [
                'capture_id' => $captureId
            ];
            Log::notice($paypalData);

            return response()->json($paypalData, 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_10002,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10002, 500);
        }
    }

    public function paypalOnlyCaptureOrder($paymentId)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paymentId');
            Log::notice($paymentId);

            $paypalHelper   = new PayPalHelper();
            $paypalResponse = $paypalHelper->orderCaptureAuthorized($paymentId);

            Log::notice($paypalResponse);
            if (! isset($paypalResponse['data'])) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            return response()->json($paypalResponse, 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_10003,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10003, 500);
        }
    }

    public function paypalCancelOrder($paymentId)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paymentId');
            Log::notice($paymentId);

            $paypalHelper   = new PayPalHelper();
            $paypalResponse = $paypalHelper->orderCancel($paymentId);

            Log::notice($paypalResponse);
            if (! isset($paypalResponse['data'])) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            return response()->json($paypalResponse, 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_10004,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10004, 500);
        }
    }

    public function paypalRefundPayment($paymentId)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paymentId');
            Log::notice($paymentId);

            $paypalHelper   = new PayPalHelper();
            $paypalResponse = $paypalHelper->paymentRefund($paymentId);
//            $paypalResponse = $paypalHelper->paymentRefund($data['order_id']);

            Log::notice($paypalResponse);
            if (! isset($paypalResponse['data'])) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            return response()->json($paypalResponse, 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_10005,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10005, 500);
        }
    }

    /**
     * Attempt to connect the user via authorization code for Payout.
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function paypalPayoutConnect(Request $request)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice(json_encode($request->all()));

            $paypalHelper   = new PayPalHelper();
            $code = $request->input('code') ?? $request->input('authorization_code');
            $paypalResponse = $paypalHelper->userInfo($code);
            $paypal_email = $paypalResponse['data']['emails'][0]['value'];

            // Invalidated old Payout Methods.
            $request->user()->payoutMethod()->update([
                'state' => ProfilPayoutMethod::STATE['not_valid'],
            ]);

            // Add new Payout Method.
            $request->user()->payoutMethod()->create([
                'method' => ProfilPayoutMethod::METHOD['paypal'],
                'value'  => $paypal_email,
            ]);

            return response()->success('Connected Paypal account.');
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_10007, 500);
        }
    }
}
