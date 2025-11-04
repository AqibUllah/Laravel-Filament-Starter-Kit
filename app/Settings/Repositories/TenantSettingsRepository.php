<?php

namespace App\Settings\Repositories;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Enums\TaskStatusEnum;
use Filament\Facades\Filament;
use Spatie\LaravelSettings\SettingsRepositories\DatabaseSettingsRepository;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelSettings\SettingsRepositories\SettingsRepository;

class TenantSettingsRepository extends DatabaseSettingsRepository
{

    public function getBuilder(): Builder
    {
        $builder = parent::getBuilder();

        // Automatically scope queries by tenant
        $tenantId = $this->currentTenantId();

        if ($tenantId) {
            $builder->where('tenant_id', $tenantId);
            return $builder;
        }

        // During initial boot when no tenant context, fallback to tenant_id = 1
        // This allows the panel provider to load default settings
        $builder->where(function ($query) {
            $query->whereNull('tenant_id')
                  ->orWhere('tenant_id', 1);
        });

        return $builder;
    }

    public function createProperty(string $group, string $name, $payload): void
    {
        $tenantId = $this->currentTenantId();

        $this->getBuilder()->create([
            'group' => $group,
            'name' => $name,
            'payload' => $this->encode($payload),
            'locked' => false,
            'tenant_id' => $tenantId,
        ]);
    }

    protected function currentTenantId(): ?int
    {
        // return app()->bound('currentTenantId')
        // ? app('currentTenantId')
        // : null;
        // return filament()->getTenant() ?? null;

        // 1. Filament context first
    if (function_exists('filament') && filament()->getTenant()) {
        return method_exists(filament()->getTenant(), 'getKey')
            ? filament()->getTenant()->getKey()
            : filament()->getTenant();
    }

    // 2. Auth context fallback
    if (auth()->check() && isset(auth()->user()->team)) {
        return auth()->user()->team->id;
    }

    // 3. Fallback: Get ID from URL segment (assuming structure: /tenant/{id}/...)
    $request = request();
    if ($request->route('tenant')) {
        return is_object($request->route('tenant'))
            ? $request->route('tenant')->getKey()
            : $request->route('tenant');
    }

    // 4. Optionally, fallback to URL segment manually
    $segments = $request->segments();
    $tenantIndex = array_search('tenant', $segments);
    if ($tenantIndex !== false && isset($segments[$tenantIndex + 1])) {
        return (int) $segments[$tenantIndex + 1];
    }

    return null;
    }

    public function updatePropertiesPayload(string $group, array $properties): void
    {
        $tenantId = $this->currentTenantId();

        $propertiesInBatch = collect($properties)
            ->map(function ($payload, $name) use ($group, $tenantId) {
                return [
                    'group' => $group,
                    'name' => $name,
                    'payload' => $this->encode($payload),
                    'tenant_id' => $tenantId,
                ];
            })
            ->values()
            ->toArray();


        $this->getBuilder()
            ->where('group', $group)
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->upsert($propertiesInBatch, ['group', 'name', 'tenant_id'], ['payload']);
    }

    public function getPropertiesInGroup(string $group): array
    {
        $tenantId = $this->currentTenantId();
        $builder = parent::getBuilder();

        // Try to get tenant-specific properties first
        if ($tenantId) {
            $tenantProps = $builder->where('group', $group)
                ->where('tenant_id', $tenantId)
                ->get(['name', 'payload']);

            if ($tenantProps->isNotEmpty()) {
                return $tenantProps
                    ->mapWithKeys(fn ($object) => [
                        $object->name => $this->decode($object->payload, true)
                    ])
                    ->toArray();
            }

            // If no tenant-specific settings exist, auto-initialize them
            // This ensures every tenant has settings when they visit the settings page
            $this->initializeDefaultSettingsForTenant($group, $tenantId);

            // Try to get the newly created settings using a fresh query
            // (without tenant scoping to ensure we can find them)
            $tenantProps = parent::getBuilder()
                ->where('group', $group)
                ->where('tenant_id', $tenantId)
                ->get(['name', 'payload']);

            if ($tenantProps->isNotEmpty()) {
                return $tenantProps
                    ->mapWithKeys(fn ($object) => [
                        $object->name => $this->decode($object->payload, true)
                    ])
                    ->toArray();
            }
        }

        // If no tenant-specific settings found, fallback to tenant_id = 1 (default)
        $defaultProps = $builder->newQuery()
            ->where('group', $group)
            ->where('tenant_id', 1)
            ->get(['name', 'payload']);

        // If still none found, try tenant_id = null (global fallback)
        if ($defaultProps->isEmpty()) {
            $defaultProps = $builder->newQuery()
                ->where('group', $group)
                ->whereNull('tenant_id')
                ->get(['name', 'payload']);
        }

        return $defaultProps
            ->mapWithKeys(fn ($object) => [
                $object->name => $this->decode($object->payload, true)
            ])
            ->toArray();
    }

