<?php

declare(strict_types=1);

return [
    'about' => (bool) env('PLAYGROUND_STUB_ABOUT', true),
    'load' => [
        'commands' => (bool) env('PLAYGROUND_STUB_LOAD_COMMANDS', true),
        'translations' => (bool) env('PLAYGROUND_STUB_LOAD_TRANSLATIONS', true),
    ],
];
