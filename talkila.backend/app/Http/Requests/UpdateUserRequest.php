<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'name'    => [
                'required',
            ],
            'state'    => [
                'required',
            ],
            'username'    => [
                'nullable',
                'max:100',
                'unique:users,username,' . request()->route('user')->id,
            ],
            'email'   => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'roles.*' => [
                'integer',
            ],
            'roles'   => [
                'required',
                'array',
            ],
            'description' => [
                'nullable',
            ],
            'profession' => [
                'max:50',
            ],
            'youtube_video' => [
                'nullable',
                'max:100',
            ],
            'billing_address_id' => [
                'required',
                'integer',
            ],
            'email_activation_id' => [
                'max:40',
            ],
            'notification_message' => [
                'integer',
            ],
            'notification_sound' => [
                'integer',
            ],
            'profile_picture' => [
                'nullable',
            ],
            'login_type' => [
                'integer',
            ],
            'gmail_token' => [
                'max:50',
            ],
            'facebook_token' => [
                'max:50',
            ],
            'url' => [
                'max:45',
            ],
        ];
    }
}
