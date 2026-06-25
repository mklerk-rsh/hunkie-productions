<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationItemResource\Pages;
use App\Models\QuotationItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuotationItemResource extends Resource
{
    protected static ?string $model = QuotationItem::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'quotation-items';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('quotation_id')
                            ->relationship('quotation', 'quotation_number')
                            ->required()
                            ->native(false),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->step(0.01)
                            ->required(),
                        TextInput::make('total')
                            ->numeric()
                            ->step(0.01)
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quotation.quotation_number')
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50),
                TextColumn::make('quantity')
                    ->sortable(),
                TextColumn::make('unit_price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
            ])
            ->filters([])
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
            'index' => Pages\ListQuotationItems::route('/'),
        ];
    }
}
