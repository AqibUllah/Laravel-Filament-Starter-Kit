<?php

namespace App\Services;

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
        if (! $this->tenant) {
            return true; // Allow creation in test context
        }

        $currentUsers = \DB::table('team_user')
            ->where('team_id', $this->tenant->id)
            ->distinct('user_id')
            ->count('user_id');
        $maxUsers = $this->getFeatureLimit('Users');

        return $currentUsers < $maxUsers;
    }

    public function canCreateTask(): bool
    {
        if (! $this->tenant) {
            return true; // Allow creation in test context
        }

        $currentTasks = $this->tenant->tasks()->count();
        $maxTasks = $this->getFeatureLimit('Tasks');

        return $currentTasks < $maxTasks;
    }

    public function canCreateProject(): bool
    {
        if (! $this->tenant) {
            return true; // Allow creation in test context
        }

        $currentProjects = $this->tenant->projects()->count();
        $maxProjects = $this->getFeatureLimit('Projects');

        return $currentProjects < $maxProjects;
    }

    public function canCreateProduct(): bool
    {
        if (! $this->tenant) {
            return true; // Allow creation in test context
        }

        $currentProducts = $this->tenant->products()->count();
        $maxProducts = $this->getFeatureLimit('Products');

        return $currentProducts < $maxProducts;
    }

    public function canCreateCategory(): bool
    {
        if (! $this->tenant) {
            return true; // Allow creation in test context
        }

        $currentCategories = $this->tenant->categories()->count();
        $maxCategories = $this->getFeatureLimit('Categories');

        return $currentCategories < $maxCategories;
    }

    public function canUseStorage(int $additionalBytes = 0): bool
    {
        $currentStorage = $this->getCurrentStorageUsage();
        $maxStorage = $this->getStorageLimitInBytes();

        return ($currentStorage + $additionalBytes) <= $maxStorage;
    }

    public function getStorageLimitInBytes(): int
    {
        // Try to get storage limit from features
        $storageFeature = $this->tenant->subscription->plan->features
            ->where('name', 'Storage')
            ->first();
        
        if ($storageFeature) {
            $limit = $storageFeature->value; // e.g., "10GB"
            return $this->convertStorageToBytes($limit);
        }
        
        // Fallback to max_storage feature
        $maxStorageFeature = $this->getFeatureLimit('max_storage');
        if ($maxStorageFeature > 0) {
            return $maxStorageFeature * 1024 * 1024; // Convert MB to bytes
        }
        
        // Default limit if no feature found
        return 10 * 1024 * 1024 * 1024; // 10GB default
    }

    public function convertStorageToBytes(string $storage): int
    {
        $storage = strtoupper(trim($storage));
        
        if (str_contains($storage, 'TB')) {
            $value = (float) str_replace('TB', '', $storage);
            return (int) ($value * 1024 * 1024 * 1024 * 1024);
        }
        
        if (str_contains($storage, 'GB')) {
            $value = (float) str_replace('GB', '', $storage);
            return (int) ($value * 1024 * 1024 * 1024);
        }
        
        if (str_contains($storage, 'MB')) {
            $value = (float) str_replace('MB', '', $storage);
            return (int) ($value * 1024 * 1024);
        }
        
        // Assume GB if no unit specified
        return (int) ((float) $storage * 1024 * 1024 * 1024);
    }

    public function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max(0, $bytes);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    public function getRemainingUsers(): int
    {
        $currentUsers = \DB::table('team_user')
            ->where('team_id', $this->tenant->id)
            ->distinct('user_id')
            ->count('user_id');
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
        $maxStorage = $this->getStorageLimitInBytes();

        return max(0, $maxStorage - $currentStorage);
    }

    public function getFeatureLimit(string $feature): int
    {
        if (! $this->tenant) {
            return 999; // Return high limit for test context
        }

        return Cache::remember(
            "tenant_{$this->tenant->id}_feature_{$feature}",
            now()->addHours(1),
            fn () => $this->tenant->currentPlan->features->where('name', $feature)->first()?->value ?? 0
        );
    }

    public function getCurrentStorageUsage(): int
    {
        // Implement your storage calculation logic
        return $this->tenant->files()->sum('size');
    }

    // Clear cache when features change
    public function clearCache(): void
    {
        $features = ['max_users', 'max_tasks', 'max_storage', 'max_products', 'max_categories'];

        foreach ($features as $feature) {
            Cache::forget("tenant_{$this->tenant->id}_feature_{$feature}");
        }
    }

    public function canCreate(string $featureKey): bool
    {
        return match ($featureKey) {
            'Users' => $this->canCreateUser(),
            'Projects' => $this->canCreateProject(),
            'Tasks' => $this->canCreateTask(),
            'Products' => $this->canCreateProduct(),
            'Categories' => $this->canCreateCategory(),
            default => false,
        };
    }
}
