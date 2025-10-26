<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Facades\Cache;

class FeatureLimiterService
{
    protected $tenant;
    public function forTenant($tenant): self
    {
        $this->tenant = $tenant;
        return $this;
    }

    public function canCreateUser(): bool
    {
        $currentUsers = $this->tenant->members()->count();
        $maxUsers = $this->getFeatureLimit('Users');

        return $currentUsers < $maxUsers;
    }

    public function canCreateTask(): bool
    {
        $currentTasks = $this->tenant->tasks()->count();
        $maxTasks = $this->getFeatureLimit('Tasks');

        return $currentTasks < $maxTasks;
    }

    public function canCreateProject(): bool
    {
        $currentTasks = $this->tenant->projects()->count();
        $maxTasks = $this->getFeatureLimit('Projects');
        return $currentTasks < $maxTasks;
    }

    public function canUseStorage(int $additionalBytes = 0): bool
    {
        $currentStorage = $this->getCurrentStorageUsage();
        $maxStorage = $this->getFeatureLimit('max_storage') * 1024 * 1024; // Convert MB to bytes

        return ($currentStorage + $additionalBytes) <= $maxStorage;
    }

    public function getRemainingUsers(): int
    {
        $currentUsers = $this->tenant->members()->count();
        $maxUsers = $this->getFeatureLimit('max_users');

        return max(0, $maxUsers - $currentUsers);
    }

    public function getRemainingTasks(): int
    {
        $currentTasks = $this->tenant->tasks()->count();
        $maxTasks = $this->getFeatureLimit('max_tasks');

        return max(0, $maxTasks - $currentTasks);
    }

    public function getRemainingStorage(): int
    {
        $currentStorage = $this->getCurrentStorageUsage();
        $maxStorage = $this->getFeatureLimit('max_storage') * 1024 * 1024;

        return max(0, $maxStorage - $currentStorage);
    }

    public function getFeatureLimit(string $feature): int
    {
        return Cache::remember(
            "tenant_{$this->tenant->id}_feature_{$feature}",
            now()->addHours(1),
            fn() => $this->tenant->currentPlan->features->where('name', $feature)->first()?->value ?? 0
        );
    }

    protected function getCurrentStorageUsage(): int
    {
        // Implement your storage calculation logic
        return $this->tenant->files()->sum('size');
    }

    // Clear cache when features change
    public function clearCache(): void
    {
        $features = ['max_users', 'max_tasks', 'max_storage'];

        foreach ($features as $feature) {
            Cache::forget("tenant_{$this->tenant->id}_feature_{$feature}");
        }
    }
}
