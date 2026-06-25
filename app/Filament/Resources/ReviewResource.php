<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
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

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $slug = 'reviews';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Client Information')
                    ->schema([
                        TextInput::make('client_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('client_email')
                            ->email()
                            ->maxLength(255),
                        Select::make('service_category_id')
                            ->relationship('serviceCategory', 'name')
                            ->native(false),
                        Select::make('project_id')
                            ->relationship('project', 'title')
                            ->native(false),
                    ]),
                Section::make('Review')
                    ->schema([
                        Select::make('rating')
                            ->options([
                                1 => '1',
                                2 => '2',
                                3 => '3',
                                4 => '4',
                                5 => '5',
                            ])
                            ->required()
                            ->native(false),
                        Textarea::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Approval')
                    ->schema([
                        Toggle::make('is_approved'),
                        DateTimePicker::make('approved_at')
                            ->disabled(),
                        Select::make('approved_by')
                            ->relationship('approver', 'name')
                            ->disabled()
                            ->native(false),
                    ]),
                Section::make('Display')
                    ->schema([
                        TextInput::make('display_order')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rating')
                    ->sortable(),
                TextColumn::make('content')
                    ->limit(50),
                IconColumn::make('is_approved')
                    ->boolean(),
                TextColumn::make('serviceCategory.name')
                    ->label('Service Category'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_approved')
                    ->options([
                        '1' => 'Approved',
                        '0' => 'Pending',
                    ]),
                SelectFilter::make('rating')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                    ]),
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

    public static function getNavigationBadge(): ?string
    {
        return \Illuminate\Support\Facades\Cache::remember('reviews_unapproved_count', 300, function () {
            return static::getModel()::where('is_approved', false)->count();
        });
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
        ];
    }
}
