<?php

namespace App\Filament\Tenant\Resources\EmailTemplates\Schemas;

use App\Models\EmailTemplate;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Visualbuilder\EmailTemplates\Contracts\FormHelperInterface;
use Visualbuilder\FilamentTinyEditor\TinyEditor;

class EmailTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        $formHelper = app(FormHelperInterface::class);
        $templates = $formHelper->getTemplateViewOptions();

        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema(
                        [
                            Grid::make(['default' => 1])
                                ->schema(
                                    [
                                        TextInput::make('name')
                                            ->live()
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.template-name'))
                                            ->hint(__('vb-email-templates::email-templates.form-fields-labels.template-name-hint'))
                                            ->required(),
                                    ]
                                ),

                            Grid::make(['default' => 1, 'sm' => 1, 'md' => 2])
                                ->schema(
                                    [
                                        TextInput::make('key')
                                            ->afterStateUpdated(
                                                fn (Set $set, ?string $state) => $set('key', Str::slug($state))
                                            )
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.key'))
                                            ->hint(__('vb-email-templates::email-templates.form-fields-labels.key-hint'))
                                            ->required()
                                            ->unique(table: EmailTemplate::class,
                                                column: 'key',
                                                ignoreRecord: true,
                                                modifyRuleUsing: function (Unique $rule, $get) {
                                                    return $rule->where('language', $get('language'));
                                                })
                                            ->maxLength(191),
                                        Select::make('language')
                                            ->options($formHelper->getLanguageOptions())
                                            ->default(config('filament-email-templates.default_locale'))
                                            ->searchable()
                                            ->allowHtml(),
                                        TextInput::make('from.email')->default(config('mail.from.address'))
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.email-from'))
                                            ->email(),
                                        TextInput::make('from.name')->default(config('mail.from.name'))
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.email-from-name'))
                                            ->string()
                                            ->maxLength(191),

                                        Select::make('view')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.template-view'))
                                            ->options($templates)
                                            ->default(current($templates))
                                            ->searchable()
                                            ->required(),

                                        Select::make(config('filament-email-templates.theme_table_name').'_id')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.theme'))
                                            ->relationship(name: 'theme', titleAttribute: 'name')
                                            ->native(false),
                                    ]
                                ),

                            Grid::make(['default' => 1])
                                ->schema(
                                    [
                                        TextInput::make('subject')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.subject'))
                                            ->maxLength(191),

                                        TextInput::make('preheader')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.header'))
                                            ->hint(__('vb-email-templates::email-templates.form-fields-labels.header-hint'))
                                            ->maxLength(191),

                                        TextInput::make('title')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.title'))
                                            ->hint(__('vb-email-templates::email-templates.form-fields-labels.title-hint'))
                                            ->maxLength(191),

                                        TinyEditor::make('content')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.content'))
                                            ->profile('default')
                                            ->default('<p>Dear ##user.first_name##, </p>'),

                                        Radio::make('logo_type')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.logo-type'))
                                            ->options([
                                                'browse_another' => __('vb-email-templates::email-templates.form-fields-labels.browse-another'),
                                                'paste_url' => __('vb-email-templates::email-templates.form-fields-labels.paste-url'),
                                            ])
                                            ->default('browse_another')
                                            ->inline()
                                            ->live(),

                                        FileUpload::make('logo')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.logo'))
                                            ->hint(__('vb-email-templates::email-templates.form-fields-labels.logo-hint'))
                                            ->hidden(fn (Get $get) => $get('logo_type') !== 'browse_another')
                                            ->directory(config('filament-email-templates.browsed_logo'))
                                            ->image(),

                                        TextInput::make('logo_url')
                                            ->label(__('vb-email-templates::email-templates.form-fields-labels.logo-url'))
                                            ->hint(__('vb-email-templates::email-templates.form-fields-labels.logo-url-hint'))
                                            ->placeholder('https://www.example.com/media/test.png')
                                            ->hidden(fn (Get $get) => $get('logo_type') !== 'paste_url')
                                            ->activeUrl()
                                            ->maxLength(191),
                                    ]
                                ),

                        ]
                    ),
            ]);
    }
}
