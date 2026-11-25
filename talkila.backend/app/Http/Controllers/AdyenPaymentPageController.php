<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdyenPaymentController;
use Illuminate\Http\Request;

/**
 * Class AdyenPaymentPageController
 * @package App\Http\Controllers
 */
class AdyenPaymentPageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function adyenPayment()
    {
        $adyenPayment = new AdyenPaymentController();
        $paymentMethods = json_encode($adyenPayment->adyenPaymentMethods());

        return view('adyen_payment', compact( 'paymentMethods'));
    }
}
