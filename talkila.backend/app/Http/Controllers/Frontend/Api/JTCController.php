<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\PayoutsMethodsApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequests\StoreBillingAddressRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class JTCController extends Controller
{
    //
    public function setProfilPayoutMethods(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $setProfilPayoutMethodsObject = new PayoutsMethodsApiController();
        $setProfilPayoutMethods = $setProfilPayoutMethodsObject->setPayoutMethodToUser($request)->getData(true);

        // Get the user from Request object.
        $user = $request->user();

        // Fetch users' Billing Address info.
        $billing_address = $request->user()->billingAddress;

        // In case no Billing info exists, create it.
        if ($billing_address->isEmpty()) {
            $request->user()->billingAddress()->create([
                'countries_id'        => Country::GERMANY,
                'email'               => $user->email,
                'iban_recipient_name' => $user->name,
            ]);
        }

        return $setProfilPayoutMethods;
    }

    public function joinTheClubAccount(StoreBillingAddressRequest $request)
    {
        if(!$request->user()) {
            return redirect()->route('login');
        }


        $joinTheClubAccountingObject = new JoinTheClubApiController();
        $joinTheClubAccounting = $joinTheClubAccountingObject->joinTheClubAccounting($request)->getData(true);

        return $joinTheClubAccounting;
    }
}
