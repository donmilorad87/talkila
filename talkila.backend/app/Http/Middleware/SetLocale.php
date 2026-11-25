<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Str;

/**
 * Class SetLocale
 * @package App\Http\Middleware
 */
class SetLocale
{
    /**
     * @param           $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = Str::lower(
            ($request->input('hl') ?: $request->header('Application-Language'))
                ?: (session('language') ?: ($request->cookie('activeLang') ?? $_COOKIE['activeLang'] ?? null))
        );

        $hasErrors = empty($language);

        if ($hasErrors) {
            Log::notice('::Middleware::SetLocale::$parameters', [
                'Application-Language' => $request->header('Application-Language'),
                'Is-Mobile-App'        => $request->header('Is-Mobile-App'),
                'hl'                   => $request->input('hl'),
                'session'              => session('language'),
                'cookie'               => $_COOKIE['activeLang'] ?? null,
            ]);

            $language = 'de';
        }

        switch ($language) {
            case 'en':
                session()->put('language', 'en');
                break;
            case 'pl':
                session()->put('language', 'pl');
                break;
            case 'hr':
                session()->put('language', 'hr');
                break;
            default:
                session()->put('language', 'de');
                break;
        }

        app()->setLocale(Str::lower($language));

        if ($request->user()) {
            $request->user()->update([
                'last_language' => $language,
            ]);

            if ($hasErrors) {
                Log::error("User ID {$request->user()->id} app language was manually set to German (de).");
            }
        }

        setcookie("activeLang", $language, time() + (24 * 3600 * 30), "/");

        return $next($request);
    }
}
