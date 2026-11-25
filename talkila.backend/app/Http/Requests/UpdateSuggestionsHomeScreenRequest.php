<?php

namespace App\Http\Requests;

use App\Models\SuggestionsHomeScreen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateSuggestionsHomeScreenRequest
 * @package App\Http\Requests
 */
class UpdateSuggestionsHomeScreenRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('suggestions_home_screen_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'state' => [
                'required',
            ],
        ];
    }
}
