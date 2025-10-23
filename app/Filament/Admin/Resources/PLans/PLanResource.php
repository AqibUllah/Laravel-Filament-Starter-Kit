<?php

namespace App\Filament\Admin\Resources\PLans;

use App\Filament\Admin\Resources\PLans\Pages\CreatePLan;
use App\Filament\Admin\Resources\PLans\Pages\EditPLan;
use App\Filament\Admin\Resources\PLans\Pages\ListPLans;
use App\Filament\Admin\Resources\PLans\Schemas\PLanForm;
use App\Filament\Admin\Resources\PLans\Tables\PLansTable;
use App\Models\PLan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PLanResource extends Resource
{
    protected static ?string $model = PLan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CreditCard;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PLanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PLansTable::configure($table);
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
            'index' => ListPLans::route('/'),
            'create' => CreatePLan::route('/create'),
            'edit' => EditPLan::route('/{record}/edit'),
        ];
    }
}
