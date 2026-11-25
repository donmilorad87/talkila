<?php

namespace App\Rules\Password;

use Illuminate\Contracts\Validation\Rule;

class SpecialCharacter implements Rule
{
    /**
     * @var string Rule attribute.
     */
    protected string $attribute;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        return ((bool) preg_match('/[^A-Za-z0-9]+/', $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('ATTRIBUTE_SPECIAL_CHARACTER', ['attribute' => $this->attribute]);
    }
}
