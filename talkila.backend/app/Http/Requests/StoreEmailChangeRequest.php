<?php

namespace App\Http\Requests;

use App\Models\EmailChangeVerification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreEmailChangeRequest
 * @package App\Http\Requests
 */
class StoreEmailChangeRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'email'   => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
        ];
    }
}
