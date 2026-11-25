<?php

namespace App\Http\Requests\ApiRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreTalkRequest
 * @package App\Http\Requests\ApiRequests
 */
class StoreTalkRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        // TODO Removed this check because user on Jtc that is still student can create talk before we approve him
        // abort_if(Gate::denies('talk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'languages_id'          => [
                'required',
                'integer',
            ],
            'anonym_call'           => [
                'nullable',
                'integer',
                'max:9',
            ],
            'call_type'             => [
                'required',
                'integer',
                'max:9',
            ],
            'talk_type'             => [
                'required',
                'integer',
                'max:9',
            ],
            'interactive_mode'      => [
                'sometimes',
                'nullable',
                'integer',
                'in:1,2,3',
            ],
            'repeat'                => [
                'sometimes',
                'nullable',
                'boolean',
            ],
            'headline'              => [
                'required',
                'max:100',
            ],
            'description'           => [
                'nullable',
                'min:50',
            ],
            'duration'              => [
                'integer',
                'max:999',
            ],
            'start_time_call'       => [
                'nullable',
                'date_format:H:i:00',
            ],
            'end_time_call'         => [
                'nullable',
                'date_format:H:i:00',
            ],
            'price'                 => [
                'required',
                'numeric',
                'between:10,10000',
            ],
            'max_participiants'     => [
                'required',
                'integer',
                'between:1,50',
            ],
            'finance_currencies_id' => [
                'required',
                'integer',
            ],
            'talk_categories_id'    => [
                'required',
                'integer',
            ],
            'talk_subcategories_id' => [
                'required',
                'integer',
            ],
        ];
    }

    /**
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors'  => $validator->errors(),
            'message' => 'Fields validation failed.',
            'success' => false,
        ], 200);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
