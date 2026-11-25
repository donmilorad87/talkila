<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateBookingRequest
 * @package App\Http\Requests
 */
class UpdateBookingRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'state'      => [
                'nullable',
                'integer',
                'max:9',
            ],
            'booking_type'  => [
                'nullable',
                'integer',
                'max:9',
            ],
            'anonym'     => [
                'nullable',
                'integer',
                'max:9',
            ],
            'participant_user_id'   => [
                'required',
                'integer',
                'max:999999',
            ],
            'start_call' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'end_call'   => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'duration'   => [
                'nullable',
                'integer',
                'max:999',
            ],
            'price'        => [
                'required',
                'between:0,99999999.99',
            ],
            'currency' => [
                'required',
                'integer',
                'max:999',
            ],
            'message'        => [
                'nullable',
            ],
            'cancellation_reason_id' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
