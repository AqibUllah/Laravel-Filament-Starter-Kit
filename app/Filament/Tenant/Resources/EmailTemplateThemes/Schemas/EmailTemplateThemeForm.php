<?php

namespace App\Filament\Tenant\Resources\EmailTemplateThemes\Schemas;

use App\Filament\Tenant\Resources\EmailTemplateThemes\EmailTemplateThemeResource;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class EmailTemplateThemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make(__('vb-email-templates::email-templates.theme-form-fields-labels.template-preview'))
                            ->schema([
                                View::make('preview')
                                    ->view('vb-email-templates::email.default_preview',
                                        ['data' => EmailTemplateThemeResource::getPreviewData()])
                                    ->dehydrated(false),
                            ])
                            ->columnSpan(['lg' => 2]),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.theme-name'))
                                    ->columnSpan(3),

                                Toggle::make('is_default')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.is-default'))
                                    ->inline(false)
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),

                        Section::make(__('vb-email-templates::email-templates.theme-form-fields-labels.set-colors'))
                            ->schema([
                                ColorPicker::make('colours.header_bg_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.header-bg'))
                                    ->live(),

                                ColorPicker::make('colours.body_bg_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.body-bg'))
                                    ->live(),

                                ColorPicker::make('colours.content_bg_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.content-bg'))
                                    ->live(),

                                ColorPicker::make('colours.footer_bg_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.footer-bg')),

                                ColorPicker::make('colours.callout_bg_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.callout-bg'))
                                    ->live(),

                                ColorPicker::make('colours.button_bg_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.button-bg'))
                                    ->live(),

                                ColorPicker::make('colours.body_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.body-color'))
                                    ->live(),

                                ColorPicker::make('colours.callout_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.callout-color'))
                                    ->live(),

                                ColorPicker::make('colours.button_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.button-color'))
                                    ->live(),

                                ColorPicker::make('colours.anchor_color')
                                    ->label(__('vb-email-templates::email-templates.theme-form-fields-labels.anchor-color'))
                                    ->live(),
                            ]),

                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}
