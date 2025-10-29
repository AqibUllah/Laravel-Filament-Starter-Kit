<?php

namespace App\Filament\Tenant\Pages;

use App\Settings\TenantGeneralSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Artisan;
use UnitEnum;

class ManageTenantSettings extends Page
{
    use HasPageShield;

    protected string $view = 'filament.tenant.pages.manage-tenant-settings';
    protected static string $settings = TenantGeneralSettings::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

     protected static string | UnitEnum | null $navigationGroup = 'System';

     protected static ?int $navigationSort = 8;

     protected static ?string $title = 'System Settings';

     protected ?string $subheading = 'Manage your application configuration and preferences';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Edit & Save Settings')
                ->modalHeading('Tenant Settings')
                ->form([
                    Section::make('Branding')
                        ->schema([
                            TextInput::make('company_name')
                                ->label('Company Name')
                                ->required()
                                ->maxLength(120),
                            FileUpload::make('company_logo_path')
                                ->label('Company Logo')
                                ->image()
                                ->disk($settings->storage_upload_disk ?? 'public')
                                ->acceptedFileTypes(['image/jpg','image/png','image/jpeg'])
                                ->directory('tenant-logos')
                                ->visibility('public')
                                ->imageEditor(),
                            ColorPicker::make('primary_color')
                                ->label('Primary Color')
                                ->nullable(),
                        ]),

                    Section::make('Localization')
                        ->schema([
                            Select::make('locale')
                                ->label('Language')
                                ->options([
                                    'en' => 'English',
                                    'fr' => 'French',
                                    'es' => 'Spanish',
                                    'de' => 'German',
                                ])
                                ->nullable(),
                            Select::make('timezone')
                                ->label('Timezone')
                                ->options([
                                    'UTC' => 'UTC',
                                    'America/New_York' => 'Eastern Time',
                                    'America/Chicago' => 'Central Time',
                                    'America/Denver' => 'Mountain Time',
                                    'America/Los_Angeles' => 'Pacific Time',
                                    'Europe/London' => 'London',
                                    'Europe/Paris' => 'Paris',
                                ])
                                ->nullable(),
                            Select::make('date_format')
                                ->label('Date Format')
                                ->options([
                                    'Y-m-d' => 'YYYY-MM-DD',
                                    'm/d/Y' => 'MM/DD/YYYY',
                                    'd/m/Y' => 'DD/MM/YYYY',
                                ])
                                ->nullable(),
                            Select::make('time_format')
                                ->label('Time Format')
                                ->options([
                                    'H:i' => '24 Hour (HH:MM)',
                                    'g:i A' => '12 Hour (H:MM AM/PM)',
                                ])
                                ->nullable(),
                        ]),

                    Section::make('Security')
                        ->schema([
                            Toggle::make('require_2fa')
                                ->label('Require Two-Factor Authentication'),
                            Select::make('password_policy')
                                ->label('Password Policy')
                                ->options([
                                    'weak' => 'Weak (6+ characters)',
                                    'medium' => 'Medium (8+ characters, mixed case)',
                                    'strong' => 'Strong (12+ characters, mixed case, numbers, symbols)',
                                ])
                                ->nullable(),
                        ]),

                    Section::make('Project Defaults')
                        ->schema([
                            Select::make('project_default_priority')
                                ->label('Default Priority')
                                ->options([
                                    'low' => 'Low',
                                    'medium' => 'Medium',
                                    'high' => 'High',
                                    'urgent' => 'Urgent',
                                ])
                                ->nullable(),
                            Select::make('project_default_status')
                                ->label('Default Status')
                                ->options([
                                    'active' => 'Active',
                                    'on_hold' => 'On Hold',
                                    'completed' => 'Completed',
                                    'archived' => 'Archived',
                                ])
                                ->nullable(),
                        ]),

                    Section::make('Task Defaults')
                        ->schema([
                            Select::make('task_default_priority')
                                ->label('Default Priority')
                                ->options([
                                    'low' => 'Low',
                                    'medium' => 'Medium',
                                    'high' => 'High',
                                    'urgent' => 'Urgent',
                                ])
                                ->nullable(),
                            Select::make('task_default_status')
                                ->label('Default Status')
                                ->options([
                                    'open' => 'Open',
                                    'in_progress' => 'In Progress',
                                    'review' => 'Review',
                                    'done' => 'Done',
                                ])
                                ->nullable(),
                        ]),

                    Section::make('Notifications')
                        ->schema([
                            Toggle::make('email_notifications_enabled')
                                ->label('Enable Email Notifications'),
                            Toggle::make('notify_on_project_changes')
                                ->label('Notify on Project Changes'),
                            Toggle::make('notify_on_task_assign')
                                ->label('Notify on Task Assignment'),
                        ]),

                    Section::make('Storage & Files')
                        ->schema([
                            Select::make('storage_upload_disk')
                                ->label('Upload Storage')
                                ->options([
                                    'public' => 'Local Public',
                                    's3' => 'Amazon S3',
                                ])
                                ->nullable(),
                            TextInput::make('storage_max_file_mb')
                                ->label('Max File Size (MB)')
                                ->numeric()
                                ->nullable(),
                            TagsInput::make('allowed_file_types')
                                ->label('Allowed File Types')
                                ->placeholder('pdf, jpg, png, docx')
                                ->nullable(),
                        ]),

                    Section::make('User Experience')
                        ->schema([
                            Toggle::make('sidebar_collapsed_default')
                                ->label('Collapse Sidebar by Default'),
                        ]),
                ])
                ->mountUsing(function (Schema $schema) {
                    $settings = app(TenantGeneralSettings::class);


                    // Ensure we read the latest persisted values
                    if (method_exists($settings, 'refresh')) {
                        $settings->refresh();
                    }

                    $schema->fill([
                        // Branding
                        'company_name' => $settings->company_name ?? '',
                        'company_logo_path' => $settings->company_logo_path ?? null,
                        'primary_color' => $settings->primary_color ?? null,

                        // Localization
                        'locale' => $settings->locale ?? null,
                        'timezone' => $settings->timezone ?? null,
                        'date_format' => $settings->date_format ?? null,
                        'time_format' => $settings->time_format ?? null,

                        // Security
                        'require_2fa' => $settings->require_2fa ?? false,
                        'password_policy' => $settings->password_policy ?? null,

                        // Projects
                        'project_default_priority' => $settings->project_default_priority ?? null,
                        'project_default_status' => $settings->project_default_status ?? null,

                        // Tasks
                        'task_default_priority' => $settings->task_default_priority ?? null,
                        'task_default_status' => $settings->task_default_status ?? null,

                        // Notifications
                        'email_notifications_enabled' => $settings->email_notifications_enabled ?? false,
                        'notify_on_project_changes' => $settings->notify_on_project_changes ?? false,
                        'notify_on_task_assign' => $settings->notify_on_task_assign ?? false,

                        // Storage
                        'storage_upload_disk' => $settings->storage_upload_disk ?? null,
                        'storage_max_file_mb' => $settings->storage_max_file_mb ?? null,
                        'allowed_file_types' => $settings->allowed_file_types ?? null,

                        // UX
                        'sidebar_collapsed_default' => $settings->sidebar_collapsed_default ?? false,
                    ]);

//                    dd($action);
                })
                ->action(function (array $data) {
                    // Debug tenant context
                    \Illuminate\Support\Facades\Log::info('ManageTenantSettings: Saving settings', [
                        'filament_tenant' => filament()->getTenant()?->id,
                        'auth_user' => auth()->id(),
                        'data_keys' => array_keys($data)
                    ]);

                    $settings = app(TenantGeneralSettings::class);

                    // Branding
                    $settings->company_name = $data['company_name'] ?? '';
                    $settings->company_logo_path = $data['company_logo_path'] ?? null;
                    $settings->primary_color = $data['primary_color'] ?? null;

                    // Localization
                    $settings->locale = $data['locale'] ?? null;
                    $settings->timezone = $data['timezone'] ?? null;
                    $settings->date_format = $data['date_format'] ?? null;
                    $settings->time_format = $data['time_format'] ?? null;

                    // Security
                    $settings->require_2fa = $data['require_2fa'] ?? false;
                    $settings->password_policy = $data['password_policy'] ?? null;

                    // Projects
                    $settings->project_default_priority = $data['project_default_priority'] ?? null;
                    $settings->project_default_status = $data['project_default_status'] ?? null;

                    // Tasks
                    $settings->task_default_priority = $data['task_default_priority'] ?? null;
                    $settings->task_default_status = $data['task_default_status'] ?? null;

                    // Notifications
                    $settings->email_notifications_enabled = $data['email_notifications_enabled'] ?? false;
                    $settings->notify_on_project_changes = $data['notify_on_project_changes'] ?? false;
                    $settings->notify_on_task_assign = $data['notify_on_task_assign'] ?? false;

                    // Storage
                    $settings->storage_upload_disk = $data['storage_upload_disk'] ?? null;
                    $settings->storage_max_file_mb = $data['storage_max_file_mb'] ?? null;
                    $settings->allowed_file_types = $data['allowed_file_types'] ?? null;

                    // UX
                    $settings->sidebar_collapsed_default = $data['sidebar_collapsed_default'] ?? false;

                    $settings->tenant_id = filament()->getTenant()->id;

                    $settings->save();

                    Notification::make()
                        ->title('Settings saved')
                        ->success()
                        ->send();
                })
                ->successRedirectUrl(ManageTenantSettings::getUrl()),
        ];
    }
}


