<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Api\V1\Admin\PayPalController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    const PAYMENT = [
        'STRIPE'                => 'stripe',
        'PAYPAL'                => 'paypal',
        'PAYPAL_AUTOCOMPLETE'   => 'paypal_autocomplete',
        'WALLET'                => 'wallet',
    ];

    public function chargeCustomer(Request $request, $sourceOfPayment, float $price, int $bookingId = 0)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);
            $user = $request->user();

            $paymentGateway = $request->payment_type ?? config('talkila.payment_gateway');

            switch ($paymentGateway) {
                case self::PAYMENT['STRIPE']:
                    $stripe             = new StripeController();
                    $responseFromCharge = $stripe->simpleCharge($request, $sourceOfPayment, $price, $bookingId);

                    $paymentId = $responseFromCharge['data']->id ?? null;
                    break;
                case self::PAYMENT['PAYPAL']:
                    $payPalController = new PayPalController();
                    if ($bookingId > 0) {
                        $responseFromCharge = $payPalController->paypalAuthorizeOrder($request, $sourceOfPayment, $bookingId)->getData(true);
                        $paymentId          = $responseFromCharge['data']['capture_id'];
                    } else {
                        $responseFromCharge = $payPalController->paypalCaptureOrder($request, $sourceOfPayment, $bookingId)->getData(true);
                        $paymentId          = null;
                    }
                    break;
            }

            return [
                'message' => $responseFromCharge['message'],
                'data'    => [
                    'redirect'  => $responseFromCharge['redirect'] ?? null,
                    'paymentId' => $paymentId ?? null,
                ],
                'success' => $responseFromCharge['success'],
            ];
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_9000, self::class, __FUNCTION__);

            return [
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_9000,
                'data'    => [
                    'paymentId' => $paymentId ?? null,
                ],
                'success' => false,
            ];
        }
    }

    public function capturePayment($paymentId, $paymentGateway)
    {
        try {
            $paymentGateway = !empty($paymentGateway) ? $paymentGateway : (\Str::startsWith($paymentId, ['ch', 'pi']) ? self::PAYMENT['STRIPE'] : self::PAYMENT['PAYPAL']);

            switch ($paymentGateway) {
                case self::PAYMENT['STRIPE']:
                    $stripe             = new StripeController();
                    $responseFromCharge = $stripe->captureStripePayment($paymentId);
                    break;
                case self::PAYMENT['PAYPAL']:
                    $payPalController   = new PayPalController();
                    $responseFromCharge = $payPalController->paypalOnlyCaptureOrder($paymentId)->getData(true);
                    break;
            }

            return [
                'message' => $responseFromCharge['message'] ?? null,
                'success' => (isset($responseFromCharge['success']) && $responseFromCharge['success']) ? true : ((isset($responseFromCharge['ack']) && $responseFromCharge['ack']) ? true : false),
            ];
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_9001, self::class, __FUNCTION__);

            return [
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_9001,
                'success' => false,
            ];
        }
    }

    public function cancelPayment($request, $paymentId, $paymentGateway, $sourceOfPayment, $bookingId)
    {
        try {
            $paymentGateway = !empty($paymentGateway) ? $paymentGateway : (\Str::startsWith($paymentId, ['ch', 'pi']) ? self::PAYMENT['STRIPE'] : self::PAYMENT['PAYPAL']);


            switch ($paymentGateway) {
                case self::PAYMENT['STRIPE']:
                    $stripe             = new StripeController();
                    $responseFromCharge = $stripe->cancelStripePaymentIntent($paymentId);
                    break;
                case self::PAYMENT['PAYPAL']:
                    // case self::PAYMENT['PAYPAL_AUTOCOMPLETE']:
                    Log::info('=========================');
                    Log::info($paymentGateway);
                    $payPalController   = new PayPalController();
                    $responseFromCharge = $payPalController->paypalCancelOrder($paymentId)->getData(true);
                    break;
            }

            return [
                'message' => $responseFromCharge['message'] ?? null,
                'success' => $responseFromCharge['ack'],
            ];
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_9002, self::class, __FUNCTION__);

            return [
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_9002,
                'success' => false,
            ];
        }
    }
}
