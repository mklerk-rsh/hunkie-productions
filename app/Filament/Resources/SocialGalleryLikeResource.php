<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialGalleryLikeResource\Pages;
use App\Models\SocialGalleryLike;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialGalleryLikeResource extends Resource
{
    protected static ?string $model = SocialGalleryLike::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-heart';

    protected static string|\UnitEnum|null $navigationGroup = 'Social Gallery';

    protected static ?string $slug = 'social-gallery-likes';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Like Details')
                    ->schema([
                        Select::make('social_gallery_post_id')
                            ->relationship('post', 'caption')
                            ->required()
                            ->native(false),
                        TextInput::make('session_id')
                            ->maxLength(255),
                        TextInput::make('ip_address')
                            ->maxLength(45),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post.caption')
                    ->label('Post')
                    ->searchable(),
                TextColumn::make('session_id')
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (SocialGalleryLike $record): string => SocialGalleryLikeResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (SocialGalleryLike $record) => $record->delete()),
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
            'index' => Pages\ListSocialGalleryLikes::route('/'),
        ];
    }
}
