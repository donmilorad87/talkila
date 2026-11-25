<?php

namespace App\Listeners;

use App\Exceptions\Handler;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Api\V1\Admin\BookingsApiController;
use App\Models\Booking;
use App\Models\User;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\WebhookReceived;


class StripeEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle received Stripe webhooks.
     *
     * @param  \Laravel\Cashier\Events\WebhookReceived  $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
        DB::beginTransaction();
        try {
            if ($event->payload['type'] === 'charge.succeeded') {
                // Handle the incoming event...
                Log::notice("\n\n" . '::'.self::class.'::'.__FUNCTION__.'::$event');
                Log::notice($event->payload);

                $paymentIntentId = $event->payload['data']['object']['payment_intent'];

                $walletHistoryData = WalletHistory::query()
                    ->where('transaction_id', $paymentIntentId)
                    ->where('status', WalletHistory::STATUS['PENDING'])
                    ->first();

                if(isset($walletHistoryData->id) && $walletHistoryData->id > 0) {
                    $walletHistoryData->status = WalletHistory::STATUS['COMPLETED'];
                    $walletHistoryData->transaction_id = $event->payload['data']['object']['id'];
                    $walletHistoryData->card_details = json_encode($event->payload['data']['object']);
                    $walletHistoryData->save();

                    $user = User::query()->where('id', $walletHistoryData->user_id)->first();

                    $user->wallet_balance += ($event->payload['data']['object']['amount'] / 100);
                    $user->save();

                    if($walletHistoryData->booking_id > 0) {
                        $booking = Booking::query()->where('id', $walletHistoryData->booking_id)->first();

                        $booking->state = Booking::STATE['paid'];
                        $booking->save();

                        $walletHistory = new WalletHistory();
                        $responseFromWalletHistory = $walletHistory->removeFundsFromWallet($user, $booking->id, $booking->price);

                        BookingsController::createBookingProtocolEvent($booking->id, Booking::STATE['paid']);

                        $payment            = new PaymentController();
                        $responseFromCapture = $payment->capturePayment($paymentIntentId, PaymentController::PAYMENT['STRIPE']);

                        if ($responseFromCapture['success'] == false) {
                            DB::rollBack();

                            return response()->json([
                                'message' => $responseFromCapture['message'],
                                'success' => false,
                            ], 200);
                        }

                        if($walletHistoryData->source == WalletHistory::SOURCE['EXTENSION']) {
                            $bookingApiController = new BookingsApiController();
                            $bookingApiController->extendSocketRoomInDB($booking, $booking->duration, $user);
                        }
                    }
                }
                DB::commit();
            }
        } catch (\Exception $exception) {
            DB::rollback();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_8100, self::class, __FUNCTION__);

            return [
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_8100,
                'success' => false
            ];
        }
    }
}
