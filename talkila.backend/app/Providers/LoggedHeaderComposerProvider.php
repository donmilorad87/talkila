<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class LoggedHeaderComposerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->composeLoggedHeader();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    public function composeLoggedHeader()
    {
        view()->composer(
            'frontend.partials.components.header-third'
        , 'App\Http\Composers\LoggedHeaderComposer');
    }
}
