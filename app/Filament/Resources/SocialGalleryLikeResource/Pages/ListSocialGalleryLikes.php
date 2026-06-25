<?php

namespace App\Filament\Resources\SocialGalleryLikeResource\Pages;

use App\Filament\Resources\SocialGalleryLikeResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListSocialGalleryLikes extends ListRecords
{
    protected static string $resource = SocialGalleryLikeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
