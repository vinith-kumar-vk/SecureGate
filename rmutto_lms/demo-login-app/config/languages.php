<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | Define all supported languages for the multilingual system.
    | Each language has a code, name, native name, and optional metadata.
    |
    */

    'supported' => ['en', 'th'],

    'languages' => [
        'en' => [
            'code' => 'en',
            'name' => 'English',
            'native_name' => 'English',
            'flag' => 'en-US',
            'rtl' => false,
            'enabled' => true,
        ],
        'th' => [
            'code' => 'th',
            'name' => 'Thai',
            'native_name' => 'ไทย',
            'flag' => '🇹🇭',
            'rtl' => false,
            'enabled' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Language
    |--------------------------------------------------------------------------
    |
    | The default language for the application.
    |
    */

    'default' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Fallback Language
    |--------------------------------------------------------------------------
    |
    | The fallback language when a translation is not found.
    |
    */

    'fallback' => env('APP_FALLBACK_LOCALE', 'en'),
];
