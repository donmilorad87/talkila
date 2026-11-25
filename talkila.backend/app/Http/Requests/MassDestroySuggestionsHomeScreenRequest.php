<?php

namespace App\Http\Requests;

use App\Models\SuggestionsHomeScreen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroySuggestionsHomeScreenRequest
 * @package App\Http\Requests
 */
class MassDestroySuggestionsHomeScreenRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('suggestions_home_screen_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:suggestions_home_screen,id',
        ];
    }
}
