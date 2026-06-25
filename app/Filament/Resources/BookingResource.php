<?php

namespace App\Filament\Resources;

use App\Enums\BookingStatus;
use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Bookings';

    protected static ?string $slug = 'bookings';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Client Info')
                    ->schema([
                        TextInput::make('client_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_email')
                            ->required()
                            ->email()
                            ->maxLength(255),
                        TextInput::make('client_phone')
                            ->maxLength(20),
                    ]),
                Section::make('Booking Details')
                    ->schema([
                        TextInput::make('booking_number')
                            ->disabled()
                            ->hiddenOn('create'),
                        Select::make('service_category_id')
                            ->relationship('serviceCategory', 'name')
                            ->native(false),
                        DateTimePicker::make('event_date'),
                        TextInput::make('location')
                            ->maxLength(255),
                        Select::make('status')
                            ->options(BookingStatus::class)
                            ->enum(BookingStatus::class)
                            ->required()
                            ->native(false),
                        TextInput::make('source')
                            ->maxLength(255),
                    ]),
                Section::make('Financial')
                    ->schema([
                        TextInput::make('total_amount')
                            ->numeric()
                            ->step(0.01),
                        TextInput::make('deposit_amount')
                            ->numeric()
                            ->step(0.01),
                        TextInput::make('balance_amount')
                            ->numeric()
                            ->step(0.01)
                            ->disabled(),
                    ]),
                Section::make('Tracking')
                    ->schema([
                        Select::make('lead_id')
                            ->relationship('lead', 'name')
                            ->native(false),
                        TextInput::make('utm_source')
                            ->maxLength(255),
                        TextInput::make('utm_medium')
                            ->maxLength(255),
                        TextInput::make('utm_campaign')
                            ->maxLength(255),
                    ]),
                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('serviceCategory.name')
                    ->sortable(),
                TextColumn::make('event_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state->color())
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(BookingStatus::class)
                    ->native(false),
                Filter::make('date_range')
                    ->form([
                        DateTimePicker::make('from'),
                        DateTimePicker::make('until'),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'], fn ($q, $date) => $q->where('event_date', '>=', $date))
                        ->when($data['until'], fn ($q, $date) => $q->where('event_date', '<=', $date))),
            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListBookings::route('/'),
        ];
    }
}
