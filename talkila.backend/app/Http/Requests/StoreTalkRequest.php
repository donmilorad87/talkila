<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreTalkRequest
 * @package App\Http\Requests
 */
class StoreTalkRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('talk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'teacher_user_id'       => [
                'required',
                'integer',
            ],
            'languages_id'          => [
                'required',
                'integer',
            ],
            'anonym_call'           => [
                'required',
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
            'headline'              => [
                'required',
                'max:100',
            ],
            'description'           => [
                'required',
            ],
            'duration'              => [
                'required',
                'integer',
                'max:999',
            ],
            'start_time'            => [
                'nullable',
            ],
            'end_time'              => [
                'nullable',
            ],
            'finance_currencies_id' => [
                'required',
                'integer',
                'max:999',
            ],
            'price'                 => [
                'required',
                'numeric',
                'between:10,10000',
            ],
            'max_participiants'     => [
                'required',
                'integer',
                'max:30',
            ],
            'billing_address_id'    => [
                'required',
                'integer',
            ],
            'talk_categories_id'    => [
                'nullable',
                'integer',
            ],
            'talk_subcategories_id' => [
                'nullable',
                'integer',
            ],
            'reviews'               => [
                'nullable',
                'integer',
            ],
            'ratings'               => [
                'nullable',
                'numeric',
                'between:0,99999.99',
            ],
        ];
    }
}
