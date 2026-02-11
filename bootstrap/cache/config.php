<?php return array (
  'broadcasting' =>
  array (
    'default' => 'log',
    'connections' =>
    array (
      'reverb' =>
      array (
        'driver' => 'reverb',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' =>
        array (
          'host' => NULL,
          'port' => 443,
          'scheme' => 'https',
          'useTLS' => true,
        ),
        'client_options' =>
        array (
        ),
      ),
      'pusher' =>
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' =>
        array (
          'cluster' => NULL,
          'host' => 'api-mt1.pusher.com',
          'port' => 443,
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' =>
        array (
        ),
      ),
      'ably' =>
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'log' =>
      array (
        'driver' => 'log',
      ),
      'null' =>
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'concurrency' =>
  array (
    'default' => 'process',
  ),
  'cors' =>
  array (
    'paths' =>
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' =>
    array (
      0 => '*',
    ),
    'allowed_origins' =>
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' =>
    array (
    ),
    'allowed_headers' =>
    array (
      0 => '*',
    ),
    'exposed_headers' =>
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'hashing' =>
  array (
    'driver' => 'bcrypt',
    'bcrypt' =>
    array (
      'rounds' => '12',
      'verify' => true,
      'limit' => NULL,
    ),
    'argon' =>
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
      'verify' => true,
    ),
    'rehash_on_login' => true,
  ),
  'view' =>
  array (
    'paths' =>
    array (
      0 => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\resources\\views',
    ),
    'compiled' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\framework\\views',
  ),
  'activitylog' =>
  array (
    'enabled' => true,
    'delete_records_older_than_days' => 365,
    'default_log_name' => 'default',
    'default_auth_driver' => NULL,
    'subject_returns_soft_deleted_models' => false,
    'activity_model' => 'Spatie\\Activitylog\\Models\\Activity',
    'table_name' => 'activity_log',
    'database_connection' => NULL,
  ),
  'ai' =>
  array (
    'default' => 'gemini',
    'default_for_images' => 'gemini',
    'default_for_audio' => 'openai',
    'default_for_transcription' => 'openai',
    'default_for_embeddings' => 'openai',
    'default_for_reranking' => 'cohere',
    'caching' =>
    array (
      'embeddings' =>
      array (
        'cache' => false,
        'store' => 'database',
      ),
    ),
    'providers' =>
    array (
      'anthropic' =>
      array (
        'driver' => 'anthropic',
        'key' => '',
      ),
      'cohere' =>
      array (
        'driver' => 'cohere',
        'key' => '',
      ),
      'deepseek' =>
      array (
        'driver' => 'deepseek',
        'key' => NULL,
      ),
      'eleven' =>
      array (
        'driver' => 'eleven',
        'key' => '',
      ),
      'gemini' =>
      array (
        'driver' => 'gemini',
        'key' => 'AIzaSyBvzqPJepwpqZTUOKmLRcSWL2j_myJG3Ng',
      ),
      'groq' =>
      array (
        'driver' => 'groq',
        'key' => NULL,
      ),
      'jina' =>
      array (
        'driver' => 'jina',
        'key' => '',
      ),
      'mistral' =>
      array (
        'driver' => 'mistral',
        'key' => '',
      ),
      'ollama' =>
      array (
        'driver' => 'ollama',
        'key' => '',
        'url' => 'http://localhost:11434',
      ),
      'openai' =>
      array (
        'driver' => 'openai',
        'key' => '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',
      ),
      'openrouter' =>
      array (
        'driver' => 'openrouter',
        'key' => NULL,
      ),
      'voyageai' =>
      array (
        'driver' => 'voyageai',
        'key' => '',
      ),
      'xai' =>
      array (
        'driver' => 'xai',
        'key' => '',
      ),
    ),
  ),
  'app' =>
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://laravel-filament-starter-kit.test',
    'frontend_url' => 'http://localhost:3000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'cipher' => 'AES-256-CBC',
    'key' => 'base64:J9UL13GWLIahNgjbQY4yCrq7aHC6HLCnfWrs9fdcmcc=',
    'previous_keys' =>
    array (
    ),
    'maintenance' =>
    array (
      'driver' => 'file',
      'store' => 'database',
    ),
    'providers' =>
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Concurrency\\ConcurrencyServiceProvider',
      6 => 'Illuminate\\Cookie\\CookieServiceProvider',
      7 => 'Illuminate\\Database\\DatabaseServiceProvider',
      8 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      9 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      10 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      11 => 'Illuminate\\Hashing\\HashServiceProvider',
      12 => 'Illuminate\\Mail\\MailServiceProvider',
      13 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      14 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      15 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      16 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      17 => 'Illuminate\\Queue\\QueueServiceProvider',
      18 => 'Illuminate\\Redis\\RedisServiceProvider',
      19 => 'Illuminate\\Session\\SessionServiceProvider',
      20 => 'Illuminate\\Translation\\TranslationServiceProvider',
      21 => 'Illuminate\\Validation\\ValidationServiceProvider',
      22 => 'Illuminate\\View\\ViewServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\Filament\\AdminPanelProvider',
      26 => 'App\\Providers\\Filament\\TenantPanelProvider',
      27 => 'App\\Providers\\StripeBillingProvider',
      28 => 'CodeWithDennis\\SimpleAlert\\SimpleAlertServiceProvider',
    ),
    'aliases' =>
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Benchmark' => 'Illuminate\\Support\\Benchmark',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Concurrency' => 'Illuminate\\Support\\Facades\\Concurrency',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Context' => 'Illuminate\\Support\\Facades\\Context',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Number' => 'Illuminate\\Support\\Number',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schedule' => 'Illuminate\\Support\\Facades\\Schedule',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'Uri' => 'Illuminate\\Support\\Uri',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
    ),
  ),
  'auth' =>
  array (
    'defaults' =>
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' =>
    array (
      'web' =>
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'admin' =>
      array (
        'driver' => 'session',
        'provider' => 'admins',
      ),
    ),
    'providers' =>
    array (
      'users' =>
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
      'admins' =>
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Admin',
      ),
    ),
    'passwords' =>
    array (
      'users' =>
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
      'admins' =>
      array (
        'provider' => 'admins',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'cache' =>
  array (
    'default' => 'database',
    'stores' =>
    array (
      'array' =>
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'session' =>
      array (
        'driver' => 'session',
        'key' => '_cache',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'cache',
        'lock_connection' => NULL,
        'lock_table' => NULL,
      ),
      'file' =>
      array (
        'driver' => 'file',
        'path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\framework/cache/data',
        'lock_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\framework/cache/data',
      ),
      'memcached' =>
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' =>
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' =>
        array (
        ),
        'servers' =>
        array (
          0 =>
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' =>
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' =>
      array (
        'driver' => 'octane',
      ),
      'failover' =>
      array (
        'driver' => 'failover',
        'stores' =>
        array (
          0 => 'database',
          1 => 'array',
        ),
      ),
    ),
    'prefix' => 'laravel-cache-',
  ),
  'database' =>
  array (
    'default' => 'mysql',
    'connections' =>
    array (
      'sqlite' =>
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'saas',
        'prefix' => '',
        'foreign_key_constraints' => true,
        'busy_timeout' => NULL,
        'journal_mode' => NULL,
        'synchronous' => NULL,
        'transaction_mode' => 'DEFERRED',
      ),
      'mysql' =>
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'saas',
        'username' => 'root',
        'password' => 'Root@256344',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'mariadb' =>
      array (
        'driver' => 'mariadb',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'saas',
        'username' => 'root',
        'password' => 'Root@256344',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'pgsql' =>
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'saas',
        'username' => 'root',
        'password' => 'Root@256344',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' =>
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'saas',
        'username' => 'root',
        'password' => 'Root@256344',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' =>
    array (
      'table' => 'migrations',
      'update_date_on_publish' => true,
    ),
    'redis' =>
    array (
      'client' => 'phpredis',
      'options' =>
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel-database-',
        'persistent' => false,
      ),
      'default' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
      'cache' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
        'max_retries' => 3,
        'backoff_algorithm' => 'decorrelated_jitter',
        'backoff_base' => 100,
        'backoff_cap' => 1000,
      ),
    ),
  ),
  'filament' =>
  array (
    'broadcasting' =>
    array (
    ),
    'default_filesystem_disk' => 'local',
    'assets_path' => NULL,
    'cache_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\bootstrap/cache/filament',
    'livewire_loading_delay' => 'default',
    'file_generation' =>
    array (
      'flags' =>
      array (
      ),
    ),
    'system_route_prefix' => 'filament',
  ),
  'filament-email' =>
  array (
    'resource' =>
    array (
      'class' => 'RickDBCN\\FilamentEmail\\Filament\\Resources\\EmailResource',
      'model' => 'RickDBCN\\FilamentEmail\\Models\\Email',
      'cluster' => NULL,
      'group' => NULL,
      'sort' => NULL,
      'icon' => NULL,
      'default_sort_column' => 'created_at',
      'default_sort_direction' => 'desc',
      'datetime_format' => 'Y-m-d H:i:s',
      'table_search_fields' =>
      array (
        0 => 'subject',
        1 => 'from',
        2 => 'to',
        3 => 'cc',
        4 => 'bcc',
      ),
      'has_title_case_model_label' => false,
    ),
    'keep_email_for_days' => 60,
    'label' => NULL,
    'prune_enabled' => true,
    'prune_crontab' => '0 0 * * *',
    'can_access' =>
    array (
      'role' =>
      array (
      ),
    ),
    'pagination_page_options' =>
    array (
      0 => 10,
      1 => 25,
      2 => 50,
      3 => 'all',
    ),
    'attachments_disk' => 'local',
    'store_attachments' => true,
  ),
  'filament-email-templates' =>
  array (
    'table_name' => 'vb_email_templates',
    'theme_table_name' => 'vb_email_templates_themes',
    'mailable_directory' => 'Mail/Visualbuilder/EmailTemplates',
    'tokenHelperClass' => 'Visualbuilder\\EmailTemplates\\DefaultTokenHelper',
    'known_tokens' =>
    array (
      0 => 'tokenUrl',
      1 => 'verificationUrl',
      2 => 'message',
    ),
    'navigation' =>
    array (
      'enabled' => true,
      'templates' =>
      array (
        'sort' => 10,
        'label' => 'Email Templates',
        'icon' => 'heroicon-o-envelope',
        'group' => 'Content',
        'cluster' => false,
        'position' =>
        \Filament\Pages\Enums\SubNavigationPosition::Top,
      ),
      'themes' =>
      array (
        'sort' => 20,
        'label' => 'Email Template Themes',
        'icon' => 'heroicon-o-paint-brush',
        'group' => 'Content',
        'cluster' => false,
        'position' =>
        \Filament\Pages\Enums\SubNavigationPosition::Top,
      ),
    ),
    'default_view' => 'default',
    'template_view_path' => 'vb-email-templates::email',
    'template_keys' =>
    array (
      'user-welcome' => 'User Welcome Email',
      'user-request-reset' => 'User Request Password Reset',
      'user-password-reset-success' => 'User Password Reset',
      'user-locked-out' => 'User Account Locked Out',
      'user-verify-email' => 'User Verify Email',
      'user-verified' => 'User Verified',
      'user-login' => 'User Logged In',
    ),
    'logo' => 'media/email-templates/logo.png',
    'browsed_logo' => 'media/email-templates/logos',
    'logo_width' => '500',
    'logo_height' => '126',
    'content_width' => '600',
    'customer-services' =>
    array (
      'email' => 'support@yourcompany.com',
      'phone' => '+441273 455702',
    ),
    'links' =>
    array (
      0 =>
      array (
        'name' => 'Website',
        'url' => 'https://yourwebsite.com',
        'title' => 'Goto website',
      ),
      1 =>
      array (
        'name' => 'Privacy Policy',
        'url' => 'https://yourwebsite.com/privacy-policy',
        'title' => 'View Privacy Policy',
      ),
    ),
    'default_locale' => 'en_GB',
    'languages' =>
    array (
      'en_GB' =>
      array (
        'display' => 'British',
        'flag-icon' => 'gb',
      ),
      'en_US' =>
      array (
        'display' => 'USA',
        'flag-icon' => 'us',
      ),
      'es' =>
      array (
        'display' => 'Español',
        'flag-icon' => 'es',
      ),
      'fr' =>
      array (
        'display' => 'Français',
        'flag-icon' => 'fr',
      ),
      'pt' =>
      array (
        'display' => 'Brasileiro',
        'flag-icon' => 'br',
      ),
      'in' =>
      array (
        'display' => 'Hindi',
        'flag-icon' => 'in',
      ),
    ),
    'recipients' =>
    array (
      0 => 'App\\Models\\User',
    ),
    'config_keys' =>
    array (
      0 => 'app.name',
      1 => 'app.url',
      2 => 'email-templates.customer-services',
    ),
    'send_emails' =>
    array (
      'new_user_registered' => true,
      'verification' => true,
      'user_verified' => true,
      'login' => true,
      'password_reset_success' => true,
      'locked_out' => true,
    ),
  ),
  'filament-laravel-log' =>
  array (
    'maxLines' => 50,
    'minLines' => 10,
    'fontSize' => 12,
    'limit' => 5,
  ),
  'filament-shield' =>
  array (
    'shield_resource' =>
    array (
      'slug' => 'shield/roles',
      'show_model_path' => true,
      'cluster' => NULL,
      'tabs' =>
      array (
        'pages' => true,
        'widgets' => true,
        'resources' => true,
        'custom_permissions' => true,
      ),
    ),
    'tenant_model' => 'App\\Models\\Team',
    'auth_provider_model' => 'App\\Models\\User',
    'super_admin' =>
    array (
      'enabled' => true,
      'name' => 'super_admin',
      'define_via_gate' => false,
      'intercept_gate' => 'before',
    ),
    'panel_user' =>
    array (
      'enabled' => true,
      'name' => 'panel_user',
    ),
    'permissions' =>
    array (
      'separator' => ':',
      'case' => 'pascal',
      'generate' => true,
    ),
    'policies' =>
    array (
      'path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\app\\Policies',
      'merge' => true,
      'generate' => false,
      'methods' =>
      array (
        0 => 'viewAny',
        1 => 'view',
        2 => 'create',
        3 => 'update',
        4 => 'delete',
        5 => 'restore',
        6 => 'forceDelete',
        7 => 'forceDeleteAny',
        8 => 'restoreAny',
        9 => 'replicate',
        10 => 'reorder',
      ),
      'single_parameter_methods' =>
      array (
        0 => 'viewAny',
        1 => 'create',
        2 => 'deleteAny',
        3 => 'forceDeleteAny',
        4 => 'restoreAny',
        5 => 'reorder',
      ),
    ),
    'localization' =>
    array (
      'enabled' => false,
      'key' => 'filament-shield::filament-shield',
    ),
    'resources' =>
    array (
      'subject' => 'model',
      'manage' =>
      array (
        'BezhanSalleh\\FilamentShield\\Resources\\Roles\\RoleResource' =>
        array (
          0 => 'viewAny',
          1 => 'view',
          2 => 'create',
          3 => 'update',
          4 => 'delete',
        ),
      ),
      'exclude' =>
      array (
      ),
    ),
    'pages' =>
    array (
      'subject' => 'class',
      'prefix' => 'view',
      'exclude' =>
      array (
      ),
    ),
    'widgets' =>
    array (
      'subject' => 'class',
      'prefix' => 'view',
      'exclude' =>
      array (
        0 => 'Filament\\Widgets\\AccountWidget',
        1 => 'Filament\\Widgets\\FilamentInfoWidget',
      ),
    ),
    'custom_permissions' =>
    array (
      0 => 'view_advanced_analytics',
    ),
    'discovery' =>
    array (
      'discover_all_resources' => false,
      'discover_all_widgets' => false,
      'discover_all_pages' => false,
    ),
    'register_role_policy' => true,
  ),
  'filament-socialite' =>
  array (
    'middleware' =>
    array (
      0 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
      1 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
      2 => 'Illuminate\\Session\\Middleware\\StartSession',
      3 => 'Illuminate\\Session\\Middleware\\AuthenticateSession',
      4 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
    ),
  ),
  'filament-themes-manager' =>
  array (
    'discovery' =>
    array (
      'paths' =>
      array (
        'themes' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\themes',
        'resources' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\resources\\themes',
      ),
      'cache_duration' => 3600,
      'auto_discover' => true,
    ),
    'installation' =>
    array (
      'allowed_sources' =>
      array (
        0 => 'zip',
        1 => 'github',
        2 => 'local',
      ),
      'temp_directory' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\app/temp/themes',
      'backup_existing' => true,
      'auto_enable' => false,
    ),
    'upload' =>
    array (
      'disk' => 'public',
      'directory' => 'themes/uploads',
      'max_size' => 52428800,
      'allowed_extensions' =>
      array (
        0 => 'zip',
      ),
    ),
    'security' =>
    array (
      'validate_theme_structure' => true,
      'scan_malicious_code' => true,
      'allowed_file_types' =>
      array (
        0 => 'php',
        1 => 'blade.php',
        2 => 'css',
        3 => 'scss',
        4 => 'js',
        5 => 'vue',
        6 => 'json',
        7 => 'md',
        8 => 'txt',
        9 => 'png',
        10 => 'jpg',
        11 => 'jpeg',
        12 => 'gif',
        13 => 'svg',
        14 => 'webp',
      ),
      'protected_themes' =>
      array (
        0 => 'default',
      ),
    ),
    'preview' =>
    array (
      'enabled' => true,
      'route_prefix' => 'theme-preview',
      'session_duration' => 3600,
      'cache_screenshots' => true,
    ),
    'navigation' =>
    array (
      'register' => true,
      'sort' => 200,
      'icon' => 'heroicon-o-paint-brush',
      'group' => 'System',
      'label' => 'filament-themes-manager::theme.navigation.label',
    ),
    'widgets' =>
    array (
      'enabled' => true,
      'page' => true,
      'dashboard' => true,
      'widgets' =>
      array (
        0 => 'Alizharb\\FilamentThemesManager\\Widgets\\ThemesOverview',
      ),
    ),
    'validation' =>
    array (
      'required_fields' =>
      array (
        0 => 'name',
        1 => 'version',
        2 => 'description',
      ),
      'version_format' => 'semver',
      'max_name_length' => 50,
      'max_description_length' => 200,
    ),
    'performance' =>
    array (
      'cache_theme_data' => true,
      'preload_active_theme' => true,
      'compile_assets' => false,
      'minify_output' => false,
    ),
  ),
  'filesystems' =>
  array (
    'default' => 'local',
    'disks' =>
    array (
      'local' =>
      array (
        'driver' => 'local',
        'root' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\app/private',
        'serve' => true,
        'throw' => false,
        'report' => false,
      ),
      'public' =>
      array (
        'driver' => 'local',
        'root' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\app/public',
        'url' => 'http://laravel-filament-starter-kit.test/storage',
        'visibility' => 'public',
        'throw' => false,
        'report' => false,
      ),
      's3' =>
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
        'report' => false,
      ),
      'filament-excel' =>
      array (
        'driver' => 'local',
        'root' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\app/filament-excel',
        'url' => 'http://laravel-filament-starter-kit.test/filament-excel',
      ),
    ),
    'links' =>
    array (
      'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\public\\storage' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\app/public',
    ),
  ),
  'logging' =>
  array (
    'default' => 'stack',
    'deprecations' =>
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' =>
    array (
      'stack' =>
      array (
        'driver' => 'stack',
        'channels' =>
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' =>
      array (
        'driver' => 'single',
        'path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\logs/laravel.log',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'daily' =>
      array (
        'driver' => 'daily',
        'path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
        'replace_placeholders' => true,
      ),
      'slack' =>
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'papertrail' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' =>
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
        'processors' =>
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'stderr' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'handler_with' =>
        array (
          'stream' => 'php://stderr',
        ),
        'formatter' => NULL,
        'processors' =>
        array (
          0 => 'Monolog\\Processor\\PsrLogMessageProcessor',
        ),
      ),
      'syslog' =>
      array (
        'driver' => 'syslog',
        'level' => 'debug',
        'facility' => 8,
        'replace_placeholders' => true,
      ),
      'errorlog' =>
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
        'replace_placeholders' => true,
      ),
      'null' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' =>
      array (
        'path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\logs/laravel.log',
      ),
    ),
  ),
  'mail' =>
  array (
    'default' => 'smtp',
    'mailers' =>
    array (
      'smtp' =>
      array (
        'transport' => 'smtp',
        'scheme' => NULL,
        'url' => NULL,
        'host' => 'sandbox.smtp.mailtrap.io',
        'port' => '2525',
        'username' => 'a8c0181fa4966e',
        'password' => '3515f0e80f1712',
        'timeout' => NULL,
        'local_domain' => 'laravel-filament-starter-kit.test',
      ),
      'ses' =>
      array (
        'transport' => 'ses',
      ),
      'postmark' =>
      array (
        'transport' => 'postmark',
      ),
      'resend' =>
      array (
        'transport' => 'resend',
      ),
      'sendmail' =>
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' =>
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' =>
      array (
        'transport' => 'array',
      ),
      'failover' =>
      array (
        'transport' => 'failover',
        'mailers' =>
        array (
          0 => 'smtp',
          1 => 'log',
        ),
        'retry_after' => 60,
      ),
      'roundrobin' =>
      array (
        'transport' => 'roundrobin',
        'mailers' =>
        array (
          0 => 'ses',
          1 => 'postmark',
        ),
        'retry_after' => 60,
      ),
    ),
    'from' =>
    array (
      'address' => 'hello@example.com',
      'name' => 'Laravel',
    ),
    'markdown' =>
    array (
      'theme' => 'default',
      'paths' =>
      array (
        0 => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'permission' =>
  array (
    'models' =>
    array (
      'permission' => 'App\\Models\\Permission',
      'role' => 'App\\Models\\Role',
    ),
    'table_names' =>
    array (
      'roles' => 'roles',
      'permissions' => 'permissions',
      'model_has_permissions' => 'model_has_permissions',
      'model_has_roles' => 'model_has_roles',
      'role_has_permissions' => 'role_has_permissions',
    ),
    'column_names' =>
    array (
      'role_pivot_key' => NULL,
      'permission_pivot_key' => NULL,
      'model_morph_key' => 'model_id',
      'team_foreign_key' => 'team_id',
    ),
    'register_permission_check_method' => true,
    'register_octane_reset_listener' => false,
    'events_enabled' => false,
    'teams' => true,
    'team_resolver' => 'Spatie\\Permission\\DefaultTeamResolver',
    'use_passport_client_credentials' => false,
    'display_permission_in_exception' => false,
    'display_role_in_exception' => false,
    'enable_wildcard_permission' => false,
    'cache' =>
    array (
      'expiration_time' =>
      \DateInterval::__set_state(array(
         'from_string' => true,
         'date_string' => '24 hours',
      )),
      'key' => 'spatie.permission.cache',
      'store' => 'default',
    ),
  ),
  'queue' =>
  array (
    'default' => 'database',
    'connections' =>
    array (
      'sync' =>
      array (
        'driver' => 'sync',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'connection' => NULL,
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' =>
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' =>
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
      'deferred' =>
      array (
        'driver' => 'deferred',
      ),
      'failover' =>
      array (
        'driver' => 'failover',
        'connections' =>
        array (
          0 => 'database',
          1 => 'sync',
        ),
      ),
    ),
    'batching' =>
    array (
      'database' => 'mysql',
      'table' => 'job_batches',
    ),
    'failed' =>
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' =>
  array (
    'postmark' =>
    array (
      'token' => NULL,
    ),
    'resend' =>
    array (
      'key' => NULL,
    ),
    'ses' =>
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
    'slack' =>
    array (
      'notifications' =>
      array (
        'bot_user_oauth_token' => NULL,
        'channel' => NULL,
      ),
    ),
    'stripe' =>
    array (
      'secret' => 'sk_test_51K3fZbCdDYiPm1gGXeyCMk126E6FJ7GFHsdUhVy5ABXELAeb1j6ROfgBRmrdPctvhzsLhHxmGWhtqpRNvSi3luXt00ydw29F5L',
      'channel' => 'pk_test_51K3fZbCdDYiPm1gGOxHfBEY17BERofPx7SC2wqWVuWadB9mwnIPq0opvcQVdph9USGft0B1qtCUSnVcmfDD3mryu00E8a3bUp5',
      'webhook_secret' => 'whsec_tQC8rqh4czx0VOxW4hhNZobgXdX4nKtv',
    ),
    'github' =>
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
    'google' =>
    array (
      'client_id' => NULL,
      'client_secret' => NULL,
      'redirect' => NULL,
    ),
  ),
  'session' =>
  array (
    'driver' => 'database',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' =>
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel-session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
    'partitioned' => false,
  ),
  'settings' =>
  array (
    'settings' =>
    array (
      0 => 'App\\Settings\\TenantGeneralSettings',
    ),
    'setting_class_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\app\\Settings',
    'migrations_paths' =>
    array (
      0 => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\database\\settings',
    ),
    'default_repository' => 'database',
    'repositories' =>
    array (
      'database' =>
      array (
        'type' => 'App\\Settings\\Repositories\\TenantSettingsRepository',
        'model' => NULL,
        'table' => 'settings',
        'connection' => NULL,
      ),
      'redis' =>
      array (
        'type' => 'Spatie\\LaravelSettings\\SettingsRepositories\\RedisSettingsRepository',
        'connection' => NULL,
        'prefix' => NULL,
      ),
    ),
    'encoder' => NULL,
    'decoder' => NULL,
    'cache' =>
    array (
      'enabled' => false,
      'store' => NULL,
      'prefix' => NULL,
      'ttl' => NULL,
    ),
    'global_casts' =>
    array (
      'DateTimeInterface' => 'Spatie\\LaravelSettings\\SettingsCasts\\DateTimeInterfaceCast',
      'DateTimeZone' => 'Spatie\\LaravelSettings\\SettingsCasts\\DateTimeZoneCast',
      'Spatie\\LaravelData\\Data' => 'Spatie\\LaravelSettings\\SettingsCasts\\DataCast',
    ),
    'auto_discover_settings' =>
    array (
      0 => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\app\\Settings',
    ),
    'discovered_settings_cache_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\bootstrap/cache',
    'extra_columns' =>
    array (
      0 => 'tenant_id',
    ),
    'resolvers' =>
    array (
      'tenant_id' =>
      array (
        0 => 'App\\Settings\\Resolvers\\TenantResolver',
        1 => 'tenantId',
      ),
    ),
  ),
  'settings-old' =>
  array (
    'repository' => 'Spatie\\LaravelSettings\\SettingsRepositories\\DatabaseSettingsRepository',
    'default_repository' => 'Spatie\\LaravelSettings\\SettingsRepositories\\DatabaseSettingsRepository',
    'connection' => NULL,
    'table' => 'settings',
    'setting_class_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\app\\Settings',
    'migrations_paths' =>
    array (
      0 => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\database\\settings',
    ),
    'extra_columns' =>
    array (
      0 => 'tenant_id',
    ),
    'resolvers' =>
    array (
      'tenant_id' =>
      array (
        0 => 'App\\Settings\\Resolvers\\TenantResolver',
        1 => 'tenantId',
      ),
    ),
    'settings' =>
    array (
      0 => 'App\\Settings\\TenantGeneralSettings',
    ),
    'repositories' =>
    array (
      'database' =>
      array (
        'type' => 'Spatie\\LaravelSettings\\SettingsRepositories\\DatabaseSettingsRepository',
        'model' => NULL,
        'table' => NULL,
        'connection' => NULL,
      ),
      'redis' =>
      array (
        'type' => 'Spatie\\LaravelSettings\\SettingsRepositories\\RedisSettingsRepository',
        'connection' => NULL,
        'prefix' => NULL,
      ),
    ),
    'encoder' => NULL,
    'decoder' => NULL,
    'cache' =>
    array (
      'enabled' => false,
      'store' => NULL,
      'prefix' => NULL,
      'ttl' => NULL,
    ),
    'global_casts' =>
    array (
      'DateTimeInterface' => 'Spatie\\LaravelSettings\\SettingsCasts\\DateTimeInterfaceCast',
      'DateTimeZone' => 'Spatie\\LaravelSettings\\SettingsCasts\\DateTimeZoneCast',
      'Spatie\\LaravelData\\Data' => 'Spatie\\LaravelSettings\\SettingsCasts\\DataCast',
    ),
    'auto_discover_settings' =>
    array (
      0 => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\app\\Settings',
    ),
    'discovered_settings_cache_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\bootstrap/cache',
  ),
  'usage' =>
  array (
    'enabled' => true,
    'unit_prices' =>
    array (
      'api_calls' => 0.001,
      'storage_gb' => 0.1,
      'active_users' => 2.0,
    ),
    'routes' =>
    array (
      0 =>
      array (
        'name' => 'filament.tenant.pages.*',
        'http' =>
        array (
          0 => 'GET',
        ),
        'metric' => 'page_views',
        'quantity' => 1,
        'unit_price' => 0.0,
        'metadata' => NULL,
      ),
      1 =>
      array (
        'name' => 'filament.tenant.export*',
        'http' =>
        array (
          0 => 'POST',
        ),
        'metric' => 'exports',
        'quantity' => 1,
        'unit_price' => 0.0,
      ),
    ),
  ),
  'blade-heroicons' =>
  array (
    'prefix' => 'heroicon',
    'fallback' => '',
    'class' => '',
    'attributes' =>
    array (
    ),
  ),
  'blade-icons' =>
  array (
    'sets' =>
    array (
    ),
    'class' => '',
    'attributes' =>
    array (
    ),
    'fallback' => '',
    'components' =>
    array (
      'disabled' => false,
      'default' => 'icon',
    ),
  ),
  'cashier' =>
  array (
    'key' => 'pk_test_51K3fZbCdDYiPm1gGOxHfBEY17BERofPx7SC2wqWVuWadB9mwnIPq0opvcQVdph9USGft0B1qtCUSnVcmfDD3mryu00E8a3bUp5',
    'secret' => 'sk_test_51K3fZbCdDYiPm1gGXeyCMk126E6FJ7GFHsdUhVy5ABXELAeb1j6ROfgBRmrdPctvhzsLhHxmGWhtqpRNvSi3luXt00ydw29F5L',
    'path' => 'stripe',
    'webhook' =>
    array (
      'secret' => 'whsec_tQC8rqh4czx0VOxW4hhNZobgXdX4nKtv',
      'tolerance' => 300,
      'events' =>
      array (
        0 => 'customer.subscription.created',
        1 => 'customer.subscription.updated',
        2 => 'customer.subscription.deleted',
        3 => 'customer.updated',
        4 => 'customer.deleted',
        5 => 'payment_method.automatically_updated',
        6 => 'invoice.payment_action_required',
        7 => 'invoice.payment_succeeded',
      ),
    ),
    'currency' => 'usd',
    'currency_locale' => 'en',
    'payment_notification' => NULL,
    'invoices' =>
    array (
      'renderer' => 'Laravel\\Cashier\\Invoices\\DompdfInvoiceRenderer',
      'options' =>
      array (
        'paper' => 'letter',
        'remote_enabled' => false,
      ),
    ),
    'logger' => NULL,
  ),
  'livewire' =>
  array (
    'class_namespace' => 'App\\Livewire',
    'view_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\resources\\views/livewire',
    'layout' => 'components.layouts.app',
    'lazy_placeholder' => NULL,
    'temporary_file_upload' =>
    array (
      'disk' => NULL,
      'rules' => NULL,
      'directory' => NULL,
      'middleware' => NULL,
      'preview_mimes' =>
      array (
        0 => 'png',
        1 => 'gif',
        2 => 'bmp',
        3 => 'svg',
        4 => 'wav',
        5 => 'mp4',
        6 => 'mov',
        7 => 'avi',
        8 => 'wmv',
        9 => 'mp3',
        10 => 'm4a',
        11 => 'jpg',
        12 => 'jpeg',
        13 => 'mpga',
        14 => 'webp',
        15 => 'wma',
      ),
      'max_upload_time' => 5,
      'cleanup' => true,
    ),
    'render_on_redirect' => false,
    'legacy_model_binding' => false,
    'inject_assets' => true,
    'navigate' =>
    array (
      'show_progress_bar' => true,
      'progress_bar_color' => '#2299dd',
    ),
    'inject_morph_markers' => true,
    'pagination_theme' => 'tailwind',
  ),
  'excel' =>
  array (
    'exports' =>
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' =>
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
        'output_encoding' => '',
        'test_auto_detect' => true,
      ),
      'properties' =>
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' =>
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' =>
      array (
        'formatter' => 'slug',
      ),
      'csv' =>
      array (
        'delimiter' => NULL,
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'guess',
      ),
      'properties' =>
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
      'cells' =>
      array (
        'middleware' =>
        array (
        ),
      ),
    ),
    'extension_detector' =>
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' =>
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' =>
    array (
      'driver' => 'memory',
      'batch' =>
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' =>
      array (
        'store' => NULL,
      ),
      'default_ttl' => 10800,
    ),
    'transactions' =>
    array (
      'handler' => 'db',
      'db' =>
      array (
        'connection' => NULL,
      ),
    ),
    'temporary_files' =>
    array (
      'local_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\storage\\framework/cache/laravel-excel',
      'local_permissions' =>
      array (
      ),
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'blade-fontawesome' =>
  array (
    'brands' =>
    array (
      'prefix' => 'fab',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'regular' =>
    array (
      'prefix' => 'far',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'solid' =>
    array (
      'prefix' => 'fas',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'duotone' =>
    array (
      'prefix' => 'fad',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'light' =>
    array (
      'prefix' => 'fal',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'thin' =>
    array (
      'prefix' => 'fat',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'sharp-light' =>
    array (
      'prefix' => 'fal:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'sharp-regular' =>
    array (
      'prefix' => 'far:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'sharp-solid' =>
    array (
      'prefix' => 'fas:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'sharp-duotone-solid' =>
    array (
      'prefix' => 'fad:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'sharp-thin' =>
    array (
      'prefix' => 'fat:sharp',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
    'custom' =>
    array (
      'prefix' => 'fak',
      'fallback' => '',
      'class' => '',
      'attributes' =>
      array (
      ),
    ),
  ),
  'prism' =>
  array (
    'prism_server' =>
    array (
      'middleware' =>
      array (
      ),
      'enabled' => false,
    ),
    'request_timeout' => 30,
    'providers' =>
    array (
      'openai' =>
      array (
        'url' => 'https://api.openai.com/v1',
        'api_key' => '',
        'organization' => NULL,
        'project' => NULL,
      ),
      'anthropic' =>
      array (
        'api_key' => '',
        'version' => '2023-06-01',
        'url' => 'https://api.anthropic.com/v1',
        'default_thinking_budget' => 1024,
        'anthropic_beta' => NULL,
      ),
      'ollama' =>
      array (
        'url' => 'http://localhost:11434',
      ),
      'mistral' =>
      array (
        'api_key' => '',
        'url' => 'https://api.mistral.ai/v1',
      ),
      'groq' =>
      array (
        'api_key' => '',
        'url' => 'https://api.groq.com/openai/v1',
      ),
      'xai' =>
      array (
        'api_key' => '',
        'url' => 'https://api.x.ai/v1',
      ),
      'gemini' =>
      array (
        'api_key' => 'AIzaSyBvzqPJepwpqZTUOKmLRcSWL2j_myJG3Ng',
        'url' => 'https://generativelanguage.googleapis.com/v1beta/models',
      ),
      'deepseek' =>
      array (
        'api_key' => '',
        'url' => 'https://api.deepseek.com/v1',
      ),
      'elevenlabs' =>
      array (
        'api_key' => '',
        'url' => 'https://api.elevenlabs.io/v1/',
      ),
      'voyageai' =>
      array (
        'api_key' => '',
        'url' => 'https://api.voyageai.com/v1',
      ),
      'openrouter' =>
      array (
        'api_key' => '',
        'url' => 'https://openrouter.ai/api/v1',
        'site' =>
        array (
          'http_referer' => NULL,
          'x_title' => NULL,
        ),
      ),
    ),
  ),
  'theme' =>
  array (
    'active' => NULL,
    'parent' => NULL,
    'base_path' => 'E:\\Extra\\Laravel\\Laravel-Filament-Starter-Kit\\themes',
  ),
  'filament-tinyeditor' =>
  array (
    'version' =>
    array (
      'tiny' => '7.3.0',
      'language' =>
      array (
        'version' => '24.7.29',
        'package' => 'langs7',
      ),
      'licence_key' => 'no-api-key',
    ),
    'provider' => 'cloud',
    'darkMode' => 'auto',
    'skins' =>
    array (
      'ui' => 'oxide',
      'content' => 'default',
    ),
    'profiles' =>
    array (
      'default' =>
      array (
        'plugins' => 'accordion autoresize codesample directionality advlist link image lists preview pagebreak searchreplace wordcount code fullscreen insertdatetime media table emoticons',
        'toolbar' => 'undo redo removeformat | fontfamily fontsize fontsizeinput font_size_formats styles | bold italic underline | rtl ltr | alignjustify alignleft aligncenter alignright | numlist bullist outdent indent | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen',
        'upload_directory' => NULL,
      ),
      'simple' =>
      array (
        'plugins' => 'autoresize directionality emoticons link wordcount',
        'toolbar' => 'removeformat | bold italic | rtl ltr | numlist bullist | link emoticons',
        'upload_directory' => NULL,
      ),
      'minimal' =>
      array (
        'plugins' => 'link wordcount',
        'toolbar' => 'bold italic link numlist bullist',
        'upload_directory' => NULL,
      ),
      'full' =>
      array (
        'plugins' => 'accordion autoresize codesample directionality advlist autolink link image lists charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media table emoticons help',
        'toolbar' => 'undo redo removeformat | fontfamily fontsize fontsizeinput font_size_formats styles | bold italic underline | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist outdent indent accordion | forecolor backcolor | blockquote table toc hr | image link anchor media codesample emoticons | visualblocks print preview wordcount fullscreen help',
        'upload_directory' => NULL,
      ),
    ),
    'languages' =>
    array (
    ),
    'extra' =>
    array (
      'toolbar' =>
      array (
      ),
    ),
  ),
  'tinker' =>
  array (
    'commands' =>
    array (
    ),
    'alias' =>
    array (
    ),
    'dont_alias' =>
    array (
      0 => 'App\\Nova',
    ),
  ),
);
