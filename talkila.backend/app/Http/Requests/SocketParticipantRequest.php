<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SocketParticipantRequest
 * @package App\Http\Requests
 */
class SocketParticipantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'socket_room_id' => [
                'required',
                'integer',
            ],
            'booking_id' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'name_of_user' => [
                'required',
                'string',
            ],
            'user_image' => [
                'required',
                'string',
            ],
            'firebase_token' => [
                'required',
                'string',
            ],
            'twilio_access_token' => [
                'required',
                'string',
            ],
            'is_active' => [
                'required',
                'integer',
            ],
            'is_anonym' => [
                'required',
                'integer',
            ],
            'user_type' => [
                'required',
                'integer',
            ],
        ];
    }
}
