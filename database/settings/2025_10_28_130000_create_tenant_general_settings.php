<?php

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Enums\TaskStatusEnum;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('tenant_general.company_name', 'ABC Company');
        $this->migrator->add('tenant_general.company_logo_path', '');
        $this->migrator->add('tenant_general.primary_color', '');

        $this->migrator->add('tenant_general.locale', value: 'en');
        $this->migrator->add('tenant_general.timezone', '');
        $this->migrator->add('tenant_general.date_format', 'd-m-y');
        $this->migrator->add('tenant_general.time_format', 'H:i');
        $this->migrator->add('tenant_general.require_2fa', false);
        $this->migrator->add('tenant_general.password_policy', '');
        $this->migrator->add('tenant_general.project_default_priority', PriorityEnum::Medium);
        $this->migrator->add('tenant_general.project_default_status', ProjectStatusEnum::OnHold);
        $this->migrator->add('tenant_general.task_default_priority', PriorityEnum::Medium);
        $this->migrator->add('tenant_general.task_default_status', TaskStatusEnum::Pending);
        $this->migrator->add('tenant_general.email_notifications_enabled', false);
        $this->migrator->add('tenant_general.notify_on_project_changes', false);
        $this->migrator->add('tenant_general.notify_on_task_assign', false);
        $this->migrator->add('tenant_general.storage_upload_disk', '');
        $this->migrator->add('tenant_general.storage_max_file_mb', '');
        $this->migrator->add('tenant_general.allowed_file_types', []);
        $this->migrator->add('tenant_general.sidebar_collapsed_default', false);
    }
};


