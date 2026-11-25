<?php

namespace App\Http\Requests;

use App\Models\UserDontShowAgain;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyUserDontShowAgainRequest
 * @package App\Http\Requests
 */
class MassDestroyUserDontShowAgainRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_dont_show_again_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:user_dont_show_agains,id',
        ];
    }
}
