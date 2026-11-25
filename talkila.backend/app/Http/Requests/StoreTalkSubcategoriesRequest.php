<?php

namespace App\Http\Requests;

use App\Models\TalkSubcategories;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreTalkSubcategoriesRequest
 * @package App\Http\Requests
 */
class StoreTalkSubcategoriesRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('talk_subcategories_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
