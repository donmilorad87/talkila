<?php

namespace App\Http\Requests\ApiRequests;

use App\Models\Availability;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreAvailabilityRequest
 * @package App\Http\Requests\ApiRequests
 */
class StoreAvailabilityRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        // TODO Removed this check because user on Jtc that is still student can create talk before we approve him
        // abort_if(Gate::denies('availability_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'weekday'  => [
                'required',
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

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors'    => $validator->errors(),
            'message'   => 'Fields validation failed.',
            'success'   => false
        ], 200);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
