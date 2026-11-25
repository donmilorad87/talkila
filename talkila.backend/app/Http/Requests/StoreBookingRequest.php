<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreBookingRequest
 * @package App\Http\Requests
 */
class StoreBookingRequest extends FormRequest
{
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
//                'required',
                'integer',
                'max:9999',
            ],
            'start_call' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'required',
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
                // 'required',
                'numeric',
                'between:10,10000',
            ],
            'currency' => [
//                'required',
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
            'talk_id' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
