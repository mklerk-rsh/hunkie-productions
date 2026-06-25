<?php

namespace App\Filament\Resources\MenuResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Menu Items';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->maxLength(500),
                TextInput::make('route')
                    ->maxLength(255),
                Select::make('parent_id')
                    ->relationship('parent', 'title')
                    ->label('Parent Item')
                    ->native(false),
                TextInput::make('icon')
                    ->maxLength(100),
                TextInput::make('display_order')
                    ->numeric()
                    ->default(0),
                Select::make('target')
                    ->options([
                        '_self' => 'Same Tab',
                        '_blank' => 'New Tab',
                    ])
                    ->default('_self')
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('display_order')
            ->defaultSort('display_order')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('url')
                    ->limit(30),
                TextColumn::make('parent.title')
                    ->label('Parent'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('display_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
