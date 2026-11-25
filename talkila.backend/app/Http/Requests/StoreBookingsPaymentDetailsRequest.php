<?php

namespace App\Http\Requests;

use App\Models\BookingsPaymentDetails;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreBookingsPaymentDetailsRequest
 * @package App\Http\Requests
 */
class StoreBookingsPaymentDetailsRequest extends FormRequest
{

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'booking_id' => [
                'required',
                'integer',
            ],
            'payment_reference'   => [
                'required',
                'max:100',
            ],
            'status'  => [
                'required',
                'max:100',
            ],
            'amount_value'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'amount_currency'  => [
                'required',
                'max:45',
            ],
            'creation_date'  => [
                'required',
                'max:45',
            ],
        ];
    }
}
