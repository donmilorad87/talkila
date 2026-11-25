<?php


namespace App\Http\Controllers\Admin;


use App\Exceptions\Handler;
use App\Models\Booking;
use App\Models\BookingsPaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdyenPaymentController
{
    private function initializeAdyen() {
        // Set your X-API-KEY with the API key from the Customer Area.
        $client = new \Adyen\Client();
        $client->setEnvironment(\Adyen\Environment::TEST);
        $client->setXApiKey(env('YOUR_X_API_KEY'));

        return $client;
    }

    public function adyenPaymentMethods(Request $request = null)
    {
        try {
            $client = $this->initializeAdyen();
            $service = new \Adyen\Service\Checkout($client);

            if($request == null) {
                $params = array(
                    "merchantAccount" => env('YOUR_MERCHANT_ACCOUNT'),
                    "countryCode" => "DE",
                    "shopperLocale" => "de-DE",
                    "amount" => array(
                        "currency" => "EUR",
                        "value" => 1000
                    ),
                    "channel" => "Android"
                );
            } else {
                $params = $request->all();
            }

            Log::notice('::adyenPaymentMethods::');
            Log::notice($params);

            $result = $service->paymentMethods($params);
            Log::notice($result);

            return $result;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenPaymentMethods (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5000, self::class, __FUNCTION__);
        }

    }

    public function adyenMakePayment(Request $request)
    {
        try {
            $client = $this->initializeAdyen();
            $service = new \Adyen\Service\Checkout($client);

            // GET BOOKING ID
            $params = $request->all();
            if(!isset($params["merchantAccount"])) {
                $params["merchantAccount"] = "TALKILAECOM";
                $params["additionalData"] = [
                    "allow3DS2" => true
                ];
                $params["channel"] = 'Web';
                $params["amount"] = array(
                    "currency" => "EUR",
                    "value" => 1000
                );
                $params["reference"] = "2";//"YOUR_ORDER_NUMBER",
                $params["origin"] = url('/');
                $params["returnUrl"] = url('/admin/profile-payout-methods');
            }

            if(isset($params['shopperReference'])) {
                $params['reference'] = $params['shopperReference'];
            }
            Log::notice('::adyenMakePayment::');
            Log::notice($params);

            $result = $service->payments($params);

            Log::notice($result);

            // Check if further action is needed
            $resultReturn = [];

            if (array_key_exists("action", $result)){
                // Pass the action object to your front end
                $resultReturn["action"] = $result["action"];
            }
            else {
                // No further action needed, pass the resultCode to your front end
                $resultReturn["resultCode"] = $result["resultCode"];
            }

            return $resultReturn;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenMakePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5001, self::class, __FUNCTION__);
        }
    }

    public function adyenAdditionalDetails(Request $request)
    {
        try {
            $client = $this->initializeAdyen();
            $service = new \Adyen\Service\Checkout($client);

            // STATE_DATA is an object passed from the front end or client app, deserialized from JSON to a data structure.
            $params = $request->all();
            Log::notice('::adyenAdditionalDetails::');
            Log::notice($params);

            $result = $service->paymentsDetails($params);

            Log::notice($result);

            return $result;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenAdditionalDetails (ERROR)::');
            Log::error($exception);

            return [
                'resultCode' => 'Error'
            ];
        }
    }

    public function adyenCapturePayment($bookingId)
    {
        try {
            $client = $this->initializeAdyen();
            $service = new \Adyen\Service\Modification($client);

            $bookingPaymentDetailsData = $this->getBookingPaymentDetailsDataForAdyen($bookingId);

            $params = array(
                "merchantAccount"    => env('YOUR_MERCHANT_ACCOUNT'),
                "modificationAmount" => [
                    "value" => doubleval($bookingPaymentDetailsData->amount_value),
                    "currency" => 'EUR'
                ],
                "originalReference"  => $bookingPaymentDetailsData->payment_reference,
            );
            Log::notice('::adyenCapturePayment::');
            Log::notice($params);

            $result = $service->capture($params);
            Log::notice($result);

            return $result;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenCapturePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5002, self::class, __FUNCTION__, [$bookingId]);
        }
    }

    public function adyenCancelPayment($bookingId)
    {
        try {
            $client  = $this->initializeAdyen();
            $service = new \Adyen\Service\Modification($client);

            $bookingPaymentDetailsData = $this->getBookingPaymentDetailsDataForAdyen($bookingId);

            $params = array(
                "merchantAccount"   => env('YOUR_MERCHANT_ACCOUNT'),
                "originalReference" => $bookingPaymentDetailsData->payment_reference
            );
            Log::notice('::adyenCancelPayment::');
            Log::notice($params);

            $result = $service->cancel($params);

            Log::notice($result);

            return $result;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenCancelPayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5003, self::class, __FUNCTION__, [$bookingId]);
        }
    }

    public function adyenCancelOrRefundPayment($bookingId)
    {
        try {
            $client = $this->initializeAdyen();
            $service = new \Adyen\Service\Modification($client);

            $bookingPaymentDetailsData = $this->getBookingPaymentDetailsDataForAdyen($bookingId);

            $params = array(
                "merchantAccount"   => env('YOUR_MERCHANT_ACCOUNT'),
                "originalReference" => $bookingPaymentDetailsData->payment_reference
            );
            Log::notice('::adyenCancelOrRefundPayment::');
            Log::notice($params);

            $result = $service->cancelOrRefund($params);

            Log::notice($result);

            return $result;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenCancelOrRefundPayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5004, self::class, __FUNCTION__, [$bookingId]);
        }
    }

    public function adyenRefundPayment($bookingId)
    {
        try {
            $client = $this->initializeAdyen();
            $service = new \Adyen\Service\Modification($client);

            $bookingPaymentDetailsData = $this->getBookingPaymentDetailsDataForAdyen($bookingId);

            $params = array(
                "merchantAccount"       => env('YOUR_MERCHANT_ACCOUNT'),
                "modificationAmount" => [
                    "value" => doubleval($bookingPaymentDetailsData->amount_value),
                    "currency" => 'EUR'
                ],
                "originalReference"     => $bookingPaymentDetailsData->payment_reference
            );
            Log::notice('::adyenRefundPayment::');
            Log::notice($params);

            $result = $service->refund($params);

            Log::notice($result);

            return $result;
        } catch (\Adyen\AdyenException $exception) {
            Log::notice('::adyenRefundPayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5005, self::class, __FUNCTION__, [$bookingId]);
        }
    }

    public function getBookingPaymentDetailsDataForAdyen($bookingId) {
        $oBookings      = Booking::query()->select('parent_id')
            ->find($bookingId);

        if(isset($oBookings->parent_id)) {
            $bookingId = $oBookings->parent_id;
        }

        return BookingsPaymentDetails::query()
            ->select('payment_reference', 'amount_value')
            ->where('booking_id', $bookingId)
            ->where('status', true)
            ->first();
    }
}
