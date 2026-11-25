<?php

namespace App\Http\Requests;

use App\Models\StaticBlockedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreStaticBlockedUserRequest
 * @package App\Http\Requests
 */
class StoreStaticBlockedUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_blocked_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'unique:static_blocked_users',
                'max:45',
            ],
        ];
    }
}
