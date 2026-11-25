<?php

namespace App\Http\Requests;

use App\Models\UserReported;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreUserReportedRequest
 * @package App\Http\Requests
 */
class StoreUserReportedRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_reported_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'reporter_user_id' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'type_id' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'state' => [
                'required',
                'integer',
                'max:9',
            ],
        ];
    }
}
