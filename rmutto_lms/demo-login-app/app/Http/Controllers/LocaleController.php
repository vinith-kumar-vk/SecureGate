<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocaleController extends Controller
{
    /**
     * Switch the application locale.
     *
     * @param Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocale(Request $request, string $locale)
    {
        // Validate locale is supported
        $supportedLocales = config('languages.supported', ['en', 'th']);
        if (! in_array($locale, $supportedLocales)) {
            $locale = config('languages.default', 'en');
        }

        // Store in session
        session(['locale' => $locale]);

        // If user is authenticated, also store in database
        if (Auth::check()) {
            Auth::user()->update(['language_preference' => $locale]);
        }

        // Redirect back to previous page or home
        return back() ?: redirect('/');
    }
}
