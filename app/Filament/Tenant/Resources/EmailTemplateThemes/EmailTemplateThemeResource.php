<?php

namespace App\Filament\Tenant\Resources\EmailTemplateThemes;

use App\Filament\Tenant\Resources\EmailTemplateThemes\Pages\CreateEmailTemplateTheme;
use App\Filament\Tenant\Resources\EmailTemplateThemes\Pages\EditEmailTemplateTheme;
use App\Filament\Tenant\Resources\EmailTemplateThemes\Pages\ListEmailTemplateThemes;
use App\Filament\Tenant\Resources\EmailTemplateThemes\Schemas\EmailTemplateThemeForm;
use App\Filament\Tenant\Resources\EmailTemplateThemes\Tables\EmailTemplateThemesTable;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateTheme;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class EmailTemplateThemeResource extends Resource
{
    protected static ?string $model = EmailTemplateTheme::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static string | UnitEnum | null $navigationGroup = 'System';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return EmailTemplateThemeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailTemplateThemesTable::configure($table);
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
            'index' => ListEmailTemplateThemes::route('/'),
            'create' => CreateEmailTemplateTheme::route('/create'),
            'edit' => EditEmailTemplateTheme::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPreviewData(?string $templateKey = null)
    {
        // Only return data if a template key is provided
        if (!$templateKey) {
            return null;
        }

        $emailTemplate = EmailTemplate::where('key', $templateKey)->first();

        if (!$emailTemplate) {
            return null;
        }

        return $emailTemplate->getEmailPreviewData();
    }
}
