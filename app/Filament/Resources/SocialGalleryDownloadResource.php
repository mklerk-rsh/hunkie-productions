<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialGalleryDownloadResource\Pages;
use App\Models\SocialGalleryDownload;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialGalleryDownloadResource extends Resource
{
    protected static ?string $model = SocialGalleryDownload::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static string|\UnitEnum|null $navigationGroup = 'Social Gallery';

    protected static ?string $slug = 'social-gallery-downloads';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Download Details')
                    ->schema([
                        Select::make('social_gallery_post_id')
                            ->relationship('post', 'caption')
                            ->required()
                            ->native(false),
                        TextInput::make('session_id')
                            ->maxLength(255),
                        TextInput::make('ip_address')
                            ->maxLength(45),
                        DateTimePicker::make('downloaded_at'),
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
                TextColumn::make('downloaded_at')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (SocialGalleryDownload $record): string => SocialGalleryDownloadResource::getUrl('edit', ['record' => $record])),
                Action::make('delete')
                    ->action(fn (SocialGalleryDownload $record) => $record->delete()),
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
            'index' => Pages\ListSocialGalleryDownloads::route('/'),
        ];
    }
}
