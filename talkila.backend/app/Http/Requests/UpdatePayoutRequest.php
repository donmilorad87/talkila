<?php

namespace App\Http\Requests;

use App\Models\Payout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdatePayoutRequest
 * @package App\Http\Requests
 */
class UpdatePayoutRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'payout_date'           => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'price'           => [
                'numeric',
                'between:0,99999999.99',
                'nullable',
            ],
            'finance_currencies_id' => [
                'required',
                'integer',
                'max:999',
            ],
            'invoice_number' => [
                'nullable',
                'max:10',
            ],
            'sales_tax'             => [
                'nullable',
                'integer',
                'max:99',
            ],
            'reference' => [
                'nullable',
                'max:45',
            ],
            'transferred_date'      => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
