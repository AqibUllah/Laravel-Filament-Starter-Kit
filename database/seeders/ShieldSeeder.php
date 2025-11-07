<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Widgets\Widget;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Dynamically discover all permissions from Filament panels
        $tenantPermissions = $this->discoverPermissions('tenant');

        // Define roles with their permissions using dynamic filtering
        $rolesWithPermissions = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'permissions' => $tenantPermissions // All permissions
            ],
            [
                'name' => 'team_admin',
                'guard_name' => 'web',
                'permissions' => $this->filterPermissions($tenantPermissions, [
                    'exclude' => ['View:ViewLog'] // Only super admin can view logs
                ])
            ],
            [
                'name' => 'team_manager',
                'guard_name' => 'web',
                'permissions' => $this->filterPermissions($tenantPermissions, [
                    'resources' => ['Project', 'Task', 'User', 'EmailTemplate', 'EmailTemplateTheme','Role'],
                    'resource_methods' => [
                        'Project' => ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'replicate'],
                        'Task' => ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'replicate'],
                        'User' => ['viewAny', 'view'],
                        'EmailTemplate' => ['viewAny', 'view'],
                        'EmailTemplateTheme' => ['viewAny', 'view'],
                        'Role' => ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'replicate'],
                    ],
                    'pages' => ['Dashboard', 'ProjectDashboard', 'TaskDashboard'],
                    'widgets' => ['MainOverviewStatsWidget', 'ProjectStatsWidget', 'TaskStatsWidget',
                        'ProjectProgressChartWidget', 'ProjectStatusChartWidget', 'TaskProgressChartWidget',
                        'TaskPriorityChartWidget', 'TeamPerformanceWidget', 'QuickSummaryWidget'],
                ])
            ],
            [
                'name' => 'team_member',
                'guard_name' => 'web',
                'permissions' => $this->filterPermissions($tenantPermissions, [
                    'resources' => ['Project', 'Task', 'User', 'EmailTemplate', 'EmailTemplateTheme'],
                    'resource_methods' => [
                        'Project' => ['viewAny', 'view'],
                        'Task' => ['viewAny', 'view', 'create', 'update'],
                        'User' => ['viewAny', 'view'],
                        'EmailTemplate' => ['viewAny', 'view'],
                        'EmailTemplateTheme' => ['viewAny', 'view'],
                    ],
                    'pages' => ['Dashboard', 'ProjectDashboard', 'TaskDashboard'],
                    'widgets' => ['MainOverviewStatsWidget', 'ProjectStatsWidget', 'TaskStatsWidget',
                        'ProjectProgressChartWidget', 'ProjectStatusChartWidget', 'TaskProgressChartWidget',
                        'TaskPriorityChartWidget', 'QuickSummaryWidget'],
                ])
            ]
        ];

        // Convert to JSON for the existing method
        $rolesWithPermissionsJson = json_encode($rolesWithPermissions);
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissionsJson);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed with Tenant Permissions.');
        $this->command->info('Created roles: super_admin, team_admin, team_manager, team_member');
        $this->command->info('Total permissions discovered: ' . count($tenantPermissions));
    }

    /**
     * Dynamically discover all permissions from a Filament panel
     */
    protected function discoverPermissions(string $panelId): array
    {
        $permissions = [];

        try {
            $panel = Filament::getPanel($panelId);

            if (!$panel) {
                $this->command->warn("Panel '{$panelId}' not found. Using static permissions.");
                return $this->getStaticPermissions();
            }

            // Discover Resources
            $resources = $this->discoverResources($panel);
            foreach ($resources as $resource) {
                $permissions = array_merge($permissions, $this->generateResourcePermissions($resource));
            }

            // Discover Pages
            $pages = $this->discoverPages($panel);
            foreach ($pages as $page) {
                $permissions = array_merge($permissions, $this->generatePagePermissions($page));
            }

            // Discover Widgets
            $widgets = $this->discoverWidgets($panel);
            foreach ($widgets as $widget) {
                $permissions = array_merge($permissions, $this->generateWidgetPermissions($widget));
            }

            // Add custom permissions from config
            $customPermissions = config('filament-shield.custom_permissions', []);
            foreach ($customPermissions as $customPermission) {
                $permissions[] = $this->formatPermissionName($customPermission);
            }

        } catch (\Exception $e) {
            $this->command->warn("Error discovering permissions: " . $e->getMessage());
            $this->command->warn("Falling back to static permissions.");
            return $this->getStaticPermissions();
        }

        return array_unique($permissions);
    }

    /**
     * Discover all resources from a panel using file system discovery
     */
    protected function discoverResources($panel): array
    {
        $resources = [];
        $excluded = config('filament-shield.resources.exclude', []);

        // Get resource paths from panel configuration
        // For tenant panel, resources are in app/Filament/Tenant/Resources
        $panelId = $panel->getId();
        $resourcePath = match($panelId) {
            'tenant' => app_path('Filament/Tenant/Resources'),
            'admin' => app_path('Filament/Admin/Resources'),
            default => app_path('Filament/' . ucfirst($panelId) . '/Resources'),
        };

        if (!is_dir($resourcePath)) {
            return $resources;
        }

        // Discover resources recursively
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($resourcePath)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $className = $this->getClassNameFromFile($file->getPathname());
                if ($className && is_subclass_of($className, Resource::class)) {
                    if (!in_array($className, $excluded)) {
                        $resources[] = $className;
                    }
                }
            }
        }

        return $resources;
    }

    /**
     * Discover all pages from a panel using file system discovery
     */
    protected function discoverPages($panel): array
    {
        $pages = [];
        $excluded = config('filament-shield.pages.exclude', []);

        // Get page paths from panel configuration
        $panelId = $panel->getId();
        $pagePath = match($panelId) {
            'tenant' => app_path('Filament/Tenant/Pages'),
            'admin' => app_path('Filament/Admin/Pages'),
            default => app_path('Filament/' . ucfirst($panelId) . '/Pages'),
        };

        if (!is_dir($pagePath)) {
            return $pages;
        }

        // Discover pages recursively
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($pagePath)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $className = $this->getClassNameFromFile($file->getPathname());
                if ($className && is_subclass_of($className, Page::class)) {
                    if (!in_array($className, $excluded)) {
                        $pages[] = $className;
                    }
                }
            }
        }

        return $pages;
    }

    /**
     * Discover all widgets from a panel using file system discovery
     */
    protected function discoverWidgets($panel): array
    {
        $widgets = [];
        $excluded = config('filament-shield.widgets.exclude', []);

        // Get widget paths from panel configuration
        $panelId = $panel->getId();
        $widgetPath = match($panelId) {
            'tenant' => app_path('Filament/Tenant/Widgets'),
            'admin' => app_path('Filament/Admin/Widgets'),
            default => app_path('Filament/' . ucfirst($panelId) . '/Widgets'),
        };

        if (!is_dir($widgetPath)) {
            return $widgets;
        }

        // Discover widgets recursively
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($widgetPath)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $className = $this->getClassNameFromFile($file->getPathname());
                if ($className && is_subclass_of($className, Widget::class)) {
                    if (!in_array($className, $excluded)) {
                        $widgets[] = $className;
                    }
                }
            }
        }

        // Also check for widgets in resource directories (like TimeTrackingWidget in Tasks)
        $resourcePath = match($panelId) {
            'tenant' => app_path('Filament/Tenant/Resources'),
            'admin' => app_path('Filament/Admin/Resources'),
            default => app_path('Filament/' . ucfirst($panelId) . '/Resources'),
        };

        if (is_dir($resourcePath)) {
            $resourceIterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($resourcePath)
            );

            foreach ($resourceIterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $path = $file->getPathname();
                    // Only check Widgets subdirectories
                    if (strpos($path, '/Widgets/') !== false) {
                        $className = $this->getClassNameFromFile($path);
                        if ($className && is_subclass_of($className, Widget::class)) {
                            if (!in_array($className, $excluded)) {
                                $widgets[] = $className;
                            }
                        }
                    }
                }
            }
        }

        return array_unique($widgets);
    }

    /**
     * Extract class name from PHP file
     */
    protected function getClassNameFromFile(string $filePath): ?string
    {
        $content = file_get_contents($filePath);

        // Extract namespace
        if (preg_match('/namespace\s+([^;]+);/', $content, $namespaceMatch)) {
            $namespace = $namespaceMatch[1];
        } else {
            return null;
        }

        // Extract class name
        if (preg_match('/class\s+(\w+)/', $content, $classMatch)) {
            $className = $namespace . '\\' . $classMatch[1];

            // Verify class exists and is loadable
            if (class_exists($className)) {
                return $className;
            }
        }

        return null;
    }

    /**
     * Generate permissions for a resource
     */
    protected function generateResourcePermissions(string $resourceClass): array
    {
        $permissions = [];

        try {
            // Get the model name from resource
            $model = $resourceClass::getModel();
            $modelName = class_basename($model);
        } catch (\Exception $e) {
            // Fallback: extract model name from resource class name
            // e.g., ProjectResource -> Project
            $modelName = str_replace('Resource', '', class_basename($resourceClass));
            $this->command->warn("Could not get model from {$resourceClass}, using {$modelName} as fallback");
        }

        // Get policy methods from config
        $policyMethods = config('filament-shield.policies.methods', [
            'viewAny', 'view', 'create', 'update', 'delete', 'restore',
            'forceDelete', 'forceDeleteAny', 'restoreAny', 'replicate', 'reorder',
        ]);

        // Check if resource has custom methods defined
        $resourceConfig = config('filament-shield.resources.manage', []);
        if (isset($resourceConfig[$resourceClass])) {
            $policyMethods = $resourceConfig[$resourceClass];
        }

        // Generate permission names
        foreach ($policyMethods as $method) {
            $permissions[] = $this->formatPermissionName($method . ':' . $modelName);
        }

        return $permissions;
    }

    /**
     * Generate permissions for a page
     */
    protected function generatePagePermissions(string $pageClass): array
    {
        $permissions = [];

        // Get page name
        $pageName = class_basename($pageClass);

        // Get prefix from config
        $prefix = config('filament-shield.pages.prefix', 'view');

        // Generate permission name
        $permissions[] = $this->formatPermissionName($prefix . ':' . $pageName);

        return $permissions;
    }

    /**
     * Generate permissions for a widget
     */
    protected function generateWidgetPermissions(string $widgetClass): array
    {
        $permissions = [];

        // Get widget name
        $widgetName = class_basename($widgetClass);

        // Get prefix from config
        $prefix = config('filament-shield.widgets.prefix', 'view');

        // Generate permission name
        $permissions[] = $this->formatPermissionName($prefix . ':' . $widgetName);

        return $permissions;
    }

    /**
     * Format permission name according to Shield's naming convention
     */
    protected function formatPermissionName(string $permission): string
    {
        $case = config('filament-shield.permissions.case', 'pascal');
        $separator = config('filament-shield.permissions.separator', ':');

        // Split by separator
        $parts = explode($separator, $permission);

        // Apply case formatting
        $formattedParts = array_map(function($part) use ($case) {
            return match($case) {
                'pascal' => Str::studly($part),
                'camel' => Str::camel($part),
                'snake' => Str::snake($part),
                'kebab' => Str::kebab($part),
                'upper_snake' => strtoupper(Str::snake($part)),
                'lower_snake' => strtolower(Str::snake($part)),
                default => $part,
            };
        }, $parts);

        return implode($separator, $formattedParts);
    }

    /**
     * Filter permissions based on role configuration
     */
    protected function filterPermissions(array $allPermissions, array $config): array
    {
        $filtered = [];

        foreach ($allPermissions as $permission) {
            $include = false;

            // Check exclude list
            if (isset($config['exclude']) && in_array($permission, $config['exclude'])) {
                continue;
            }

            // Check resource permissions
            if (isset($config['resources']) && isset($config['resource_methods'])) {
                foreach ($config['resources'] as $resource) {
                    foreach ($config['resource_methods'][$resource] ?? [] as $method) {
                        $expectedPermission = $this->formatPermissionName($method . ':' . $resource);
                        if ($permission === $expectedPermission) {
                            $include = true;
                            break 2;
                        }
                    }
                }
            }

            // Check page permissions
            if (isset($config['pages'])) {
                foreach ($config['pages'] as $page) {
                    $expectedPermission = $this->formatPermissionName('view:' . $page);
                    if ($permission === $expectedPermission) {
                        $include = true;
                        break;
                    }
                }
            }

            // Check widget permissions
            if (isset($config['widgets'])) {
                foreach ($config['widgets'] as $widget) {
                    $expectedPermission = $this->formatPermissionName('view:' . $widget);
                    if ($permission === $expectedPermission) {
                        $include = true;
                        break;
                    }
                }
            }

            if ($include) {
                $filtered[] = $permission;
            }
        }

        return $filtered;
    }

    /**
     * Fallback static permissions if discovery fails
     */
    protected function getStaticPermissions(): array
    {
        return [
            // Email Template Themes
            'ViewAny:EmailTemplateTheme', 'View:EmailTemplateTheme', 'Create:EmailTemplateTheme',
            'Update:EmailTemplateTheme', 'Delete:EmailTemplateTheme', 'Restore:EmailTemplateTheme',
            'ForceDelete:EmailTemplateTheme', 'ForceDeleteAny:EmailTemplateTheme', 'RestoreAny:EmailTemplateTheme',
            'Replicate:EmailTemplateTheme', 'Reorder:EmailTemplateTheme',

            // Email Templates
            'ViewAny:EmailTemplate', 'View:EmailTemplate', 'Create:EmailTemplate',
            'Update:EmailTemplate', 'Delete:EmailTemplate', 'Restore:EmailTemplate',
            'ForceDelete:EmailTemplate', 'ForceDeleteAny:EmailTemplate', 'RestoreAny:EmailTemplate',
            'Replicate:EmailTemplate', 'Reorder:EmailTemplate',

            // Projects
            'ViewAny:Project', 'View:Project', 'Create:Project', 'Update:Project',
            'Delete:Project', 'Restore:Project', 'ForceDelete:Project', 'ForceDeleteAny:Project',
            'RestoreAny:Project', 'Replicate:Project', 'Reorder:Project',

            // Tasks
            'ViewAny:Task', 'View:Task', 'Create:Task', 'Update:Task', 'Delete:Task',
            'Restore:Task', 'ForceDelete:Task', 'ForceDeleteAny:Task', 'RestoreAny:Task',
            'Replicate:Task', 'Reorder:Task',

            // Users
            'ViewAny:User', 'View:User', 'Create:User', 'Update:User', 'Delete:User',
            'Restore:User', 'ForceDelete:User', 'ForceDeleteAny:User', 'RestoreAny:User',
            'Replicate:User', 'Reorder:User',

            // Roles (Shield)
            'ViewAny:Role', 'View:Role', 'Create:Role', 'Update:Role', 'Delete:Role',
            'Restore:Role', 'ForceDelete:Role', 'ForceDeleteAny:Role', 'RestoreAny:Role',
            'Replicate:Role', 'Reorder:Role',

            // Dashboard Pages
            'View:Dashboard', 'View:ProjectDashboard', 'View:TaskDashboard',
            'View:PlansDashboard', 'View:ManageTenantSettings', 'View:Plans',
            'View:SubscriptionSuccess',

            // Widgets
            'View:MainOverviewStatsWidget', 'View:PlansStatsWidget', 'View:ProjectStatsWidget',
            'View:TaskStatsWidget', 'View:TimeTrackingWidget', 'View:ProjectProgressChartWidget',
            'View:RecentActivityWidget', 'View:SubscriptionChartWidget', 'View:TaskProgressChartWidget',
            'View:CouponStatsWidget', 'View:ProjectStatusChartWidget', 'View:TaskPriorityChartWidget',
            'View:TeamPerformanceWidget', 'View:QuickSummaryWidget',

            // Theme Management
            'View:ThemeManager', 'View:ThemesOverview',

            // Logs
            'View:ViewLog'
        ];
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
