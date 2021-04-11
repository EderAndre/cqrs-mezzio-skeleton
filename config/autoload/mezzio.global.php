<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

return [
    // Toggle the configuration cache. Set this to boolean false, or remove the
    // directive, to disable configuration caching. Toggling development mode
    // will also disable it by default; clear the configuration cache using
    // `composer clear-config-cache`.
    ConfigAggregator::ENABLE_CACHE => $_ENV['APP_ENABLE_CACHE']=='true',

    // Enable debugging; typically used to provide debugging information within templates.
    'debug' => $_ENV['APP_DEBUG']=='true',

    'mezzio' => [
        // Provide templates for the error handling middleware to use when
        // generating responses.
        'error_handler' => [
            'template_403'   => 'error::403',
            'template_405'   => 'error::405',
            'template_404'   => 'error::404',
            'template_500'   => 'error::500',
            'template_error' => 'error::error',
        ],
    ],
];
