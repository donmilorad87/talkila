<?php

namespace App\Http\Requests;

use App\Models\BillingAddress;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateBillingAddressRequest
 * @package App\Http\Requests
 */
class UpdateBillingAddressRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('billing_address_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'street' => [
                'max:45',
            ],
            'zipcode' => [
                'max:10',
            ],
            'city' => [
                'max:30',
            ],
            'company_name' => [
                'max:40',
            ],
            'tax_number' => [
                'max:20',
            ],
            'countries_id' => [
                'max:999',
            ],
            'email' => [
                'max:50',
            ],
            'tel_number' => [
                'max:30',
            ],
            'vat' => [
                'max:30',
            ],
        ];
    }
}
