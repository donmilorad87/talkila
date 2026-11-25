<?php

namespace App\Http\Requests;

use App\Rules\Password\Lowercase;
use App\Rules\Password\Number;
use App\Rules\Password\SpecialCharacter;
use App\Rules\Password\Uppercase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PartnerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'min:2', 'max:100'],
            'email'       => ['required', 'string', 'email', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:8', 'max:50', new Uppercase(), new Lowercase(), new Number(), new SpecialCharacter()],
            'username'    => ['required', 'string', 'min:3', 'max:20', 'unique:users,username'],
            'image'       => ['sometimes', 'nullable', 'string'],
            'description' => ['sometimes', 'nullable', 'max:1000'],
            'country'     => ['sometimes', 'nullable', 'string'],
            'language'    => ['sometimes', 'nullable', 'string'],
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            response()->error('Unauthorized access.', Response::HTTP_UNAUTHORIZED)
        );
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => __('REQUEST_FAILED'),
                'errors'  => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
