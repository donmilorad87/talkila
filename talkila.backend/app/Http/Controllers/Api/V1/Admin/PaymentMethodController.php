<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\PaymentMethodTypes;
use App\Http\Controllers\Admin\StripeController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        Log::notice("\n\n" . '::PaymentMethodController::index::$request');
        Log::notice($request->all());

        $payment_methods = $this->getPaymentMethods($request);

        if (empty($payment_methods)) {
            $response = response()->success(__('NO_PAYMENT_METHODS'));
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

    public function update(Request $request)
    {
        Log::notice("\n\n" . '::PaymentMethodController::update::$request');
        Log::notice($request->all());

        $payment_methods   = $this->getPaymentMethods($request);
        $payment_method_id = $request->input('id') ?: $request->input('card_id');
        $account_exists    = false;

        if (empty($payment_methods)) {
            $response = response()->error('No Payment Methods.');

            Log::notice("\n\n" . '::PaymentMethodController::update::$response');
            Log::notice($response);

            return $response;
        }

        foreach ($payment_methods as $payment_method) {
            if(is_array($payment_method)){
                foreach ($payment_method as $payment_data) {
                    if (isset($payment_data['card_id']) && $payment_data['card_id'] == $payment_method_id) {
                        $account_exists = true;
                    }
                    if (isset($payment_data['id']) && $payment_data['id'] == $payment_method_id) {
                        $account_exists = true;
                    }
                }
            }
        }

        if (! $account_exists) {
            $response = response()->error('Payment Method does not exist.', 404);
        } else {
            $request->user()->update([
                'default_payment_method' => $payment_method_id,
            ]);

            $response = response()->success(__('SUCCESSFULLY_CHANGED_PAYMENT_METHODS'));
        }

        Log::notice("\n\n" . '::PaymentMethodController::update::$response');
        Log::notice($response);

        return $response;
    }

    public function destroy(Request $request)
    {
        Log::notice("\n\n" . '::PaymentMethodController::destroy::$request');
        Log::notice($request->all());

        $payment_methods   = $this->getPaymentMethods($request);
        $payment_method_id = $request->input('id') ?: $request->input('card_id');
        $type              = Str::startsWith($payment_method_id, 'pm') ? PaymentMethodTypes::STRIPE : PaymentMethodTypes::PAYPAL;
        $is_default        = false;
        $account_exists    = false;
        $count             = 0;

        if (empty($payment_methods)) {
            $response = response()->error('No Payment Methods.');

            Log::notice("\n\n" . '::PaymentMethodController::destroy::$response');
            Log::notice($response);

            return $response;
        }

        foreach ($payment_methods as $payment_method) {
            if(is_array($payment_method)){
                foreach ($payment_method as $payment_data) {
                    if (isset($payment_data['card_id']) && $payment_data['card_id'] == $payment_method_id) {
                        $account_exists = true;

                        if ($payment_data['is_default']) {
                            $is_default = true;
                        }
                    }

                    if (isset($payment_data['id']) && $payment_data['id'] == $payment_method_id) {
                        $account_exists = true;

                        if ($payment_data['is_default']) {
                            $is_default = true;
                        }
                    }

                    $count++;
                }
            }
        }

        if (! $account_exists) {
            return response()->error('Payment Method does not exist.', 404);
        }

        if ($count > 1 && $is_default) {
            return response()->error('Default Payment Method cannot be deleted.', 405);
        }

        if ($type === PaymentMethodTypes::STRIPE) {
            if (! $request->has('card_id')) {
                $request->request->add(['card_id' => $payment_method_id]);
            }

            $response = (new StripeController())->deletePaymentMethod($request)->getData(true);
        }

        if ($type === PaymentMethodTypes::PAYPAL) {
            $response = (new PayPalController())->paypalDisconnect($request, $payment_method_id)->getData(true);
        }

        $response = response()->json([
            'success' => $response['success'],
            'message' => $response['success']
                ? 'Payment Method deleted successfully.'
                : 'Oops, something went wrong.',
        ]);

        Log::notice("\n\n" . '::PaymentMethodController::destroy::$response');
        Log::notice($response);

        return $response;
    }

    protected function getPaymentMethods(Request $request): array
    {
        $credit_cards    = (new StripeController())->retrievePaymentMethods($request)->getData(true);
        $credit_cards    = $credit_cards['success'] ? $credit_cards['data'] : [];
        $default_payment = $request->user()->default_payment_method;
        $payment_methods = [];
        $count           = 0;

        foreach ($credit_cards as $credit_card) {
            $credit_card['is_default'] = $credit_card['card_id'] == $default_payment;
            unset($credit_card['default_card']);

            $payment_methods['credit_card'][] = $credit_card;
            $count++;
        }

        $payment_methods['count'] = $count;

        return $payment_methods;
    }
}
