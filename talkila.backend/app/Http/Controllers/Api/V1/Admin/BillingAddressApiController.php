<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBillingAddressRequest;
use App\Mail\BillingInformationChanged;
use App\ModelsApi\BillingAddress;
use App\ModelsApi\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Tag(
 *     name="BillingAddress",
 *     description="Everything about Billing Address",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/user-accounting",
 *      operationId="userAccounting",
 *      tags={"BillingAddress"},
 *      summary="Method userAccounting of BillingAddressApiController",
 *      description="Method userAccounting of BillingAddressApiController",
 *
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      @OA\Response(response=500, description="Server error"),
 *      @OA\Response(response=503, description="Service unavailable"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 *
 */


/**
 * @OA\Put(
 *      path="/v1/billing-addresses/{billing_address}",
 *      operationId="updateBillingAddress",
 *      tags={"BillingAddress"},
 *      summary="Method update of BillingAddressApiController",
 *      description="Method update of BillingAddressApiController",
 *
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      @OA\Response(response=500, description="Server error"),
 *      @OA\Response(response=503, description="Service unavailable"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */
class BillingAddressApiController extends Controller
{
    public function updateBillingAddress(UpdateBillingAddressRequest $request, BillingAddress $billingAddress)
    {
        try {
            Log::notice("\n\n" . '::BillingAddressApiController::updateBillingAddress::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::BillingAddressApiController::updateBillingAddress::$billingAddress');
            Log::notice($billingAddress);

            $billingAddress->update(['state' => BillingAddress::STATE['not_valid']]);

            $newBillingAddress = BillingAddress::create($request->all());

            $addressUser            = User::query()->where('id', $billingAddress->user_id)->first();
            $originalBillingAddress = BillingAddress::query()->where('id', $billingAddress->id)->with('countries')->first();
            $newBillingAddress      = BillingAddress::query()->where('id', $newBillingAddress->id)->with('countries')->first();

            Mail::to($addressUser->email)->queue(
                new BillingInformationChanged(
                    $request->header('Application-Language', 'en'),
                    $addressUser->email,
                    $originalBillingAddress->company_name,
                    $newBillingAddress->company_name,
                    $originalBillingAddress->street,
                    $newBillingAddress->street,
                    $originalBillingAddress->city,
                    $newBillingAddress->city,
                    $originalBillingAddress->zipcode,
                    $newBillingAddress->zipcode,
                    $originalBillingAddress->pays_vat,
                    $newBillingAddress->pays_vat,
                    $originalBillingAddress->countries->name,
                    $newBillingAddress->countries->name,
                    // $newBillingAddress->updated_at
                    convertToUserTimezone($newBillingAddress->updated_at)
                )
            );
            // Mail::to($addressUser->email)->queue(new BillingInformationChanged($request->header('Application-Language', 'en'), $addressUser->email, $originalBillingAddress->company_name, $newBillingAddress->company_name, $originalBillingAddress->street, $newBillingAddress->street, $originalBillingAddress->city, $newBillingAddress->city, $originalBillingAddress->zipcode, $newBillingAddress->zipcode, $originalBillingAddress->tax_number, $newBillingAddress->tax_number, $originalBillingAddress->countries->name, $newBillingAddress->countries->name, $billingAddress->updated_at))
            $response = response()->json([
                'data'    => [
                    'billing_address_id' => $newBillingAddress->id,
                ],
                'message' => 'Previous billing address successfully deactivated and new billing address successfully added',
                'success' => true,
            ]);

            Log::notice("\n\n" . '::BillingAddressApiController::updateBillingAddress::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2200, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2200,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userAccounting(Request $request)
    {
        try {
            Log::notice("\n\n" . '::BillingAddressApiController::userAccounting::$request');
            Log::notice($request->all());

            $requestedUserBilling = $request->user();

            // $userBillingAddress = BillingAddress::query()
            //     ->select(['id', 'street', 'zipcode', 'city', 'tax_number', 'countries_id', 'vat', 'pays_vat'])
            //     ->selectRaw("IF(company_name IS NULL AND iban_recipient_name IS NOT NULL, iban_recipient_name, company_name) AS company_name")
            //     ->where('state', BillingAddress::STATE['valid'])
            //     ->where(function ($query) use ($requestedUserBilling) {
            //         $query->where(function ($query2) use ($requestedUserBilling) {
            //             $query2->where('id', $requestedUserBilling->billing_address_id);
            //         });
            //     })
            //     ->first();

            $userBillingAddress = BillingAddress::query()
                ->select(['id', 'countries_id', 'street', 'street', 'zipcode', 'city', 'company_name', 'tax_number', 'iban_recipient_name', 'email', 'vat', 'pays_vat'])
                ->selectRaw("CASE WHEN company_name IS NULL AND iban_recipient_name IS NOT NULL THEN iban_recipient_name ELSE company_name END AS company_name")
                ->where('state', BillingAddress::STATE['valid'])
                ->where('id', '!=', 1)
                ->where('user_id', $request->user()->id)
                ->first();

            // This will be removed at the later stage.
            if (! $userBillingAddress) {
                $userBillingAddress = $requestedUserBilling->billingAddress()->select(['id', 'street', 'zipcode', 'city', 'tax_number', 'countries_id', 'vat', 'pays_vat'])
                    ->selectRaw("CASE WHEN company_name IS NULL AND iban_recipient_name IS NOT NULL THEN iban_recipient_name ELSE company_name END AS company_name")
                    ->where(function ($query) use ($requestedUserBilling) {
                        $query->where(function ($query2) use ($requestedUserBilling) {
                            $query2->where('id', $requestedUserBilling->billing_address_id);
                        });
                    })
                    ->latest()
                    ->first();
            }

            if (! empty($userBillingAddress)) {
                $response = response()->json([
                    'data'    => $userBillingAddress,
                    'message' => 'Logged in user accounting data',
                    'success' => true,
                ]);

                Log::notice("\n\n" . '::BillingAddressApiController::userAccounting::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'message' => 'Logged in user dont have accounting data',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::BillingAddressApiController::userAccounting::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2201, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2201,
                'success' => false,
            ], 500);
        }
    }
}
