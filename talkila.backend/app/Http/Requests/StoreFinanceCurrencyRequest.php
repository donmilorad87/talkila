<?php

namespace App\Http\Requests;

use App\Models\FinanceCurrency;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreFinanceCurrencyRequest
 * @package App\Http\Requests
 */
class StoreFinanceCurrencyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('payout_currency_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'value' => [
                'max:5',
            ],
            'symbol' => [
                'max:15',
            ],
        ];
    }
}
