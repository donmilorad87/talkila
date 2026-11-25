<?php

namespace App\Http\Requests;

use App\Models\LanguagesProfil;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyLanguagesProfilRequest
 * @package App\Http\Requests
 */
class MassDestroyLanguagesProfilRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('languages_profil_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:languages_profils,id',
        ];
    }
}
