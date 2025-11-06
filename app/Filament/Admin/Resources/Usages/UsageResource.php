<?php

namespace App\Filament\Admin\Resources\Usages;

use App\Filament\Admin\Resources\Usages\Pages\CreateUsage;
use App\Filament\Admin\Resources\Usages\Pages\EditUsage;
use App\Filament\Admin\Resources\Usages\Pages\ListUsages;
use App\Filament\Admin\Resources\Usages\Pages\ViewUsage;
use App\Filament\Admin\Resources\Usages\Schemas\UsageForm;
use App\Filament\Admin\Resources\Usages\Tables\UsagesTable;
use App\Models\Usage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class UsageResource extends Resource
{
    protected static ?string $model = Usage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Billing & Plans';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'metric_name';

    public static function form(Schema $schema): Schema
    {
        return UsageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsagesTable::configure($table);
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
            'index' => ListUsages::route('/'),
            'create' => CreateUsage::route('/create'),
            'edit' => EditUsage::route('/{record}/edit'),
            'view' => ViewUsage::route('/{record}'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             SoftDeletingScope::class,
    //         ]);
    // }
}
