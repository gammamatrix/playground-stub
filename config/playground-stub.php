<?php
/**
 * Playground
 */

declare(strict_types=1);

/**
 * Playground Stub Configuration and Environment Variables
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_STUB_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, commands and translations are loaded.
    |
    */

    'load' => [
        'commands' => (bool) env('PLAYGROUND_STUB_LOAD_COMMANDS', true),
        'translations' => (bool) env('PLAYGROUND_STUB_LOAD_TRANSLATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | By default, stubs will be loaded from the resources directory of this
    | package. A different path may be provided with:
    |
    | PLAYGROUND_STUB_PATHS_STUBS
    |
    */

    'paths' => [
        'stubs' => env('PLAYGROUND_STUB_PATHS_STUBS', ''),
    ],
];
