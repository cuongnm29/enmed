<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (request('lang')) {
            session()->put('language', request('lang'));
            $language = request('lang');
        } elseif (session('language')) {
            $language = session('language');
        } elseif (config('panel.primary_language')) {
            $language = config('panel.primary_language');
        }

        if (isset($language)) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}
