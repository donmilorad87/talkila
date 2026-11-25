<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreNotificationSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bookings'   => ['sometimes', 'required', 'boolean'],
            'payments'   => ['sometimes', 'required', 'boolean'],
            'followings' => ['sometimes', 'required', 'boolean'],
            'reviews'    => ['sometimes', 'required', 'boolean'],
            'payouts'    => ['sometimes', 'required', 'boolean'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->error([
                'message' => __('SOMETHING_WENT_WRONG'),
                'data'    => [
                    'errors' => $errors,
                ],
            ])
        );
    }
}
