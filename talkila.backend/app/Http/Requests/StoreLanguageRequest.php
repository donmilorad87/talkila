<?php

namespace App\Http\Requests;

use App\Models\Language;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreLanguageRequest
 * @package App\Http\Requests
 */
class StoreLanguageRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('language_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'code'     => [
                'required',
                'max:3',
            ],
            'order_by' => [
                'nullable',
                'integer',
            ],
            'croatian' => [
                'required',
                'max:15',
            ],
            'english'  => [
                'required',
                'max:15',
            ],
            'german'   => [
                'required',
                'max:15',
            ],
        ];
    }
}
