<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateTalkRequest
 * @package App\Http\Requests
 */
class UpdateTalkRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('talk_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'teacher_user_id'       => [
                'sometimes',
                'required',
                'integer',
            ],
            'languages_id'          => [
                'sometimes',
                'required',
                'integer',
            ],
            'anonym_call'           => [
                'sometimes',
                'nullable',
                'integer',
                'max:9',
            ],
            'call_type'             => [
                'sometimes',
                'nullable',
                'integer',
                'max:9',
            ],
            'talk_type'             => [
                'sometimes',
                'nullable',
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
                'nullable',
                'max:100',
            ],
            'duration'              => [
                'nullable',
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
                'sometimes',
                'required',
                'integer',
                'max:999',
            ],
            'price'                 => [
                'required',
                'numeric',
                // 'between:0,99999.99',
                'between:10,10000',
            ],
            'max_participiants'     => [
                'sometimes',
                'required',
                'integer',
                'max:30',
            ],
            'reviews'               => [
                'nullable',
                'integer',
            ],
            'ratings'               => [
                'nullable',
                'numeric',
                'between:10,10000',
            ],
        ];
    }
}
