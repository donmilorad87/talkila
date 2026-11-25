<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'api' => [
            'bindings',
            \App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\ValidateTimezone::class,
           // 'throttle:60,1',
        ],
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\SetRedirectIntent::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\AuthGates::class,
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\ApprovalMiddleware::class,
            \App\Http\Middleware\VerificationMiddleware::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth'             => \App\Http\Middleware\Authenticate::class,
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.partner'     => \App\Http\Middleware\AuthenticatePartner::class,
        'bindings'         => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'oauth'            => \App\Http\Middleware\OAuthTokenIsValid::class,
        'validationJTC'    => \App\Http\Middleware\ValidationJTC::class,
        'roleAdmin'        => \App\Http\Middleware\AdminUser::class,
        'roleUser'         => \App\Http\Middleware\TeacherStudentUser::class,
        'roleAffiliate'    => \App\Http\Middleware\AffiliateUser::class,
        'role'             => \App\Http\Middleware\ValidateRole::class,
    ];
}
