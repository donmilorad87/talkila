<?php

namespace App\Http\Requests;

use App\Models\TalkSubcategories;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateTalkSubcategoriesRequest
 * @package App\Http\Requests
 */
class UpdateTalkSubcategoriesRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('talk_categories_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'talk_categories_id' => [
                'required',
                'integer',
            ],
            'english' => [
                'max:50',
            ],
            'german' => [
                'max:50',
            ],
            'croatian' => [
                'max:50',
            ],
        ];
    }
}
