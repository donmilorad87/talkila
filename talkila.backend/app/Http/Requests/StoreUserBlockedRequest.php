<?php

namespace App\Http\Requests;

use App\Models\UserBlocked;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreUserBlockedRequest
 * @package App\Http\Requests
 */
class StoreUserBlockedRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_blocked_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'         => [
                'required',
                'integer',
            ],
            'blocked_user_id' => [
                'required',
                'integer',
            ],
            'state'           => [
                'integer',
                'max:9',
            ],
        ];
    }
}
