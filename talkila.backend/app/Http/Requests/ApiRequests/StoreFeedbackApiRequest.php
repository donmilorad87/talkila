<?php

namespace App\Http\Requests\ApiRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreFeedbackApiRequest
 * @package App\Http\Requests\ApiRequests
 */
class StoreFeedbackApiRequest extends FormRequest
{
    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'booking_id' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'stars_content' => [
                'required',
                'integer',
                'max:9',
            ],
            'stars_voice_quality' => [
                'nullable',
                'integer',
                'max:9',
            ],
            'description' => [
                'nullable',
            ],
            'state' => [
                'integer',
                'max:9',
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
