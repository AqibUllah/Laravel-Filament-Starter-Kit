<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Theme Discovery Settings
    |--------------------------------------------------------------------------
    |
    | Configure how themes are discovered and managed
    */
    'discovery' => [
        'paths' => [
            'themes' => base_path('themes'),
            'resources' => resource_path('themes'),
        ],
        'cache_duration' => env('THEME_CACHE_DURATION', 3600), // seconds
        'auto_discover' => env('THEME_AUTO_DISCOVER', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Installation Settings
    |--------------------------------------------------------------------------
    |
    | Configure theme installation from various sources
    */
    'installation' => [
        'allowed_sources' => ['zip', 'github', 'local'],
        'temp_directory' => storage_path('app/temp/themes'),
        'backup_existing' => true,
        'auto_enable' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for theme file uploads
    */
    'upload' => [
        'disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),
        'directory' => 'themes/uploads',
        'max_size' => 50 * 1024 * 1024,
        'allowed_extensions' => ['zip'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security configuration for theme management
    */
    'security' => [
        'validate_theme_structure' => true,
        'scan_malicious_code' => true,
        'allowed_file_types' => [
            'php', 'blade.php', 'css', 'scss', 'js', 'vue', 'json',
            'md', 'txt', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp'
        ],
        'protected_themes' => ['default'], // Cannot be deleted/disabled
    ],

    /*
    |--------------------------------------------------------------------------
    | Preview Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for theme preview functionality
    */
    'preview' => [
        'enabled' => true,
        'route_prefix' => 'theme-preview',
        'session_duration' => 3600, // seconds
        'cache_screenshots' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation Settings
    |--------------------------------------------------------------------------
    |
    | Configure the navigation appearance in Filament
    */
    'navigation' => [
        'register' => true,
        'sort' => 200,
        'icon' => 'heroicon-o-paint-brush',
        'group' => 'System',
        'label' => 'filament-themes-manager::theme.navigation.label',
    ],

    /*
    |--------------------------------------------------------------------------
    | Widget Settings
    |--------------------------------------------------------------------------
    |
    | Configure widgets for the theme manager
    */
    'widgets' => [
        'enabled' => true,
        'page' => true, // Show widgets on theme manager page
        'dashboard' => true, // Show widgets on dashboard
        'widgets' => [
            \Alizharb\FilamentThemesManager\Widgets\ThemesOverview::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Validation Rules
    |--------------------------------------------------------------------------
    |
    | Define validation rules for theme.json files
    */
    'validation' => [
        'required_fields' => ['name', 'version', 'description'],
        'version_format' => 'semver', // semver or simple
        'max_name_length' => 50,
        'max_description_length' => 200,
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for performance optimization
    */
    'performance' => [
        'cache_theme_data' => true,
        'preload_active_theme' => true,
        'compile_assets' => env('THEME_COMPILE_ASSETS', false),
        'minify_output' => env('THEME_MINIFY_OUTPUT', false),
    ],
];
