<?php

namespace App\Http\Requests;

use App\Models\SystemLogin;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreSystemLoginRequest
 * @package App\Http\Requests
 */
class StoreSystemLoginRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('system_login_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'user_id'    => [
                'required',
                'integer',
            ],
            'login_type' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'type'       => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
