<?php

namespace App\Http\Requests\ApiRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateProfilCvRequest
 * @package App\Http\Requests\ApiRequests
 */
class UpdateProfilCvRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'type'       => [
                'required',
                'integer',
                'max:9',
            ],
            'start_date' => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
            'end_date'   => [
                'date_format:' . config('panel.date_format'),
                'nullable',
                'after_or_equal:start_date',
            ],
            'company_name'   => [
                'required',
                'max:40',
            ],
            'profession'   => [
                'nullable',
                'max:40',
            ],
            'profession_id'   => [
                'nullable',
                'integer',
            ],
            'location'   => [
                'nullable',
                'max:100',
            ],
            'work_here'   => [
                'nullable',
                'integer',
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
