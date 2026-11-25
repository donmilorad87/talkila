<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SocketRoomErrorRequest
 * @package App\Http\Requests
 */
class SocketRoomErrorRequest extends FormRequest
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
            'error' => [
                'required',
                'string',
            ],
        ];
    }
}
