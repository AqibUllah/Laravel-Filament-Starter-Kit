<?php

namespace App\Filament\Tenant\Resources\EmailTemplates;

use App\Filament\Tenant\Resources\EmailTemplates\Pages\CreateEmailTemplate;
use App\Filament\Tenant\Resources\EmailTemplates\Pages\EditEmailTemplate;
use App\Filament\Tenant\Resources\EmailTemplates\Pages\ListEmailTemplates;
use App\Filament\Tenant\Resources\EmailTemplates\Schemas\EmailTemplateForm;
use App\Filament\Tenant\Resources\EmailTemplates\Tables\EmailTemplatesTable;
use App\Models\EmailTemplate;
use App\Models\EmailTemplate as TenantEmailTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\File;
use UnitEnum;
use \Visualbuilder\EmailTemplates\Resources\EmailTemplateResource as BaseEmailTemplateResource;
use Visualbuilder\EmailTemplates\Resources\EmailTemplateThemeResource;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Envelope;

    protected static string | UnitEnum | null $navigationGroup = 'System';

    protected static ?int $navigationSort = 8;

    public static ?string $tenantOwnershipRelationshipName = 'team';

    protected static ?string $slug = 'test';
    protected static ?string $navigationLabel = 'Email Templates';

    public static function form(Schema $schema): Schema
    {
        return EmailTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmailTemplatesTable::configure($table);
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
            'index' => ListEmailTemplates::route('/'),
            'create' => CreateEmailTemplate::route('/create'),
            'edit' => EditEmailTemplate::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public function handleLogoDelete($logo)
    {
        if ($logo) {
            $defaultLogoPath = config('filament-email-templates.logo');
            $parsedLogoPath = str_replace(asset('/'), storage_path('app/public/'), $logo);

            if (!str_contains($parsedLogoPath, $defaultLogoPath) && File::exists($parsedLogoPath)) {
                File::delete($parsedLogoPath);
            }
        }
    }

    public function handleLogo(array $data): array
    {
        if ($data['logo_type'] == "paste_url" && $data['logo_url']) {
            $data['logo'] = $data['logo_url'];
        }
        unset($data['logo_type'], $data['logo_url']);
        return $data;
    }
}
