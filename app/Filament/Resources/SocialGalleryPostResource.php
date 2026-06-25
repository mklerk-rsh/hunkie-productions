<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialGalleryPostResource\Pages;
use App\Models\SocialGalleryPost;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DateTimePicker;
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

class SocialGalleryPostResource extends Resource
{
    protected static ?string $model = SocialGalleryPost::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Social Gallery';

    protected static ?string $slug = 'social-gallery-posts';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Post Details')
                    ->schema([
                        TextInput::make('image_path')
                            ->maxLength(255),
                        Textarea::make('caption')
                            ->columnSpanFull(),
                        TextInput::make('client_name')
                            ->maxLength(255),
                        TextInput::make('event_type')
                            ->maxLength(255),
                        DateTimePicker::make('posted_at'),
                        Toggle::make('is_active'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image_path')
                    ->searchable(),
                TextColumn::make('caption')
                    ->limit(50),
                TextColumn::make('client_name')
                    ->searchable(),
                TextColumn::make('event_type'),
                TextColumn::make('posted_at')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('event_type')
                    ->options(fn () => SocialGalleryPost::distinct()->pluck('event_type', 'event_type')->toArray()),
                Filter::make('is_active')
                    ->query(fn (Builder $q) => $q->where('is_active', true))
                    ->label('Active Only'),
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (SocialGalleryPost $record): string => SocialGalleryPostResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (SocialGalleryPost $record) => $record->delete()),
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
            'index' => Pages\ListSocialGalleryPosts::route('/'),
        ];
    }
}
