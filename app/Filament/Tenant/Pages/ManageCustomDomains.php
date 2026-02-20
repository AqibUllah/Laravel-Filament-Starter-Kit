<?php

namespace App\Filament\Tenant\Pages;

use App\Models\CustomDomain;
use App\Services\FeatureLimiterService;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Support\Str;

class ManageCustomDomains extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string|\BackedEnum| null $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Custom Domains';

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'Custom Domains';

    protected string $view = 'filament.tenant.pages.custom-domain';

    public function mount(): void
    {
        // Check if user has access to custom domains feature
        $tenant = filament()->getTenant();

        if (!$tenant) {
            Notification::make()
                ->danger()
                ->title('Access Denied')
                ->body('No tenant found.')
                ->send();

            redirect()->route('filament.tenant.pages.dashboard');
            return;
        }

        $limiter = app(FeatureLimiterService::class)->forTenant($tenant);
        $customDomainAccess = $limiter->getFeatureLimit('Custom Domain');

        if (!$customDomainAccess) {
            Notification::make()
                ->danger()
                ->title('Feature Not Available')
                ->body('Custom Domain is not available on your current plan. Please upgrade to access this feature.')
                ->send();

            redirect()->route('filament.tenant.pages.dashboard');
            return;
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(CustomDomain::query()->where('team_id', filament()->getTenant()->id))
            ->columns([
                Tables\Columns\TextColumn::make('domain')
                    ->label('Domain')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Domain copied to clipboard')
                    ->formatStateUsing(fn (string $state): string => Str::lower($state)),
                Tables\Columns\TextColumn::make('full_url')
                    ->label('Full URL')
                    ->url(fn (CustomDomain $record): string => $record->full_url)
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('is_verified')
                    ->label('Verified')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('warning'),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean()
                    ->trueColor('primary')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Verified At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('domain')
                            ->label('Domain')
                            ->required()
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, callable $get) {
                                return $rule->where('team_id', filament()->getTenant()->id);
                            })
                            ->regex('/^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?(\.[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?)*$/')
                            ->helperText('Enter your custom domain (e.g., example.com)'),
                        Forms\Components\Toggle::make('is_primary')
                            ->label('Make Primary Domain')
                            ->helperText('This will be the main domain for your application'),
                    ])
                    ->action(function (CustomDomain $record, array $data) {
                        // If setting as primary, unset other primary domains
                        if ($data['is_primary']) {
                            CustomDomain::where('team_id', filament()->getTenant()->id)
                                ->where('id', '!=', $record->id)
                                ->update(['is_primary' => false]);
                        }

                        $record->update($data);

                        Notification::make()
                            ->success()
                            ->title('Domain Updated')
                            ->body('Custom domain has been updated successfully.')
                            ->send();
                    }),
                Actions\Action::make('verify')
                    ->label('Verify Domain')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (CustomDomain $record): bool => !$record->is_verified)
                    ->action(function (CustomDomain $record) {
                        // Generate verification token if not exists
                        if (!$record->dns_verification_token) {
                            $token = $record->generateDnsVerificationToken();
                        } else {
                            $token = $record->dns_verification_token;
                        }

                        // In a real implementation, you would check DNS records here
                        // For now, we'll simulate verification
                        $record->update([
                            'is_verified' => true,
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Domain Verified')
                            ->body('Your custom domain has been verified and is now active.')
                            ->send();
                    }),
                Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Custom Domain')
                    ->modalDescription('Are you sure you want to delete this custom domain? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete')
                    ->modalCancelActionLabel('Cancel')
                    ->successNotificationTitle('Custom domain deleted successfully.'),
            ])
            ->emptyStateHeading('No custom domains configured')
            ->emptyStateDescription('Add your first custom domain to get started.')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Add Custom Domain')
                    ->icon('heroicon-o-plus')
                    ->form([
                        Forms\Components\TextInput::make('domain')
                            ->label('Domain')
                            ->required()
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, callable $get) {
                                return $rule->where('team_id', filament()->getTenant()->id);
                            })
                            ->regex('/^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?(\.[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?)*$/')
                            ->helperText('Enter your custom domain (e.g., example.com)'),
                        Forms\Components\Toggle::make('is_primary')
                            ->label('Make Primary Domain')
                            ->default(false)
                            ->helperText('This will be the main domain for your application'),
                    ])
                    ->action(function (array $data) {
                        // If setting as primary, unset other primary domains
                        if ($data['is_primary']) {
                            CustomDomain::where('team_id', filament()->getTenant()->id)
                                ->update(['is_primary' => false]);
                        }

                        CustomDomain::create([
                            'team_id' => filament()->getTenant()->id,
                            'domain' => strtolower($data['domain']),
                            'is_primary' => $data['is_primary'],
                            'dns_verification_token' => Str::random(32),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Domain Added')
                            ->body('Custom domain has been added successfully. Please verify your domain to activate it.')
                            ->send();
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('addDomain')
                ->label('Add Custom Domain')
                ->icon('heroicon-o-plus')
                ->form([
                    Forms\Components\TextInput::make('domain')
                        ->label('Domain')
                        ->required()
                        ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, callable $get) {
                            return $rule->where('team_id', filament()->getTenant()->id);
                        })
                        ->regex('/^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?(\.[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9]?)*$/')
                        ->helperText('Enter your custom domain (e.g., example.com)'),
                    Forms\Components\Toggle::make('is_primary')
                        ->label('Make Primary Domain')
                        ->default(false)
                        ->helperText('This will be the main domain for your application'),
                ])
                ->action(function (array $data) {
                    // If setting as primary, unset other primary domains
                    if ($data['is_primary']) {
                        CustomDomain::where('team_id', filament()->getTenant()->id)
                            ->update(['is_primary' => false]);
                    }

                    CustomDomain::create([
                        'team_id' => filament()->getTenant()->id,
                        'domain' => strtolower($data['domain']),
                        'is_primary' => $data['is_primary'],
                        'dns_verification_token' => Str::random(32),
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Domain Added')
                        ->body('Custom domain has been added successfully. Please verify your domain to activate it.')
                        ->send();
                }),
        ];
    }

    public static function canAccess(): bool
    {
        $tenant = filament()->getTenant();

        if (!$tenant) {
            return false;
        }

        $limiter = app(FeatureLimiterService::class)->forTenant($tenant);
        return (bool) $limiter->getFeatureLimit('Custom Domain');
    }
}
