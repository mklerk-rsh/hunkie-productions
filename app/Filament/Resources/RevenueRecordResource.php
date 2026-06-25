<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RevenueRecordResource\Pages;
use App\Models\RevenueRecord;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DatePicker;
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

class RevenueRecordResource extends Resource
{
    protected static ?string $model = RevenueRecord::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string|\UnitEnum|null $navigationGroup = 'Finance';

    protected static ?string $slug = 'revenue-records';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Revenue Details')
                    ->schema([
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->step(0.01),
                        Select::make('currency')
                            ->options([
                                'USD' => 'USD',
                                'EUR' => 'EUR',
                                'GBP' => 'GBP',
                                'KES' => 'KES',
                                'NGN' => 'NGN',
                                'ZAR' => 'ZAR',
                                'GHS' => 'GHS',
                            ])
                            ->default('USD')
                            ->native(false),
                        Select::make('type')
                            ->options([
                                'payment' => 'Payment',
                                'refund' => 'Refund',
                                'deposit' => 'Deposit',
                                'withdrawal' => 'Withdrawal',
                            ])
                            ->required()
                            ->native(false),
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                                'credit_card' => 'Credit Card',
                                'bank_transfer' => 'Bank Transfer',
                                'paypal' => 'PayPal',
                            ])
                            ->native(false),
                        Select::make('booking_id')
                            ->relationship('booking', 'booking_number')
                            ->native(false),
                        Select::make('quotation_id')
                            ->relationship('quotation', 'quotation_number')
                            ->native(false),
                        DateTimePicker::make('recorded_at'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('amount')
                    ->sortable()
                    ->money('USD'),
                TextColumn::make('currency'),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('payment_method'),
                TextColumn::make('booking.booking_number')
                    ->label('Booking')
                    ->searchable(),
                TextColumn::make('recorded_at')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'payment' => 'Payment',
                        'refund' => 'Refund',
                        'deposit' => 'Deposit',
                        'withdrawal' => 'Withdrawal',
                    ]),
                SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'credit_card' => 'Credit Card',
                        'bank_transfer' => 'Bank Transfer',
                        'paypal' => 'PayPal',
                    ]),
                Filter::make('recorded_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(fn (Builder $q, array $data) => $q
                        ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('recorded_at', '>=', $date))
                        ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('recorded_at', '<=', $date))
                    ),
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (RevenueRecord $record): string => RevenueRecordResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (RevenueRecord $record) => $record->delete()),
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
            'index' => Pages\ListRevenueRecords::route('/'),
        ];
    }
}
