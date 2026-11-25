<?php

namespace App\Http\Requests;

use App\Models\LanguagesProfil;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateLanguagesProfilRequest
 * @package App\Http\Requests
 */
class UpdateLanguagesProfilRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('languages_profil_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'     => [
                'required',
                'integer',
            ],
            'language_id' => [
                'required',
                'integer',
                'max:999',
            ],
            'level'       => [
                'nullable',
                'integer',
                'max:9',
            ],
        ];
    }
}
