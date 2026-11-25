<?php

namespace App\Http\Requests;

use App\Models\UserVisited;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreUserVisitedRequest
 * @package App\Http\Requests
 */
class StoreUserVisitedRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_visited_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'visited_user_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
