<?php
namespace App\Filament\Tenant\Pages\Tenancy;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Team;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Role;

class RegisterTeam extends RegisterTenant
{
//    protected static string $view = 'filament.company.pages.register-team';
protected string $view = 'components.team.pages.register-team';

protected static string $layout = 'components.team.layout.custom-simple';
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('slug')->required(),
                TextInput::make('description'),
                TextInput::make('domain')->url(),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $data['owner_id'] = auth()->id();

        $team = Team::create($data);
        $team->members()->attach(auth()->user());
        $team_name = $team->name;

        $team_admin_role = Role::firstOrCreate([
           'name'   => 'team_admin',
           'team_id' => $team->id,
           'guard_name' => 'web'
        ]);

        setPermissionsTeamId($team->id);

        $team_admin_role->syncPermissions(Utils::getPermissionModel()::pluck('id'));

        auth()->user()->assignRole($team_admin_role->name);

        // Initialize default settings for the new team
        $this->initializeTeamSettings($team->id, $team->name);

        Notification::make()
            ->title('company created')
            ->success()
            ->icon('heroicon-o-document-text')
            ->body(Str::inlineMarkdown(__('New company created successfully', compact('team_name'))))
            ->send();

        return $team;
    }

    /**
     * Initialize default settings for a new team
     */
    protected function initializeTeamSettings(int $tenantId, string $teamName = 'ABC Company'): void
    {
        $settings = [
            ['group' => 'tenant_general', 'name' => 'company_name', 'payload' => json_encode($teamName), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'company_logo_path', 'payload' => json_encode(''), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'primary_color', 'payload' => json_encode(''), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'locale', 'payload' => json_encode('en'), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'timezone', 'payload' => json_encode(''), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'date_format', 'payload' => json_encode('d-m-y'), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'time_format', 'payload' => json_encode('H:i'), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'require_2fa', 'payload' => json_encode(false), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'password_policy', 'payload' => json_encode(''), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'project_default_priority', 'payload' => json_encode(PriorityEnum::Medium), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'project_default_status', 'payload' => json_encode(ProjectStatusEnum::OnHold), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'task_default_priority', 'payload' => json_encode(PriorityEnum::Medium), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'task_default_status', 'payload' => json_encode(TaskStatusEnum::Pending), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'email_notifications_enabled', 'payload' => json_encode(false), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'notify_on_project_changes', 'payload' => json_encode(false), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'notify_on_task_assign', 'payload' => json_encode(false), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'storage_upload_disk', 'payload' => json_encode(''), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'storage_max_file_mb', 'payload' => json_encode(1024), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'allowed_file_types', 'payload' => json_encode([]), 'tenant_id' => $tenantId],
            ['group' => 'tenant_general', 'name' => 'sidebar_collapsed_default', 'payload' => json_encode(false), 'tenant_id' => $tenantId],
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
}
