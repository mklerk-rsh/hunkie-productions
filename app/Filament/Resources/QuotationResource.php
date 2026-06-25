<?php

namespace App\Filament\Resources;

use App\Enums\QuotationStatus;
use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static string|\UnitEnum|null $navigationGroup = 'Bookings';

    protected static ?string $slug = 'quotations';

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
                Section::make('Quotation Details')
                    ->schema([
                        TextInput::make('quotation_number')
                            ->disabled(),
                        Select::make('booking_id')
                            ->relationship('booking', 'booking_number')
                            ->native(false),
                        Select::make('service_category_id')
                            ->relationship('serviceCategory', 'name')
                            ->native(false),
                        Select::make('status')
                            ->options(QuotationStatus::class)
                            ->enum(QuotationStatus::class)
                            ->required()
                            ->native(false),
                        DatePicker::make('valid_until'),
                    ]),
                Section::make('Financial')
                    ->schema([
                        TextInput::make('subtotal')
                            ->numeric()
                            ->step(0.01),
                        TextInput::make('tax_percentage')
                            ->numeric()
                            ->suffix('%'),
                        TextInput::make('tax_amount')
                            ->numeric()
                            ->step(0.01)
                            ->disabled(),
                        TextInput::make('discount_percentage')
                            ->numeric()
                            ->suffix('%'),
                        TextInput::make('discount_amount')
                            ->numeric()
                            ->step(0.01)
                            ->disabled(),
                        TextInput::make('total')
                            ->numeric()
                            ->step(0.01)
                            ->disabled(),
                    ]),
                Section::make('Notes & Terms')
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull(),
                        RichEditor::make('terms')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quotation_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking.booking_number')
                    ->sortable(),
                TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => $state->color())
                    ->sortable(),
                TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('valid_until')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(QuotationStatus::class)
                    ->native(false),
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
            'index' => Pages\ListQuotations::route('/'),
        ];
    }
}
