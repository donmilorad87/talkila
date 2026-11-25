<?php

namespace App\Http\Requests;

use App\Models\BookingsPayout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreBookingsPayoutRequest
 * @package App\Http\Requests
 */
class StoreBookingsPayoutRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('bookings_payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'payouts_id' => [
                'required',
                'integer',
            ],
            'bookings_id'            => [
                'required',
                'integer',
            ],
        ];
    }
}
