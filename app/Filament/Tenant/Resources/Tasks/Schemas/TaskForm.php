<?php

namespace App\Filament\Tenant\Resources\Tasks\Schemas;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Settings\TenantGeneralSettings;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Schema as TableSchema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {

        //        $currentTeam = \Auth::user()->currentTeam;

        $currentTeam = Filament::getTenant();
        $settings = null;
        if (TableSchema::hasTable('settings')) {
            try {
                $settings = app(TenantGeneralSettings::class);
                // Verify that all required properties are set
                if (! isset($settings->company_name)) {
                    throw new \Exception('Settings properties missing');
                }
            } catch (\Throwable $e) {
                // The settings table might not be ready or filled, or properties are missing
                // Fallback to default values
                $settings = (object) [
                    'company_name' => 'Team',
                    'company_logo_path' => null,
                    'primary_color' => null,
                    'locale' => 'en',
                    'timezone' => null,
                    'date_format' => null,
                    'time_format' => null,
                    'require_2fa' => false,
                    'google_login' => true,
                    'github_login' => true,
                    'password_policy' => null,
                    'project_default_priority' => null,
                    'project_default_status' => null,
                    'task_default_priority' => null,
                    'task_default_status' => null,
                    'email_notifications_enabled' => false,
                    'notify_on_project_changes' => false,
                    'notify_on_task_assign' => false,
                    'storage_upload_disk' => null,
                    'storage_max_file_mb' => null,
                    'allowed_file_types' => [],
                    'sidebar_collapsed_default' => false,
                ];
            }
        } else {
            // Table does not exist: fallback to default values for first-time setup
            $settings = (object) [
                'company_name' => 'Team',
                'company_logo_path' => null,
                'primary_color' => null,
                'locale' => 'en',
                'timezone' => null,
                'date_format' => null,
                'time_format' => null,
                'require_2fa' => false,
                'google_login' => true,
                'github_login' => true,
                'password_policy' => null,
                'project_default_priority' => null,
                'project_default_status' => null,
                'task_default_priority' => null,
                'task_default_status' => null,
                'email_notifications_enabled' => false,
                'notify_on_project_changes' => false,
                'notify_on_task_assign' => false,
                'storage_upload_disk' => null,
                'storage_max_file_mb' => null,
                'allowed_file_types' => [],
                'sidebar_collapsed_default' => false,
            ];
        }

        return $schema
            ->components([
                Section::make('Task Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('project')
                            ->label('Project')
                            ->relationship('Project', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('Select a project'),
                        Select::make('assigned_to')
                            ->label('Assign To')
                            ->options($currentTeam->members()->pluck('name', 'user_id'))
                            ->searchable()
                            ->required(),
                        DatePicker::make('due_date')
                            ->minDate(now()),
                        Select::make('priority')
                            ->options(PriorityEnum::class)
                            ->default($settings->task_default_priority ?? 'medium'),
                        Select::make('status')
                            ->options(TaskStatusEnum::class)
                            ->default($settings->task_default_status ?? 'pending'),
                    ])->columns(2),

                Section::make('Time Tracking')
                    ->schema([
                        TextInput::make('estimated_hours')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->suffix('hours'),
                        TextInput::make('actual_hours')
                            ->numeric()
                            ->minValue(0)
                            ->step(0.5)
                            ->suffix('hours')
                            ->disabled(fn ($context) => $context === 'create')
                            ->hint(fn ($record) => $record ? "Estimated: {$record->estimated_hours} hours" : ''),
                        Placeholder::make('time_difference')
                            ->label('Time Difference')
                            ->content(function ($record) {
                                if (! $record || ! $record->estimated_hours || ! $record->actual_hours) {
                                    return 'N/A';
                                }
                                $difference = $record->actual_hours - $record->estimated_hours;
                                $color = $difference <= 0 ? 'text-success-600' : 'text-danger-600';
                                $sign = $difference > 0 ? '+' : '';

                                return "<span class='{$color}'>{$sign}{$difference} hours</span>";
                            })
                            ->visible(fn ($record) => $record && $record->estimated_hours && $record->actual_hours)
                            ->html(),
                        TagsInput::make('tags')
                            ->placeholder('Add tags')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
