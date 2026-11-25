<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Exceptions\IncompletePayment;

class StripeController extends Controller
{
    public function createCustomer(Request $request)
    {
        try {
            Log::notice("\n\n" . '::StripeController::createCustomer::$request');
            Log::notice($request);
            $user = $request->user();

            $stripeCustomer = $user->createOrGetStripeCustomer();

            return response()->json([
                'stripeCustomer' => $stripeCustomer,
                'success'        => true,
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8000, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8000,
                'success' => false,
            ], 500);
        }
    }

    public function updateCustomer(Request $request)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $options = [];
            $user    = $request->user();

            $stripeCustomer = $user->updateStripeCustomer($options);

            return response()->json([
                'stripeCustomer' => $stripeCustomer,
                'success'        => true,
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8001, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8001,
                'success' => false,
            ], 500);
        }
    }

    public function retrieveCustomer(int $stripeId)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$stripeId');
            Log::notice($stripeId);

            $user = Cashier::findBillable($stripeId);

            return response()->json([
                'user'    => $user,
                'success' => true,
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8002, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8002,
                'success' => false,
            ], 500);
        }
    }

    public function determineUserPaymentMethods(Request $request)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $user = $request->user();

            if ($user->hasPaymentMethod()) {
                if ($user->hasDefaultPaymentMethod()) {
                    return response()->json([
                        'defaultPaymentMethod' => true,
                        'hasPaymentMethod'     => true,
                        'success'              => true,
                    ], 200);
                } else {
                    return response()->json([
                        'defaultPaymentMethod' => false,
                        'hasPaymentMethod'     => true,
                        'success'              => true,
                    ], 200);
                }
            } else {
                return response()->json([
                    'defaultPaymentMethod' => false,
                    'hasPaymentMethod'     => false,
                    'success'              => true,
                ], 200);
            }
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8004, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8004,
                'success' => false,
            ], 500);
        }
    }

    public function addPaymentMethod(Request $request)
    {
        $user = $request->user();

        if (! isset($user->id)) {
            return response()->json([
                'success' => false,
                'message' => __('USER_NOT_FOUND'), //"User not found.",
            ], 200);
        } else {
            if (empty($request->payment_method)) {
                return response()->json([
                    'success' => false,
                    'message' => __('PAYMENT_METHOD_REQUIRED'), //"User not found.",
                ], 200);
            }
        }

        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paymentMethod');
            Log::notice($request->payment_method);

            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($request->payment_method);

            // Remove Duplicate Cards by fingerprint
            $paymentMethods       = $user->paymentMethods();
            $defaultPaymentMethod = $user->defaultPaymentMethod();

            $deleted_method = null;

            foreach ($paymentMethods as $paymentMethod) {
                if (
                    ! empty($paymentMethod->card->fingerprint) &&
                    $paymentMethod->card->fingerprint == $defaultPaymentMethod->card->fingerprint &&
                    $defaultPaymentMethod->id != $paymentMethod->id
                ) {
                    $deleted_method = [
                        'card_id'              => $paymentMethod->id,
                        'card_last_four_digit' => $paymentMethod->card->last4,
                        'card_month_expire'    => $paymentMethod->card->exp_month,
                        'card_year_expire'     => $paymentMethod->card->exp_year,
                        'card_brand'           => $paymentMethod->card->brand,
                        'name'                 => $paymentMethod->billing_details->name,
                        'is_default'           => false,
                    ];


                    $paymentMethod->delete();
                }
            }

            return $this->retrievePaymentMethods($request, __('CREDIT_CARD_ADDED_SUCCESSFULLY'), $deleted_method);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8005, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8005,
                'success' => false,
            ], 500);
        }
    }

    public function retrievePaymentMethods(Request $request, $message = null, $deleted_method = null)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$message');
            Log::notice($message);

            $user           = $request->user();
            $paymentMethods = $user->paymentMethods();

            $intent = $user->createSetupIntent();

            //$defaultPaymentMethod = $user->defaultPaymentMethod();

            //dd($paymentMethods->toArray(), $defaultPaymentMethod,  $intent);
            $cardArr = [];

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paymentMethods');
            Log::notice($paymentMethods);

            foreach ($paymentMethods as $paymentMethod) {
                $cardArr[] = [
                    'card_id'              => $paymentMethod->id,
                    'card_last_four_digit' => $paymentMethod->card->last4,
                    'card_month_expire'    => $paymentMethod->card->exp_month,
                    'card_year_expire'     => $paymentMethod->card->exp_year,
                    'card_brand'           => $paymentMethod->card->brand,
                    //'default_card'       => ($defaultPaymentMethod->id == $paymentMethod->id),
                    'name'                 => $paymentMethod->billing_details->name,
                ];
            }

            if ($deleted_method) {
                $cardArr = array_merge($cardArr, ['deleted_card' => $deleted_method]);
            }

            return response()->json([
                'success' => true,
                'message' => $message ?? __('CARD_LIST_BY_USER'), //"Card list by user.",
                'data'    => $cardArr ?? [],
                'intent'  => $intent->client_secret,
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8003, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8003,
                'success' => false,
            ], 500);
        }
    }

    public function deletePaymentMethod(Request $request)
    {
        $user = $request->user();

        if (! isset($user->id)) {
            return response()->json([
                'success' => false,
                'message' => __('USER_NOT_FOUND'), //"User not found.",
            ], 200);
        }

        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$paymentMethod');
            Log::notice($request->card_id);

            $user          = $request->user();
            $paymentMethod = $user->findPaymentMethod($request->card_id);

            if (empty($paymentMethod)) {
                return response()->json([
                    'success' => false,
                    'message' => __('INVALID_CARD_ID'),
                ], 200);
            }

            // Commented out due to migrating to 'payment-methods/delete' route.
            // if ($user->paymentMethods()->count() > 1 && $paymentMethod->id == $user->defaultPaymentMethod()->id) {
            //     return response()->error('Default Card cannot be deleted.');
            // }

            $paymentMethod->delete();

            return response()->json([
                'success' => true,
                'message' => __('CARD_REMOVED_SUCCESSFULLY'),
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8006, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8006,
                'success' => false,
            ], 500);
        }
    }

    public function simpleCharge(Request $request, $sourceOfPayment, float $price, int $bookingId = 0)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request->all());

            if ($request->has('fake_user_id')) {
                $user = User::query()->find($request->input('fake_user_id'));
            } else {
                $user = $request->user();
            }

            if (! isset($request->selected_card_data['card_id'])) {
                return [
                    'message' => __('MISSING_CARD'),
                    'success' => false,
                ];
            }

            // Build charge options for modern Stripe API
            $chargeOption = [
                'payment_method_types' => ['card'],
                'expand'               => ['latest_charge'],
                'return_url'           => url('/settings/wallets'),
            ];

            if ($sourceOfPayment == WalletHistory::SOURCE['BOOKING']) {
                $chargeOption['capture_method'] = 'manual';
                $chargeOption['return_url'] = url('/booking-payment');
            } elseif ($sourceOfPayment == WalletHistory::SOURCE['EXTENSION']) {
                $chargeOption['capture_method'] = 'manual';
                $chargeOption['return_url'] = url('/talk/incall');
            }

            $stripeCharge = $user->charge(
                (int) ceil($price * 100),
                $request->selected_card_data['card_id'],
                $chargeOption
            );

            // Extract charge data — handle both old and modern Stripe API responses
            $chargeData = $stripeCharge->latest_charge
                ?? ($stripeCharge->charges->data[0] ?? null);

            if (! $chargeData) {
                Log::notice(self::class . '::' . __FUNCTION__ . ' :: No charge data in response');
                Log::notice($stripeCharge->toArray());

                return [
                    'data'    => $stripeCharge,
                    'message' => __('UNEXPECTED_RESPONSE'),
                    'success' => false,
                ];
            }

            $chargeId = is_object($chargeData) ? $chargeData->id : $chargeData;
            $chargeAmount = is_object($chargeData) && isset($chargeData->amount)
                ? $chargeData->amount
                : $stripeCharge->amount;

            $wallethistory = new WalletHistory();
            $responseFromWalletHistory = $wallethistory->addFundsInWallet(
                $user,
                ($chargeAmount / 100),
                WalletHistory::TYPE['CREDIT'],
                $bookingId,
                $chargeId,
                $chargeData,
                WalletHistory::STATUS['COMPLETED'],
                $sourceOfPayment
            );

            if ($responseFromWalletHistory['success'] == false) {
                return [
                    'message' => $responseFromWalletHistory['message'],
                    'success' => false,
                ];
            }

            return [
                'data'    => $stripeCharge,
                'message' => $responseFromWalletHistory['message'],
                'success' => true,
            ];
        } catch (IncompletePayment $exception) {
            $redirectUrl = match ($sourceOfPayment) {
                WalletHistory::SOURCE['BOOKING']   => '/booking-payment',
                WalletHistory::SOURCE['EXTENSION'] => '/talk/incall',
                default                            => '/settings/wallets',
            };

            Log::notice(self::class . '::' . __FUNCTION__ . ' (IncompletePayment)::');
            Log::notice(route('cashier.payment', [$exception->payment->id, 'redirect' => $redirectUrl], false));

            $wallethistory             = new WalletHistory();
            $responseFromWalletHistory = $wallethistory->addFundsInWallet($user, $price, WalletHistory::TYPE['CREDIT'], $bookingId, $exception->payment->id, $exception->payment, WalletHistory::STATUS['PENDING'], $sourceOfPayment);

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8008, self::class, __FUNCTION__);

            return [
                'message'  => 'Error: ' . Handler::TYPE_EXCEPTION_8008,
                'redirect' => route('cashier.payment', [$exception->payment->id, 'redirect' => $redirectUrl], false),
                'success'  => false,
            ];
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8008, self::class, __FUNCTION__);

            return [
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8008,
                'success' => false,
            ];
        }
    }

    public function refundCharge($user, $payment)
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$user');
            Log::notice($user);

            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$payment');
            Log::notice($payment);

            $user->refund($payment->id);

            return response()->json([
                'success' => true,
            ], 200);
        } catch (IncompletePayment $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8009, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8009,
                'success' => false,
            ], 500);
        }
    }

    public function getSetupIntent($request): \Illuminate\Http\JsonResponse
    {
        try {
            Log::notice("\n\n" . '::' . self::class . '::' . __FUNCTION__ . '::$request');
            Log::notice($request);

            $user = $request->user();

            $intent = $user->createSetupIntent();

            return response()->json([
                'success' => true,
                'intent'  => $intent->client_secret,
            ], 200);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8010, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_8010,
                'success' => false,
            ], 500);
        }
    }


    //    public function storePaymentMethods(Int $stripeId)
    //    {
    //        try {
    //            Log::notice("\n\n" . '::'.self::class.'::'.__FUNCTION__.'::$stripeId');
    //            Log::notice($stripeId);
    //
    //            $user = Cashier::findBillable($stripeId);
    //
    //            return response()->json([
    //                'user'    => $user,
    //                'success' => true
    //            ], 200);
    //        } catch (\Exception $exception) {
    //            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
    //
    //            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8002, self::class, __FUNCTION__);
    //
    //            return response()->json([
    //                'message' => 'Error: '.Handler::TYPE_EXCEPTION_8002,
    //                'success' => false
    //            ], 500);
    //        }
    //    }


    public function captureStripePayment($paymentIntent)
    {
        try {
            $stripe = new \Stripe\StripeClient(
                config('services.stripe.secret')
            );
            $stripe->paymentIntents->capture(
                $paymentIntent,
                []
            );

            return [
                'message' => 'Successfully Captured the Payment',
                'success' => true,
            ];
        } catch (\Exception $exception) {

            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8011, self::class, __FUNCTION__);

            return [
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_8011,
                'success' => false,
            ];
        }
    }

    public function cancelStripePaymentIntent($paymentIntent)
    {
        try {
            $stripe = new \Stripe\StripeClient(
                config('services.stripe.secret')
            );
            $stripe->paymentIntents->cancel(
                $paymentIntent,
                []
            );

            return [
                'message' => 'Successfully Canceled the Payment Intent',
                'success' => true,
            ];
        } catch (\Exception $exception) {

            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8012, self::class, __FUNCTION__);

            return [
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_8012,
                'success' => false,
            ];
        }
    }
}
