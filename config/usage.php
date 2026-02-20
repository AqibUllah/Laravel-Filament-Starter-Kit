<?php

return [
    'enabled' => env('USAGE_TRACKING_ENABLED', true),

    // Default unit prices per metric (used if not overridden per route)
    'unit_prices' => [
        'api_calls' => 0.001,
        'storage_gb' => 0.10,
        'active_users' => 2.00,
    ],

    // Route-based metering rules. Each rule can match by route name (supports *), path regex, and/or HTTP method.
    // On match, a metric is recorded with optional unit price override and metadata builder.
    'routes' => [
        // Example: count dashboard page hits
        [
            'name' => 'filament.tenant.pages.*',
            'http' => ['GET'],
            'metric' => 'page_views',
            'quantity' => 1,
            'unit_price' => 0.0,
            // Closures are not allowed in config cache; use a serializable value.
            // If runtime-built metadata is needed, implement it where the config is consumed.
            'metadata' => null,
        ],

        // Example: track table exports
        [
            'name' => 'filament.tenant.export*',
            'http' => ['POST'],
            'metric' => 'exports',
            'quantity' => 1,
            'unit_price' => 0.0,
        ],

        // Track file uploads
        [
            'path_regex' => '#^/tenant/[^/]+/projects/[^/]+.*#',
            'http' => ['POST'],
            'metric' => 'file_uploads',
            'quantity' => 1,
            'unit_price' => 0.0,
            'metadata' => null,
        ],
    ],
];
