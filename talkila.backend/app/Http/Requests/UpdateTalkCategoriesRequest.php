<?php

namespace App\Http\Requests;

use App\Models\TalkCategories;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateTalkCategoriesRequest
 * @package App\Http\Requests
 */
class UpdateTalkCategoriesRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('talk_subcategories_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
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