    /**
     * Initialize default settings for a tenant if they don't exist
     */
    protected function initializeDefaultSettingsForTenant(string $group, int $tenantId): void
    {
        // Only initialize for tenant_general group
        if ($group !== 'tenant_general') {
            return;
        }

        // Get default settings from tenant_id = 1 (or first available)
        $defaultSettings = parent::getBuilder()
            ->where('group', $group)
            ->where('tenant_id', 1)
            ->get(['name', 'payload']);

        // If no default settings exist, create them from scratch
        if ($defaultSettings->isEmpty()) {
            $defaultSettings = parent::getBuilder()
                ->where('group', $group)
                ->whereNull('tenant_id')
                ->get(['name', 'payload']);
        }

        // If we have default settings, copy them for the current tenant
        if ($defaultSettings->isNotEmpty()) {
            // Use a fresh query builder without tenant scoping to insert settings
            $freshBuilder = parent::getBuilder();
            foreach ($defaultSettings as $defaultSetting) {
                $freshBuilder->updateOrInsert(
                    [
                        'group' => $group,
                        'name' => $defaultSetting->name,
                        'tenant_id' => $tenantId,
                    ],
                    [
                        'payload' => $defaultSetting->payload,
                        'locked' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        } else {
            // If no defaults exist at all, create default settings from scratch
            $this->createDefaultSettingsFromScratch($group, $tenantId);
        }
    }

    /**
     * Create default settings from scratch when no defaults exist
     */
    protected function createDefaultSettingsFromScratch(string $group, int $tenantId): void
    {
        if ($group !== 'tenant_general') {
            return;
        }

        // Use enum instances to ensure correct values
        $defaultSettings = [
            ['name' => 'company_name', 'payload' => json_encode('ABC Company')],
            ['name' => 'company_logo_path', 'payload' => json_encode('')],
            ['name' => 'primary_color', 'payload' => json_encode('')],
            ['name' => 'locale', 'payload' => json_encode('en')],
            ['name' => 'timezone', 'payload' => json_encode('')],
            ['name' => 'date_format', 'payload' => json_encode('d-m-y')],
            ['name' => 'time_format', 'payload' => json_encode('H:i')],
            ['name' => 'require_2fa', 'payload' => json_encode(false)],
            ['name' => 'password_policy', 'payload' => json_encode('')],
            ['name' => 'project_default_priority', 'payload' => json_encode(PriorityEnum::Medium->value)],
            ['name' => 'project_default_status', 'payload' => json_encode(ProjectStatusEnum::OnHold->value)],
            ['name' => 'task_default_priority', 'payload' => json_encode(PriorityEnum::Medium->value)],
            ['name' => 'task_default_status', 'payload' => json_encode(TaskStatusEnum::Pending->value)],
            ['name' => 'email_notifications_enabled', 'payload' => json_encode(false)],
            ['name' => 'notify_on_project_changes', 'payload' => json_encode(false)],
            ['name' => 'notify_on_task_assign', 'payload' => json_encode(false)],
            ['name' => 'storage_upload_disk', 'payload' => json_encode('')],
            ['name' => 'storage_max_file_mb', 'payload' => json_encode(1024)],
            ['name' => 'allowed_file_types', 'payload' => json_encode([])],
            ['name' => 'sidebar_collapsed_default', 'payload' => json_encode(false)],
        ];

        // Use a fresh query builder without tenant scoping to insert settings
        $freshBuilder = parent::getBuilder();
        foreach ($defaultSettings as $setting) {
            $freshBuilder->updateOrInsert(
                [
                    'group' => $group,
                    'name' => $setting['name'],
                    'tenant_id' => $tenantId,
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
}
