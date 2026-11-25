<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\JoinTheClub;
use App\ModelsApi\BillingAddress;
use App\ModelsApi\ProfilPayoutMethod;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class PayoutsMethodsApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */


/**
 * @OA\Tag(
 *     name="PayoutsMethods",
 *     description="Everything about PayoutsMethods",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/user-payout-methods",
 *      operationId="userPayoutMethods",
 *      tags={"PayoutsMethods"},
 *      summary="Method userPayoutMethods of PayoutsMethodsApiController",
 *      description="Method userPayoutMethods of PayoutsMethodsApiController",
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
 */

/**
 * @OA\Post(
 *      path="/v1/set-profile-payout-methods",
 *      operationId="setPayoutMethodToUser",
 *      tags={"PayoutsMethods"},
 *      summary="Method setPayoutMethodToUser of PayoutsMethodsApiController",
 *      description="Method setPayoutMethodToUser of PayoutsMethodsApiController",
 *
 *      @OA\Response(
 *          response=201,
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
class PayoutsMethodsApiController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     */
    public function userPayoutMethods(Request $request)
    {
        Log::notice("\n\n" . '::PayoutsMethodsApiController::userPayoutMethods::$request');
        Log::notice($request->all());

        try {
            $existingPayPallPayoutMethod = ProfilPayoutMethod::query()
                ->select([
                    'id',
                    'user_id',
                    'method',
                    'value',
                    'state',
                ])
                ->with(['user.userBillingAddress'])
                ->get()
                ->toArray();

            $data = [];
            foreach ($existingPayPallPayoutMethod as $payoutMethod) {
                $payoutBillingAddress = $payoutMethod['user']['user_billing_address'];

                if ($payoutMethod['method'] == ProfilPayoutMethod::METHOD['iban']) {
                    $data['iban']           = $payoutMethod['value'];
                    $data['iban_recipient'] = empty($payoutBillingAddress['iban_recipient_name']) ? ($payoutBillingAddress['company_name'] ?? '') : $payoutBillingAddress['iban_recipient_name'];
                    $data['iban_email']     = $payoutBillingAddress['email'] ?? '';
                } else {
                    $data['paypal_email'] = $payoutMethod['value'] ?? '';
                }

                if ($payoutMethod['state'] == ProfilPayoutMethod::STATE['valid']) {
                    $data['method'] = $payoutMethod['method'] ?? '';
                }
            }


            if (empty($data)) {
                $response = response()->success(__('NO_PAYOUTS'));

                Log::notice("\n\n" . '::PayoutsMethodsApiController::userPayoutMethods::$response');
                Log::notice($response);

                return $response;
            }

            // $response = response()->json([
            //     'data'      => $data,
            //     'message'   => 'User profile payout methods.',
            //     'success'   => true,
            // ], 200);

            $response = response()->success([
                'message' => 'User profile payout methods.',
                'data'    => $data,
            ]);

            Log::notice("\n\n" . '::PayoutsMethodsApiController::userPayoutMethods::$response');
            Log::notice($response);

            return $response;
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3300,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3300,
            //     'success' => false
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3300, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $methodId
     *
     * @return JsonResponse
     */
    public function setPayoutMethodToUser(Request $request)
    {
        try {
            Log::notice("\n\n" . '::PayoutsMethodsApiController::setPayoutMethodToUser::$request');
            Log::notice($request->all());

            // Get the user from Request object.
            $user = $request->user();

            // Fetch users' Billing Address info.
            $billing_address = $request->user()->billingAddress;

            // In case no Billing info exists, create it.
            if ($billing_address->isEmpty()) {
                $billing = $user->billingAddress()->create([
                    'countries_id'        => Country::GERMANY,
                    'email'               => $user->email,
                    'iban_recipient_name' => $user->name,
                ]);

                $user->update([
                    'billing_address_id' => $billing->id,
                ]);
            }

            $methodId = $request->input('method');
            if (! empty($methodId)) {
                $dataErrors = [];
                $dataUpdate = [];

                if ($methodId == ProfilPayoutMethod::METHOD['iban']) {
                    if (empty($request->input('iban'))) {
                        $dataErrors['iban'] = ['The Iban value is required.'];
                    }
                    if (empty($request->input('iban_recipient'))) {
                        $dataErrors['iban_recipient'] = ['The Recipient name is required.'];
                    } else {
                        $dataUpdate['iban_recipient_name'] = $request->input('iban_recipient');
                    }

                    /* if (empty($request->input('iban_email'))) {
                        // $dataErrors['iban_email'] = [
                        //     'The email is required.'
                        // ];
                        $dataErrors['iban_email'] = 'The email is required.';
                    } else {
                        $dataUpdate['email'] = $request->input('iban_email');
                    } */

                    if (! empty($dataErrors)) {
                        $response = response()->error([
                            'message' => 'The given data was invalid.',
                            'data'    => [
                                'errors' => $dataErrors,
                            ],
                        ]);

                        Log::notice("\n\n" . '::PayoutsMethodsApiController::setPayoutMethodToUser::$response');
                        Log::notice($response);

                        return $response;
                    }
                } elseif ($methodId == ProfilPayoutMethod::METHOD['paypal']) {
                    if (empty($request->input('paypal_email'))) {
                        $dataErrors['paypal_email'] = ['The email is required.'];
                    }

                    if (empty($request->input('paypal_email'))) {
                        $response = response()->error([
                            'message' => 'The given data was invalid.',
                            'data'    => [
                                'errors' => $dataErrors,
                            ],
                        ]);

                        Log::notice("\n\n" . '::PayoutsMethodsApiController::setPayoutMethodToUser::$response');
                        Log::notice($response);

                        return $response;
                    }
                }
                DB::beginTransaction();

                auth()->user()->payoutMethod()->update([
                    'state' => ProfilPayoutMethod::STATE['not_valid'],
                ]);

                auth()->user()->payoutMethod()->create([
                    'method' => $request->input('method'),
                    'value'  => $request->input($methodId == ProfilPayoutMethod::METHOD['iban'] ? 'iban' : 'paypal_email'),
                ]);

                $requestedUserBilling = $request->user();

                $userBillingAddress = BillingAddress::query()->where('state', true)
                    ->where('id', '!=', BillingAddress::STATE['valid'])
                    ->where(function ($query) use ($requestedUserBilling) {
                        $query->where(function ($query2) use ($requestedUserBilling) {
                            $query2->where('id', $requestedUserBilling->billing_address_id);
                        });
                        $query->orWhere(function ($query2) use ($requestedUserBilling) {
                            $query2->whereNotNull('user_id');
                            $query2->where('user_id', $requestedUserBilling->id);
                        });
                    })
                    ->first();

                if (! empty($dataUpdate)) {
                    if (! empty($userBillingAddress)) {
                        /* $addressUser            = User::query()->where('id', $userBillingAddress->user_id)->first();
                        $originalBillingAddress = BillingAddress::query()->where('id', $userBillingAddress->id)->with('countries')->first();

                        $userBillingAddress->update($dataUpdate);

                        $newBillingAddress      = BillingAddress::query()->where('id', $userBillingAddress->id)->with('countries')->first();

                        Mail::to($addressUser->email)->queue(new BillingInformationChanged(
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
                            $originalBillingAddress->tax_number,
                            $newBillingAddress->tax_number,
                            $originalBillingAddress->countries->name,
                            $newBillingAddress->countries->name)
                        );
                        */
                    } else {
                        $dataUpdate['user_id']      = $requestedUserBilling->id;
                        $dataUpdate['countries_id'] = BillingAddress::DEFAULT_COUNTRY;
                        $billing_address            = BillingAddress::create($dataUpdate);

                        //  Set billing for user
                        if ($requestedUserBilling->billing_address_id == 1) {
                            $requestedUserBilling->update(['billing_address_id' => $billing_address->id]);
                        }
                    }
                }


                $joinTheClubStepFour = JoinTheClub::query()->where('users_id', $request->user()->id)->first();

                // if ($joinTheClubStepFour->step_4 != 1) {
                //     $joinTheClubStepFour->update(['step_4' => 1]);
                // }

                DB::commit();

                $response = response()->success(__('SUCCESSFULLY_UPDATED_PAYOUT_METHODS'));

                Log::notice("\n\n" . '::PayoutsMethodsApiController::setPayoutMethodToUser::$response');
                Log::notice($response);

                return $response;
            } else {
                DB::rollBack();

                $response = response()->error([
                    'message' => 'Payment method is missing',
                    'data'    => [
                        'errors' => [
                            'method' => 'Method is required',
                        ],
                    ],
                ]);

                Log::notice("\n\n" . '::PayoutsMethodsApiController::setPayoutMethodToUser::$response');
                Log::notice($response);

                return $response;
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3301,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3301,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3301, 500);
        }
    }
}
