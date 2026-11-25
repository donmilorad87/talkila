<?php

namespace App\Http\Requests;

use App\Models\Availability;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreAvailabilityRequest
 * @package App\Http\Requests
 */
class StoreAvailabilityRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('availability_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'weekday'  => [
                'nullable',
                'integer',
                'max:9',
            ],
            'state'      => [
                'nullable',
                'integer',
                'max:9',
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'end_time'   => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
