<?php

namespace App\Http\Requests;

use App\Models\UserBookmarkedTalks;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyUserBookmarkedTalksRequest
 * @package App\Http\Requests
 */
class MassDestroyUserBookmarkedTalksRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_bookmarked_talks_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:user_bookmarked_talks,id',
        ];
    }
}
