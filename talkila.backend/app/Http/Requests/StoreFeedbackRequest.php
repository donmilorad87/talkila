<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreFeedbackRequest
 * @package App\Http\Requests
 */
class StoreFeedbackRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('feedback_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'min:-2147483648',
                'max:2147483647',
            ],
            'booking_id' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'stars_content' => [
                'nullable',
                'integer',
                'max:9',
            ],
            'stars_voice_quality' => [
                'nullable',
                'integer',
                'max:9',
            ],
            'description' => [
                'nullable',
            ],
            'state' => [
                'integer',
                'max:9',
            ],
        ];
    }
}
