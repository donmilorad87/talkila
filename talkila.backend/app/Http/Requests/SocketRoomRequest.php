<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SocketRoomRequest
 * @package App\Http\Requests
 */
class SocketRoomRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'talk_id' => [
                'required',
                'integer',
            ],
            'room_name' => [
                'required',
                'string',
            ],
            'duration' => [
                'required',
                'integer',
            ],
            'talk_type' => [
                'required',
                'integer',
            ],
            'state' => [
                'required',
                'integer',
            ],
        ];
    }
}
