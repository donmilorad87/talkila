<?php

namespace App\Http\Requests;

use App\Models\StaticBlockedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateStaticBlockedUserRequest
 * @package App\Http\Requests
 */
class UpdateStaticBlockedUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_blocked_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'unique:static_blocked_users,email,' . request()->route('static_blocked_user')->id,
                'max:45',
            ],
        ];
    }
}
