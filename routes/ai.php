<?php

use Laravel\Mcp\Facades\Mcp;

// Mcp::web('/mcp/demo', \App\Mcp\Servers\PublicServer::class);

Mcp::web('/mcp/weather', \App\Mcp\Servers\WeatherServer::class)
    ->middleware(['throttle:mcp']);

Mcp::local('weather', \App\Mcp\Servers\WeatherServer::class);
