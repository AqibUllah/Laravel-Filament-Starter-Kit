<?php

namespace App\Filament\Admin\Resources\Plans;

use App\Filament\Admin\Resources\PLans\Pages\CreatePLan;
use App\Filament\Admin\Resources\PLans\Pages\EditPlan;
use App\Filament\Admin\Resources\PLans\Pages\ListPlans;
use App\Filament\Admin\Resources\PLans\Schemas\PlanForm;
use App\Filament\Admin\Resources\Plans\Tables\PlansTable;
use App\Models\Plan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Billing & Plans';

    public static function form(Schema $schema): Schema
    {
        return PlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlansTable::configure($table);
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
            'index' => ListPlans::route('/'),
            'create' => CreatePLan::route('/create'),
            'edit' => EditPlan::route('/{record}/edit'),
        ];
    }
}
