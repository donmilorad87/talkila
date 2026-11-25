<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
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
         * JSON response in case of successful request.
         */
        Response::macro('success', function ($payload, $status = 200) {
            $response['success'] = true;

            if (is_string($payload)) {
                $response['message'] = $payload;
            }

            if (is_array($payload)) {
                $response['message'] =  $payload['message'];

                if (array_key_exists('data', $payload)) {
                    $response['data'] = $payload['data'];
                }
            }

            return Response::json($response, $status);
        });

        /**
         * JSON response in case of failed request.
         */
        Response::macro('error', function ($payload, $status = 400) {
            $response['success'] = false;

            if (is_string($payload)) {
                $response['message'] = $payload;
            }

            if (is_array($payload)) {
                $response['message'] =  $payload['message'];

                if (array_key_exists('data', $payload)) {
                    $response['data'] = $payload['data'];
                }
            }

            return Response::json($response, $status);
        });
    }
}
