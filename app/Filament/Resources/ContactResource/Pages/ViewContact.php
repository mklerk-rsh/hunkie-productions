<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Message')
                    ->schema([
                        TextEntry::make('name')
                            ->label('From'),
                        TextEntry::make('email'),
                        TextEntry::make('phone'),
                        TextEntry::make('subject')
                            ->columnSpanFull(),
                        TextEntry::make('message')
                            ->markdown()
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Received')
                            ->dateTime(),
                    ]),
                Section::make('Replies')
                    ->visible(fn (Contact $record) => $record->replies()->count() > 0)
                    ->schema([
                        RepeatableEntry::make('replies')
                            ->schema([
                                TextEntry::make('admin.name')
                                    ->label('Replied by'),
                                TextEntry::make('message')
                                    ->markdown(),
                                TextEntry::make('hasQuotation')
                                    ->label('Quotation')
                                    ->visible(fn ($state) => $state)
                                    ->badge()
                                    ->color('success')
                                    ->formatStateUsing(fn ($state, $record) => $record->quotation_filename ?? 'View Quotation'),
                                TextEntry::make('created_at')
                                    ->label('Date')
                                    ->dateTime(),
                            ]),
                    ]),
            ]);
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
