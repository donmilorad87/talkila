<?php

namespace App\Providers;

use App\View\Composers\NotificationsCount;
use App\View\Composers\UserComposer;
use App\View\Composers\IsAppleComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer([
            'frontend.pages.home',
            'frontend/partials/components/top-header',
            'frontend/pages/profile',
            'frontend/partials/components/head',
            'frontend/partials/components/app_icons'
        ], IsAppleComposer::class);

        View::composer([
            'frontend/partials/*',
            'frontend/pages/*'
        ], UserComposer::class);

        View::composer([
            'frontend/pages/*'
        ], NotificationsCount::class);
    }
}
