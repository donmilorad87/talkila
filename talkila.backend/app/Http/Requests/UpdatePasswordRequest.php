<?php

namespace App\Http\Requests;

use App\Rules\Password\Lowercase;
use App\Rules\Password\Number;
use App\Rules\Password\SpecialCharacter;
use App\Rules\Password\Uppercase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

/**
 * Class UpdatePasswordRequest
 * @package App\Http\Requests
 */
class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'password' => ['required', 'confirmed', 'string', 'min:8', 'max:50', new Uppercase(), new Lowercase(), new Number(), new SpecialCharacter()],
        ];
    }
}
