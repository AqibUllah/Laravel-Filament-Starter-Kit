<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define comprehensive tenant permissions
        $tenantPermissions = [
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

        // Define roles with their permissions
        $rolesWithPermissions = [
            [
                'name' => 'super_admin',
                'guard_name' => 'web',
                'permissions' => $tenantPermissions // All permissions
            ],
            [
                'name' => 'team_admin',
                'guard_name' => 'web',
                'permissions' => array_merge(
                    // Full access to all resources
                    array_filter($tenantPermissions, function($permission) {
                        return !in_array($permission, [
                            'View:ViewLog' // Only super admin can view logs
                        ]);
                    })
                )
            ],
            [
                'name' => 'team_manager',
                'guard_name' => 'web',
                'permissions' => [
                    // Projects - full access
                    'ViewAny:Project', 'View:Project', 'Create:Project', 'Update:Project', 
                    'Delete:Project', 'Restore:Project', 'Replicate:Project',
                    
                    // Tasks - full access
                    'ViewAny:Task', 'View:Task', 'Create:Task', 'Update:Task', 'Delete:Task',
                    'Restore:Task', 'Replicate:Task',
                    
                    // Users - view only
                    'ViewAny:User', 'View:User',
                    
                    // Dashboard access
                    'View:Dashboard', 'View:ProjectDashboard', 'View:TaskDashboard',
                    
                    // Widgets - view stats
                    'View:MainOverviewStatsWidget', 'View:ProjectStatsWidget', 'View:TaskStatsWidget',
                    'View:ProjectProgressChartWidget', 'View:ProjectStatusChartWidget',
                    'View:TaskProgressChartWidget', 'View:TaskPriorityChartWidget',
                    'View:TeamPerformanceWidget', 'View:QuickSummaryWidget',
                    
                    // Email templates - view only
                    'ViewAny:EmailTemplate', 'View:EmailTemplate',
                    'ViewAny:EmailTemplateTheme', 'View:EmailTemplateTheme'
                ]
            ],
            [
                'name' => 'team_member',
                'guard_name' => 'web',
                'permissions' => [
                    // Projects - view only
                    'ViewAny:Project', 'View:Project',
                    
                    // Tasks - limited access
                    'ViewAny:Task', 'View:Task', 'Create:Task', 'Update:Task',
                    
                    // Users - view only
                    'ViewAny:User', 'View:User',
                    
                    // Dashboard access
                    'View:Dashboard', 'View:ProjectDashboard', 'View:TaskDashboard',
                    
                    // Widgets - view stats
                    'View:MainOverviewStatsWidget', 'View:ProjectStatsWidget', 'View:TaskStatsWidget',
                    'View:ProjectProgressChartWidget', 'View:ProjectStatusChartWidget',
                    'View:TaskProgressChartWidget', 'View:TaskPriorityChartWidget',
                    'View:QuickSummaryWidget',
                    
                    // Email templates - view only
                    'ViewAny:EmailTemplate', 'View:EmailTemplate',
                    'ViewAny:EmailTemplateTheme', 'View:EmailTemplateTheme'
                ]
            ]
        ];

        // Convert to JSON for the existing method
        $rolesWithPermissionsJson = json_encode($rolesWithPermissions);
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissionsJson);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed with Tenant Permissions.');
        $this->command->info('Created roles: super_admin, team_admin, team_manager, team_member');
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
