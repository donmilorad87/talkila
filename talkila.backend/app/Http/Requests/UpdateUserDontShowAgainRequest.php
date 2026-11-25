<?php

namespace App\Http\Requests;

use App\Models\UserDontShowAgain;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateUserDontShowAgainRequest
 * @package App\Http\Requests
 */
class UpdateUserDontShowAgainRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_dont_show_again_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'                 => [
                'required',
                'integer',
            ],
            'dont_show_again_user_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
