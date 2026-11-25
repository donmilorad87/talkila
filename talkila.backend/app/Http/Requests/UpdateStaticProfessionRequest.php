<?php

namespace App\Http\Requests;

use App\Models\StaticProfession;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateStaticProfessionRequest
 * @package App\Http\Requests
 */
class UpdateStaticProfessionRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_profession_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'croatian' => [
                'required',
                'max:50',
            ],
            'german'   => [
                'required',
                'max:45',
            ],
            'english'  => [
                'required',
                'max:45',
            ],
            'spanish'  => [
                'required',
                'max:45',
            ],
            'french'   => [
                'required',
                'max:45',
            ],
        ];
    }
}
