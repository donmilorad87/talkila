<?php

namespace App\Rules\Email;

use App\Models\DisposalEmail;
use Illuminate\Contracts\Validation\Rule;

class Blocked implements Rule
{
    /**
     * Disposable Emails model.
     */
    public $emails;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->emails = new DisposalEmail();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->emails->where('email', $value)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is blocked.';
    }
}
