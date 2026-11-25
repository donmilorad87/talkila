<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\StripeController;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PaypalTransactions;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Wallet",
 *     description="Everything about Wallet",
 * )
 */


/**
 * @OA\Post (
 *      path="/api/v1/deposite-in-wallet",
 *      operationId="depositeWallet",
 *      tags={"depositeWallet"},
 *      summary="Add money in wallet",
 *      description="Returns waallet balance",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns waallet balance
 */

/**
 * @OA\Post (
 *      path="/api/v1/get-wallet-balance/{user_id}",
 *      operationId="getWalletBalance",
 *      tags={"getWalletBalance"},
 *      summary="Get wallet balance",
 *      description="Returns waallet balance",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns waallet balance
 */

/**
 * @OA\Post (
 *      path="/api/v1/add-book-transaction",
 *      operationId="addBookTransaction",
 *      tags={"addBookTransaction"},
 *      summary="Add booking data in transaction table",
 *      description="Returns transaction data",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns Returns transaction data
 */

/**
 * @OA\Post (
 *      path="/api/v1/charge-wallet",
 *      operationId="ChargeFromWallet",
 *      tags={"ChargeFromWallet"},
 *      summary="Charge booking call from wallet",
 *      description="Returns Charge amount",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns Charge amount
 */

/**
 * @OA\Post (
 *      path="/api/v1/charge-wallet/{user_id}",
 *      operationId="getTransactionHistory",
 *      tags={"getTransactionHistory"},
 *      summary="Get transaction history by user id.",
 *      description="Returns Transaction List",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns Transaction List
 */
class WalletController extends Controller
{
    public function __construct()
    {
        $this->stripeUrl = getenv("STRIPE_API_BASE_URl");
        $this->stripeKey = getenv("STRIPE_SECRET_KEY");
    }

    public function paypalCreateOrder(Request $request)
    {
        return response()->json(1);
    }

    /* protected function depositeWalletStripe($stripeCustomer, $amount, $currency)
    {
        $stripeUrl = $this->stripeUrl;
        $url = $stripeUrl."charges";
        $headers = array(
            "Authorization: Bearer " .$this->stripeKey,
            'Content-Type: application/x-www-form-urlencoded'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "amount=".$amount."&currency=".$currency."&customer=".$stripeCustomer);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    } */

    public function createPaymentIntent($stripeCustomer, $amount, $currency)
    {
        $stripeUrl = $this->stripeUrl;
        $url       = $stripeUrl . "payment_intents";
        $headers   = [
            "Authorization: Bearer " . $this->stripeKey,
            'Content-Type: application/x-www-form-urlencoded',
        ];
        $curl      = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            "amount=" . $amount . "&currency=" . $currency . "&customer=card&customer=" . $stripeCustomer
        );
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    public function paymentCharge($paymentIntentId, $defaultCardId, $userId, $webUrl = "")
    {
        $baseUrl   = url('/');
        $stripeUrl = $this->stripeUrl;
        $url       = $stripeUrl . "payment_intents/" . $paymentIntentId . "/confirm";
        $headers   = [
            "Authorization: Bearer " . $this->stripeKey,
            'Content-Type: application/x-www-form-urlencoded',
        ];
        $curl      = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $return_url = $baseUrl . "/callback?user_id=" . $userId;
        if ($webUrl != "") {
            $return_url .= "&web_redirect=" . $webUrl;
        }
        $return_url = urlencode($return_url);
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            "payment_method_types[]=card&payment_method=" . $defaultCardId . "&return_url=" . $return_url
        );
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * @param  Request  $request
     */
    public function depositeWallet(Request $request)
    {
        $user = $request->user();

        $message = false;
        if (!isset($user->id)) {
            $message = __('USER_ID_REQUIRED'); // "User is required.";
        } elseif (!($request->amount > 0)) {
            $message = __('AMOUNT_IS_REQUIRED'); // "Amount is required.";
        }/* elseif (empty(trim($request->currency))) {
            $message = __('CURRENCY_IS_REQUIRED'); //"Currency is required.";
        }*/

        $curentBalance = $user->wallet_balance;

        if ($message !== false) {
            return response()->error($message);
        }

        try {
            Log::notice("\n\n" . '::WalletController::depositeWallet::$request');
            Log::notice($request->all());

            $payment = new PaymentController();
            DB::beginTransaction();
            $responseFromCharge = $payment->chargeCustomer($request, WalletHistory::SOURCE['WALLET'], $request->amount);

            Log::notice('$responseFromCharge');
            Log::notice($responseFromCharge);

            if ($responseFromCharge['success'] == false && !empty($responseFromCharge['data']['redirect'])) {
                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $responseFromCharge['message'],
                    'data'    => [
                        'redirect' => $responseFromCharge['data']['redirect'],
                    ],
                ]);
            }

