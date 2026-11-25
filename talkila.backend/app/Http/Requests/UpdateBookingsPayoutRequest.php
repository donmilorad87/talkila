<?php

namespace App\Http\Requests;

use App\Models\BookingsPayout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateBookingsPayoutRequest
 * @package App\Http\Requests
 */
class UpdateBookingsPayoutRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('bookings_payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
