<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalendarAvailabilityResource\Pages;
use App\Models\CalendarAvailability;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CalendarAvailabilityResource extends Resource
{
    protected static ?string $model = CalendarAvailability::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static string|\UnitEnum|null $navigationGroup = 'Bookings';

    protected static ?string $slug = 'calendar-availabilities';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('date')
                            ->required(),
                        TextInput::make('start_time')
                            ->placeholder('09:00'),
                        TextInput::make('end_time')
                            ->placeholder('17:00'),
                        Toggle::make('is_available')
                            ->default(true),
                        Select::make('booking_id')
                            ->relationship('booking', 'booking_number')
                            ->nullable()
                            ->native(false),
                        Select::make('service_category_id')
                            ->relationship('serviceCategory', 'name')
                            ->nullable()
                            ->native(false),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('start_time'),
                TextColumn::make('end_time'),
                IconColumn::make('is_available')
                    ->boolean(),
                TextColumn::make('booking.booking_number')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_available')
                    ->options([
                        '1' => 'Available',
                        '0' => 'Unavailable',
                    ]),
                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'], fn ($q, $date) => $q->where('date', '>=', $date))
                        ->when($data['until'], fn ($q, $date) => $q->where('date', '<=', $date))),
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
            'index' => Pages\ListCalendarAvailabilities::route('/'),
        ];
    }
}
