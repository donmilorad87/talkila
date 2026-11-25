<?php

namespace App\Http\Requests;

use App\Models\UserBookmarkedTalks;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateUserBookmarkedTalksRequest
 * @package App\Http\Requests
 */
class UpdateUserBookmarkedTalksRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_bookmarked_talks_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'talks_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
