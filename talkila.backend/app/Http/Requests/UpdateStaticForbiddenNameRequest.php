<?php

namespace App\Http\Requests;

use App\Models\StaticForbiddenName;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateStaticForbiddenNameRequest
 * @package App\Http\Requests
 */
class UpdateStaticForbiddenNameRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_forbidden_name_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:45',
            ],
        ];
    }
}
