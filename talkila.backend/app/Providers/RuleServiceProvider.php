<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class RuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Attribute must contain at least one lower case character.
         */
        Validator::extend('lowercase', function ($attribute, $value, $parameters, $validator) {
            return ((bool) preg_match('/[a-z]/', $value));
        });

        /**
         * Attribute must contain at least one upper case character.
         */
        Validator::extend('lowercase', function ($attribute, $value, $parameters, $validator) {
            return ((bool) preg_match('/[A-Z]/', $value));
        });

        /**
         * Attribute must contain at least one digit.
         */
        Validator::extend('lowercase', function ($attribute, $value, $parameters, $validator) {
            return ((bool) preg_match('/[0-9]/', $value));
        });

        /**
         * Attribute must contain at least one digit.
         */
        Validator::extend('symbol', function ($attribute, $value, $parameters, $validator) {
            return ((bool) preg_match('/[^A-Za-z0-9]/', $value));
        });
    }
}
