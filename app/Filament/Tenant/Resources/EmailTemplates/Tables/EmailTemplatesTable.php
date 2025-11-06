<?php

namespace App\Filament\Tenant\Resources\EmailTemplates\Tables;

use App\Filament\Tenant\Resources\EmailTemplates\EmailTemplateResource;
use App\Models\EmailTemplate;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\View\View;
use Visualbuilder\EmailTemplates\Contracts\CreateMailableInterface;

class EmailTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(EmailTemplate::query())
            ->columns(
                [
                    TextColumn::make('id')
                        ->sortable()
                        ->searchable(),
                    TextColumn::make('name')
                        ->limit(50)
                        ->sortable()
                        ->searchable(),
                    TextColumn::make('language')
                        ->limit(50),
                    TextColumn::make('subject')
                        ->searchable()
                        ->limit(50),
                ]
            )
            ->filters(
                [
                    TrashedFilter::make(),
                ]
            )
            ->actions(
                [
                    Action::make('create-mail-class')
                        ->label('Build Class')
                        // Only show the button if the file does not exist
                        ->visible(function (EmailTemplate $record) {
                            return ! $record->mailable_exists;
                        })
                        ->icon('heroicon-o-document-text')
                        // ->action('createMailClass'),
                        ->action(function (EmailTemplate $record) {
                            $notify = app(CreateMailableInterface::class)->createMailable($record);
                            Notification::make()
                                ->title($notify->title)
                                ->icon($notify->icon)
                                ->iconColor($notify->icon_color)
                                ->duration(10000)
                                // Fix for bug where body hides the icon
                                ->body("<span style='overflow-wrap: anywhere;'>".$notify->body.'</span>')
                                ->send();
                        }),
                    ViewAction::make('Preview')
                        ->icon('heroicon-o-magnifying-glass')
                        ->modalContent(fn (EmailTemplate $record): View => view(
                            'vb-email-templates::forms.components.iframe',
                            ['record' => $record],
                        ))
                        ->modalHeading(fn (EmailTemplate $record): string => 'Preview Email: '.$record->name)
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false)
                        ->slideOver(),

                    EditAction::make(),
                    DeleteAction::make(),
                    ForceDeleteAction::make()
                        ->before(function (EmailTemplate $record, EmailTemplateResource $emailTemplateResource) {
                            $emailTemplateResource->handleLogoDelete($record->logo);
                        }),
                    RestoreAction::make(),
                ]
            )
            ->bulkActions(
                [
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]
            );
    }
}
