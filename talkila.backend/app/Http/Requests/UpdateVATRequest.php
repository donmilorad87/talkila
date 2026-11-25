<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateVATRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('vat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'english'      => ['required', 'string', 'max:60'],
            'german'       => ['required', 'string', 'max:60'],
            'croatian'     => ['required', 'string', 'max:60'],
            'country_code' => ['required', 'string', 'max:3', 'unique:static_vat,country_code,' . $this->vat->id],
            'value'        => ['required', 'numeric'],
        ];
    }
}
