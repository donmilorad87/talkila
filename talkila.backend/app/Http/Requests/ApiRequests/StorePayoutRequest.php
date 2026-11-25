<?php

namespace App\Http\Requests\ApiRequests;

use App\Models\Payout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StorePayoutRequest
 * @package App\Http\Requests\ApiRequests
 */
class StorePayoutRequest extends FormRequest
{
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
            'user_id'             => [
                'required',
                'integer',
            ],
        ];
    }
}
