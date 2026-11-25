<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SocketNetworkQualityRequest
 * @package App\Http\Requests
 */
class SocketNetworkQualityRequest extends FormRequest
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
            'socket_participant_id' => [
                'required',
                'integer',
            ],
            'quality_level' => [
                'required',
                'integer',
            ],
        ];
    }
}
