<?php

namespace App\Http\Requests;

use App\Models\StaticBlockedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyStaticBlockedUserRequest
 * @package App\Http\Requests
 */
class MassDestroyStaticBlockedUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('static_blocked_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:static_blocked_users,id',
        ];
    }
}
