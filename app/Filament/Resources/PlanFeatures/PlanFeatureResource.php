<?php

namespace App\Filament\Resources\PlanFeatures;

use App\Filament\Resources\PlanFeatures\Pages\CreatePlanFeature;
use App\Filament\Resources\PlanFeatures\Pages\EditPlanFeature;
use App\Filament\Resources\PlanFeatures\Pages\ListPlanFeatures;
use App\Filament\Resources\PlanFeatures\Schemas\PlanFeatureForm;
use App\Filament\Resources\PlanFeatures\Tables\PlanFeaturesTable;
use App\Models\PlanFeature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlanFeatureResource extends Resource
{
    protected static ?string $model = PlanFeature::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckBadge;

    protected static string | UnitEnum | null $navigationGroup = 'Billing';

    public static function form(Schema $schema): Schema
    {
        return PlanFeatureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlanFeaturesTable::configure($table);
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
            'index' => ListPlanFeatures::route('/'),
            'create' => CreatePlanFeature::route('/create'),
            'edit' => EditPlanFeature::route('/{record}/edit'),
        ];
    }
}
