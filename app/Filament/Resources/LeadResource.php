<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static string|\UnitEnum|null $navigationGroup = 'Leads';

    protected static ?string $slug = 'leads';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('name')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('company')
                            ->maxLength(255),
                        Textarea::make('message')
                            ->columnSpanFull(),
                        Select::make('service_interest')
                            ->options([
                                'Film Production' => 'Film Production',
                                'Video Editing' => 'Video Editing',
                                'Animation' => 'Animation',
                                'Photography' => 'Photography',
                            ]),
                    ]),
                Section::make('Lead Details')
                    ->schema([
                        Select::make('status')
                            ->options(\App\Enums\LeadStatus::class)
                            ->required(),
                        Select::make('source')
                            ->options(\App\Enums\LeadSource::class)
                            ->required(),
                        TextInput::make('lead_score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
                Section::make('Tracking Data')
                    ->visible(fn (?Lead $record) => $record && $record->session_id)
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                        TextInput::make('device_type')
                            ->disabled(),
                        TextInput::make('browser')
                            ->disabled(),
                        TextInput::make('os')
                            ->disabled(),
                        TextInput::make('referrer_url')
                            ->label('Referrer URL')
                            ->disabled()
                            ->columnSpanFull(),
                        TextInput::make('landing_page')
                            ->label('Landing Page')
                            ->disabled()
                            ->columnSpanFull(),
                        TextInput::make('time_spent_seconds')
                            ->label('Time Spent')
                            ->disabled()
                            ->formatStateUsing(fn (?int $state) => $state ? gmdate('H:i:s', $state) : '0s'),
                        TextInput::make('page_views_count')
                            ->label('Page Views')
                            ->disabled(),
                        TextInput::make('latitude')
                            ->disabled(),
                        TextInput::make('longitude')
                            ->disabled(),
                        TextInput::make('utm_source')
                            ->disabled(),
                        TextInput::make('utm_medium')
                            ->disabled(),
                        TextInput::make('utm_campaign')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Anonymous'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('phone')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('source')
                    ->badge()
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('device_type')
                    ->label('Device')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('page_views_count')
                    ->label('Views')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('time_spent_seconds')
                    ->label('Time')
                    ->sortable()
                    ->formatStateUsing(fn (?int $state) => $state ? gmdate('H:i:s', $state) : '—')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Received'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(\App\Enums\LeadStatus::class),
                SelectFilter::make('source')
                    ->options(\App\Enums\LeadSource::class),
                SelectFilter::make('device_type')
                    ->options([
                        'desktop' => 'Desktop',
                        'mobile' => 'Mobile',
                        'tablet' => 'Tablet',
                    ]),
                Filter::make('new')
                    ->query(fn (Builder $q) => $q->where('status', \App\Enums\LeadStatus::New))
                    ->label('New Leads'),
                Filter::make('anonymous')
                    ->query(fn (Builder $q) => $q->whereNull('email'))
                    ->label('Anonymous Visitors'),
            ])
            ->actions([
                Action::make('convert_to_client')
                    ->label('Convert')
                    ->icon('heroicon-o-check-badge')
                    ->action(fn (Lead $record) => $record->update(['status' => \App\Enums\LeadStatus::Converted]))
                    ->hidden(fn (Lead $record) => $record->status === \App\Enums\LeadStatus::Converted),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
