<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
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
        //
       /* DB::listen(function($query) {
            Log::info($query->sql);
            Log::info($query->bindings);
            Log::info($query->time);
//            try {
//                $test = vsprintf(str_replace('?', '`%s`', $query->sql), $query->bindings);
//                Log::info($test);
//            } catch (\Exception $e) {
//                return false;
//            }
//
            Log::info('-----------------------------------------------------------------------------------------'. "\n\r");
        });*/
    }
}
