<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Admin\StripeController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Post (
 *      path="/api/v1/add-card",
 *      operationId="addCard",
 *      tags={"addCard"},
 *      summary="Add credit card.",
 *      description="Returns credit card Details",
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
 * Returns credit card Details
 */

/**
 * @OA\Post (
 *      path="/api/v1/card-list/{user_id}",
 *      operationId="cardList",
 *      tags={"cardList"},
 *      summary="Get all crediy card list by user id.",
 *      description="Returns All user's credit card list",
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
 * Returns All user's credit card list
 */

/**
 * @OA\Post (
 *      path="/api/v1/update-default-card",
 *      operationId="updateDefaultCard",
 *      tags={"updateDefaultCard"},
 *      summary="Update users default card",
 *      description="Returns All user's credit card list.",
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
 * Returns All user's credit card list
 */
class CreditCardController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function addCard(Request $request)
    {
        $response = response()->json([
            'message' => 'Error: ' . Handler::TYPE_EXCEPTION_7000,
            'success' => false,
        ], 500);

        switch (env('PAYMENT_GATEWAY')) {
            case 'stripe':
                $stripe   = new StripeController();
                $payment_response = $stripe->addPaymentMethod($request)->getData(true);
                break;
        }

        if ($payment_response['success']) {
            $request->user()->update([
                'default_payment_method' => $request->input('payment_method'),
            ]);
        }

        $response = [
            'success' => $payment_response['success'],
            'message' => $payment_response['message'],
            'data'    => [
                'cards' => [
                    'added'   => array_merge(reset($payment_response['data']), ['is_default' => true]),
                ],
            ],
        ];

        if (isset($payment_response['data']['deleted_card'])) {
            $response['data']['cards']['deleted'] = $payment_response['data']['deleted_card'];
        }

        return response()->json($response);
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function cardList(Request $request, $message = false)
    {

        $response = response()->json([
            'message' => 'Error: ' . Handler::TYPE_EXCEPTION_7001,
            'success' => false,
        ], 500);

        switch (env('PAYMENT_GATEWAY')) {
            case 'stripe':
                $stripe   = new StripeController();
                $response = $stripe->retrievePaymentMethods($request);
                break;
        }

        return $response;
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateDefaultCard(Request $request)
    {
        $response = response()->json([
            'message' => 'Error: ' . Handler::TYPE_EXCEPTION_7002,
            'success' => false,
        ], 500);

        switch (env('PAYMENT_GATEWAY')) {
            case 'stripe':
                $stripe   = new StripeController();
                $response = $stripe->addPaymentMethod($request);
                break;
        }

        return $response;
    }

    /**
     * Delete saved card from stripe payment & database
     */
    public function deleteCard(Request $request)
    {
        $response = response()->json([
            'message' => 'Error: ' . Handler::TYPE_EXCEPTION_7003,
            'success' => false,
        ], 500);

        switch (env('PAYMENT_GATEWAY')) {
            case 'stripe':
                $stripe   = new StripeController();
                $response = $stripe->deletePaymentMethod($request);
                break;
        }

        return $response;
    }

    /**
     * Get New Setup Intent For Stripe
     */
    public function setupIntent(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = response()->json([
            'message' => 'Error: ' . Handler::TYPE_EXCEPTION_7004,
            'success' => false,
        ], 500);

        switch (env('PAYMENT_GATEWAY')) {
            case 'stripe':
                $stripe   = new StripeController();
                $response = $stripe->getSetupIntent($request);
                break;
        }

        return $response;
    }
}
