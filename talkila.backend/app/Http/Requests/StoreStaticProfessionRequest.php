<?php

namespace App\Http\Requests;

use App\Models\StaticProfession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreStaticProfessionRequest
 * @package App\Http\Requests
 */
class StoreStaticProfessionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_profession_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'croatian' => [
                'nullable',
                'max:50',
            ],
            'german'   => [
                'nullable',
                'max:45',
            ],
            'english'  => [
                'nullable',
                'max:45',
            ],
            'spanish'  => [
                'nullable',
                'max:45',
            ],
            'french'   => [
                'nullable',
                'max:45',
            ],
        ];
    }
}
