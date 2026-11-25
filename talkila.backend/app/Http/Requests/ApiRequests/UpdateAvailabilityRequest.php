<?php

namespace App\Http\Requests\ApiRequests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateAvailabilityRequest
 * @package App\Http\Requests\ApiRequests
 */
class UpdateAvailabilityRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('availability_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'weekday'  => [
                'required_without_all:state,start_time,end_time',
                'integer',
                'max:9',
            ],
            'state'      => [
                'required_without_all:weekday,start_time,end_time',
                'integer',
                'max:9',
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'required_without_all:weekday,state,end_time',
            ],
            'end_time'   => [
                'date_format:' . config('panel.time_format'),
                'required_without_all:weekday,state,start_time',
            ],
        ];
    }


    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors'    => $validator->errors(),
            'message'   => __('FAILED_FIELDS'),
            'success'   => false
        ], 200);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
