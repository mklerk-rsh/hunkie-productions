<?php

namespace App\Filament\Resources;

use App\Enums\ProjectStatus;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $slug = 'projects';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('status')
                            ->options(ProjectStatus::class)
                            ->required()
                            ->native(false),
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'name'),
                        MarkdownEditor::make('description')
                            ->columnSpanFull(),
                        TextInput::make('client_name')
                            ->maxLength(255),
                        TextInput::make('url')
                            ->url()
                            ->maxLength(500),
                        DatePicker::make('project_date')
                            ->label('Project Date'),
                        TextInput::make('completion_year')
                            ->numeric()
                            ->label('Completion Year'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('categories.name')
                    ->badge()
                    ->label('Categories'),
                TextColumn::make('client_name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('project_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Project Date'),
                TextColumn::make('completion_year')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Completion Year'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProjectStatus::class)
                    ->native(false),
                SelectFilter::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple(),
            ])
            ->actions([
                ViewAction::make(),
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
            'index' => Pages\ListProjects::route('/'),
        ];
    }
}
