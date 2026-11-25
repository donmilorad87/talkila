<?php

namespace App\Http\Requests;

use App\Models\StaticForbiddenName;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyStaticForbiddenNameRequest
 * @package App\Http\Requests
 */
class MassDestroyStaticForbiddenNameRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_forbidden_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:static_forbidden_names,id',
        ];
    }
}
