<?php

namespace App\Http\Requests;

use App\Models\ProfilPayoutMethod;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreProfilPayoutMethodRequest
 * @package App\Http\Requests
 */
class StoreProfilPayoutMethodRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profil_payout_method_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'method'  => [
                'nullable',
                'integer',
                'max:99',
            ],
            'value'  => [
                'nullable',
                'max:45',
            ],
            'state'   => [
                'nullable',
                'integer',
                'max:9',
            ],
        ];
    }
}
