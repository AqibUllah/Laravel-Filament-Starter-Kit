<?php

namespace App\Filament\Tenant\Resources\Projects;

use App\Filament\Tenant\Resources\Projects\Pages\CreateProject;
use App\Filament\Tenant\Resources\Projects\Pages\EditProject;
use App\Filament\Tenant\Resources\Projects\Pages\ListProjects;
use App\Filament\Tenant\Resources\Projects\Pages\ViewProject;
use App\Filament\Tenant\Resources\Projects\RelationManagers\TasksRelationManager;
use App\Filament\Tenant\Resources\Projects\RelationManagers\TeamMembersRelationManager;
use App\Filament\Tenant\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Tenant\Resources\Projects\Tables\ProjectsTable;
use App\Filament\Tenant\Widgets\ProjectStatsWidget;
use App\Models\Project;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::FolderOpen;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Project Management';

    protected static ?string $navigationLabel = 'Projects';

    protected static ?string $modelLabel = 'Project';

    protected static ?string $pluralModelLabel = 'Projects';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TasksRelationManager::class,
            TeamMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'view' => ViewProject::route('/{record}'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getNavigationBadge();

        return match (true) {
            $count > 10 => 'danger',
            $count > 5 => 'warning',
            default => 'success',
        };
    }

    public static function getGlobalSearchResultTitle($record): string
    {
        return $record->name;
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Status' => $record->status->getLabel(),
            'Priority' => $record->priority->getLabel(),
            'Progress' => $record->progress . '%',
            'Due Date' => $record->due_date?->format('M j, Y'),
        ];
    }

    public static function getGlobalSearchResultUrl($record): ?string
    {
        return static::getUrl('view', ['record' => $record]);
    }
}
