<?php

namespace App\Rules\Email;

use App\Models\DisposalDomain;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Domain implements Rule
{
    /**
     * Disposable Domains model.
     */
    public $domains;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->domains = new DisposalDomain();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $domain = Str::of($value)->explode('@')->last();
        return $this->domains->where('domain', $domain)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute domain is invalid.';
    }
}
