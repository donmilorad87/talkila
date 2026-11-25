<?php

namespace App\Http\Requests;

use App\Models\Pages;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdatePagesRequest
 * @package App\Http\Requests
 */
class UpdatePagesRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
//        abort_if(Gate::denies('pages_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'title'       => [
                'required',
            ],
            'slug'       => [
                'required',
            ]
        ];
    }
}
