<?php

namespace App\Http\Requests;

use App\Models\Country;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StoreCountryRequest
 * @package App\Http\Requests
 */
class StoreCountryRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('country_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * @return \string[][]
     */
    public function rules()
    {
        return [
            'short_code' => [
                'required',
                'max:3',
            ],
            'shorter_code' => [
                'required',
                'max:2',
            ],
            'english' => [
                'max:60',
            ],
            'german' => [
                'max:60',
            ],
            'croatian' => [
                'max:60',
            ],
            'spanish' => [
                'max:60',
            ],
            'french' => [
                'max:60',
            ],
            'italian' => [
                'max:60',
            ],
            'dutch' => [
                'max:60',
            ],
            'polish' => [
                'max:60',
            ],
            'danish' => [
                'max:60',
            ],
            'hungarian' => [
                'max:60',
            ],
            'portuguese' => [
                'max:60',
            ],
            'russian' => [
                'max:60',
            ],
            'turkish' => [
                'max:60',
            ],
            'bulgarian' => [
                'max:60',
            ],
            'romanian' => [
                'max:60',
            ],
            'slovak' => [
                'max:60',
            ],
            'czech' => [
                'max:60',
            ],
        ];
    }
}
