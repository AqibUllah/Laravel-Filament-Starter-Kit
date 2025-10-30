<?php

namespace App\Settings\Repositories;

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
        }

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
        return filament()->getTenant() ?? null;
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

        // Try to get tenant-specific properties
        $tenantProps = $builder->where('group', $group)
        ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
        ->get(['name', 'payload']);

        // dd($tenantId,filament()->getTenant());

        // If none found, fallback to global (tenant_id = null)
        if ($tenantProps->isEmpty()) {
            $tenantProps = $builder->newQuery()
                ->where('group', $group)
                ->whereNull('tenant_id')
                ->get(['name', 'payload']);
        }

        return $tenantProps
            ->mapWithKeys(fn ($object) => [
                $object->name => $this->decode($object->payload, true)
            ])
            ->toArray();
    }
}
