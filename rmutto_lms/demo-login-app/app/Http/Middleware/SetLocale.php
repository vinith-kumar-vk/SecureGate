<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from different sources in priority order
        $locale = $this->detectLocale($request);

        // Set the application locale
        App::setLocale($locale);

        // Store in session for next request
        if (! session()->has('locale')) {
            session(['locale' => $locale]);
        }

        return $next($request);
    }

    /**
     * Detect the locale from various sources.
     *
     * @param Request $request
     * @return string
     */
    private function detectLocale(Request $request): string
    {
        $supportedLocales = config('languages.supported', ['en', 'th']);
        $defaultLocale = config('languages.default', 'en');

        // 1. Check if user is authenticated and has language preference
        if (auth()->check() && auth()->user()->language_preference) {
            $locale = auth()->user()->language_preference;
            if (in_array($locale, $supportedLocales)) {
                return $locale;
            }
        }

        // 2. Check session for user's language selection
        if (session()->has('locale')) {
            $locale = session('locale');
            if (in_array($locale, $supportedLocales)) {
                return $locale;
            }
        }

        // 3. Check browser Accept-Language header
        if ($request->header('Accept-Language')) {
            $browserLocale = $this->getLocaleFromHeader($request->header('Accept-Language'), $supportedLocales);
            if ($browserLocale) {
                return $browserLocale;
            }
        }

        // 4. Return config default
        return $defaultLocale;
    }

    /**
     * Extract locale from Accept-Language header.
     *
     * @param string $header
     * @param array $supportedLocales
     * @return string|null
     */
    private function getLocaleFromHeader(string $header, array $supportedLocales): ?string
    {
        // Parse Accept-Language header
        // Example: "en-US,en;q=0.9,th;q=0.8"
        $locales = array_map(function ($locale) {
            return trim(explode(';', $locale)[0]);
        }, explode(',', $header));

        foreach ($locales as $locale) {
            // Check full locale (e.g., en-US)
            if (in_array($locale, $supportedLocales)) {
                return $locale;
            }

            // Check language code only (e.g., en from en-US)
            $languageCode = explode('-', $locale)[0];
            if (in_array($languageCode, $supportedLocales)) {
                return $languageCode;
            }
        }

        return null;
    }
}
