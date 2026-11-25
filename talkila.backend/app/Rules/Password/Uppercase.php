<?php

namespace App\Rules\Password;

use Illuminate\Contracts\Validation\Rule;

class Uppercase implements Rule
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

        return ((bool) preg_match('/[A-Z]+/', $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('ATTRIBUTE_UPPERCASE', ['attribute' => $this->attribute]);
    }
}
