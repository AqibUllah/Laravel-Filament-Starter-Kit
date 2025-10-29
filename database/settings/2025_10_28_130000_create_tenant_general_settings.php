<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('tenant_general.company_name', '');
        $this->migrator->add('tenant_general.company_logo_path', null);
        $this->migrator->add('tenant_general.primary_color', null);

        $this->migrator->add('tenant_general.locale', null);
        $this->migrator->add('tenant_general.timezone', null);
        $this->migrator->add('tenant_general.date_format', null);
        $this->migrator->add('tenant_general.time_format', null);
        $this->migrator->add('tenant_general.require_2fa', null);
        $this->migrator->add('tenant_general.password_policy', null);
        $this->migrator->add('tenant_general.project_default_priority', null);
        $this->migrator->add('tenant_general.project_default_status', null);
        $this->migrator->add('tenant_general.task_default_priority', null);
        $this->migrator->add('tenant_general.task_default_status', null);
        $this->migrator->add('tenant_general.email_notifications_enabled', null);
        $this->migrator->add('tenant_general.notify_on_project_changes', null);
        $this->migrator->add('tenant_general.notify_on_task_assign', null);
        $this->migrator->add('tenant_general.storage_upload_disk', null);
        $this->migrator->add('tenant_general.storage_max_file_mb', null);
        $this->migrator->add('tenant_general.allowed_file_types', null);
        $this->migrator->add('tenant_general.sidebar_collapsed_default', null);
    }
};


