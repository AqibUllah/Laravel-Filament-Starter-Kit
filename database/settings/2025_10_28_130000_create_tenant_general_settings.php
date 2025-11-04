<?php

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Enums\TaskStatusEnum;
use Spatie\LaravelSettings\Migrations\SettingsMigration;
use Illuminate\Support\Facades\DB;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Get the default tenant_id (first team or 1)
        $defaultTenantId = DB::table('teams')->orderBy('id')->value('id') ?? 1;

        // Create settings with tenant_id = 1 (or first team) for default/initial setup
        // We need to insert directly with tenant_id since migrator->add() doesn't support extra columns
        $settings = [
            ['group' => 'tenant_general', 'name' => 'company_name', 'payload' => json_encode('ABC Company'), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'company_logo_path', 'payload' => json_encode(''), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'primary_color', 'payload' => json_encode(''), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'locale', 'payload' => json_encode('en'), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'timezone', 'payload' => json_encode(''), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'date_format', 'payload' => json_encode('d-m-y'), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'time_format', 'payload' => json_encode('H:i'), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'require_2fa', 'payload' => json_encode(false), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'password_policy', 'payload' => json_encode(''), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'project_default_priority', 'payload' => json_encode(PriorityEnum::Medium), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'project_default_status', 'payload' => json_encode(ProjectStatusEnum::OnHold), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'task_default_priority', 'payload' => json_encode(PriorityEnum::Medium), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'task_default_status', 'payload' => json_encode(TaskStatusEnum::Pending), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'email_notifications_enabled', 'payload' => json_encode(false), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'notify_on_project_changes', 'payload' => json_encode(false), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'notify_on_task_assign', 'payload' => json_encode(false), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'storage_upload_disk', 'payload' => json_encode(''), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'storage_max_file_mb', 'payload' => json_encode(1024), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'allowed_file_types', 'payload' => json_encode([]), 'tenant_id' => $defaultTenantId],
            ['group' => 'tenant_general', 'name' => 'sidebar_collapsed_default', 'payload' => json_encode(false), 'tenant_id' => $defaultTenantId],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                [
                    'group' => $setting['group'],
                    'name' => $setting['name'],
                    'tenant_id' => $setting['tenant_id'],
                ],
                [
                    'payload' => $setting['payload'],
                    'locked' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
};


