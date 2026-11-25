<?php

namespace App\Http\Requests;

use App\Models\BookingsPayout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyBookingsPayoutRequest
 * @package App\Http\Requests
 */
class MassDestroyBookingsPayoutRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('bookings_payout_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:bookings_payouts,id',
        ];
    }
}
