<?php

namespace App\Http\Requests;

use App\Models\FinanceCurrency;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MassDestroyFinanceCurrencyRequest
 * @package App\Http\Requests
 */
class MassDestroyFinanceCurrencyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('payout_currency_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:finance_currencies,id',
        ];
    }
}
