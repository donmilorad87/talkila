<?php

namespace App\Http\Requests;

use App\Models\ProfilPayoutMethod;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyProfilPayoutMethodRequest
 * @package App\Http\Requests
 */
class MassDestroyProfilPayoutMethodRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profil_payout_method_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:payouts_methods,id',
        ];
    }
}