            DB::commit();

            return response()->success(__('MONEY_ADDED_TO_WALLET_SUCCESSFULLY'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['PAYMENT'],
                Handler::TYPE_EXCEPTION_6001,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6001, 500);
        }
    }

    public function checkPaymentStatus($paymentIntentId)
    {
        $paymentDeails = $this->paymentStatus($paymentIntentId);

        return $paymentDeails;
    }

    public function paymentStatus($paymentIntentID)
    {
        $stripeUrl = $this->stripeUrl;
        $url       = $stripeUrl . "payment_intents/" . $paymentIntentID;
        $headers   = [
            "Authorization: Bearer " . $this->stripeKey,
            'Content-Type: application/x-www-form-urlencoded',
        ];
        $curl      = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * @param  Request  $request
     */
    public function getWalletBalance(Request $request)
    {
        header('Content-Type: application/json');
        try {
            Log::notice("\n\n" . '::WalletController::getWalletBalance::$request');
            Log::notice($request->all());

            $user = $request->user();

            if (!$user) {
                return response()->error(__('USER_NOT_FOUND'));
            }

            $response = response()->success([
                'message' => __('BALANCE'), //'Balance',
                'data'    => [
                    'balance'           => number_format($user->wallet_balance, 2),
                    'available_balance' => number_format($user->wallet_balance, 2),
                    'available_balance_regular_format' => $user->wallet_balance,
                ],
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_6001,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6001, 500);
        }

        return $response;
    }


    public function addBookTransaction(Request $request)
    {
        header('Content-Type: application/json');
        DB::beginTransaction();
        try {
            Log::notice("\n\n" . '::WalletController::addBookTransaction::$request');
            Log::notice($request->all());

            $user          = new User();
            $wallet        = new Wallet();
            $wallethistory = new WalletHistory();
            $booking       = new Booking();

            $userId        = $request->user_id;
            $bookingId     = $request->booking_id;
            $extend_amount = $request->amount;      //This amount is use only for extend call payment
            $is_extend     = $request->is_extend;
            $is_multiple   = $request->is_multiple;

            if (empty(trim($userId))) {
                $response['success'] = false;
                $response['message'] = __('USER_ID_REQUIRED'); // "User is required.";
            }

            if (!empty($response)) {
                $response['success'] = false;
            } else {
                $user = $user->getUserDataById($userId);
                if (!$user) {
                    return response()->error(__('USER_NOT_FOUND'));
                }

                $bookDataArr['wallet_amount'] = $user->wallet_balance;
                DB::commit();

                $response = response()->success([
                    'message' => __('DATA_ADD_SUCCESSFULLY'),  //"Data add successfully.",
                    'data'    => $bookDataArr,
                ]);
            }
        } catch (\Exception $exception) {
            DB::rollback();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_6002,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6002, 500);
        }

        return $response;
    }

    public function insufficientBalance()
    {
        return response()->error(__('INSUFFICIENT_BALANCE_IN_YOUR_WALLET'));
    }

    /**
     * @param  Request  $request
     */
    public function ChargeFromWallet(Request $request)
    {
        header('Content-Type: application/json');
        DB::beginTransaction();
        try {
            Log::notice("\n\n" . '::WalletController::ChargeFromWallet::$request');
            Log::notice($request->all());

            $user          = new User();
            $wallet        = new Wallet();
            $wallethistory = new WalletHistory();
            $booking       = new Booking();

            $userId        = $request->user_id;
            $bookingId     = $request->booking_id;
            $extended_time = $request->extended_time;
            $actual_time   = $request->actual_time;

            if (empty(trim($userId))) {
                $response['success'] = false;
                $response['message'] = __('USER_ID_REQUIRED'); // "User is required.";
            } elseif (empty(trim($bookingId))) {
                $response['success'] = false;
                $response['message'] = __('BOOKING_ID_REQUIRED'); //"Booking id is required.";
            }

            if (!empty($response)) {
                $response['success'] = false;
            } else {
                $user = $user->getUserDataById($userId);
                if (!$user) {
                    return response()->error(__('USER_NOT_FOUND'));
                }
                $bookingData        = $booking->getBookingDetailsById($bookingId);
                $amount             = 0;
                $extend_call_amount = 0;
                if ($bookingData) {
                    $transactionData = $wallethistory->getTansactionByBookinId($userId, $bookingId);
                    if (!empty($transactionData)) {
                        foreach ($transactionData as $transaction) {
                            $tarnsactonId = $transaction->id;
                            if ($transaction->transaction_type == 'debit') {
                                $transactionAmount = $amount = $bookingData->price;
                            } else {
                                if ($transaction->transaction_type == 'extend') {
                                    $transactionAmount = $extend_call_amount = $wallethistory->getPricePerminute(
                                        $transaction->amount,
                                        $extended_time,
                                        $actual_time
                                    );
                                }
                            }

                            $transactionArr = [
                                'id'     => $tarnsactonId,
                                'amount' => $transactionAmount,
                                'status' => WalletHistory::STATUS['COMPLETED'],
                            ];
                            $update         = $wallethistory->updateTransactionDetals($transactionArr);
                            if ($update) {
                                $checkBalance      = $wallet->checkWalletExits($userId);
                                $userWalletBalance = $checkBalance->raw_balance;
                                $balance           = ($userWalletBalance - $transactionAmount);
                                $available_balance = "";
                                if ($transaction->transaction_type == 'extend') {
                                    //If call is disconnect before extend time then need to revert points into wallet. In wallet add remaining balance into wallet which was deduct while extend call(As a pending status)
                                    $available_balance = $checkBalance->available_balance + ($transaction->amount - $transactionAmount);
                                }
                                $wallet->updateWalletData($userId, $balance, $available_balance);
                            } else {
                                DB::rollback();

                                return response()->error(__('SOMETHING_WENT_WRONG'));
                            }
                        }
                        $totalAmount = $amount + $extend_call_amount;
                        // TODO Marko to create booking here
                        DB::commit();

                        $response = response()->success([
                            'message' => __('TRANSACTION_SUCCESSFULLY'), //"Transaction successfully.",
                            'data'    => [
                                'booking_id'    => $bookingId,
                                'user_id'       => $userId,
                                'charge_amount' => $totalAmount,
                            ],
                        ], 200);
                    } else {
                        $response = response()->error(__('NO_CHARGES_FOUND'));
                    }
                } else {
                    $response = response()->error(__('BOOKING_DATA_NOT_FOUND'));
                }
            }
        } catch (\Exception $exception) {
            DB::rollback();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_6003,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6003, 500);
        }

        return $response;
    }

    /**
     * @param  Request  $request
     */

    public function getTransactionHistory(Request $request)
    {

        try {
            Log::notice("\n\n" . '::WalletController::getTransactionHistory::$request');
            Log::notice($request->all());

            $wallethistory = new WalletHistory();

            if (!empty($response)) {
                $response['success'] = false;
            } else {
                $user = $request->user();
                if (!$user) {
                    return response()->error(__('USER_NOT_FOUND'));
                }
                $transactionHistory = $wallethistory->getTransactionDetailsByUserId($user->id);
                $historyDetails     = [];

                foreach ($transactionHistory as $key => $tHistory) {
                    $cardNumber  = $cardType = $paymentType = $cardExpiry = $cardHolderName = $paypalAccount = null;
                    $booking     = $tHistory->booking;
                    $bookingId   = $tHistory->parent_id ?: $tHistory->booking_id;
                    $bookings    = $transactionHistory->where('booking_id', $tHistory->booking_id)->where('source', '!=', WalletHistory::SOURCE['WALLET']);
                    $talk        = $booking ? $booking->talk : null;
                    $addingFunds = [WalletHistory::PAYMENT['coins_bought_credit_card'], WalletHistory::PAYMENT['coins_bought_paypal'], WalletHistory::PAYMENT['refund_coins'], WalletHistory::PAYMENT['refund_money']];

                    // If Transaction has no card details, it was paid fully with Wallet.
                    if ($tHistory->card_details === '') {
                        $paymentType = WalletHistory::PAYMENT['paid_with_wallet'];
                    }

                    // If Transaction has card details, determine whether it was paid via PayPal or Stripe/Credit Card.
                    if ($tHistory->card_details == '"Paid By PayPal"') {
                        $paymentType   = WalletHistory::PAYMENT['paid_with_paypal'];
                        $paypalAccount = $tHistory->paypalAccount;
                    } else {
                        $cardHistoryDetails = json_decode($tHistory->card_details, true);
                        $cardData           = $cardHistoryDetails['payment_method_details']['card'] ?? null;
                        $cardNumber         = $cardData['last4'] ?? null;
                        $cardType           = $cardData['brand'] ?? null;
                        $cardExpiry         = $cardData['exp_year'] ?? null;
                        $cardHolderName     = $cardHistoryDetails['billing_details']['name'] ?? null;

                        if (isset($cardHistoryDetails['payment_method_details']['card'])) {
                            $paymentType = WalletHistory::PAYMENT['paid_with_credit_card'];
                        }
                    }

                    // If Transaction source is set to Wallet, user bought Talkila coins.
                    // Depending on the lastTransaction card details, we'll determine if the coins were bought via PayPal or Stripe/Credit Card.
                    if ($tHistory->source === WalletHistory::SOURCE['WALLET']) {
                        if ($tHistory->card_details == '"Paid By PayPal"') {
                            $paymentType = WalletHistory::PAYMENT['coins_bought_paypal'];
                        } else {
                            $paymentType = WalletHistory::PAYMENT['coins_bought_credit_card'];
                        }
                    }

                    if ($bookings->count() === 2) {
                        $credit = $bookings->where('transaction_type', 'credit')->first();
                        $debit  = $bookings->where('transaction_type', 'debit')->first();

                        // If Booking has 2 lastTransaction entries, and both debit and credit Transaction have the same amount,
                        // user has no coins and the lastTransaction was paid fully via PayPal or Stripe/Credit Card.
                        if ($credit->amount === $debit->amount) {
                            if ($bookings->where('card_details', '"Paid By PayPal"')->count()) {
                                $paymentType = WalletHistory::PAYMENT['paid_with_paypal'];
                            } else {
                                $paymentType = WalletHistory::PAYMENT['paid_with_credit_card'];
                            }
                        }

                        // If Booking has 2 lastTransaction entries, and both debit and credit Transaction do NOT have the same amount,
                        // user had some coins and the lastTransaction was paid partially via PayPal or Stripe/Credit Card and coins.
                        if ($credit->amount !== $debit->amount) {
                            if ($bookings->where('card_details', '"Paid By PayPal"')->count()) {
                                $paymentType = WalletHistory::PAYMENT['paid_with_paypal_and_wallet'];
                            } else {
                                $paymentType = WalletHistory::PAYMENT['paid_with_credit_card_and_wallet'];
                            }
                        }

                        if (!empty($historyDetails)) {
                            $transactionKeys    = array_keys($historyDetails);
                            $lastTransactionKey = end($transactionKeys);
                            $lastTransaction    = $historyDetails[$lastTransactionKey];

                            if ($lastTransaction['booking_id'] === $tHistory->booking_id) {
                                $lastTransaction['amount']              = in_array($paymentType, $addingFunds) ? $debit->amount : $debit->amount * -1;
                                $lastTransaction['payment_method_info'] = $cardNumber ?: $paypalAccount;
                                $historyDetails[$lastTransactionKey]    = $lastTransaction;

                                continue;
                            }
                        }
                    }

                    // If Transaction source is set to Refund, user has received a refund in Talkila coins.
                    if ($tHistory->source === WalletHistory::SOURCE['REFUND']) {
                        $paymentType = WalletHistory::PAYMENT['refund_coins'];
                    }

                    if (isMobileApp()) {
                        $historyDetails[$key] = [
                            'type'                => $paymentType,
                            'payment_method_info' => $cardNumber ?: $paypalAccount,
                            'booking_id'          => $bookingId != 0 ? $bookingId : null,
                            'amount'              => in_array($paymentType, $addingFunds) ? $tHistory->amount : $tHistory->amount * -1,
                            'date'                => convertToUserTimezone($tHistory->created_at)->toDateTimeString(),
                        ];
                        if ($talk) {
                            $historyDetails[$key]['talk_name'] = $talk->headline;
                        }
                    } else {
                        $historyDetails[] = [
                            'id'               => $tHistory->id,
                            'user_id'          => $tHistory->user_id,
                            'wallet_id'        => $tHistory->wallet_id,
                            'booking_id'       => $tHistory->parent_id ?: $tHistory->booking_id,
                            'talk_id'          => $booking->talk_id ?? '',
                            'source'           => $tHistory->source,
                            'talk_name'        => $booking->talk->headline ?? '',
                            'transaction_type' => $tHistory->transaction_type,
                            'transaction_id'   => $tHistory->transaction_id,
                            'card_number'      => $cardNumber,
                            'amount'           => $tHistory->amount,
                            'date'             => convertToUserTimezone($tHistory->created_at)->toDateTimeString(),
                            'payment_type'     => $paymentType,
                            'card_type'        => $cardType,
                            'card_expiry'      => $cardExpiry,
                            'card_holder_name' => $cardHolderName,
                        ];
                    }
                }

                if (empty($historyDetails)) {
                    $response = response()->success(__('NO_TRANSACTIONS'));
                } else {
                    $response = response()->success([
                        'message' => __('ALL_TRANSACTION_HISTORY'),
                        'data'    => [
                            'transactions' => array_values($historyDetails),
                        ],
                    ]);
                }
            }
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_6004,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6004, 500);
        }

        return $response;
    }

    public function cancelCall(Request $request)
    {
        header('Content-Type: application/json');
        DB::beginTransaction();
        try {
            Log::notice("\n\n" . '::WalletController::cancelCall::$request');
            Log::notice($request->all());

            $user          = new User();
            $wallet        = new Wallet();
            $wallethistory = new WalletHistory();

            $userId     = $request->user_id;
            $bookingId  = $request->booking_id;
            $is_teacher = $request->is_teacher;

            if (empty(trim($userId))) {
                $response['success'] = false;
                $response['message'] = __('USER_ID_REQUIRED'); // "User is required.";
            } elseif (empty(trim($bookingId))) {
                $response['success'] = false;
                $response['message'] = __('BOOKING_ID_REQUIRED'); //"Booking id is required.";
            }

            if (!empty($response)) {
                $response['success'] = false;
            } else {
                $user = $user->getUserDataById($userId);
                if (!$user) {
                    return response()->error(__('USER_NOT_FOUND'));
                }

                if ($is_teacher == 1) {
                    $transactionData = $wallethistory->getCancelTransactionByBookingId($bookingId);
                    if (!empty($transactionData)) {
                        $delete = $wallethistory->updateCancelCallFlag(
                            $flag = WalletHistory::ISDELETE['REFUNDABLE'],
                            $status = WalletHistory::STATUS['COMPLETED'],
                            $bookingId
                        );
                        // TODO Marko to create booking here

                        //Refund balance to user wallet
                        $walletData        = $wallet->checkWalletExits($transactionData[0]['user_id']);
                        $balance           = $walletData['raw_balance'];
                        $available_balance = $walletData['available_balance'] + $transactionData[0]['amount'];
                        $wallet->updateWalletData($transactionData[0]['user_id'], $balance, $available_balance);
                        DB::commit();

                        $response = response()->success([
                            'message' => __('REFUND_SUCCESSFULLY_TO_WALLET'), //"Refund successfully to wallet.",
                            'data'    => [
                                'is_chargeable' => false,
                            ],
                        ]);
                    } else {
                        DB::rollback();

                        $response = response()->error(__('USER_NOT_FOUND'));
                    }
                } else {
                    $date           = Carbon::now();
                    $currentData    = strtotime($date->toDateTimeString());
                    $cancelDateTIme = strtotime($request->cancel_date);
                    $timediff       = $currentData - $cancelDateTIme;
                    if ($timediff > WalletHistory::TIME['Hrs24']) {
                        $transactionData = $wallethistory->getTansactionByBookinId($userId, $bookingId);

                        if (!$transactionData->isEmpty()) {
                            $delete = $wallethistory->updateCancelCallFlag(
                                $flag = WalletHistory::ISDELETE['CHARGEABLE'],
                                $status = WalletHistory::STATUS['PENDING'],
                                $bookingId
                            );
                            // TODO Marko to create booking here
                            DB::commit();

                            $response = response()->success([
                                'message' => __('TALK_CHARGEABLE'), //"Call chargeable.",
                                'data'    => [
                                    'is_chargeable' => true,
                                ],
                            ]);
                        } else {
                            DB::rollback();

                            $response = response()->error(__('DATA_NOT_FOUND'));
                        }
                    } else {
                        $transactionData = $wallethistory->getTansactionByBookinId($userId, $bookingId);
                        if (!empty($transactionData)) {
                            $delete = $wallethistory->updateCancelCallFlag(
                                $flag = WalletHistory::ISDELETE['NON_CHARGEABLE'],
                                $status = WalletHistory::STATUS['CANCELLED'],
                                $bookingId
                            );
                            // TODO Marko to create booking here
                            DB::commit();

                            $response = response()->success([
                                'message' => __('TALK_CANCEL_BY_USER'), //"Call cancelled by user.",
                                'data'    => [
                                    'is_chargeable' => false,
                                ],
                            ]);
                        } else {
                            DB::rollback();

                            $response = response()->error(__('DATA_NOT_FOUND'));
                        }
                    }
                }
            }
        } catch (\Exception $exception) {
            DB::rollback();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_6005,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6005, 500);
        }

        return $response;
    }

    public function addPayPalTransaction($request, $bookingId, $sourceOfPayment)
    {
        header('Content-Type: application/json');
        if ($sourceOfPayment == WalletHistory::SOURCE['WALLET']) {
            DB::beginTransaction();
        }

        try {
            Log::notice("\n\n" . '::WalletController::addPayPalTransaction::$request');
            Log::notice($request);

            $userId          = $request['user_id'];
            $amount          = $request['amount'];
            $transactionType = $request['transaction_type'];
            $transactionId   = $request['transaction_id'];
            $responseData    = $request['response'];
            $status          = $request['status'];

            $response = [];
            if (empty(trim($userId))) {
                $response['success'] = false;
                $response['message'] = __('USER_ID_REQUIRED'); // "User is required.";
            } elseif (empty(trim($amount))) {
                $response['success'] = false;
                $response['message'] = __('AMOUNT_IS_REQUIRED'); // "Ammount is required.";
            } elseif ($transactionType == "") {
                $response['success'] = false;
                $response['message'] = __(
                    'TRANSACTION_TYPE_IS_REQUIRED'
                ); //"TransactionType is required : 0=Booking, 1=Add points into wallet, 2=Extend Call";
            } elseif (empty(trim($transactionId))) {
                $response['success'] = false;
                $response['message'] = __(
                    'TRANSACTION_ID_IS_REQUIRED'
                ); //"TransactionId is required : Which is came from PayPal response";
            } elseif (empty(trim($responseData))) {
                $response['success'] = false;
                $response['message'] = __('RESPONSE_IS_REQUIRED'); //"Response is required";
            } elseif (empty(trim($status))) {
                $response['success'] = false;
                $response['message'] = __('STATUS_IS_REQUIRED'); //"Status is required";
            }

            if (!empty($response)) {
                $response['success'] = false;
            } else {
                $user = new User();
                $user = $user->getUserDataById($userId);
                if (!$user) {
                    // return response()->json([
                    //     'success' => false,
                    //     'message' => __('USER_NOT_FOUND'), //"User not found.",
                    // ], 200);

                    return response()->error(__('USER_NOT_FOUND'));
                }

                $payPalTransactions     = new PaypalTransactions();
                $checkTransactionExists = $payPalTransactions->getTransactionById($transactionId);
                if (empty($checkTransactionExists)) {
                    $data = [
                        'user_id'          => (int)$userId,
                        'amount'           => $amount,
                        'transaction_type' => $transactionType,
                        'transaction_id'   => $transactionId,
                        'response'         => $responseData,
                        'status'           => $status,
                    ];

                    $insertedID = $payPalTransactions->addPayPalTransaction($data);

                    if ($status == 1 && $insertedID > 0) {
                        $wallethistory             = new WalletHistory();
                        $responseFromWalletHistory = $wallethistory->addFundsInWallet(
                            $user,
                            $amount,
                            WalletHistory::TYPE['CREDIT'],
                            $bookingId,
                            $transactionId,
                            'Paid By PayPal',
                            WalletHistory::STATUS['COMPLETED'],
                            $sourceOfPayment
                        );

                        if ($responseFromWalletHistory['success'] == true) {
                            if ($sourceOfPayment == WalletHistory::SOURCE['WALLET']) {
                                DB::commit();
                            }

                            $responseArr = [
                                'user_id'           => $user->id,
                                'balance'           => $user->wallet_balance,
                                'available_balance' => $user->wallet_balance,
                            ];
                            $response    = [
                                'success' => true,
                                'message' => __('MONEY_ADDED_TO_WALLET_SUCCESSFULLY'),
                                //"Money Added to wallet successfully.",]
                                'data'    => $responseArr,
                            ];
                        } else {
                            if ($sourceOfPayment == WalletHistory::SOURCE['WALLET']) {
                                DB::rollback();
                            }
                            $response = [
                                'success' => false,
                                'message' => __('SOMETHING_WENT_WRONG'), //"Something went wrong!",
                            ];
                        }
                    } else {
                        if ($sourceOfPayment == WalletHistory::SOURCE['WALLET']) {
                            DB::rollback();
                        }
                        $response = [
                            'success' => false,
                            'message' => __('SOMETHING_WENT_WRONG'), //"Something went wrong!",
                        ];
                    }
                } else {
                    if ($sourceOfPayment == WalletHistory::SOURCE['WALLET']) {
                        DB::rollback();
                    }
                    $response = [
                        'success' => false,
                        'message' => __('EXIST_TRANSACTION_ID'), //" Exist Paypal Transaction ID!",
                    ];
                }
            }
        } catch (\Exception $exception) {
            if ($sourceOfPayment == WalletHistory::SOURCE['WALLET']) {
                DB::rollback();
            }
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_6006,
                self::class,
                __FUNCTION__
            );

            // return [
            //     'message' => 'Error: ' . Handler::TYPE_EXCEPTION_6006,
            //     'success' => false
            // ];

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_6006, 500);
        }

        return $response;
    }

    public function getPaymentMethods(Request $request)
    {
        Log::notice("\n\n" . '::WalletController::getPaymentMethods::$request');
        Log::notice($request->all());

        $credit_cards    = (new StripeController())->retrievePaymentMethods($request)->getData(true);
        $credit_cards    = $credit_cards['success'] ? $credit_cards['data'] : [];
        $paypal_accounts = (new PayPalController())->paypalPaymentMethods($request)->getData(true);
        $paypal_accounts = $paypal_accounts['success'] ? $paypal_accounts['data'] : [];
        $default_payment = $request->user()->default_payment_method;
        $payment_methods = [];

        foreach ($credit_cards as $credit_card) {
            $credit_card['is_default'] = $credit_card['card_id'] == $default_payment;
            unset($credit_card['default_card']);

            $payment_methods['credit_card'][] = $credit_card;
        }

        foreach ($paypal_accounts as $paypal_account) {
            $paypal_account['is_default'] = $paypal_account['id'] == $default_payment;
            unset($paypal_account['state']);

            $payment_methods['paypal'][] = $paypal_account;
        }

        if (empty($payment_methods)) {
            $response = response()->error(__('NO_PAYMENT_METHODS'));
        } else {
            $response = response()->success([
                'message' => __('SUCCESSFULLY_RETRIEVED_PAYMENT_METHODS'),
                'data'    => $payment_methods,
            ]);
        }

        Log::notice("\n\n" . '::WalletController::getPaymentMethods::$response');
        Log::notice($response);

        return $response;
    }

    public function setPaymentMethods(Request $request)
    {
        Log::notice("\n\n" . '::WalletController::setPaymentMethods::$request');
        Log::notice($request->all());

        $payment_methods   = $this->getPaymentMethods($request)->getData(true);
        $payment_method_id = $request->input('id');
        $account_exists    = false;

        if (!$payment_methods['success']) {
            $response = response()->error(__('SOMETHING_WENT_WRONG'));

            Log::notice("\n\n" . '::WalletController::setPaymentMethods::$response');
            Log::notice($response);

            return $response;
        }

        foreach ($payment_methods['data'] as $payment_method) {
            foreach ($payment_method as $payment_data) {
                if (isset($payment_data['card_id']) && $payment_data['card_id'] == $payment_method_id) {
                    $account_exists = true;
                }
                if (isset($payment_data['id']) && $payment_data['id'] == $payment_method_id) {
                    $account_exists = true;
                }
            }
        }

        if (!$account_exists) {
            $response = response()->error(__('NO_PAYMENT_METHODS'));
        } else {
            $request->user()->update([
                'default_payment_method' => $payment_method_id,
            ]);

            $response = response()->success(__('SUCCESSFULLY_CHANGED_PAYMENT_METHODS'));
        }

        Log::notice("\n\n" . '::WalletController::setPaymentMethods::$response');
        Log::notice($response);

        return $response;
    }
}
