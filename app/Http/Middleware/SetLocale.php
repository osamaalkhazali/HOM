<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldForceEnglish($request)) {
            App::setLocale(config('app.admin_locale', config('app.fallback_locale', 'en')));
            return $next($request);
        }

        $locale = session('locale', config('app.locale'));
        if (!in_array($locale, config('app.available_locales', [config('app.locale')]))) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }

    protected function shouldForceEnglish(Request $request): bool
    {
        if ($request->route()?->getName() && $request->route()->named('admin.*')) {
            return true;
        }

        return $request->is('admin') || $request->is('admin/*');
    }
}
