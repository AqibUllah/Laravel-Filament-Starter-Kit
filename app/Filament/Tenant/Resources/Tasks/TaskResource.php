<?php

namespace App\Filament\Tenant\Resources\Tasks;

use App\Filament\Tenant\Resources\Tasks\Pages\CreateTask;
use App\Filament\Tenant\Resources\Tasks\Pages\EditTask;
use App\Filament\Tenant\Resources\Tasks\Pages\ListTasks;
use App\Filament\Tenant\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Tenant\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | UnitEnum | null $navigationGroup = 'Project Management';

    protected static ?int $navigationSort=3;

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
            'activities' => Pages\ListTaskActivities::route('/{record}/activities'),
        ];
    }
}
