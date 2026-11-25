<?php

namespace App\Http\Requests;

use App\Models\SuggestionsHomeScreen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreSuggestionsHomeScreenRequest
 * @package App\Http\Requests
 */
class StoreSuggestionsHomeScreenRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('suggestions_home_screen_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
