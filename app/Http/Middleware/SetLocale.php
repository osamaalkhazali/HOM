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

        $availableLocales = config('app.available_locales', [config('app.locale')]);
        $locale = session('locale');

        $user = $request->user();
        if ($user && in_array($user->preferred_language, $availableLocales, true)) {
            $locale = $user->preferred_language;
        }

        if (! $locale || !in_array($locale, $availableLocales, true)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        if (session('locale') !== $locale) {
            session(['locale' => $locale]);
        }

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
