<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreUserRequest
 * @package App\Http\Requests
 */
class StoreUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {

        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'name'     => [
                'nullable',
            ],
            'username'    => [
                'nullable',
                'max:100',
                'unique:users',
            ],
            'email'    => [
                'nullable',
                'max:50',
                'unique:users',
            ],
            'password' => [
                'nullable',
            ],
            'password_tmp' => [
                'nullable',
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'nullable',
                'array',
            ],
            'description' => [
                'nullable',
            ],
            'profession' => [
                'max:50',
            ],
            'password_salt' => [
                'max:9999',
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
