<?php

namespace App\Http\Requests\ApiRequests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreBillingAddressRequest
 * @package App\Http\Requests\ApiRequests
 */
class StoreBillingAddressRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        // TODO Removed this check because user on Jtc that is still student can create talk before we approve him
        //abort_if(Gate::denies('billing_address_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        $required = ($this->user()->type == 2 || $this->boolean('from_jtc')) ? 'required' : null;

        return [
            'street'       => [$required, 'max:45'],
            'zipcode'      => [$required, 'max:10'],
            'city'         => [$required, 'max:30'],
            'company_name' => [$required, 'max:40'],
            'tax_number'   => ['max:20'],
            'countries_id' => ['required', 'max:999'],
            'pays_vat'     => [$required, 'boolean'],
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'pays_vat' => $this->toBoolean($this->pays_vat),
        ]);
    }

    /**
     * Convert to boolean
     *
     * @param $booleable
     * @return boolean
     */
    private function toBoolean($booleable)
    {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors'  => $validator->errors(),
            'message' => 'Fields validation failed.',
            'success' => false,
        ], 200);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
