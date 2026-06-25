<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioMediaResource\Pages;
use App\Models\PortfolioMedia;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PortfolioMediaResource extends Resource
{
    protected static ?string $model = PortfolioMedia::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Portfolio';

    protected static ?string $slug = 'portfolio-media';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Select::make('project_id')
                            ->relationship('project', 'title')
                            ->native(false),
                        Select::make('portfolio_category_id')
                            ->relationship('portfolioCategory', 'name')
                            ->native(false),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        Select::make('media_type')
                            ->options([
                                'image' => 'Image',
                                'video' => 'Video',
                            ])
                            ->native(false),
                        TextInput::make('file_path')
                            ->maxLength(255),
                        Toggle::make('is_featured'),
                        TextInput::make('download_count')
                            ->numeric()
                            ->disabled(),
                        TextInput::make('like_count')
                            ->numeric()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.title')
                    ->label('Project'),
                TextColumn::make('portfolioCategory.name')
                    ->label('Category'),
                TextColumn::make('media_type')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->boolean(),
                TextColumn::make('download_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('like_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('media_type')
                    ->options([
                        'image' => 'Image',
                        'video' => 'Video',
                    ]),
                SelectFilter::make('is_featured')
                    ->options([
                        '1' => 'Featured',
                        '0' => 'Not Featured',
                    ]),
                SelectFilter::make('portfolio_category_id')
                    ->relationship('portfolioCategory', 'name'),
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
            'index' => Pages\ListPortfolioMedia::route('/'),
        ];
    }
}
