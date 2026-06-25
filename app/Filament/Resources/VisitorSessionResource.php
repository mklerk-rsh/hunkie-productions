<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorSessionResource\Pages;
use App\Models\VisitorSession;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VisitorSessionResource extends Resource
{
    protected static ?string $model = VisitorSession::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static string|\UnitEnum|null $navigationGroup = 'Analytics';

    protected static ?string $slug = 'visitor-sessions';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Session Info')
                    ->schema([
                        TextInput::make('session_id')
                            ->disabled()
                            ->readOnly(),
                        TextInput::make('ip_address')
                            ->maxLength(45),
                        Textarea::make('user_agent')
                            ->columnSpanFull(),
                        TextInput::make('page_views_count')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('time_spent_seconds')
                            ->numeric()
                            ->disabled()
                            ->suffix('s'),
                        TextInput::make('referrer_url')
                            ->maxLength(255),
                        TextInput::make('landing_page')
                            ->maxLength(255),
                    ]),
                Section::make('Device')
                    ->schema([
                        Select::make('device_type')
                            ->options([
                                'desktop' => 'Desktop',
                                'mobile' => 'Mobile',
                                'tablet' => 'Tablet',
                            ])
                            ->native(false),
                        TextInput::make('browser')
                            ->maxLength(255),
                        TextInput::make('os')
                            ->maxLength(255),
                    ]),
                Section::make('Location')
                    ->schema([
                        TextInput::make('country')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->maxLength(255),
                        TextInput::make('latitude')
                            ->numeric()
                            ->step(0.0001),
                        TextInput::make('longitude')
                            ->numeric()
                            ->step(0.0001),
                    ]),
                Section::make('Tracking')
                    ->schema([
                        TextInput::make('utm_source')
                            ->maxLength(255),
                        TextInput::make('utm_medium')
                            ->maxLength(255),
                        TextInput::make('utm_campaign')
                            ->maxLength(255),
                    ]),
                Section::make('Timestamps')
                    ->schema([
                        DateTimePicker::make('first_visited_at')
                            ->disabled(),
                        DateTimePicker::make('last_visited_at')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('session_id')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('ip_address')
                    ->searchable(),
                TextColumn::make('page_views_count')
                    ->sortable(),
                TextColumn::make('time_spent_seconds')
                    ->formatStateUsing(fn (?int $state) => $state ? "{$state}s" : '—'),
                TextColumn::make('device_type')
                    ->badge(),
                TextColumn::make('country')
                    ->searchable(),
                TextColumn::make('first_visited_at')
                    ->sortable(),
                TextColumn::make('last_visited_at'),
            ])
            ->filters([
                SelectFilter::make('device_type')
                    ->options([
                        'desktop' => 'Desktop',
                        'mobile' => 'Mobile',
                        'tablet' => 'Tablet',
                    ]),
                SelectFilter::make('country')
                    ->options(fn () => VisitorSession::distinct()->pluck('country', 'country')->toArray()),
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (VisitorSession $record): string => VisitorSessionResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (VisitorSession $record) => $record->delete()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitorSessions::route('/'),
        ];
    }
}
