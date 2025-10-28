<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TenantGeneralSettings extends Settings
{
    // Branding
    public string $company_name;
    public ?string $company_logo_path;
    public ?string $primary_color;

    // Localization
    public ?string $locale;
    public ?string $timezone;
    public ?string $date_format;
    public ?string $time_format;

    // Security
    public ?bool $require_2fa;
    public ?string $password_policy;

    // Projects
    public ?string $project_default_priority;
    public ?string $project_default_status;

    // Tasks
    public ?string $task_default_priority;
    public ?string $task_default_status;

    // Notifications
    public ?bool $email_notifications_enabled;
    public ?bool $notify_on_project_changes;
    public ?bool $notify_on_task_assign;

    // Storage
    public ?string $storage_upload_disk;
    public ?int $storage_max_file_mb;
    public ?array $allowed_file_types;

    // UX
    public ?bool $sidebar_collapsed_default;

    public static function group(): string
    {
        return 'tenant_general';
    }
}


