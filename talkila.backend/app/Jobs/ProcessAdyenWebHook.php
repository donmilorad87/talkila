<?php

namespace App\Jobs;

use Adyen\AdyenException;
use App\Http\Controllers\Admin\BookingsPaymentDetailsController;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

/**
 * Class ProcessAdyenWebHook
 * @package App\Jobs
 */
class ProcessAdyenWebHook extends SpatieProcessWebhookJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::notice('Webhook:: ');
        Log::notice($this->webhookCall);

        $notificationRequest = json_decode($this->webhookCall, true);
//        $request = array (
//            'live' => 'false',
//            'notificationItems' =>
//                array (
//                    0 =>
//                        array (
//                            'NotificationRequestItem' =>
//                                array (
//                                    'additionalData' =>
//                                        array (
//                                            'expiryDate' => '03/2030',
//                                            'authCode' => '014482',
//                                            'cardSummary' => '0002',
//                                            'hmacSignature' => '/GvTU3H/a1gNBqsRl6gahIvxsTmYfWcflBXgS/PBPSM=',
//                                            'threeds2.cardEnrolled' => 'false',
//                                        ),
//                                    'amount' =>
//                                        array (
//                                            'currency' => 'EUR',
//                                            'value' => 1000,
//                                        ),
//                                    'eventCode' => 'AUTHORISATION',
//                                    'eventDate' => '2020-12-05T00:55:00+01:00',
//                                    'merchantAccountCode' => 'TALKILAECOM',
//                                    'merchantReference' => '2',
//                                    'operations' =>
//                                        array (
//                                            0 => 'CANCEL',
//                                            1 => 'CAPTURE',
//                                            2 => 'REFUND',
//                                        ),
//                                    'paymentMethod' => 'amex',
//                                    'pspReference' => '853607126100098G',
//                                    'reason' => '014482:0002:03/2030',
//                                    'success' => 'true',
//                                ),
//                        ),
//                ),
//        );

        $bookingsPaymentDetailsController = new BookingsPaymentDetailsController();
        if(isset($notificationRequest['payload']["notificationItems"])) {
            foreach ( $notificationRequest['payload']["notificationItems"] as $notificationRequestItem ) {
                $params = $notificationRequestItem["NotificationRequestItem"];

                $requestBookingPayment['booking_id']        = $params['merchantReference'] ?? '';
                $requestBookingPayment['payment_reference'] = $params['pspReference'] ?? '';
                $requestBookingPayment['payload']           = json_encode($params) ?? '';
                $requestBookingPayment['event_code']        = $params['eventCode'] ?? '';
                $requestBookingPayment['status']            = $params['success'] == 'true' ? 1 : 0;
                $requestBookingPayment['amount_value']      = $params['amount']['value'] ?? '';
                $requestBookingPayment['amount_currency']   = $params['amount']['currency'] ?? '';
                $requestBookingPayment['creation_date']     = $params['eventDate'] ?? '';
                //$requestBookingPayment['payment_method']    = $params['paymentMethod'] ?? '';
                //$requestBookingPayment['reason']            = $params['reason'] ?? '';

                $existBooking = Booking::query()->where('id', $requestBookingPayment['booking_id'])->withTrashed()->exists();

                if($existBooking) {
                    $bookingsPaymentDetailsController->paymentStore($requestBookingPayment);
                } else {
                    // TODO HANDLE ERROR IF BOOKING DOESN'T EXIST
                }

            }
        }

        echo "[accepted]";
    }
}
