<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Admin\CallsCancellationReasonApiController;
use App\Http\Controllers\Api\V1\Admin\BookingsApiController;

class BookingController extends Controller
{


    public function callsCancelationReasons(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }

        $callsCancelationReasonsObject = new CallsCancellationReasonApiController();
        $callsCancelationReasons = $callsCancelationReasonsObject->index($request)->getData(true);

        return $callsCancelationReasons;

    }

    public function bookExtension(Request $request)
    {

        if(!$request->user()) {
            return redirect()->route('login');
        }


        $bookExtensionObject = new BookingsApiController();
        $bookExtension = $bookExtensionObject->getAvailableExtensions($request)->getData(true);

        return $bookExtension;

    }


}
