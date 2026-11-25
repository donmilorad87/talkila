<?php

namespace App\Http\Requests;

use App\Models\UserFollowed;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreUserFollowedRequest
 * @package App\Http\Requests
 */
class StoreUserFollowedRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_followed_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'          => [
                'required',
                'integer',
            ],
            'follower_user_id' => [
                'required',
                'integer',
            ],
            'state'            => [
                'required',
                'integer',
                'max:9',
            ],
        ];
    }
}
