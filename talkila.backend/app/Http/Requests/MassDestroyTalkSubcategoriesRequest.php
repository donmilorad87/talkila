<?php

namespace App\Http\Requests;

use App\Models\TalkSubcategories;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyTalkSubcategoriesRequest
 * @package App\Http\Requests
 */
class MassDestroyTalkSubcategoriesRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('talk_subcategories_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:talk_subcategories,id',
        ];
    }
}
